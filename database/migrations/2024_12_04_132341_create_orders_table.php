<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
           
            $table->unsignedBigInteger('user_id')->nullable(); // Tham chiếu đến người dùng (nếu có đăng nhập)
            $table->decimal('total_amount', 10, 2); // Tổng tiền
            $table->string('status')->default('pending'); // Trạng thái đơn hàng
            $table->string('name'); // Họ tên
            $table->string('email'); // Email
            $table->string('phone'); // Số điện thoại
            $table->string('ward'); // Xã
            $table->string('district'); // Huyện
            $table->string('city'); // Tỉnh/Thành phố
            $table->string('payment_method'); // Phương thức thanh toán (offline/online)
            $table->string('online_payment_method')->nullable(); // Phương thức thanh toán online (Momo, VNPay, v.v.)
            $table->timestamps(); // Thời gian tạo và cập nhật

            // Nếu bạn muốn tạo khóa ngoại cho `user_id`
            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
        });
    }

    

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
