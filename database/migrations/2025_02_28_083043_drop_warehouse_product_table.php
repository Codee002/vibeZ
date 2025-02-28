<?php

use App\Models\Product;
use App\Models\Warehouse;
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
        Schema::dropIfExists('warehouse_product');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::create('warehouse_product', function (Blueprint $table) {
            $table->foreignIdFor(Product::class)->constrained();
            $table->foreignIdFor(Warehouse::class)->constrained();
            $table->primary(['product_id', 'warehouse_id']);
    
            $table->integer("quantity")->default(0);
            $table->enum("status", ['actived', 'disabled'])->default('actived');
            });
    }
};
