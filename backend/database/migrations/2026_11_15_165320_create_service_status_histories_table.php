
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('service_status_histories', function (Blueprint $table) {
            $table->id();

            $table->foreignId('service_item_id')
                ->constrained('service_items')
                ->restrictOnDelete();

            $table->string('old_status', 50)->nullable();
            $table->string('new_status', 50);

            $table->foreignId('changed_by')
                ->constrained('users')
                ->restrictOnDelete();

            $table->dateTime('changed_at');
            $table->text('reason')->nullable();

            $table->timestamps();

            $table->index(
                ['service_item_id', 'changed_at'],
                'status_item_date_idx'
            );
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('service_status_histories');
    }
};
