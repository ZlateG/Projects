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
        Schema::create('apartmant_images', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('apartmant_id');
            $table->string('image_path');
            $table->softDeletes();
            $table->foreign('apartmant_id')->references('id')->on('apartments')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('apartmant_images');
    }
};
