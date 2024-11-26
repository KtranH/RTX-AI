<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        //
        DB::table('admin_roles')->insert([
            [
                'role_name' => 'superadmin',
                'description' => 'Có toàn quyền và quản lý admin',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'role_name' => 'admin',
                'description' => 'Có quyền hạn nhất định và chịu quản lý bởi supderadmin',
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
        DB::table('admin_roles')->truncate();
    }
};
