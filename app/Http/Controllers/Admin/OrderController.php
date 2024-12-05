<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
            $data = Order::with(['orderdetails'])->paginate(10);
        
            $tableCrud = [
                'headers' => [
                    ['text' => 'Mã SP', 'key' => 'id'],
                    ['text' => 'Tên SP', 'key' => 'name'],
                    ['text' => 'Hình Ảnh', 'key' => 'img', 'img' => ['url' => \Storage::url($data['img']), 'style' => 'width: 100px;']],
                    ['text' => 'Tổng giá', 'key' => 'total_amount','format' => true],               
                    ['text' => 'Số lượng', 'key' => 'orderdetails->quantity'],
                    ['text' => 'Trang thái', 'key' => 'status'], 
                    ['text' => 'Thanh toán', 'key' => 'status'], 
                    ['text' => 'Thông tin', 'key' => 'note'], 
                ],
            'actions' => [
                'text' => 'Thao Tác',
                'create' => false,
                'createExcel' => false,
                'edit' => true,
                'deleteAll' => true,
                'delete' => true,
                'viewDetail' => true,
                'editPermission' =>false
            ],
            'routes' => [
                'create' => 'products.create',
                'delete' => 'products.destroy',
                'edit' => 'products.edit',
                'editPermission' =>'roles'
            ],
            'list' => $data,
        ];

        return view('admin.order.index', compact('tableCrud'));
    }
}
