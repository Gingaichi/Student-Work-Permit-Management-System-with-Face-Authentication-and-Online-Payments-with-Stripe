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
    Schema::create('workpermits', function (Blueprint $table) {
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
        $table->string('passport_number');

        // Field for job title
        $table->string('job_title');
        
        // Field for employer
        $table->string('employer');
        
        
        // Field for workplace_address
        $table->string('workplace_address');
        
        // Field for duration of stay
        $table->string('employment_duration');

        $table->foreignId('user_id')->constrained();
        
        // Fields for file uploads
        $table->string('app_letter'); // Path to approval letter
        $table->string('passport_photo'); // Path to passport photo
        $table->string('employment_contract'); // Path to employment contract
        $table->string('cv'); // Path to cv
        $table->string('professional_clearance'); // Path to proffesional clearance

        // Add reference_number column
        $table->string('reference_number')->nullable()->unique();
        $table->enum('status', ['new', 'pending', 'approved', 'rejected','correction'])->default('new'); // Adding default value

        //$table->timestamps();
    });
}

    public function down(): void
    {
        Schema::dropIfExists('workpermits');
    }
};
