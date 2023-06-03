<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderDetail extends Model
{
    use HasFactory;

    protected $table = 'order_details';
    protected $primaryKey = 'order_detail_id';

    protected $fillable = [
        'order_id', 'good_id', 'good_sell_price', 'discount', 'quantity', 'quantity',
    ];
}
