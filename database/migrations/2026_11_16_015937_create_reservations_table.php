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
        Schema::create('reservations', function (Blueprint $table) {
    $table->id();
    $table->string('booking_code', 30)->unique();
    $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
    $table->foreignId('branch_id')->constrained('branches')->cascadeOnDelete();
    $table->foreignId('package_id')->constrained('packages')->cascadeOnDelete();
    $table->date('booking_date');
    $table->time('start_time');
    $table->time('end_time');
    $table->integer('total_people')->default(1);
    $table->decimal('total_price', 12, 2);
    $table->enum('status', ['pending', 'confirmed', 'completed', 'cancelled'])->default('pending');
    $table->text('notes')->nullable();
    $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reservations');
    }
};
