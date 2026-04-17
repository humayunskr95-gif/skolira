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
        Schema::create('staff_attendances', function (Blueprint $table) {
    $table->id();

    $table->foreignId('staff_id')->constrained('users')->cascadeOnDelete();
    $table->foreignId('school_id')->constrained('users')->cascadeOnDelete();

    $table->date('date');

    $table->enum('status', ['present','absent','late'])->default('present');

    $table->time('check_in')->nullable();
    $table->time('check_out')->nullable();

    $table->timestamps();

    $table->unique(['staff_id','date']); // duplicate prevent
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('staff_attendances');
    }
};
