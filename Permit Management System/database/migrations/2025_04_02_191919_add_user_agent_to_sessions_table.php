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
        Schema::table('sessions', function (Blueprint $table) {
            $table->string('user_agent')->nullable()->after('ip_address'); // Add user_agent column
        });
    }
    
    public function down()
    {
        Schema::table('sessions', function (Blueprint $table) {
            $table->dropColumn('user_agent'); // Drop user_agent column if rolling back
        });
    }
    
};
