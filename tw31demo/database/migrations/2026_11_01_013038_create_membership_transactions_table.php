<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('membership_transactions', function (Blueprint $table) {
            $table->id();

            $table->foreignId('member_id')
                ->constrained('members')
                ->cascadeOnDelete();

            $table->foreignId('membership_level_id')
                ->constrained('membership_levels')
                ->restrictOnDelete();

            $table->string('reference_number')->unique();

            $table->enum('transaction_type', [
                'Application',
                'Renewal',
            ]);

            $table->decimal('amount', 10, 2);

            $table->enum('status', [
                'Pending',
                'Paid',
                'Approved',
                'Expired',
                'Cancelled',
            ])->default('Pending');

            $table->date('transaction_date');
            $table->date('expiry_date')->nullable();
            $table->text('notes')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('membership_transactions');
    }
};