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
        Schema::create('general_images', function (Blueprint $table) {
            $table->id();
            $table->string("banner")->nullable();
            $table->string("logo_header")->nullable();
            $table->string("logo_footer")->nullable();
            $table->string("login")->nullable();
            $table->string("register")->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('general_images');
    }
};
