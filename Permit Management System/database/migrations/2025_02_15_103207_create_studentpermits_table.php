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
    Schema::create('studentpermits', function (Blueprint $table) {
        $table->id();
        $table->timestamps();
        
        // Field for full name
        $table->string('name');
        
        // Field for email address
        $table->string('email');
        
        // Field for phone number
        $table->string('phone')->nullable(); // Optional, as it's not marked required in the form
        
        // Field for date of birth
        $table->date('dob');
        
        // Field for nationality
        $table->string('nationality');
        
        // Field for identification number (ID/passport number)
        $table->string('id_number');
        
        // Field for course of study
        $table->string('course');
        
        // Field for institution
        $table->string('institution');
        
        // Field for current place of residence
        $table->string('current_address');
        
        // Field for duration of stay
        $table->string('duration');

        $table->foreignId('user_id')->constrained();
        
        // Fields for file uploads
        $table->string('app_letter'); // Path to approval letter
        $table->string('passport_photo'); // Path to passport photo
        $table->string('birth_certificate'); // Path to birth certificate

        // Add reference_number column
        $table->string('reference_number')->nullable()->unique();
        $table->enum('status', ['new', 'pending', 'approved', 'rejected','correction'])->default('new'); // Adding default value

        //$table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('studentpermits');
    }
};
