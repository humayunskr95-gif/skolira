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
        Schema::create('staff_leaves', function (Blueprint $table) {
    $table->id();

    $table->foreignId('staff_id')->constrained('users')->cascadeOnDelete();
    $table->foreignId('school_id')->constrained('users')->cascadeOnDelete();

    $table->string('reason');
    $table->date('from_date');
    $table->date('to_date');

    $table->enum('status', ['pending','approved','rejected'])->default('pending');

    $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('staff_leaves');
    }
};
