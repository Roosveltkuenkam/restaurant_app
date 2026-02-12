<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddProductsImagePathColumn extends Migration
{
public function up()
{
    Schema::table('products', function (Blueprint $table) {
        if (!Schema::hasColumn('products', 'image_path')) {
            $table->string('image_path')->nullable()->after('sku');
        }
    });
}

public function down()
{
    Schema::table('products', function (Blueprint $table) {
        if (Schema::hasColumn('products', 'image_path')) {
            $table->dropColumn('image_path');
        }
    });
}

}


