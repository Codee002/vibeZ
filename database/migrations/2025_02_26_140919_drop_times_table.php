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
        Schema::dropIfExists('times');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::create('times', function (Blueprint $table) {
            $table->unsignedInteger('month');
            $table->unsignedInteger('year');
            $table->primary(['month', 'year']);
        });
    }
};
