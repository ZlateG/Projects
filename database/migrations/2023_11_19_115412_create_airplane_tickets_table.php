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
        Schema::create('airplane_tickets', function (Blueprint $table) {
            $table->id();
            $table->enum('ticket_type', ['one_way', 'return']);
            $table->string('from_destination');
            $table->string('to_destination');
            $table->date('departure_date')->nullable();
            $table->date('return_date')->nullable();
            $table->integer('adults')->default(0);
            $table->integer('children')->default(0);
            $table->integer('babies')->default(0);
            $table->enum('class', ['economy', 'business', 'first_class']);
            $table->string('name');
            $table->string('email');
            $table->text('message');
            $table->unsignedBigInteger('answered_by')->nullable();
            $table->text('answer')->nullable();
            $table->foreign('answered_by')->references('id')->on('users')->constrained();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('airplane_tickets');
    }
};
