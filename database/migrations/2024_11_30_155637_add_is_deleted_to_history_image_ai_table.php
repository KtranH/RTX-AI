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
        Schema::table('history_image_ai', function (Blueprint $table) {
            $table->boolean('is_deleted')->default(false)->after('updated_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('history_image_ai', function (Blueprint $table) {
            $table->dropColumn('is_deleted');
        });
    }
};
