<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
{
    Schema::table('users', function (Blueprint $table) {

        if (Schema::hasColumn('users', 'school_id')) {
            $table->dropColumn('school_id');
        }

        if (Schema::hasColumn('users', 'mobile')) {
            $table->dropColumn('mobile');
        }

        if (Schema::hasColumn('users', 'image')) {
            $table->dropColumn('image');
        }

    });
}

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['school_id','mobile','image']);
        });
    }
};
