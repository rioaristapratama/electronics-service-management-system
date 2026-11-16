
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('communication_logs', function (Blueprint $table) {
            $table->id();

            $table->foreignId('service_item_id')
                ->constrained('service_items')
                ->restrictOnDelete();

            $table->foreignId('customer_contact_id')
                ->nullable()
                ->constrained('customer_contacts')
                ->nullOnDelete();

            $table->foreignId('recorded_by')
                ->constrained('users')
                ->restrictOnDelete();

            $table->string('communication_type', 30);
            $table->string('direction', 20)->nullable();
            $table->string('recipient_name', 150)->nullable();
            $table->string('recipient_phone', 30)->nullable();
            $table->text('message');
            $table->string('proof_path', 500)->nullable();
            $table->dateTime('communicated_at');
            $table->timestamps();

            $table->index(
                ['service_item_id', 'communicated_at'],
                'cl_item_date_idx'
            );
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('communication_logs');
    }
};
