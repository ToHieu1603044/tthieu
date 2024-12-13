<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'name',
        'description',
        'price_buy',
        'price_sell',
        'img',
        'status',
        'descriptions',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    // Mối quan hệ với bảng Colors thông qua bảng trung gian product_color_size
    public function colors()
    {
        return $this->belongsToMany(Color::class, 'product_color_size')
                    ->withPivot('size_id', 'stock', 'price_sell');
    }

    // Mối quan hệ với bảng Sizes thông qua bảng trung gian product_color_size
    public function sizes()
    {
        return $this->belongsToMany(Size::class, 'product_color_size')
                    ->withPivot('color_id', 'stock', 'price_sell');
    }

}

