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
        Schema::create('pedigrees', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cat_id')->constrained('cats')->onDelete('cascade');
            $table->foreignId('parent_id')->constrained('cats')->onDelete('cascade');
            $table->enum('relation_type', ['mother', 'father']);
            $table->timestamps();


            $table->unique(['cat_id', 'parent_id', 'relation_type']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pedigrees');
    }
};
