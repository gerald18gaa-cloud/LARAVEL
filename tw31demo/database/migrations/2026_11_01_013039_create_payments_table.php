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

            $table->foreignId('membership_transaction_id')
                ->constrained('membership_transactions')
                ->cascadeOnDelete();

            $table->string('payment_reference')->unique();

            $table->decimal('amount', 10, 2);

            $table->enum('payment_method', [
                'Cash',
                'Bank Transfer',
                'GCash',
                'Credit Card',
                'Debit Card',
            ]);

            $table->dateTime('paid_at');

            $table->text('notes')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};