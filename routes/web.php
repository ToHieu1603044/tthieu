<?php

use App\Http\Controllers\Admin\AuthenController;
use App\Http\Controllers\Admin\CategoryController;

use App\Http\Controllers\Admin\HomeController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Client\CheckoutController;
use App\Http\Controllers\Client\PageController;
use App\Livewire\Category;
use App\Livewire\CategorySubcategory;
use Illuminate\Support\Facades\Route;


// Route::middleware('auth')->group(function () {
//     Route::get('checkout', [CheckoutController::class, 'index'])->name('checkout.index');
//     Route::post('checkout', [CheckoutController::class, 'store'])->name('checkout.store');
//     Route::get('checkout/{orderId}/payment', [CheckoutController::class, 'payment'])->name('checkout.payment');
//     Route::post('checkout/{orderId}/process-payment', [CheckoutController::class, 'processPayment'])->name('checkout.process_payment');
// });
// Route để trả về trang thành công sau khi thanh toán
Route::get('checkout/success', [CheckoutController::class, 'success'])->name('checkout.success');

// Route để nhận thông báo callback từ MoMo
Route::post('checkout/payment/notify', [CheckoutController::class, 'handleSuccess'])->name('checkout.payment.notify');


Route::post('check',[CheckoutController::class,'store'])->name('check');
Route::get('checkoutstatus',[CheckoutController::class,'statussuccess'])->name('checkoutstatus');
Route::get('checkout',[CheckoutController::class,'index'])->name('checkout');

Route::get('/',[PageController::class,'home']);
Route::get('product/{product}/detail', [PageController::class, 'productDetail'])->name('product.detail');
Route::get('categoryslug/{slug}', [PageController::class, 'categorybyslug'])->name('categoryslug');

Route::get('get-pro-by-cate/{slug}', [PageController::class, 'getProductbyCategory'])->name('get-pro-by-cate');

Route::get('addtocart', [PageController::class, 'addToCart'])->name('addtocart');
Route::get('cart/{product}', [PageController::class, 'storeCart'])->name('cart');
Route::get('remove/{id}', [PageController::class, 'removeCart'])->name('removeCart');


Route::middleware(['auth','role:admin|subadmin'])->prefix('admin')->group(function () {

    Route::resource('permissions',PermissionController::class);
    Route::resource('roles',RoleController::class);
    Route::get('roles/{role}/give-permission',[RoleController::class,'addPermissionRole'])->name('addPermissionRole');
    Route::put('roles/{role}/give-permission',[RoleController::class,'updatePermissionRole'])->name('updatePermissionRole');

    Route::resource('users',UserController::class);

    Route::get('/', [HomeController::class, 'index'])->name('admin');
    Route::resource('products', ProductController::class);
    Route::get('category-by-parent', [ProductController::class, 'getCategorybyParent'])->name('admin.categorybyparent');

    Route::get('category', [CategorySubcategory::class]);
    Route::get('get-categories-by-parent', [ProductController::class, 'getCategoryByParent'])->name('admin.category_by_parent');

    Route::resource('categories', CategoryController::class);

    Route::resource('order',OrderController::class);

});


Auth::routes();


