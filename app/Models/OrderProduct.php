<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderProduct extends Model
{
    use HasFactory;
    protected $table = 'orders_products';
    protected $fillable = ['sort', 'product_id', 'order_id', 'subt_total', 'quantity'];

    public function items()
    {
        return $this->hasMany(OrderProduct::class, 'product_id');
    }
}
