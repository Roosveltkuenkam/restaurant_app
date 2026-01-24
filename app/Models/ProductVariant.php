<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProductVariant extends BaseModel
{
    use SoftDeletes;

    protected $fillable = [
        'product_id', 'name', 'price_delta', 'is_active',
    ];

    protected $casts = [
        'price_delta' => 'decimal:2',
        'is_active' => 'boolean',
    ];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}
