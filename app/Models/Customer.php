<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;
    protected $table = 'customers';
    protected $fillable = ['name', 'cpf', 'phone', 'email', 'password'];

    protected $hidden = ['password'];

    public function address()  {
        return $this->hasMany(Address::class,'customer_id');
    }
}
