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
    Schema::table('schools', function (Blueprint $table) {

        if (!Schema::hasColumn('schools', 'name')) {
            $table->string('name')->nullable();
        }

        if (!Schema::hasColumn('schools', 'owner_name')) {
            $table->string('owner_name')->nullable();
        }

        if (!Schema::hasColumn('schools', 'address1')) {
            $table->string('address1')->nullable();
        }

        if (!Schema::hasColumn('schools', 'address2')) {
            $table->string('address2')->nullable();
        }

        if (!Schema::hasColumn('schools', 'city')) {
            $table->string('city')->nullable();
        }

        if (!Schema::hasColumn('schools', 'district')) {
            $table->string('district')->nullable();
        }

        if (!Schema::hasColumn('schools', 'state')) {
            $table->string('state')->nullable();
        }

        if (!Schema::hasColumn('schools', 'pin')) {
            $table->string('pin')->nullable();
        }

        if (!Schema::hasColumn('schools', 'logo')) {
            $table->string('logo')->nullable();
        }

    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('schools', function (Blueprint $table) {
            //
        });
    }
};
