<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddBranchFieldsToUsersTable extends Migration
{

   public function up(): void
    {
    Schema::table('users', function (Blueprint $table) {
        $table->uuid('branch_id')->nullable()->after('id');
        $table->string('phone')->nullable()->after('email');
        $table->boolean('is_active')->default(true)->after('password');
        $table->timestamp('last_login_at')->nullable()->after('remember_token');

        $table->index('branch_id');

        $table->foreign('branch_id')
            ->references('id')->on('branches')
            ->nullOnDelete();
    });
    }

    public function down(): void
    {
    Schema::table('users', function (Blueprint $table) {
        $table->dropForeign(['branch_id']);
        $table->dropIndex(['branch_id']);

        $table->dropColumn(['branch_id', 'phone', 'is_active', 'last_login_at']);
    });
    }

}
