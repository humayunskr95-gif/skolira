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
    Schema::table('results', function (Blueprint $table) {
        $table->dropColumn('subject'); // ❌ remove text subject

        $table->foreignId('subject_id')->after('student_id');
        $table->string('grade')->nullable();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
