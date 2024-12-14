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
    
       
        $variants = ProductColorSize::with(['color', 'size'])
            ->get()
            ->groupBy('product_id') 
            ->map(function ($group) {
                return $group->groupBy('color_id');
            });
          //  dd($variants);
           
        $categories = Category::whereNull('parent_id')
            ->with('children')
            ->get();
    
        return view('web.home', compact('product', 'categories', 'variants'));
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
    public function storeCart(Request $request, Product $product)
{
    try {
        $colorId = $request->input('color');
        $sizeId = $request->input('size');

        $colorName = DB::table('colors')->where('id', $colorId)->value('name');
        $sizeName = DB::table('sizes')->where('id', $sizeId)->value('name');

        // Lấy thông tin sản phẩm
        $product = $product->load('category', 'colors', 'sizes');

        $stock = DB::table('product_color_size')
            ->where('product_id', $product->id)
            ->where('color_id', $colorId)
            ->where('size_id', $sizeId)
            ->value('stock');

        if (!$stock || $stock <= 0) {
            return redirect()->back()->with('error', 'Sản phẩm hiện không có sẵn trong kho.');
        }

        $cart = session()->get('cart', []);

        $cartKey = "{$product->id}_{$colorId}_{$sizeId}";
       
        if (isset($cart[$cartKey])) {
            $cart[$cartKey]['quantity']++;
        } else {
           
            $cart[$cartKey] = [
                'id' => $product->id,
                'name' => $product->name,
                'quantity' => 1,
                'price_sell' => $product->price_sell,
                'image' => $product->img,
                'color' => $colorName,
                'sizes' => $sizeName,
                'stock' => $stock,
            ];
        }

        session()->put('cart', $cart);

        return redirect()->route('addtocart')->with('success', 'Thêm sản phẩm vào giỏ hàng thành công!');
    } catch (\Throwable $th) {

        return redirect()->back()->withErrors(['message' => $th->getMessage()]);
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
    
}



