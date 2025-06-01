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
        Schema::create('ratings', function (Blueprint $table) {
            $table->id(); // Cột id
            $table->unsignedBigInteger('customer_id'); // Cột customer_id
            $table->tinyInteger('rating'); // Đánh giá (ví dụ 1-5 sao)
            $table->text('comment')->nullable(); // Bình luận của khách hàng
            $table->timestamps();
        
            // Tạo foreign key cho customer_id
            $table->foreign('customer_id')->references('id')->on('customer')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ratings');
    }
};
