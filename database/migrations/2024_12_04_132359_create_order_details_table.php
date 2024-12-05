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
        Schema::create('order_details', function (Blueprint $table) {
            $table->id(); // Auto increment ID
            $table->unsignedBigInteger('order_id'); // Tham chiếu đến đơn hàng
            $table->unsignedBigInteger('product_id'); // Tham chiếu đến sản phẩm
            $table->integer('quantity'); // Số lượng sản phẩm
            $table->decimal('price', 10, 2); // Giá sản phẩm
            $table->timestamps();

            // Khóa ngoại tham chiếu đến bảng orders
            $table->foreign('order_id')->references('id')->on('orders')->onDelete('cascade');

            // Khóa ngoại tham chiếu đến bảng products (nếu có)
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_details');
    }
};
