<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class RestaurantTable extends BaseModel
{
    protected $table = 'restaurant_tables';

    protected $fillable = [
        'branch_id','dining_area_id','table_number','capacity','status','is_active'
    ];

    protected $casts = [
        'capacity' => 'integer',
        'is_active' => 'boolean',
    ];

    public function branch(): BelongsTo
    {
        return $this->belongsTo(Branch::class);
    }

    public function diningArea(): BelongsTo
    {
        return $this->belongsTo(DiningArea::class);
    }

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class, 'restaurant_table_id');
    }
}
