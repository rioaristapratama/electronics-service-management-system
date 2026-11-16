
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('service_item_costs', function (Blueprint $table) {
            $table->id();

            $table->foreignId('service_item_id')
                ->constrained('service_items')
                ->restrictOnDelete();

            $table->foreignId('recorded_by')
                ->constrained('users')
                ->restrictOnDelete();

            $table->string('cost_type', 30);
            $table->string('description', 255);
            $table->decimal('amount', 15, 2);
            $table->dateTime('recorded_at');
            $table->timestamps();

            $table->index(
                ['service_item_id', 'recorded_at'],
                'sicost_item_date_idx'
            );
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('service_item_costs');
    }
};
