<?php

namespace App\Http\Controllers\Client;

use App\Helpers\TextSystemConst;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductColorSize;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

use Cart;

class PageController extends Controller
{
    public function home()
    {
        $product = Product::all();

        $categories = Category::whereNull('parent_id')
            ->with('children')
            ->get();

        return view('web.home', compact('product', 'categories'));
    }
    public function productDetail($product)
    {
        $product = Product::where('id', $product)->first();
        
        $variants = ProductColorSize::with(['color', 'size'])
        ->where('product_id', $product->id)
        ->get()
        ->groupBy('color_id'); 
    
    
     //  dd($variants);
        $categories = Category::whereNull('parent_id')
            ->with('children')
            ->get();

        return view('web.detail', compact('product', 'categories','variants'));
    }
    public function getProductbyCategory($slug)
    {
        $categories = Category::whereNull('parent_id')
            ->with('children')
            ->get();

        $category = Category::where('slug', $slug)->pluck('id')->first();

        $productbyidcate = Product::where('category_id', $category)->get();

        return view('web.productbycategory', compact('categories', 'productbyidcate'));
    }

    public function addToCart()
    {
        return view('web.cart');
    }
    public function storeCart(Product $product)
    {       
   
        try {
            $product = $product->load('category', 'colors', 'sizes');
            $stock = DB::table('product_color_size')
                ->where('product_id', $product->id)
                ->where('color_id', $product->colors->first()->id)
                ->where('size_id', $product->sizes->first()->id)
                ->value('stock');

            $cart = session()->get('cart', []);

            if (isset($cart[$product->id])) {

                $cart[$product->id]['quantily']++;
            } else {

                $cart[$product->id] = [
                    'id' => $product->id,
                    'name' => $product->name,
                    'quantily' => 1,
                    'price_sell' => $product->price_sell,
                    'image' => $product->img,
                    'color' => $product->colors->first()->name,
                    'size' => $product->sizes->first()->name,
                    'stock' => $stock
                ];
            }
            session()->put('cart', $cart);

            return redirect()->route('addtocart')->with('success', 'Thêm sản phẩm vào giỏ hàng thành công!');
        } catch (\Throwable $th) {
            return [
                'line' => $th->getLine(),
                'message' => $th->getMessage()
            ];
        }
    }

    public function removeCart($id)
    {

        try {
            $cart = session()->get('cart');

            if (isset($cart[$id])) {
                unset($cart[$id]);

                session()->put('cart', $cart);
            }
            return redirect()->back()->with('success', TextSystemConst::DELETE_SUCCESS);
        } catch (\Throwable $th) {
            return [
                'line' => $th->getLine(),
                'message' => $th->getMessage()
            ];
        }
    }


    public function storeCarts(Request $request, $id)
{
    // Lấy sản phẩm theo ID
    $product = Product::findOrFail($id);

    // Load thông tin sản phẩm với các quan hệ (category, colors, sizes)
    $product = $product->load('category', 'colors', 'sizes');

    // Lấy số lượng tồn kho từ bảng trung gian 'product_color_size'
    $stock = DB::table('product_color_size')
        ->where('product_id', $product->id)
        ->where('color_id', $product->colors->first()->id)
        ->where('size_id', $product->sizes->first()->id)
        ->value('stock');

    // Kiểm tra giỏ hàng hiện tại
    $cart = \Cart::getContent();

    // Kiểm tra nếu sản phẩm đã có trong giỏ hàng
    $cartItem = $cart->firstWhere('id', $product->id); // Thay thế 'where' bằng 'firstWhere'

    if ($cartItem) {
        // Nếu sản phẩm đã có trong giỏ hàng, tăng số lượng lên 1
        if ($cartItem->quantity + 1 <= $stock) { // Kiểm tra số lượng còn trong kho
            \Cart::update($cartItem->id, [
                'quantity' => $cartItem->quantity + 1
            ]);
        } else {
            return redirect()->route('addtocart')->with('error', 'Không đủ hàng trong kho!');
        }
    } else {
        // Nếu sản phẩm chưa có trong giỏ hàng, thêm mới vào giỏ
        \Cart::add([
            'id' => $product->id,
            'name' => $product->name,
            'price' => $product->price_sell,
            'quantity' => 1, // Mặc định số lượng là 1
            'attributes' => [
                'image' => $product->img,
                'color' => $product->colors->first()->name,
                'size' => $product->sizes->first()->name,
                'stock' => $stock,
            ]
        ]);
    }

    // Quay lại trang giỏ hàng và thông báo thành công
    return redirect()->route('addtocart')->with('success', 'Thêm sản phẩm vào giỏ hàng thành công!');
}

    
    
}



