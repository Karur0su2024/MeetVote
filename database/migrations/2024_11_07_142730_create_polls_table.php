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
        Schema::create('polls', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('username');
            $table->string('email');
            $table->foreignId('user_id')->nullable()->constrained('users');
            $table->date('deadline')->nullable();
            $table->string('status')->default('active');
            $table->string('password')->nullable();
            $table->string('background_color')->default('#ffffff');
            $table->boolean('comments')->default(0);
            $table->string('admin_key')->nullable();
            $table->boolean('anonymous_voting')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('polls');
    }
};
