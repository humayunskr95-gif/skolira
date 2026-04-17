<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {

            // 🔥 ROLE (simple string)
            if (!Schema::hasColumn('users', 'role')) {
                $table->string('role')->default('student');
            }

            // 🔥 SCHOOL
            if (!Schema::hasColumn('users', 'school_id')) {
                $table->unsignedBigInteger('school_id')->nullable();
            }

            // 🔥 MOBILE
            if (!Schema::hasColumn('users', 'mobile')) {
                $table->string('mobile')->nullable()->after('email');
            }

            // 🔥 IMAGE
            if (!Schema::hasColumn('users', 'image')) {
                $table->string('image')->nullable()->after('mobile');
            }

            // 🔥 CLASS & SECTION
            if (!Schema::hasColumn('users', 'class_id')) {
                $table->unsignedBigInteger('class_id')->nullable();
            }

            if (!Schema::hasColumn('users', 'section_id')) {
                $table->unsignedBigInteger('section_id')->nullable();
            }

            // ❌ REMOVE role_id completely
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {

            $table->dropColumn([
                'role',
                'school_id',
                'mobile',
                'image',
                'class_id',
                'section_id'
            ]);

            // ❌ no role_id
        });
    }
};