<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $table = 'orders';

    protected $fillable = [
        'transaction_id',
        'total',
        'user_id',
        'last_four',
        'status',
        'product_id',
        'is_refund_request'
    ];

    public function products()
    {
        return $this->belongsToMany(Product::class);
    }
}
