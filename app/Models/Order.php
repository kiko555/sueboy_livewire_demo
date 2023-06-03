<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'orders';
    protected $primaryKey = 'order_id';

    protected $fillable = [
        'name', 'user_id', 'total_price_origin', 'total_price_after_discount', 'total_quantity',
    ];
}
