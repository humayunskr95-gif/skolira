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
        Schema::create('subscriptions', function (Blueprint $table) {
    $table->id();
    $table->unsignedBigInteger('school_id');
    $table->unsignedBigInteger('plan_id');
    $table->date('start_date');
    $table->date('end_date');
    $table->enum('status', ['active','expired']);
    $table->timestamps();
    $table->decimal('amount', 10, 2)->default(0);
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('subscriptions');
    }
};
