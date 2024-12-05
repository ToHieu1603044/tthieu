<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Color extends Model
{
    use HasFactory;

    protected $fillable = [    
        'name',
    ];

    public function products()
    {
        return $this->belongsToMany(Product::class, 'product_color_size','product_id')
                    ->withPivot('size_id', 'stock');
    }

}