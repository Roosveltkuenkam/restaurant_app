<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddServiceToMenuCategoriesTable extends Migration
{
    public function up(): void {
        Schema::table('menu_categories', function (Blueprint $table) {
            $table->string('service', 20)->default('CUISINE')->after('name'); // CUISINE|BAR|PIZZERIA
            $table->index(['branch_id','service']);
        });
    }
    public function down(): void {
        Schema::table('menu_categories', function (Blueprint $table) {
            $table->dropIndex(['branch_id','service']);
            $table->dropColumn('service');
        });
    }
}


