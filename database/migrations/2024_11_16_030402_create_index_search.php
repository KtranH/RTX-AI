<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('photos', function (Blueprint $table) {
            $table->index('title');
        });
        Schema::table('categories', function (Blueprint $table) {
            $table->index('name');
        });
        Schema::table('users', function (Blueprint $table) {
            $table->index('username');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('photos', function (Blueprint $table) {
            $table->dropIndex('photos_title_index');
        });
        Schema::table('categories', function (Blueprint $table) {
            $table->dropIndex('categories_name_index');
        });
        Schema::table('users', function (Blueprint $table) {
            $table->dropIndex('users_username_index');
        });
    }
};
