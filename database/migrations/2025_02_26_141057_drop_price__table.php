<?php

use App\Models\Product;
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
        Schema::dropIfExists('price');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::create('price', function (Blueprint $table) {
            // Lấy product_id về làm khóa ngoại
            $table->foreignIdFor(Product::class)->constrained();

            // Tạo 2 cột month và year cùng kiểu DL với times
            $table->unsignedInteger('month');
            $table->unsignedInteger('year');

            // Ràng buộc khóa ngoại với times
            $table->foreign(['month', 'year'])->references(['month', 'year'])->on('times');

            $table->decimal("price");
            // Ràng buộc khóa chính
            $table->primary(['product_id', 'month', 'year']);
        });
    }
};
