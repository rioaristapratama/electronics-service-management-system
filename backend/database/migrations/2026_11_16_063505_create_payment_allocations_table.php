
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('payment_allocations', function (Blueprint $table) {
            $table->id();

            $table->foreignId('payment_id')
                ->constrained('payments')
                ->restrictOnDelete();

            $table->foreignId('service_item_id')
                ->constrained('service_items')
                ->restrictOnDelete();

            $table->decimal('allocated_amount', 15, 2);
            $table->string('allocation_type', 30)->default('PAYMENT');
            $table->dateTime('allocated_at');
            $table->timestamps();

            $table->index(
                ['service_item_id', 'allocated_at'],
                'pa_item_date_idx'
            );

            $table->index('payment_id', 'pa_payment_idx');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payment_allocations');
    }
};
