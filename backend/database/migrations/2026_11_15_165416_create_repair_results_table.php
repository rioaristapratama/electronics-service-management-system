
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('repair_results', function (Blueprint $table) {
            $table->id();

            $table->foreignId('service_item_id')
                ->constrained('service_items')
                ->restrictOnDelete();

            $table->foreignId('recorded_by')
                ->constrained('users')
                ->restrictOnDelete();

            $table->string('result', 30);
            $table->text('repair_notes')->nullable();
            $table->dateTime('completed_at');

            $table->timestamps();

            $table->index(
                ['service_item_id', 'completed_at'],
                'repair_item_date_idx'
            );
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('repair_results');
    }
};
