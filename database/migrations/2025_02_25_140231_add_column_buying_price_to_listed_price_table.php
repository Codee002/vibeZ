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
        Schema::table('listed_price', function (Blueprint $table) {
            $table->renameColumn("price", "buying_price");
            $table->decimal("selling_price");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('listed_price', function (Blueprint $table) {
            $table->renameColumn("buying_price", "price");
            $table->dropColumn("selling_price");
        });
    }
};
