<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function index()
    {

        $data = DB::table('orders')
            ->join('order_details', 'orders.id', '=', 'order_details.order_id')
            ->join('products', 'order_details.product_id', '=', 'products.id')
            ->select(
                'orders.id as id',                    // Mã đơn hàng
                'orders.status',                            // Trạng thái đơn hàng
                'orders.note',                              // Thông tin đơn hàng
                DB::raw('SUM(order_details.quantity) as total_quantity'),  // Tổng số lượng cho mỗi sản phẩm trong đơn hàng
                DB::raw('SUM(order_details.quantity * order_details.price) as total_amount')  // Tổng tiền cho mỗi đơn hàng
            )
            ->groupBy('orders.id', 'orders.status', 'orders.note') // Nhóm theo order_id, status và note
            ->paginate(10);


        $tableCrud = [
            'headers' => [
                ['text' => 'Mã Đơn Hàng', 'key' => 'id'],
                ['text' => 'Tổng Số Lượng', 'key' => 'total_quantity'],
                ['text' => 'Tổng Tiền', 'key' => 'total_amount', 'format' => true],
                ['text' => 'Trạng Thái', 'key' => 'status'],
                ['text' => 'Thông Tin', 'key' => 'note'],
            ],
            'actions' => [
                'text' => 'Thao Tác',
                'create' => false,
                'createExcel' => false,
                'edit' => true,
                'deleteAll' => true,
                'delete' => true,
                'viewDetail' => true,
                'editPermission' => false
            ],
            'routes' => [
                'delete' => 'products.destroy',
                'edit' => 'products.edit',
                'detail' => 'orders.show'
            ],
            'list' => $data,
        ];

        return view('admin.order.index', compact('tableCrud'));
    }

    public function show($id)
    {
        // Lấy thông tin chung của đơn hàng
        $order = DB::table('orders')
            ->select(
                'orders.id as order_id',
                'orders.total_amount',
                'orders.status',
                'orders.note',
                'orders.user_id',
                'orders.name as name',
                'orders.email as email',
                'orders.phone as phone',
                'orders.ward',
                'orders.district',
                'orders.city',
                'orders.payment_method',
                'orders.created_at as time_order'
            )
            ->where('orders.id', $id)
            ->first();


        $data = DB::table('order_details')
            ->join('products', 'order_details.product_id', '=', 'products.id')
            ->select(
                'order_details.product_id as product_id',
                'products.name as product_name',
                'products.img as product_image',  
                'order_details.quantity as product_quantity',
              
                DB::raw('order_details.quantity * order_details.price as total_amount_per_product'),
                'order_details.created_at as time_order'
            )
            ->where('order_details.order_id', $id)
            ->get();

        return view('admin.order.details', compact('order', 'data'));
    }

    public function updateNote(Request $request, $id)
    {

        $validated = $request->validate([
            'note' => 'required|integer|between:0,4'
        ]);
       
        $order = Order::find($id); 

        if ($order) {
            $order->note = $request->note;

            $order->save();
    
            return response()->json(['success' => true, 'message' => 'Cập nhật thành công']);
        }
    
        return response()->json(['success' => false, 'message' => 'Cập nhật thất bại']);
    }
    

}



