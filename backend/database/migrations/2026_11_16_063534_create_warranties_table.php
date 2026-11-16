
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('warranties', function (Blueprint $table) {
            $table->id();

            $table->foreignId('service_item_id')
                ->constrained('service_items')
                ->restrictOnDelete();

            $table->foreignId('handover_record_id')
                ->unique()
                ->constrained('service_handover_records')
                ->restrictOnDelete();

            $table->dateTime('starts_at');
            $table->dateTime('expires_at');
            $table->boolean('is_eligible')->default(true);
            $table->string('exclusion_reason', 255)->nullable();
            $table->timestamps();

            $table->index('expires_at', 'warranties_expiry_idx');
            $table->index('service_item_id', 'warranties_item_idx');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('warranties');
    }
};
