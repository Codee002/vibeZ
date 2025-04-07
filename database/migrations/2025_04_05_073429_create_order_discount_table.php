<?php

use App\Models\Discount;
use App\Models\Order;
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
        Schema::create('order_discount', function (Blueprint $table) {
            $table->foreignIdFor(Discount::class);
            $table->foreignIdFor(Order::class);
            $table->primary(['discount_id', 'order_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_discount');
    }
};
