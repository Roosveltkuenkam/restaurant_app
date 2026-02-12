<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductOptionGroupsTable extends Migration
{
public function up(): void
{
    Schema::create('product_option_groups', function (Blueprint $table) {
        $table->uuid('id')->primary();
        $table->uuid('product_id');
        $table->uuid('option_group_id');

        $table->timestamps();

        $table->unique(['product_id', 'option_group_id']);
        $table->index('product_id');
        $table->index('option_group_id');

        $table->foreign('product_id')
            ->references('id')->on('products');

        $table->foreign('option_group_id')
            ->references('id')->on('option_groups');
    });
}

public function down(): void
{
    Schema::dropIfExists('product_option_groups');
}

}

