<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('unit_type_relationships', function (Blueprint $table) {
            $table->id();
            $table->foreignId('parent_type_id')->constrained('unit_types')->onDelete('cascade');
            $table->foreignId('child_type_id')->constrained('unit_types')->onDelete('cascade');
            $table->timestamps();
            $table->unique(['parent_type_id', 'child_type_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('unit_type_relationships');
    }
};