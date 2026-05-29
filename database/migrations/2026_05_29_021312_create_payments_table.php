<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->string('invoice_number')->unique();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('peserta_id')->nullable();
            $table->decimal('amount', 15, 2);
            $table->decimal('paid_amount', 15, 2)->default(0);
            $table->string('status')->default('pending');
            $table->string('payment_method')->default('transfer');
            $table->string('external_id')->nullable();
            $table->json('payment_details')->nullable();
            $table->timestamp('expired_at')->nullable();
            $table->timestamp('paid_at')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
            
            $table->index(['status', 'expired_at']);
            $table->index('invoice_number');
            $table->index('user_id');
            $table->index('peserta_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};