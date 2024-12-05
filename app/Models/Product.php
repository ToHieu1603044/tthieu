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

    public function category(){
        return $this->belongsTo(Category::class);
    }

    public function colors()
    {
        return $this->belongsToMany(Color::class, 'product_color_size','product_id')
                    ->withPivot('size_id', 'stock'); 
    }

    public function sizes()
    {
        return $this->belongsToMany(Size::class,'product_color_size','product_id')
                    ->withPivot('color_id', 'stock'); 
    }
}

