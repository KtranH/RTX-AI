<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        //
        DB::table('admin_accounts')->insert([
            [
                'username' => 'superadmin',
                'email' => 'superadmin@example.com',
                'password' => Hash::make('password123'),
                'role_id' => 1, // Superadmin
                'avatar_url' => 'default_avatar.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'username' => 'admin1',
                'email' => 'admin1@example.com',
                'password' => Hash::make('password123'),
                'role_id' => 2, // Admin
                'avatar_url' => 'default_avatar.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'username' => 'admin2',
                'email' => 'admin2@example.com',
                'password' => Hash::make('password123'),
                'role_id' => 2, // Admin
                'avatar_url' => 'default_avatar.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'username' => 'admin3',
                'email' => 'admin3@example.com',
                'password' => Hash::make('password123'),
                'role_id' => 2, // Admin
                'avatar_url' => 'default_avatar.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'username' => 'admin4',
                'email' => 'admin4@example.com',
                'password' => Hash::make('password123'),
                'role_id' => 2, // Admin
                'avatar_url' => 'default_avatar.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
        DB::table('admin_accounts')->truncate();
    }
};
