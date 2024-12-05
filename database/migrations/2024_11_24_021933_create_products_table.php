<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->constrained('categories')->onDelete('cascade');
            $table->string('name')->unique();
            $table->text('description')->nullable();
            $table->decimal('price_buy',10,2);
            $table->decimal('price_sell',10,2);
            $table->integer('stock')->default(0);
           
            $table->enum('status', ['available', 'out_of_stock', 'discontinued'])->default('available');  // Trạng thái sản phẩm
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
