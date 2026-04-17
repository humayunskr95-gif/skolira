<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {

            // $table->string('student_id')->nullable()->after('id');

            // $table->string('father_name')->nullable();
            // $table->string('mother_name')->nullable();


            $table->string('gender')->nullable();
            $table->date('dob')->nullable();

            $table->string('class')->nullable();
            $table->string('section')->nullable();

            $table->string('address1')->nullable();
            $table->string('address2')->nullable();

            $table->string('state')->nullable();
            $table->string('district')->nullable();
            $table->string('block')->nullable();
            $table->string('city')->nullable();
            $table->string('pin')->nullable();

            $table->string('photo')->nullable();

        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            //
        });
    }
};
