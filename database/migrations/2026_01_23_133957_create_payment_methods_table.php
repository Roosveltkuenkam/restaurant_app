<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentMethodsTable extends Migration
{
public function up(): void
{
    Schema::create('payment_methods', function (Blueprint $table) {
        $table->uuid('id')->primary();
        $table->uuid('branch_id');

        $table->string('type'); // CASH/CARD/MOBILE_MONEY...
        $table->string('name'); // "MTN MoMo", "Orange Money"
        $table->boolean('is_active')->default(true);

        $table->timestamps();

        $table->unique(['branch_id', 'name']);
        $table->index('branch_id');

        $table->foreign('branch_id')
            ->references('id')->on('branches')
            ->cascadeOnDelete();
    });
}

public function down(): void
{
    Schema::dropIfExists('payment_methods');
}

}
