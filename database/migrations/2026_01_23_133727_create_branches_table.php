<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBranchesTable extends Migration
{
    public function up(): void
    {
        Schema::create('branches', function (Blueprint $table) {
            $table->char('id', 36)->primary();

            // FK vers restaurants.id (char(36)), nullable
            $table->char('restaurant_id', 36)->nullable();
            $table->index('restaurant_id');

            $table->string('name');

            $table->string('address_line')->nullable();
            $table->string('city')->nullable();
            $table->string('country')->nullable();
            $table->string('phone')->nullable();

            $table->string('default_currency', 10)->default('XAF');
            $table->boolean('is_active')->default(true);

            $table->timestamps();

            $table->unique(['restaurant_id', 'name']);

            $table->foreign('restaurant_id')
                ->references('id')->on('restaurants')
                ->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('branches');
    }
}
