<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductColorSize extends Model
{
    use HasFactory;

    protected $table = 'product_color_size';  

    // Các cột có thể được truy cập
    protected $fillable = ['product_id', 'color_id', 'size_id', 'stock', 'price_sell'];

   
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function color()
    {
        return $this->belongsTo(Color::class);
    }

    public function size()
    {
        return $this->belongsTo(Size::class);
    }
}

