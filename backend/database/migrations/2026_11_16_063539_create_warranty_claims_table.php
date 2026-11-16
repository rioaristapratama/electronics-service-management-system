
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('warranty_claims', function (Blueprint $table) {
            $table->id();

            $table->foreignId('warranty_id')
                ->constrained('warranties')
                ->restrictOnDelete();

            $table->foreignId('recorded_by')
                ->constrained('users')
                ->restrictOnDelete();

            $table->foreignId('decided_by')
                ->nullable()
                ->constrained('users')
                ->restrictOnDelete();

            $table->dateTime('reported_at');
            $table->dateTime('recorded_at');
            $table->text('issue_description');
            $table->string('decision', 30)->default('PENDING');
            $table->dateTime('decided_at')->nullable();
            $table->text('decision_notes')->nullable();
            $table->string('proof_path', 500)->nullable();
            $table->timestamps();

            $table->index(
                ['warranty_id', 'reported_at'],
                'wc_warranty_date_idx'
            );
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('warranty_claims');
    }
};
