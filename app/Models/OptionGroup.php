<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class OptionGroup extends BaseModel
{
    use SoftDeletes;

    protected $fillable = [
        'branch_id',
        'name',
        'min_select',
        'max_select',
        'is_required',
        'is_active',
    ];

    protected $casts = [
        'min_select' => 'integer',
        'max_select' => 'integer',
        'is_required' => 'boolean',
        'is_active' => 'boolean',
    ];

    public function branch(): BelongsTo
    {
        return $this->belongsTo(Branch::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(OptionItem::class, 'option_group_id');
    }

    public function products(): BelongsToMany
    {
        return $this->belongsToMany(
            Product::class,
            'product_option_groups',
            'option_group_id',
            'product_id'
        )->withTimestamps();
    }
}
