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
    Schema::create('system_settings', function (Blueprint $table) {
        $table->id();
        $table->date('start_date'); // Date when appointments start
        $table->time('start_time')->default('08:00:00');
        $table->time('end_time')->default('17:00:00');
        $table->integer('max_per_hour')->default(5); // Max people per hour
        $table->timestamps();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('system_settings');
    }
};
