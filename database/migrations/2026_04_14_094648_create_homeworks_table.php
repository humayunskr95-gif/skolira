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
       Schema::create('homeworks', function (Blueprint $table) {
    $table->id();
    $table->foreignId('teacher_id');
    $table->foreignId('subject_id');
    $table->foreignId('class_id');
    $table->foreignId('section_id')->nullable();
    $table->text('title');
    $table->text('description')->nullable();
    $table->date('due_date');
    $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('homeworks');
    }
};
