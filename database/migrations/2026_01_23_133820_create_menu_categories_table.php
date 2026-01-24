<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMenuCategoriesTable extends Migration
{
public function up(): void
{
    Schema::create('menu_categories', function (Blueprint $table) {
        $table->uuid('id')->primary();
        $table->uuid('branch_id');

        $table->string('name');
        $table->unsignedInteger('sort_order')->default(0);
        $table->boolean('is_active')->default(true);

        $table->timestamps();
        $table->softDeletes();

        $table->unique(['branch_id', 'name']);
        $table->index('branch_id');

        $table->foreign('branch_id')
            ->references('id')->on('branches')
            ->cascadeOnDelete();
    });
}

public function down(): void
{
    Schema::dropIfExists('menu_categories');
}

}
