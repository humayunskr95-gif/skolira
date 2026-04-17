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
    Schema::table('users', function (Blueprint $table) {

        // $table->unsignedBigInteger('class_id')->nullable();
        // $table->unsignedBigInteger('section_id')->nullable();

        // $table->integer('roll')->nullable();

        // $table->string('address1')->nullable();
        // $table->string('address2')->nullable();

        // $table->string('state')->nullable();
        // $table->string('district')->nullable();
        // $table->string('block')->nullable();
        // $table->string('city')->nullable();
        // $table->string('pin')->nullable();

        // $table->string('photo')->nullable();

        // $table->boolean('is_active')->default(1);
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            //
        });
    }
};
