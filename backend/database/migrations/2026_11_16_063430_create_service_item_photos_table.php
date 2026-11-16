
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('service_item_photos', function (Blueprint $table) {
            $table->id();

            $table->foreignId('service_item_id')
                ->constrained('service_items')
                ->restrictOnDelete();

            $table->foreignId('uploaded_by')
                ->constrained('users')
                ->restrictOnDelete();

            $table->string('photo_type', 20);
            $table->string('file_path', 500);
            $table->text('caption')->nullable();
            $table->dateTime('uploaded_at');

            $table->foreignId('replaces_photo_id')
                ->nullable()
                ->constrained('service_item_photos')
                ->restrictOnDelete();

            $table->timestamps();

            $table->index(
                ['service_item_id', 'photo_type'],
                'sip_item_type_idx'
            );
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('service_item_photos');
    }
};
