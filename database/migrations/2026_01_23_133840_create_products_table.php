<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
public function up(): void
{
    Schema::create('products', function (Blueprint $table) {
        $table->uuid('id')->primary();

        $table->uuid('branch_id');
        $table->uuid('menu_category_id');
        $table->uuid('tax_rule_id')->nullable();

        $table->string('sku')->nullable();
        $table->string('name');
        $table->text('description')->nullable();

        $table->decimal('base_price', 12, 2);

        $table->boolean('is_active')->default(true);

        $table->timestamps();
        $table->softDeletes();

        $table->unique(['branch_id', 'name']);
        $table->index(['branch_id', 'menu_category_id']);
        $table->index('tax_rule_id');
        $table->index('sku');

        $table->foreign('branch_id')
            ->references('id')->on('branches')
            ->cascadeOnDelete();

        $table->foreign('menu_category_id')
            ->references('id')->on('menu_categories')
            ->restrictOnDelete();

        $table->foreign('tax_rule_id')
            ->references('id')->on('tax_rules')
            ->nullOnDelete();
    });
}

public function down(): void
{
    Schema::dropIfExists('products');
}

}
