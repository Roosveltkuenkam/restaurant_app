<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\HasMany;

class Restaurant extends BaseModel
{
    protected $fillable = ['name'];

    public function branches(): HasMany
    {
        return $this->hasMany(Branch::class);
    }
}
