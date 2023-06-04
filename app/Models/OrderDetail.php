<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class OrderDetail extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'order_details';
    protected $primaryKey = 'order_detail_id';

    protected $fillable = [
        'order_id', 'good_id', 'good_sell_price', 'discount', 'quantity', 'quantity',
    ];

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class, 'order_id', 'order_id');
    }

    public function goods(): HasMany
    {
        return $this->hasMany(Good::class, 'good_id', 'good_id');
    }
}
