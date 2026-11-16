
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('service_items', function (Blueprint $table) {
            $table->id();

            $table->foreignId('service_order_id')
                ->constrained('service_orders')
                ->cascadeOnDelete();

            $table->foreignId('category_id')
                ->constrained('device_categories')
                ->restrictOnDelete();

            $table->string('device_name', 150);
            $table->string('brand', 100)->nullable();
            $table->string('model', 100)->nullable();
            $table->string('serial_number', 100)->nullable();

            $table->text('complaint');
            $table->text('physical_condition')->nullable();
            $table->text('accessories')->nullable();

            $table->string('current_status', 50)->default('DITERIMA');

            $table->timestamps();

            $table->index(['service_order_id', 'current_status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('service_items');
    }
};
