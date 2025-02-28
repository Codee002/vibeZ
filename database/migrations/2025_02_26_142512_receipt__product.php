<?php

use App\Models\Product;
use App\Models\Receipt;
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
        Schema::create('receipt_product', function (Blueprint $table) {
            $table->foreignIdFor(Product::class)->constrained();
            $table->foreignIdFor(Receipt::class)->constrained();
            $table->primary(['product_id', 'receipt_id']);

            $table->integer("quantity")->default(0);
            $table->decimal("price")->default(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('receipt_product');
    }
};
