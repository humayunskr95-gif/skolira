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
        Schema::table('plans', function (Blueprint $table) {

    // $table->boolean('subjects')->default(0);
    // $table->boolean('classes')->default(0);
    // $table->boolean('sections')->default(0);

    // $table->boolean('attendance')->default(0);
    $table->boolean('results')->default(0);

    // $table->boolean('fees')->default(0);
    // $table->boolean('accounts')->default(0);

    // $table->boolean('hostel')->default(0);

    // $table->boolean('transport')->default(0);
    $table->boolean('driver_assign')->default(0);
    $table->boolean('vehicles')->default(0);
    $table->boolean('routes')->default(0);

    $table->boolean('staff_attendance')->default(0);
    $table->boolean('leave')->default(0);

    // $table->boolean('reports')->default(0);
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('plans', function (Blueprint $table) {
            //
        });
    }
};
