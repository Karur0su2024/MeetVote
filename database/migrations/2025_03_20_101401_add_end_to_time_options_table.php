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
        Schema::table('time_options', function (Blueprint $table) {
            $table->time('end')->nullable()->after('start');
            $table->boolean('all_day')->default(false)->after('end');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('time_options', function (Blueprint $table) {
            $table->dropColumn('end');
            $table->dropColumn('all_day');
        });
    }
};
