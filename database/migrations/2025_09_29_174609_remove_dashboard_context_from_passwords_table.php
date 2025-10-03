<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('passwords', function (Blueprint $table) {
            $table->dropIndex(['user_id', 'dashboard_context']);
            $table->dropColumn('dashboard_context');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('passwords', function (Blueprint $table) {
            $table->string('dashboard_context')->default('admin')->after('user_id');
            $table->index(['user_id', 'dashboard_context']);
        });
    }
};