<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('persons', function (Blueprint $table) {
            $table->id();
            $table->string('national_id', 10)->unique()->comment('کد ملی');
            $table->string('name')->comment('نام و نام خانوادگی');
            $table->string('phone', 11)->nullable()->comment('شماره تلفن');
            $table->foreignId('unit_id')->nullable()->constrained('units')->onDelete('set null')->comment('واحد مرتبط');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('persons');
    }
};