
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('service_item_components', function (Blueprint $table) {
            $table->id();

            $table->foreignId('service_item_id')
                ->constrained('service_items')
                ->restrictOnDelete();

            $table->foreignId('component_id')
                ->constrained('components')
                ->restrictOnDelete();

            $table->decimal('quantity', 10, 2)->default(1);
            $table->string('usage_status', 30)->default('NEEDED');
            $table->dateTime('ordered_at')->nullable();
            $table->dateTime('expected_at')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->index(
                ['service_item_id', 'usage_status'],
                'sic_item_status_idx'
            );
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('service_item_components');
    }
};
