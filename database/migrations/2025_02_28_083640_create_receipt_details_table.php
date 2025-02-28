<?php

use App\Models\Product;
use App\Models\Receipt;
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
        Schema::create('receipt_details', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Receipt::class)->constrained();
            $table->foreignIdFor(Product::class)->constrained();
            $table->unsignedInteger('size');
            $table->foreign("size")->references('size')->on('sizes');
            $table->integer("quantity");
            $table->decimal("purchase_price");
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('receipt_details');
    }
};
