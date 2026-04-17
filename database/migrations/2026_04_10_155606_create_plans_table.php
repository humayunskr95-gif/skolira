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
        Schema::create('plans', function (Blueprint $table) {
    $table->id();
    $table->string('name'); // Basic / Pro
    $table->integer('price');
    $table->integer('duration'); // days
    $table->timestamps();
    $table->integer('student_limit')->nullable();
    $table->integer('teacher_limit')->nullable();
    $table->integer('parent_limit')->nullable();
    $table->boolean('attendance')->default(0);
    $table->boolean('hostel')->default(0);
    $table->boolean('transport')->default(0);
    $table->boolean('accounts')->default(0);
    $table->boolean('exam')->default(0);
   });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('plans');
    }
};
