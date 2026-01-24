<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductVariantsTable extends Migration
{
public function up(): void
{
    Schema::create('product_variants', function (Blueprint $table) {
        $table->uuid('id')->primary();
        $table->uuid('product_id');

        $table->string('name'); // Small/Medium/Large
        $table->decimal('price_delta', 12, 2)->default(0);

        $table->boolean('is_active')->default(true);
        $table->timestamps();
        $table->softDeletes();

        $table->unique(['product_id', 'name']);
        $table->index('product_id');

        $table->foreign('product_id')
            ->references('id')->on('products')
            ->cascadeOnDelete();
    });
}

public function down(): void
{
    Schema::dropIfExists('product_variants');
}

}
