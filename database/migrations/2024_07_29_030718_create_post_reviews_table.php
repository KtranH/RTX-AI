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
        Schema::create('post_reviews', function (Blueprint $table) {
            $table->id();
            $table->foreignId('photo_id')->constrained('photos')->onDelete('cascade');
            $table->foreignId('admin_id')->constrained('admin_accounts')->onDelete('cascade');
            $table->text('review_content');
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('post_reviews');
    }
};
