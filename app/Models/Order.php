<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    protected $fillable = ['customer_id', 'address_id', 'status', 'payment', 'total_price'];

    public function customer()  {
        return $this->belongsTo(Customer::class,'customer_id');
    }

    public function items()  {
        return $this->hasMany(OrderProduct::class,'product_id');
    }
}
