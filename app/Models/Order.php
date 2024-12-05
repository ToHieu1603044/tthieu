<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'total_amount', 'status', 'name', 'email', 'phone', 'ward', 'district', 'city', 'payment_method', 'online_payment_method'
    ];

    public function orderdetails(){
        return $this->hasMany(OrderDetail::class);
    }
}
