
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('customer_approval_histories', function (Blueprint $table) {
            $table->id();

            $table->foreignId('service_estimate_history_id')
                ->constrained('service_estimate_histories')
                ->restrictOnDelete();

            $table->foreignId('customer_contact_id')
                ->nullable()
                ->constrained('customer_contacts')
                ->nullOnDelete();

            $table->foreignId('recorded_by')
                ->constrained('users')
                ->restrictOnDelete();

            $table->string('decision', 30);
            $table->dateTime('decided_at');
            $table->text('notes')->nullable();

            $table->timestamps();

            $table->index(
                ['service_estimate_history_id', 'decided_at'],
                'approval_estimate_date_idx'
            );
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('customer_approval_histories');
    }
};
