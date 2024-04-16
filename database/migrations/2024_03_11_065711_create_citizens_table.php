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
        Schema::create('citizens', function (Blueprint $table) {
            $table->id();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('patronymic');
            $table->string('passport')->unique();
            $table->bigInteger('tin')->unique();
            $table->date('birth_date');
            $table->foreignId('region_id')->constrained();
            $table->foreignId('city_id')->constrained();
            $table->string('address');
            $table->string('phone');
            $table->unsignedBigInteger('doctor_user_id');
            $table->foreign('doctor_user_id')->references('id')->on('users');
            $table->foreignId('diseases_id')->constrained();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('citizens');
    }
};
