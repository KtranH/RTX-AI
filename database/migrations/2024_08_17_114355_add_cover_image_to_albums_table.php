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
            $table->string('cover_image')->nullable()->after('description'); // Cột ảnh đại diện, có thể để trống
        });
    }

    public function down()
    {
        Schema::table('albums', function (Blueprint $table) {
            $table->dropColumn('cover_image');
        });
    }

};
