<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderItemsTable extends Migration
{
public function up(): void
{
    Schema::create('order_items', function (Blueprint $table) {
        $table->uuid('id')->primary();

        $table->uuid('order_id');
        $table->uuid('product_id')->nullable();
        $table->uuid('product_variant_id')->nullable();

        // snapshots
        $table->string('product_name_snapshot');
        $table->string('variant_name_snapshot')->nullable();

        $table->decimal('unit_price_snapshot', 12, 2);
        $table->decimal('tax_rate_snapshot', 6, 3)->default(0);

        $table->decimal('qty', 10, 2)->default(1);

        $table->decimal('line_subtotal', 12, 2);
        $table->decimal('line_tax', 12, 2)->default(0);
        $table->decimal('line_total', 12, 2);

        $table->text('kitchen_notes')->nullable();
        $table->string('kitchen_status')->default('QUEUED');

        $table->timestamps();
        $table->softDeletes();

        $table->index(['order_id', 'kitchen_status']);
        $table->index('product_id');
        $table->index('product_variant_id');

        $table->foreign('order_id')
            ->references('id')->on('orders');

        $table->foreign('product_id')
            ->references('id')->on('products')
            ->onDelete('set null');

        $table->foreign('product_variant_id')
            ->references('id')->on('product_variants')
            ->onDelete('set null');
    });
}

public function down(): void
{
    Schema::dropIfExists('order_items');
}

}

