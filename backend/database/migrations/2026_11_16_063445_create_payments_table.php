
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

            $table->foreignId('customer_id')
                ->constrained('customers')
                ->restrictOnDelete();

            $table->foreignId('received_by')
                ->constrained('users')
                ->restrictOnDelete();

            $table->string('payment_number', 50)->unique();
            $table->decimal('amount', 15, 2);
            $table->string('payment_method', 30);
            $table->string('reference_number', 100)->nullable();
            $table->dateTime('payment_date');
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->index('payment_date', 'payments_date_idx');
            $table->index(
                ['customer_id', 'payment_date'],
                'payments_customer_date_idx'
            );
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
