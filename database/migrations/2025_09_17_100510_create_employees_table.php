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
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            
            // Personal Information
            $table->string('full_name');
            $table->enum('gender', ['male', 'female', 'other']);
            $table->date('date_of_birth');
            $table->string('blood_group');
            $table->enum('marital_status', ['single', 'married', 'divorced', 'widowed']);
            $table->string('nationality');
            $table->string('religion');
            $table->string('aadhaar_number')->unique();
            $table->string('aadhaar_front_photo')->nullable();
            $table->string('aadhaar_back_photo')->nullable();
            $table->string('passport_photo')->nullable();
            $table->string('pan_card')->nullable();
            $table->string('passport_number')->nullable();
            
            // Professional Information
            $table->string('designation');
            $table->date('date_of_joining');
            
            // Contact Information
            $table->string('personal_mobile');
            $table->string('personal_email');
            $table->text('current_address');
            $table->text('permanent_address');
            
            // Emergency Contact
            $table->string('emergency_contact_name');
            $table->string('emergency_contact_number');
            $table->string('emergency_contact_relation');
            $table->text('emergency_contact_address');
            
            // Terms and Conditions
            $table->boolean('terms_accepted')->default(false);
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employees');
    }
};
