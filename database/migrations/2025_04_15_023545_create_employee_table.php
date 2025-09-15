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
        Schema::create('employee', function (Blueprint $table) {
            $table->id();
            $table->string('full_name', 255);
            $table->string('email', 255)->unique();
            $table->string('phone', 15)->unique();
            $table->string('address', 255)->nullable();
            $table->date('birth_day')->nullable();
            $table->date('hire_date')->default(now());
            $table->string('position', 100); // Vị trí công việc
            $table->decimal('salary', 12, 2)->default(0); // Lương
            $table->foreignId('admin_id')->constrained('admin'); // Liên kết với quyền admin
            $table->tinyInteger('status')->default(1); // Trạng thái: 1 - Đang làm việc, 0 - Nghỉ việc
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employee');
    }
};
