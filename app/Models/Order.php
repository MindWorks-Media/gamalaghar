<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Order extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class, 'order_id'); // Adjust if necessary
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
