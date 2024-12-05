<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Product;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
{
    public function index()
    {
        $cartItems = session('cart', []);
        $totalAmount = 0;

        foreach ($cartItems as $item) {
            $totalAmount += $item['price_sell'] * $item['quantily'];
        }

        return view('web.checkout', compact('cartItems', 'totalAmount'));
    }
    public function statussuccess()
    {
        return view('web.statusorder');
    }

    public function store(Request $request)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }
    
        $user = Auth::user();
    
        DB::beginTransaction();
    
        try {
        
            $order = Order::create([
                'user_id' => $user->id,
                'total_amount' => $request->total_amount,
                'status' => 'pending',
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'ward' => $request->ward,
                'district' => $request->district,
                'city' => $request->city,
                'payment_method' => $request->payment_method,
                'online_payment_method' => $request->online_payment_method ?? null,
            ]);
    
            $quantily = 0; // So luong = 0
            $cartItems = json_decode($request->cart_items, true); // lấy session giỏ hàng thông qua thẻ hidden
    
            foreach ($cartItems as $item) {      
                $stok = DB::table('product_color_size')                        //Lấy ra số lượng trong kho của sản phẩm
                    ->where('product_id', $item['id'])
                    ->value('stock');      
                $quantily += $item['quantily'];                                      // cộng với số lượng sản phẩm lấy được qua giỏ hàng
    
               
                $orderDetail = OrderDetail::create([
                    'order_id' => $order->id,
                    'product_id' => $item['id'],
                    'quantity' => $item['quantily'],
                    'price' => $item['price_sell'],
                ]);
    
                //Cập nhật lại số lượng trong kho
                $newStock = $stok - $item['quantily'];      
    
               
                if ($newStock < 0) {
                    throw new \Exception("Số lượng hàng trong kho đã hết" . $item['name']);
                }
    
                DB::table('product_color_size')
                    ->where('product_id', $item['id'])
                    ->update(['stock' => $newStock]);
            }
    
          
            if ($request->payment_method == 'online' && $request->payment_method_option == 'momo') {
                $momoResponse = $this->processPayment($order->id, $order->total_amount);
                DB::commit();
                return redirect()->away($momoResponse['payUrl']);
            }
                     
            DB::commit();
             
            session()->forget('cart');
    
            return redirect()->route('checkoutstatus')->with('success', 'Đặt hàng thành công');
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Order creation failed: ' . $e->getMessage());
            return redirect()->route('checkoutstatus')->with('error', 'Đặt hàng thất bại. Vui lòng thử lại.');
        }
    }
    

    public function processPayment($orderId,$total_amount)
    {
       
        $endpoint = "https://test-payment.momo.vn/v2/gateway/api/create";
        $partnerCode = 'MOMOBKUN20180529';
        $accessKey = 'klm05TvNBzhg7h7j';
        $secretKey = 'at67qH6mk8w5Y1nAyMoYKMWACiEi2bsa';
        $orderInfo = "Thanh toán qua MoMo";
        $amount = floatval($total_amount);
       
        $orderId = $orderId;
        $redirectUrl = route('checkout.success'); // URL trang thành công
        $ipnUrl = route('checkout.payment.notify'); // URL nhận thông báo callback từ MoMo
        $extraData = "";

        $requestId = time() . "";
        $requestType = "payWithATM";

        // Tạo chuỗi dữ liệu để ký HMAC SHA256
        $rawHash = "accessKey=" . $accessKey . "&amount=" . $amount . "&extraData=" . $extraData . "&ipnUrl=" . $ipnUrl . "&orderId=" . $orderId . "&orderInfo=" . $orderInfo . "&partnerCode=" . $partnerCode . "&redirectUrl=" . $redirectUrl . "&requestId=" . $requestId . "&requestType=" . $requestType;
        $signature = hash_hmac("sha256", $rawHash, $secretKey);

        // Chuẩn bị dữ liệu để gửi tới API MoMo
        $data = [
            'partnerCode' => $partnerCode,
            'partnerName' => "Test",
            'storeId' => "MomoTestStore",
            'requestId' => $requestId,
            'amount' => $amount,
            'orderId' => $orderId,
            'orderInfo' => $orderInfo,
            'redirectUrl' => $redirectUrl,
            'ipnUrl' => $ipnUrl,
            'lang' => 'vi',
            'extraData' => $extraData,
            'requestType' => $requestType,
            'signature' => $signature
        ];

        // Gửi yêu cầu POST tới API MoMo
        $result = $this->execPostRequest($endpoint, json_encode($data));
        $jsonResult = json_decode($result, true);  // Giải mã kết quả JSON trả về

        // Kiểm tra và trả về kết quả
        if (isset($jsonResult['resultCode']) && $jsonResult['resultCode'] == '0' && isset($jsonResult['payUrl'])) {
            // Trả về URL thanh toán của MoMo
            return $jsonResult;
        } else {
            // Xử lý lỗi nếu không có payUrl hoặc có lỗi trong việc gọi API
            return redirect()->route('checkout.status')->with('error', 'Yêu cầu thanh toán thất bại');
        }
    }

    function execPostRequest($url, $data)
    {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt(
            $ch,
            CURLOPT_HTTPHEADER,
            array(
                'Content-Type: application/json',
                'Content-Length: ' . strlen($data)
            )
        );
        curl_setopt($ch, CURLOPT_TIMEOUT, 5);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
        //execute post
        $result = curl_exec($ch);
        //close connection
        curl_close($ch);
        return $result;
    }


    public function success(Request $request)
    {
        $partnerCode = $request->input('partnerCode');
        $orderId = $request->input('orderId');
        $requestId = $request->input('requestId');
        $amount = $request->input('amount');
        $orderInfo = $request->input('orderInfo');
        $orderType = $request->input('orderType');
        $transId = $request->input('transId');
        $resultCode = $request->input('resultCode');
        $message = $request->input('message');
        $payType = $request->input('payType');
        $responseTime = $request->input('responseTime');
        $extraData = $request->input('extraData');
        $signature = $request->input('signature');


        $secretKey = 'at67qH6mk8w5Y1nAyMoYKMWACiEi2bsa'; // Secret key của bạn
        $rawHash = "accessKey=klm05TvNBzhg7h7j&amount=$amount&extraData=$extraData&ipnUrl=" . route('checkout.payment.notify') . "&orderId=$orderId&orderInfo=$orderInfo&partnerCode=$partnerCode&redirectUrl=" . route('checkout.success') . "&requestId=$requestId&requestType=payWithATM";
        $calculatedSignature = hash_hmac('sha256', $rawHash, $secretKey);

  

        if ($resultCode == '0') {
          
            $order = Order::where('id', $orderId)->first();

            if ($order) {
                $order->status = 'completed';  

                $order->payment_method = 'online';
                $order->total_amount = $amount;
                $order->save();
                session()->forget('cart');
                return view('web.success', compact('order'))->with('success','Thanh toán Momo thành công');
            } else {
               
                return redirect()->route('checkout.status')->with('error', 'Không tìm thấy đơn hàng');
            }
        } else {
            $order = Order::where('id', $orderId)->first();
            $order->delete();

            return redirect()->route('checkoutstatus')->with('error', 'Đặt hàng thất bại');
        }
        return view('web.success');
    }

}
