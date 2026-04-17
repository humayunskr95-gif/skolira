<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::create('transport_routes', function (Blueprint $table) {
        $table->id();
        $table->string('name');
        $table->string('start_point')->nullable();
        $table->string('end_point')->nullable();
        $table->unsignedBigInteger('school_id');
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transport_routes');
    }
};
