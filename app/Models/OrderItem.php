<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class OrderItem extends BaseModel
{
    use SoftDeletes;

    protected $fillable = [
        'order_id',
        'product_id',
        'product_variant_id',
        'product_name_snapshot',
        'variant_name_snapshot',
        'unit_price_snapshot',
        'tax_rate_snapshot',
        'qty',
        'line_subtotal',
        'line_tax',
        'line_total',
        'kitchen_notes',
        'kitchen_status',
    ];

    protected $casts = [
        'unit_price_snapshot' => 'decimal:2',
        'tax_rate_snapshot' => 'decimal:3',
        'qty' => 'decimal:2',
        'line_subtotal' => 'decimal:2',
        'line_tax' => 'decimal:2',
        'line_total' => 'decimal:2',
    ];

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function variant(): BelongsTo
    {
        return $this->belongsTo(ProductVariant::class, 'product_variant_id');
    }

    public function options(): HasMany
    {
        return $this->hasMany(OrderItemOption::class);
    }

    public const KDS_QUEUED = 'QUEUED';
    public const KDS_IN_PROGRESS = 'IN_PROGRESS';
    public const KDS_READY = 'READY';
    public const KDS_SERVED = 'SERVED';

    public static function allowedKitchenStatuses(): array
    {
        return [self::KDS_QUEUED, self::KDS_IN_PROGRESS, self::KDS_READY, self::KDS_SERVED];
    }
}


