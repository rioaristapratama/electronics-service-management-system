
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('service_estimate_histories', function (Blueprint $table) {
            $table->id();

            $table->foreignId('service_item_id')
                ->constrained('service_items')
                ->restrictOnDelete();

            $table->foreignId('recorded_by')
                ->constrained('users')
                ->restrictOnDelete();

            $table->decimal('estimated_labor_cost', 15, 2)->default(0);
            $table->decimal('estimated_parts_cost', 15, 2)->default(0);
            $table->decimal('estimated_other_cost', 15, 2)->default(0);
            $table->decimal('total_estimated_cost', 15, 2);

            $table->text('notes')->nullable();
            $table->dateTime('estimated_at');

            $table->timestamps();

            $table->index(['service_item_id', 'estimated_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('service_estimate_histories');
    }
};
