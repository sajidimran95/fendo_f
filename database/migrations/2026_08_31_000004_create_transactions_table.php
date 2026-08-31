<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('contact_id')->constrained()->cascadeOnDelete();
            $table->enum('type', ['lend', 'borrow', 'pay_debt', 'close_debt']);
            $table->decimal('amount', 12, 2)->default(0);
            $table->string('description')->nullable();
            $table->decimal('balance_after', 12, 2)->default(0);
            $table->timestamps();

            $table->index(['user_id', 'created_at']);
            $table->index(['contact_id', 'created_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
