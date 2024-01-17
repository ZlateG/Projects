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
        Schema::create('apartments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('resort_id');
            $table->string('apartment_name');
            $table->softDeletes();
            $table->string('apartment_description')->nullable();
            $table->boolean('last_minute_offer')->default(false);
            $table->timestamps();
            
            $table->foreign('resort_id')->references('id')->on('resorts')->constrained()->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('apartments');
    }
};
