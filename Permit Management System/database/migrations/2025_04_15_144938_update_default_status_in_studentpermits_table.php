<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('studentpermits', function (Blueprint $table) {
            DB::statement("ALTER TABLE studentpermits MODIFY status ENUM('new', 'pending', 'approved', 'rejected', 'correction') DEFAULT 'pending'");
        });
    }

    public function down(): void
    {
        Schema::table('studentpermits', function (Blueprint $table) {
            DB::statement("ALTER TABLE studentpermits MODIFY status ENUM('new', 'pending', 'approved', 'rejected', 'correction') DEFAULT 'new'");
        });
    }
};
