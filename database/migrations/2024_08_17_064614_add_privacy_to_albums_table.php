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
        Schema::table('albums', function (Blueprint $table) {
            $table->boolean('is_private')->default(false); // False là công khai, True là riêng tư
        });
    }
    
    public function down()
    {
        Schema::table('albums', function (Blueprint $table) {
            $table->dropColumn('is_private');
        });
    }
};
