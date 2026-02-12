<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderItemOptionsTable extends Migration
{
public function up(): void
{
    Schema::create('order_item_options', function (Blueprint $table) {
        $table->uuid('id')->primary();

        $table->uuid('order_item_id');

        $table->string('option_group_name_snapshot');
        $table->string('option_item_name_snapshot');
        $table->decimal('option_price_snapshot', 12, 2)->default(0);
        $table->decimal('qty', 10, 2)->default(1);

        $table->timestamps();

        $table->index('order_item_id');

        $table->foreign('order_item_id')
            ->references('id')->on('order_items');
    });
}

public function down(): void
{
    Schema::dropIfExists('order_item_options');
}

}

