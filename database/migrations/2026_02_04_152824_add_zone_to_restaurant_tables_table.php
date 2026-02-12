<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddZoneToRestaurantTablesTable extends Migration
{
    public function up(): void
    {
        Schema::table('restaurant_tables', function (Blueprint $table) {
            $table->string('zone', 20)->default('INTERNO')->after('dining_area_id');
            $table->index(['branch_id','zone','is_active']);
        });
    }
    public function down(): void
    {
        Schema::table('restaurant_tables', function (Blueprint $table) {
            $table->dropIndex(['branch_id','zone','is_active']);
            $table->dropColumn('zone');
        });
    }

}


