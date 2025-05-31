<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('available_slots', function (Blueprint $table) {
            $table->id();
            $table->date('date'); // Ensure this column exists
            $table->time('slot_time')->default('00:00:00'); // Example default value

            $table->boolean('is_booked')->default(false);
            $table->unsignedBigInteger('applicant_id')->nullable(); // If you store applicant info
            $table->timestamps();
        });
    }
    
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('available_slots');
    }
};
