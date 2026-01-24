<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRestaurantTablesTable extends Migration
{
public function up(): void
{
    Schema::create('restaurant_tables', function (Blueprint $table) {
        $table->uuid('id')->primary();
        $table->uuid('branch_id');
        $table->uuid('dining_area_id');

        $table->string('table_number');
        $table->unsignedInteger('capacity')->default(2);
        $table->string('status')->default('FREE'); // FREE/OCCUPIED/RESERVED
        $table->boolean('is_active')->default(true);

        $table->timestamps();

        $table->unique(['branch_id', 'table_number']);

        $table->index('branch_id');
        $table->index('dining_area_id');

        $table->foreign('branch_id')
            ->references('id')->on('branches')
            ->cascadeOnDelete();

        $table->foreign('dining_area_id')
            ->references('id')->on('dining_areas')
            ->restrictOnDelete();
    });
}

public function down(): void
{
    Schema::dropIfExists('restaurant_tables');
}

}
