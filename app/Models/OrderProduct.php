<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class OrderProduct extends Model
{
    public $timestamps = false;

    protected $table = 'order_product';

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function gifts(): BelongsToMany
    {
        return $this->belongsToMany(Gift::class, 'gift_order_product');
    }
}
