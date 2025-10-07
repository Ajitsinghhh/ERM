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
            // Check if the column exists before dropping it
            if (Schema::hasColumn('passwords', 'dashboard_context')) {
                // Check if the index exists before dropping it
                if (Schema::hasIndex('passwords', 'passwords_user_id_dashboard_context_index')) {
                    $table->dropIndex(['user_id', 'dashboard_context']);
                }
                $table->dropColumn('dashboard_context');
            }
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