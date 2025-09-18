<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('locations', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('type')->comment('نوع مکان: مانند استان، شهرستان و غیره');
            $table->foreignId('parent_id')->nullable()->constrained('locations')->onDelete('cascade');
            $table->string('slug')->unique()->comment('برای URLهای سئو شده');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('locations');
    }
};