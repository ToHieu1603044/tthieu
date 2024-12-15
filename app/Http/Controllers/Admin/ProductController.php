<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\TextSystemConst;
use App\Models\Attribute;
use App\Models\Category;
use App\Models\Color;
use App\Models\Product;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\ProductColorSize;
use App\Models\Size;
use Exception;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Mockery\Expectation;
use Storage;

class ProductController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:view product', ['only' => ['index']]);
        $this->middleware('permission:delete product', ['only' => ['destroy']]);
        $this->middleware('permission:update product', ['only' => ['update', 'edit']]);
        $this->middleware('permission:create product', ['only' => ['edit', 'store']]);

    }
    public function index()
    {
        $data = Product::with(['category'])->paginate(5);
        // dd($data);
        $tableCrud = [
            'headers' => [
                ['text' => 'Mã SP', 'key' => 'id'],
                ['text' => 'Tên SP', 'key' => 'name'],
                ['text' => 'Hình Ảnh', 'key' => 'img', 'img' => ['url' => \Storage::url($data['img']), 'style' => 'width: 100px;']],
                ['text' => 'Danh Mục', 'key' => 'category.name'],
                ['text' => 'Giá bán', 'key' => 'price_sell'],
                ['text' => 'Giá', 'key' => 'price_sell', 'format' => true],
            ],
            'actions' => [
                'text' => 'Thao Tác',
                'create' => true,
                'createExcel' => false,
                'edit' => true,
                'deleteAll' => true,
                'delete' => true,
                'viewDetail' => true,
                'editPermission' => false
            ],
            'routes' => [
                'create' => 'products.create',
                'delete' => 'products.destroy',
                'edit' => 'products.edit',
                'editPermission' => 'roles'
            ],
            'list' => $data,
        ];

        return view('admin.products.index', compact('tableCrud'));
    }

    public function create()
    {
        $colors = Color::pluck('name', 'id')->all();
        $sizes = Size::pluck('name', 'id')->all();
        $categories = Category::whereNull('parent_id')
            ->with('children')
            ->get();
        return view('admin.products.create', compact('colors', 'sizes', 'categories'));
    }

    public function store(StoreProductRequest $request)
    {
       // dd($request->all());
        $data = [
            'category_id' => $request->category_id,
            'name' => $request->name,
            'description' => $request->description,
            'price_buy' => $request->price_buy,
            'price_sell' => $request->price_sell,
            'status' => $request->status,
            'descriptions' => $request->descriptions,
        ];

        if ($request->hasFile('img')) {
            $data['img'] = Storage::put('products', $request->file('img'));
        }

        $product = Product::create($data);

        foreach ($request->color as $colorId) {
            if (!empty($request->size[$colorId])) {
                foreach ($request->size[$colorId] as $sizeId) {
                    // Lấy số lượng cho màu và kích thước cụ thể
                    $quantity = $request->quantity[$colorId][$sizeId] ?? 0;
        
                    // Lấy giá bán riêng (nếu có)
                    $priceSell = $request->price[$colorId][$sizeId] ?? $request->price_sell;
        
                    ProductColorSize::create([
                        'product_id' => $product->id,
                        'color_id' => $colorId,
                        'size_id' => $sizeId,
                        'stock' => $quantity,
                        'price_sell' => $priceSell,
                    ]);
                }
            }
        }
        
        return redirect()->route('products.index')->with('success', 'Sản phẩm đã được tạo thành công.');
    }

    public function show(Product $product)
    {
       
    }

    public function edit(Product $product)
    {

        $product = $product->load('category', 'colors', 'sizes');
        $category = Category::pluck('name', 'id');
        $colors = Color::pluck('name', 'id')->all();
        $sizes = Size::pluck('name', 'id')->all();
        $productColors = $product->colors->pluck('id')->toArray();
        $productSize = $product->sizes->pluck('id')->toArray();
        $stock = Attribute::where('product_id', $product->id)->pluck('stock');

        $parent = Category::with('parent')
            ->whereNotNull('parent_id')
            ->get();

        return view('admin.products.edit', compact('category', 'colors', 'sizes', 'parent', 'product', 'productColors', 'productSize', 'stock'));
    }

    public function update(UpdateProductRequest $request, Product $product)
    {
        try {
            $data = [
                'category_id' => $request->category_id,
                'name' => $request->name,
                'description' => $request->description,
                'price_buy' => $request->price_buy,
                'price_sell' => $request->price_sell,
                'status' => $request->status,

                'descriptions' => $request->descriptions
            ];

            if ($request->hasFile('img')) {
                $data['img'] = Storage::put('products', $request->file('img'));
            }

            $product->update($data);

            Attribute::where('product_id', $product->id)->update([
                'color_id' => $request->color,
                'size_id' => $request->size,
                'stock' => $request->stock
            ]);

            return redirect()->route('products.index')->with('success', TextSystemConst::UPDATE_SUCCESS);
        } catch (Exception $e) {
            Log::error($e);
            DB::rollBack();
            return back()->with('error', TextSystemConst::UPDATE_FAILED);
        }
    }

    public function destroy(Product $product)
    {
        try {
            Attribute::where('product_id', $product->id)->delete();

            $product->delete();

            return redirect()->route('products.index')->with('success', TextSystemConst::DELETE_SUCCESS);

        } catch (\Throwable $th) {
            return redirect()->route('products.index')->with('errors', TextSystemConst::DELETE_FAILED);
        }
    }
}
