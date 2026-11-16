
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('notification_records', function (Blueprint $table) {
            $table->id();

            $table->foreignId('service_item_id')
                ->constrained('service_items')
                ->restrictOnDelete();

            $table->foreignId('communication_log_id')
                ->nullable()
                ->constrained('communication_logs')
                ->nullOnDelete();

            $table->foreignId('created_by')
                ->constrained('users')
                ->restrictOnDelete();

            $table->string('notification_type', 30);
            $table->string('delivery_status', 20)->default('PENDING');
            $table->string('recipient_name', 150)->nullable();
            $table->string('recipient_phone', 30);
            $table->text('message');
            $table->string('proof_path', 500)->nullable();
            $table->dateTime('attempted_at')->nullable();
            $table->dateTime('delivered_at')->nullable();
            $table->text('failure_reason')->nullable();
            $table->timestamps();

            $table->index(
                ['service_item_id', 'delivery_status'],
                'nr_item_status_idx'
            );

            $table->index('delivered_at', 'nr_delivered_idx');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('notification_records');
    }
};
