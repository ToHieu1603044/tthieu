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
                'create' => 'products.create',
                'delete' => 'products.destroy',
                'edit' => 'products.edit',
                'editPermission' => 'roles'
            ],
            'list' => $data, 
        ];
    
        return view('admin.order.index', compact('tableCrud'));
    }
    
}
