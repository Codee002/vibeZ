<?php

use App\Models\Product;
use App\Models\Size;
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
        Schema::create('warehouse_details', function (Blueprint $table) {
            $table->id();
            $table->integer("quantity");
            $table->enum("status", ['actived', 'disabled'])->default('actived');
            $table->foreignIdFor(Product::class)->constrained();
            $table->foreignIdFor(Warehouse::class)->constrained();
            $table->unsignedInteger('size');
            $table->foreign("size")->references('size')->on('sizes');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('warehouse_details');
    }
};
