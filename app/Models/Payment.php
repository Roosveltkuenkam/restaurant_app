<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Payment extends BaseModel
{
    protected $fillable = [
        'branch_id',
        'order_id',
        'payment_method_id',
        'status',
        'amount',
        'currency',
        'provider_reference',
        'paid_by_customer_name',
        'taken_by_user_id',
        'paid_at',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'paid_at' => 'datetime',
    ];

    public function branch(): BelongsTo
    {
        return $this->belongsTo(Branch::class);
    }

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    public function method(): BelongsTo
    {
        return $this->belongsTo(PaymentMethod::class, 'payment_method_id');
    }

    public function takenBy(): BelongsTo
    {
        return $this->belongsTo(\App\Models\User::class, 'taken_by_user_id');
    }
}
