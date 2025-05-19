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
        Schema::create('cats', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->enum('gender', ['кошка', 'кот'])->default('кошка');
            $table->date('birth_date');
            $table->string('color');
            $table->foreignId('breed_id')->constrained('breeds');
            $table->enum('status',['доступен','забронирован','усыновлен'])->default('доступен');
            $table->string('photo')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cats');
    }
};
