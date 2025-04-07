<?php

use App\Models\Discount;
use App\Models\PaymentMethod;
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
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn("discount_id");
            $table->decimal("total_price", 10, 2);
            $table->foreignIdFor(PaymentMethod::class);

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->foreignIdFor(Discount::class);
            $table->dropColumn("total_price");
            $table->dropColumn("payment_method_id");

        });
    }
};
