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
        Schema::create('apartmant_prices', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('apartmant_id');
            $table->decimal('price', 10, 2);
            $table->softDeletes();
            $table->date('start_date');
            $table->date('end_date');
            $table->timestamps();
            $table->foreign('apartmant_id')->references('id')->on('apartments')->constrained()->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('apartmant_prices');
    }
};
