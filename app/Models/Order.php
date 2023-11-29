<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'customer_id', 'number', 'total_price', 'status', 'shipping_price', 'notes'
    ];

    //a order can have a user (a order is made by a user)
    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    //one to many
    //a order can have many products while a product can be only attached to one order
    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }
}
