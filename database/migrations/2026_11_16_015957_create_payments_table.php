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
        Schema::create('payments', function (Blueprint $table) {
        $table->id();
        $table->foreignId('reservation_id')->constrained('reservations')->cascadeOnDelete();
        $table->string('payment_method', 50);
        $table->decimal('amount', 12, 2);
        $table->string('proof_image')->nullable();
        $table->enum('payment_status', ['unpaid', 'pending_verification', 'paid', 'rejected'])->default('unpaid');
        $table->timestamp('paid_at')->nullable();
        $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
