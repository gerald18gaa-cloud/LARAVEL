<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('members', function (Blueprint $table) {
            $table->id();

            $table->string('membership_number')->unique();

            $table->string('first_name');
            $table->string('last_name');

            $table->string('email')->nullable()->unique();
            $table->string('phone')->nullable();
            $table->text('address')->nullable();
            $table->date('birth_date')->nullable();

            $table->foreignId('membership_category_id')
                ->constrained('membership_categories')
                ->restrictOnDelete();

            $table->foreignId('membership_level_id')
                ->constrained('membership_levels')
                ->restrictOnDelete();

            $table->string('status')->default('Active');
            $table->date('registered_at')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('members');
    }
};