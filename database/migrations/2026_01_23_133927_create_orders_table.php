<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
public function up(): void
{
    Schema::create('orders', function (Blueprint $table) {
        $table->uuid('id')->primary();

        $table->uuid('branch_id');
        $table->string('order_number');

        $table->string('channel'); // DINE_IN/TAKEAWAY/DELIVERY
        $table->string('status');  // OPEN/CONFIRMED/PAID/CANCELLED...

        $table->uuid('restaurant_table_id')->nullable();
        $table->uuid('customer_id')->nullable(); // on ajoutera customers plus tard si besoin

        $table->foreignId('opened_by_user_id')->constrained('users');
        $table->foreignId('closed_by_user_id')->nullable()->constrained('users')->onDelete('set null');

        $table->timestamp('opened_at');
        $table->timestamp('closed_at')->nullable();

        $table->text('notes')->nullable();
        $table->text('cancellation_reason')->nullable();

        $table->string('currency', 10)->default('XAF');
        $table->decimal('subtotal', 12, 2)->default(0);
        $table->decimal('discounts_total', 12, 2)->default(0);
        $table->decimal('taxes_total', 12, 2)->default(0);
        $table->decimal('service_fee', 12, 2)->default(0);
        $table->decimal('delivery_fee', 12, 2)->default(0);
        $table->decimal('grand_total', 12, 2)->default(0);

        $table->timestamps();
        $table->softDeletes();

        $table->unique(['branch_id', 'order_number']);
        $table->index(['branch_id', 'status', 'opened_at']);
        $table->index(['branch_id', 'channel', 'opened_at']);
        $table->index('restaurant_table_id');

        $table->foreign('branch_id')
            ->references('id')->on('branches');

        $table->foreign('restaurant_table_id')
            ->references('id')->on('restaurant_tables')
            ->onDelete('set null');
    });
}

public function down(): void
{
    Schema::dropIfExists('orders');
}

}

