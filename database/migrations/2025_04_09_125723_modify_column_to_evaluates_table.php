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
        Schema::table('evaluates', function (Blueprint $table) {
            $table->string("content")->nullable()->change();
            $table->string("image")->nullable()->after("content")->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('evaluates', function (Blueprint $table) {
            $table->string("content")->change();
            $table->string("image")->after("content")->change();
        });
    }
};
