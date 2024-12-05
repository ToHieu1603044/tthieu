<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\StoreProductRequest;
use App\Http\Requests\API\UpdateProductRequest;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;


class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Product::query()->latest()->paginate(5);

        return response()->json([
            'message'=> 'Danh sach san pham trang ' . request('page',1),
            'data' =>$data
        ],200);
    }
   
    public function store(StoreProductRequest $request)
    {
       try {
        $data = [
            'category_id' => $request->category_id,
            'name' => $request->name,
            'description' => $request->description,
            'price_buy' => $request->price_buy,
            'price_sell' => $request->price_sell,
            'status'=>$request->status,           
            'descriptions'=>$request->descriptions
        ];

        if ($request->hasFile('img')) {
            $data['img'] = Storage::put('products', $request->file('img'));
        }
        
        $product = Product::query()->create($data);
        
        return response()->json([
            'message' => 'Them san pham thanh cong',
            'data' => $data
        ],Response::HTTP_CREATED);
       } catch (\Throwable $th) {

        Log::error('Loi them san pham: ' . $th->getMessage(), [
            'exception' => $th,
            'data' => $request->all()
        ]);

        return response()->json([
            'message' => 'Đã xảy ra lỗi khi thêm sản phẩm',
        ], Response::HTTP_INTERNAL_SERVER_ERROR);
       }

    }

    public function show(string $id)
    {
       try {
        $data = Product::with(['colors', 'sizes', 'category'])->findOrFail($id);
        
        return response()->json([
            'message' =>'Chi tiet san pham id =' .$id,
            'data' => $data
        ]);
       } catch (\Throwable $th) {

            Log::error(__CLASS__. '@' . __FUNCTION__,[$th->getTraceAsString()]);

            if($th instanceof ModelNotFoundException){
                return response()->json([
                    'message'=> 'San pham khong ton tai'. $id,
                ],Response::HTTP_NOT_FOUND);
            }
            
            return response()->json([
                'Khong tim thay san pham co id'. $id
            ],Response::HTTP_INTERNAL_SERVER_ERROR);
       }
    }

    public function update(UpdateProductRequest $request, string $id)
    {
       try {
        $product = Product::query()->findOrFail($id);

        $data = [
            'category_id' => $request->category_id,
            'name' => $request->name,
            'description' => $request->description,
            'price_buy' => $request->price_buy,
            'price_sell' => $request->price_sell,
            'status'=>$request->status,           
            'descriptions'=>$request->descriptions
        ];

        if ($request->hasFile('img')) {
            $data['img'] = Storage::put('products', $request->file('img'));
        }
        
        $product->update($data);
        
        return response()->json([
            'message' => 'Cap nhat san pham thanh cong',
            'data' => $data
        ],Response::HTTP_CREATED);
       } catch (\Throwable $th) {

            Log::error(__CLASS__.'@'. __FUNCTION__,[$th->getTraceAsString()]);

            if($th instanceof ModelNotFoundException){
                return response()->json([
                    'Khong tim thay san pham '. $id
                ],Response::HTTP_NOT_FOUND);
            }
    
            return response()->json([
                'Co loi'
            ],Response::HTTP_INTERNAL_SERVER_ERROR);
       }
    }

    public function destroy(string $id)
    {
        try {
            Product::destroy($id);

            return response()->json([
                'message'=> 'Xoa thanh cong'
            ],Response::HTTP_OK);
        } catch (\Throwable $th) {
            if($th instanceof ModelNotFoundException){
                return response()->json([
                    'message' => 'Khong tim thay san pham co id.'. $id
                ],Response::HTTP_NOT_FOUND);
            }

            return response()->json([
                'Khong tim thay san pham co id.' .$id
            ],Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
