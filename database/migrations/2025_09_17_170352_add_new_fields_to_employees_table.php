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
        Schema::table('employees', function (Blueprint $table) {
            // Add new fields from CSV format
            $table->date('marriage_anniversary')->nullable();
            $table->string('passport')->nullable();
            $table->string('aadhaar_card_front')->nullable();
            $table->string('aadhaar_card_back')->nullable();
            $table->string('profile_photo')->nullable();
            $table->boolean('terms_and_conditions')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('employees', function (Blueprint $table) {
            $table->dropColumn([
                'marriage_anniversary',
                'passport',
                'aadhaar_card_front',
                'aadhaar_card_back',
                'profile_photo',
                'terms_and_conditions'
            ]);
        });
    }
};
