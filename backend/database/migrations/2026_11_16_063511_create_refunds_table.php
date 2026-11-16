
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('refunds', function (Blueprint $table) {
            $table->id();

            $table->foreignId('payment_allocation_id')
                ->constrained('payment_allocations')
                ->restrictOnDelete();

            $table->foreignId('requested_by')
                ->constrained('users')
                ->restrictOnDelete();

            $table->foreignId('approved_by')
                ->nullable()
                ->constrained('users')
                ->restrictOnDelete();

            $table->decimal('amount', 15, 2);
            $table->string('refund_method', 30);
            $table->string('reason', 255);
            $table->string('refund_status', 20)->default('PENDING');
            $table->dateTime('requested_at');
            $table->dateTime('approved_at')->nullable();
            $table->dateTime('refunded_at')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->index('refund_status', 'refunds_status_idx');
            $table->index('requested_at', 'refunds_requested_idx');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('refunds');
    }
};
