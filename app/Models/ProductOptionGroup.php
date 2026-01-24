<?php

namespace App\Models;

class ProductOptionGroup extends BaseModel
{
    protected $table = 'product_option_groups';

    protected $fillable = ['product_id', 'option_group_id'];
}
