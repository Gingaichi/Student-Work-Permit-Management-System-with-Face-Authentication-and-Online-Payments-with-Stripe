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
        $table->unsignedBigInteger('user_id')->nullable()->after('id'); // Add user_id column
    });
}

public function down()
{
    Schema::table('sessions', function (Blueprint $table) {
        $table->dropColumn('user_id'); // Drop user_id column if rolling back
    });
}
};
