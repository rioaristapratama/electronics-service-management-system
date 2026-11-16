
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('service_handover_records', function (Blueprint $table) {
            $table->id();

            $table->foreignId('service_item_id')
                ->constrained('service_items')
                ->restrictOnDelete();

            $table->foreignId('handed_over_by')
                ->constrained('users')
                ->restrictOnDelete();

            $table->string('recipient_name', 150);
            $table->string('recipient_phone', 30)->nullable();
            $table->string('recipient_type', 30);

            $table->foreignId('authorized_by_contact_id')
                ->nullable()
                ->constrained('customer_contacts')
                ->nullOnDelete();

            $table->string('authorization_method', 50)->nullable();
            $table->text('authorization_notes')->nullable();
            $table->string('proof_path', 500)->nullable();
            $table->dateTime('handed_over_at');
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->index(
                ['service_item_id', 'handed_over_at'],
                'shr_item_date_idx'
            );
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('service_handover_records');
    }
};
