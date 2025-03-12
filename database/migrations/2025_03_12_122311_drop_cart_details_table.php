<?php

use App\Models\Cart;
use App\Models\Product;
use App\Models\Size;
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
        Schema::dropIfExists('cart_details');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::create('cart_details', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Cart::class)->constrained();
            $table->foreignIdFor(Product::class)->constrained();
            $table->unsignedInteger('size');
            $table->foreign("size")->references('size')->on('sizes');
            $table->integer("quantity");
        });
    }
};
