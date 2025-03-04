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
            $table->string('public_id')->unique();
            $table->string('admin_key')->unique();
            $table->string('author_name')->nullable();
            $table->string('author_email')->nullable();
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('cascade');
            $table->string('title');
            $table->text('description')->nullable();
            $table->boolean('anonymous_votes')->default(false);
            $table->boolean('comments')->default(true);
            $table->boolean('invite_only')->default(false);
            $table->boolean('hide_results')->default(false);
            $table->string('password')->nullable();
            $table->string('status', 45);
            $table->timestamp('deadline')->nullable();
            //Později přidat pro časovou zónu
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
