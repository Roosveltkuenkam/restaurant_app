<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OrderItemOption extends BaseModel
{
    protected $fillable = [
        'order_item_id',
        'option_group_name_snapshot',
        'option_item_name_snapshot',
        'option_price_snapshot',
        'qty',
    ];

    protected $casts = [
        'option_price_snapshot' => 'decimal:2',
        'qty' => 'decimal:2',
    ];

    public function orderItem(): BelongsTo
    {
        return $this->belongsTo(OrderItem::class);
    }
}
