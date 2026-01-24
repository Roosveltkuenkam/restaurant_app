<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TaxRule extends BaseModel
{
    use SoftDeletes;

    protected $fillable = [
        'branch_id', 'name', 'rate_percent', 'is_active',
    ];

    protected $casts = [
        'rate_percent' => 'decimal:3',
        'is_active' => 'boolean',
    ];

    public function branch(): BelongsTo
    {
        return $this->belongsTo(Branch::class);
    }

    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }
}
