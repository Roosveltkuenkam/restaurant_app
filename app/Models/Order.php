<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends BaseModel
{
    use SoftDeletes;

    // statuts recommandés (string dans DB)
    public const STATUS_OPEN = 'OPEN';
    public const STATUS_CONFIRMED = 'CONFIRMED';
    public const STATUS_PREPARING = 'PREPARING';
    public const STATUS_READY = 'READY';
    public const STATUS_SERVED = 'SERVED';
    public const STATUS_PAID = 'PAID';
    public const STATUS_CANCELLED = 'CANCELLED';
    public const STATUS_VOID = 'VOID';

    public const CHANNEL_DINE_IN = 'DINE_IN';
    public const CHANNEL_TAKEAWAY = 'TAKEAWAY';
    public const CHANNEL_DELIVERY = 'DELIVERY';

    protected $fillable = [
        'branch_id',
        'order_number',
        'channel',
        'status',
        'restaurant_table_id',
        'customer_id',
        'opened_by_user_id',
        'closed_by_user_id',
        'opened_at',
        'closed_at',
        'notes',
        'cancellation_reason',
        'currency',
        'subtotal',
        'discounts_total',
        'taxes_total',
        'service_fee',
        'delivery_fee',
        'grand_total',
    ];

    protected $casts = [
        'opened_at' => 'datetime',
        'closed_at' => 'datetime',
        'subtotal' => 'decimal:2',
        'discounts_total' => 'decimal:2',
        'taxes_total' => 'decimal:2',
        'service_fee' => 'decimal:2',
        'delivery_fee' => 'decimal:2',
        'grand_total' => 'decimal:2',
    ];

    public function branch(): BelongsTo
    {
        return $this->belongsTo(Branch::class);
    }

    public function table(): BelongsTo
    {
        return $this->belongsTo(RestaurantTable::class, 'restaurant_table_id');
    }

    public function openedBy(): BelongsTo
    {
        return $this->belongsTo(\App\Models\User::class, 'opened_by_user_id');
    }

    public function closedBy(): BelongsTo
    {
        return $this->belongsTo(\App\Models\User::class, 'closed_by_user_id');
    }

    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class);
    }

    /**
     * Recalcule et met à jour les totaux à partir des items + options.
     * (remises non gérées ici, discounts_total reste tel quel).
     */
    public function recalculateTotals(): void
    {
        $items = $this->items()->with('options')->get();

        $subtotal = 0;
        $taxes = 0;

        foreach ($items as $item) {
            // line_total et line_tax sont déjà stockés; on les somme
            $subtotal += (float) $item->line_subtotal;
            $taxes += (float) $item->line_tax;
        }

        $this->subtotal = $subtotal;
        $this->taxes_total = $taxes;

        $grand = $subtotal - (float) $this->discounts_total + $taxes + (float) $this->service_fee + (float) $this->delivery_fee;
        $this->grand_total = $grand;

        $this->save();
    }

    public function amountPaid(): float
    {
        return (float) $this->payments()
            ->where('status', 'SUCCESS')
            ->sum('amount');
    }

    public function isFullyPaid(): bool
    {
        return $this->amountPaid() >= (float) $this->grand_total;
    }
}

