<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOptionItemsTable extends Migration
{
public function up(): void
{
    Schema::create('option_items', function (Blueprint $table) {
        $table->uuid('id')->primary();
        $table->uuid('option_group_id');

        $table->string('name');
        $table->decimal('price', 12, 2)->default(0);

        $table->boolean('is_active')->default(true);

        $table->timestamps();
        $table->softDeletes();

        $table->unique(['option_group_id', 'name']);
        $table->index('option_group_id');

        $table->foreign('option_group_id')
            ->references('id')->on('option_groups');
    });
}

public function down(): void
{
    Schema::dropIfExists('option_items');
}

}

