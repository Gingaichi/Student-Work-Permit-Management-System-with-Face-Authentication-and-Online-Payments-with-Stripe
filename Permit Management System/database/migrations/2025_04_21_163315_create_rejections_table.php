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
        Schema::create('rejections', function (Blueprint $table) {
            $table->id();

            // Foreign key to studentpermits
            $table->unsignedBigInteger('studentpermit_id');

            // Foreign key to officer (optional)
            $table->unsignedBigInteger('officer_id')->nullable();

            // Reason for rejection
            $table->text('reason');

            $table->timestamps();

            // Foreign key constraints
            $table->foreign('studentpermit_id')->references('id')->on('studentpermits')->onDelete('cascade');
            $table->foreign('officer_id')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rejections');
    }
};
