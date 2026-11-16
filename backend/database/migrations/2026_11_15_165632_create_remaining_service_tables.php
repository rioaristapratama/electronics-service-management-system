
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Master komponen
        Schema::create('components', function (Blueprint $table) {
            $table->id();
            $table->string('name', 150);
            $table->string('description')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->index('is_active', 'components_active_idx');
        });

        // 2. Kebutuhan komponen per perangkat
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

        // 3. Biaya aktual per perangkat
        Schema::create('service_item_costs', function (Blueprint $table) {
            $table->id();

            $table->foreignId('service_item_id')
                ->constrained('service_items')
                ->restrictOnDelete();

            $table->foreignId('recorded_by')
                ->constrained('users')
                ->restrictOnDelete();

            $table->string('cost_type', 30);
            $table->string('description', 255)->nullable();
            $table->decimal('amount', 15, 2);
            $table->dateTime('recorded_at');
            $table->timestamps();

            $table->index(
                ['service_item_id', 'recorded_at'],
                'sicost_item_date_idx'
            );
        });

        // 4. Foto perangkat dan riwayat penggantian
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
            $table->text('description')->nullable();
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

        // 5. Transaksi pembayaran
        Schema::create('payments', function (Blueprint $table) {
            $table->id();

            $table->foreignId('recorded_by')
                ->constrained('users')
                ->restrictOnDelete();

            $table->string('payment_number', 50)->unique();
            $table->decimal('amount', 15, 2);
            $table->string('payment_method', 30);
            $table->string('reference_number', 100)->nullable();
            $table->dateTime('paid_at');
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->index('paid_at', 'payments_paid_at_idx');
        });

        // 6. Alokasi pembayaran ke perangkat
        Schema::create('payment_allocations', function (Blueprint $table) {
            $table->id();

            $table->foreignId('payment_id')
                ->constrained('payments')
                ->restrictOnDelete();

            $table->foreignId('service_item_id')
                ->constrained('service_items')
                ->restrictOnDelete();

            $table->decimal('allocated_amount', 15, 2);
            $table->string('allocation_type', 30)->default('PAYMENT');
            $table->dateTime('allocated_at');
            $table->timestamps();

            $table->index(
                ['service_item_id', 'allocated_at'],
                'pa_item_date_idx'
            );
        });

        // 7. Pengembalian dana
        Schema::create('refunds', function (Blueprint $table) {
            $table->id();

            $table->foreignId('payment_allocation_id')
                ->constrained('payment_allocations')
                ->restrictOnDelete();

            $table->foreignId('recorded_by')
                ->constrained('users')
                ->restrictOnDelete();

            $table->decimal('amount', 15, 2);
            $table->string('refund_method', 30);
            $table->string('reason', 255);
            $table->dateTime('refunded_at');
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->index('refunded_at', 'refunds_date_idx');
        });

        // 8. Catatan komunikasi dengan pelanggan
        Schema::create('communication_logs', function (Blueprint $table) {
            $table->id();

            $table->foreignId('service_item_id')
                ->nullable()
                ->constrained('service_items')
                ->restrictOnDelete();

            $table->foreignId('customer_contact_id')
                ->nullable()
                ->constrained('customer_contacts')
                ->nullOnDelete();

            $table->foreignId('recorded_by')
                ->constrained('users')
                ->restrictOnDelete();

            $table->string('communication_type', 30);
            $table->string('direction', 20)->nullable();
            $table->string('recipient_name', 150)->nullable();
            $table->string('recipient_phone', 30)->nullable();
            $table->text('message');
            $table->string('proof_path', 500)->nullable();
            $table->dateTime('communicated_at');
            $table->timestamps();

            $table->index(
                ['service_item_id', 'communicated_at'],
                'cl_item_date_idx'
            );
        });

        // 9. Catatan pemberitahuan pelanggan
        Schema::create('notification_records', function (Blueprint $table) {
            $table->id();

            $table->foreignId('service_item_id')
                ->constrained('service_items')
                ->restrictOnDelete();

            $table->foreignId('communication_log_id')
                ->nullable()
                ->constrained('communication_logs')
                ->nullOnDelete();

            $table->foreignId('recorded_by')
                ->constrained('users')
                ->restrictOnDelete();

            $table->string('notification_type', 30);
            $table->string('status', 20)->default('PENDING');
            $table->string('recipient_name', 150)->nullable();
            $table->string('recipient_phone', 30);
            $table->text('message');
            $table->string('proof_path', 500)->nullable();
            $table->dateTime('attempted_at')->nullable();
            $table->dateTime('delivered_at')->nullable();
            $table->text('failure_reason')->nullable();
            $table->timestamps();

            $table->index(
                ['service_item_id', 'status'],
                'nr_item_status_idx'
            );

            $table->index('delivered_at', 'nr_delivered_idx');
        });

        // 10. Serah terima perangkat
        Schema::create('service_handover_records', function (Blueprint $table) {
            $table->id();

            $table->foreignId('service_item_id')
                ->constrained('service_items')
                ->restrictOnDelete();

            $table->foreignId('handed_over_by')
                ->constrained('users')
                ->restrictOnDelete();

            $table->string('received_by_name', 150);
            $table->string('received_by_phone', 30)->nullable();
            $table->string('relationship', 50)->nullable();
            $table->boolean('third_party_authorized')->default(false);
            $table->string('proof_path', 500)->nullable();
            $table->dateTime('handed_over_at');
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->index(
                ['service_item_id', 'handed_over_at'],
                'shr_item_date_idx'
            );
        });

        // 11. Garansi per perangkat
        Schema::create('warranties', function (Blueprint $table) {
            $table->id();

            $table->foreignId('service_item_id')
                ->unique()
                ->constrained('service_items')
                ->restrictOnDelete();

            $table->foreignId('handover_record_id')
                ->constrained('service_handover_records')
                ->restrictOnDelete();

            $table->dateTime('starts_at');
            $table->dateTime('expires_at');
            $table->boolean('is_eligible')->default(true);
            $table->string('exclusion_reason', 255)->nullable();
            $table->timestamps();

            $table->index('expires_at', 'warranties_expiry_idx');
        });

        // 12. Klaim garansi
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

        // 13. Audit log perubahan penting
        Schema::create('audit_logs', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->string('action', 100);
            $table->string('auditable_type', 100)->nullable();
            $table->unsignedBigInteger('auditable_id')->nullable();
            $table->json('old_values')->nullable();
            $table->json('new_values')->nullable();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->dateTime('created_at');

            $table->index(
                ['auditable_type', 'auditable_id'],
                'audit_subject_idx'
            );

            $table->index('user_id', 'audit_user_idx');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('audit_logs');
        Schema::dropIfExists('warranty_claims');
        Schema::dropIfExists('warranties');
        Schema::dropIfExists('service_handover_records');
        Schema::dropIfExists('notification_records');
        Schema::dropIfExists('communication_logs');
        Schema::dropIfExists('refunds');
        Schema::dropIfExists('payment_allocations');
        Schema::dropIfExists('payments');
        Schema::dropIfExists('service_item_photos');
        Schema::dropIfExists('service_item_costs');
        Schema::dropIfExists('service_item_components');
        Schema::dropIfExists('components');
    }
};
