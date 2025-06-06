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
        Schema::dropIfExists('events');

        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->foreignId('poll_id')->constrained()->onDelete('cascade');
            $table->string('title');
            $table->dateTime('start_time');
            $table->dateTime('end_time')->nullable();
            $table->text('description')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};
