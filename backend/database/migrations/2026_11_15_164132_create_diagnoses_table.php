
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('diagnoses', function (Blueprint $table) {
            $table->id();

            $table->foreignId('service_item_id')
                ->constrained('service_items')
                ->restrictOnDelete();

            $table->foreignId('diagnosed_by')
                ->constrained('users')
                ->restrictOnDelete();

            $table->text('diagnosis');
            $table->text('recommended_action')->nullable();
            $table->dateTime('diagnosed_at');

            $table->timestamps();

            $table->index(['service_item_id', 'diagnosed_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('diagnoses');
    }
};
