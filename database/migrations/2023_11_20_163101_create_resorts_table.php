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
        Schema::create('resorts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('city_id');
            $table->unsignedBigInteger('resort_type');
            $table->string('resort_name');
            $table->integer('priority')->unsigned();
            $table->boolean('is_visible')->default(true);
            $table->boolean('last_minute_offer')->default(false);
            $table->softDeletes();
            $table->text('resort_description');
            // $table->point('location')->nullable();
            $table->timestamps();

            $table->foreign('city_id')->references('id')->on('cities')->constrained()->onDelete('cascade');
            $table->foreign('resort_type')->references('id')->on('resort_types')->constrained()->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('resorts');
    }
};