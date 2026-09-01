<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::statement("ALTER TABLE users MODIFY COLUMN status ENUM('active', 'suspended', 'banned') NOT NULL DEFAULT 'active'");
    }

    public function down(): void
    {
        DB::table('users')->where('status', 'banned')->update(['status' => 'suspended']);
        DB::statement("ALTER TABLE users MODIFY COLUMN status ENUM('active', 'suspended') NOT NULL DEFAULT 'active'");
    }
};
