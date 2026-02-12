<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOptionGroupsTable extends Migration
{
public function up(): void
{
    Schema::create('option_groups', function (Blueprint $table) {
        $table->uuid('id')->primary();
        $table->uuid('branch_id');

        $table->string('name');
        $table->unsignedInteger('min_select')->default(0);
        $table->unsignedInteger('max_select')->default(99);
        $table->boolean('is_required')->default(false);

        $table->boolean('is_active')->default(true);

        $table->timestamps();
        $table->softDeletes();

        $table->unique(['branch_id', 'name']);
        $table->index('branch_id');

        $table->foreign('branch_id')
            ->references('id')->on('branches');
    });
}

public function down(): void
{
    Schema::dropIfExists('option_groups');
}

}

