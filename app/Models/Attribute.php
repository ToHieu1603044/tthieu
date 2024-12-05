<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attribute extends Model
{
    use HasFactory;

    protected $table ='product_color_size';
    protected $fillable = [
        'product_id',
        'color_id',
        'size_id',
        'stock'
    ];
}
