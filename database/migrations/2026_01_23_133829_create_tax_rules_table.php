<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTaxRulesTable extends Migration
{
public function up(): void
{
    Schema::create('tax_rules', function (Blueprint $table) {
        $table->uuid('id')->primary();
        $table->uuid('branch_id');

        $table->string('name');
        $table->decimal('rate_percent', 6, 3); // ex: 19.250
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
    Schema::dropIfExists('tax_rules');
}

}

