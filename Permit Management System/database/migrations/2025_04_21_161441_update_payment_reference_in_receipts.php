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
        Schema::table('receipts', function (Blueprint $table) {
            // Modify the column to allow null or set a default value
            $table->string('payment_reference')->nullable()->default(null)->change();
        });
    }
    
    public function down()
    {
        Schema::table('receipts', function (Blueprint $table) {
            // Reverse the changes, e.g., make it not nullable
            $table->string('payment_reference')->nullable(false)->change();
        });
    }
    
};
