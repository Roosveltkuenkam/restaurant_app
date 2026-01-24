<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentsTable extends Migration
{
public function up(): void
{
    Schema::create('payments', function (Blueprint $table) {
        $table->uuid('id')->primary();

        $table->uuid('branch_id');
        $table->uuid('order_id');
        $table->uuid('payment_method_id');

        $table->string('status'); // PENDING/SUCCESS/FAILED/REFUNDED...
        $table->decimal('amount', 12, 2);
        $table->string('currency', 10)->default('XAF');

        $table->string('provider_reference')->nullable(); // transaction id
        $table->string('paid_by_customer_name')->nullable();

        $table->foreignId('taken_by_user_id')->constrained('users')->cascadeOnDelete();

        $table->timestamp('paid_at')->nullable();

        $table->timestamps();

        $table->index(['order_id', 'status']);
        $table->index(['branch_id', 'paid_at']);
        $table->index('payment_method_id');
        $table->index('provider_reference');

        $table->foreign('branch_id')
            ->references('id')->on('branches')
            ->cascadeOnDelete();

        $table->foreign('order_id')
            ->references('id')->on('orders')
            ->cascadeOnDelete();

        $table->foreign('payment_method_id')
            ->references('id')->on('payment_methods')
            ->restrictOnDelete();
    });
}

public function down(): void
{
    Schema::dropIfExists('payments');
}

}
