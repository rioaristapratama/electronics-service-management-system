<?php

namespace App\Http\Controllers;

use App\Models\CustomerApprovalHistory;
use App\Models\Diagnosis;
use App\Models\ServiceEstimateHistory;
use App\Models\ServiceItem;
use App\Models\ServiceStatusHistory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class DiagnosisEstimateController extends Controller
{
    /**
     * Menyimpan hasil diagnosis perangkat.
     */
    public function storeDiagnosis(
        Request $request,
        ServiceItem $serviceItem
    ): RedirectResponse {
        $validated = $request->validate([
            'diagnosis' => ['required', 'string', 'max:10000'],
            'recommended_action' => ['nullable', 'string', 'max:10000'],
        ]);

        DB::transaction(function () use ($validated, $serviceItem) {
            $item = ServiceItem::whereKey($serviceItem->id)
                ->lockForUpdate()
                ->firstOrFail();

            if ($item->current_status !== 'DITERIMA') {
                abort(422, 'Diagnosis hanya dapat dicatat pada perangkat yang baru diterima.');
            }

            $diagnosis = new Diagnosis([
                'service_item_id' => $item->id,
                'diagnosis' => $validated['diagnosis'],
                'recommended_action' => $validated['recommended_action'] ?? null,
                'diagnosed_at' => now(),
            ]);

            $diagnosis->diagnosed_by = Auth::id();
            $diagnosis->save();

            $this->changeStatus(
                $item,
                'DIAGNOSIS',
                'Diagnosis perangkat dicatat.'
            );
        });

        return back()
            ->with('success', 'Hasil diagnosis berhasil disimpan.')
            ->withFragment('diagnosis-item-' . $serviceItem->id);
    }

    /**
     * Menyimpan estimasi pertama atau estimasi hasil negosiasi.
     */
    public function storeEstimate(
        Request $request,
        ServiceItem $serviceItem
    ): RedirectResponse {
        $validated = $request->validate([
            'estimated_labor_cost' => [
                'required',
                'numeric',
                'min:0',
                'max:9999999999999.99',
            ],
            'estimated_parts_cost' => [
                'required',
                'numeric',
                'min:0',
                'max:9999999999999.99',
            ],
            'estimated_other_cost' => [
                'required',
                'numeric',
                'min:0',
                'max:9999999999999.99',
            ],
            'notes' => ['nullable', 'string', 'max:10000'],
        ]);

        DB::transaction(function () use ($validated, $serviceItem) {
            $item = ServiceItem::whereKey($serviceItem->id)
                ->lockForUpdate()
                ->firstOrFail();

            if (!$item->diagnoses()->exists()) {
                abort(422, 'Diagnosis harus dicatat sebelum membuat estimasi biaya.');
            }

            if (!in_array($item->current_status, ['DIAGNOSIS', 'MENAWAR'], true)) {
                abort(422, 'Estimasi tidak dapat dibuat pada status perangkat saat ini.');
            }

            // Jika status MENAWAR, pastikan memang ada keputusan negosiasi.
            if ($item->current_status === 'MENAWAR') {
                $hasNegotiationRequest = $item->estimateHistories()
                    ->whereHas('approvalHistories', function ($query) {
                        $query->where('decision', 'MENAWAR');
                    })
                    ->exists();

                if (!$hasNegotiationRequest) {
                    abort(422, 'Permintaan negosiasi tidak ditemukan.');
                }

                // Pastikan belum pernah ada estimasi revisi.
                $estimateCount = $item->estimateHistories()->count();

                if ($estimateCount !== 1) {
                    abort(422, 'Estimasi revisi hanya dapat dibuat satu kali.');
                }
            }

            $laborCost = (float) $validated['estimated_labor_cost'];
            $partsCost = (float) $validated['estimated_parts_cost'];
            $otherCost = (float) $validated['estimated_other_cost'];

            $totalCost = round(
                $laborCost + $partsCost + $otherCost,
                2
            );

            $estimate = new ServiceEstimateHistory([
                'service_item_id' => $item->id,
                'estimated_labor_cost' => $laborCost,
                'estimated_parts_cost' => $partsCost,
                'estimated_other_cost' => $otherCost,
                'total_estimated_cost' => $totalCost,
                'notes' => $validated['notes'] ?? null,
                'estimated_at' => now(),
            ]);

            $estimate->recorded_by = Auth::id();
            $estimate->save();

            $reason = $item->current_status === 'MENAWAR'
                ? 'Estimasi biaya revisi setelah negosiasi pelanggan.'
                : 'Estimasi biaya awal dibuat dan menunggu persetujuan pelanggan.';

            $this->changeStatus(
                $item,
                'MENUNGGU_PERSETUJUAN',
                $reason
            );
        });

        return back()
            ->with('success', 'Estimasi biaya berhasil disimpan.')
            ->withFragment('estimate-item-' . $serviceItem->id);
    }

    /**
     * Mencatat keputusan pelanggan terhadap estimasi terbaru.
     */
    public function storeApproval(
        Request $request,
        ServiceItem $serviceItem
    ): RedirectResponse {
        $validated = $request->validate([
            'service_estimate_history_id' => [
                'required',
                'integer',
                'exists:service_estimate_histories,id',
            ],
            'customer_contact_id' => [
                'nullable',
                'integer',
                'exists:customer_contacts,id',
            ],
            'decision' => [
                'required',
                Rule::in(['DISETUJUI', 'MENAWAR', 'DITOLAK']),
            ],
            'notes' => ['nullable', 'string', 'max:10000'],
        ]);

        DB::transaction(function () use ($validated, $serviceItem) {
            $item = ServiceItem::with('serviceOrder')
                ->whereKey($serviceItem->id)
                ->lockForUpdate()
                ->firstOrFail();

            if ($item->current_status !== 'MENUNGGU_PERSETUJUAN') {
                abort(422, 'Perangkat tidak sedang menunggu persetujuan pelanggan.');
            }

            $estimate = $item->estimateHistories()
                ->orderByDesc('estimated_at')
                ->orderByDesc('id')
                ->first();

            if (
                !$estimate ||
                (int) $estimate->id !== (int) $validated['service_estimate_history_id']
            ) {
                abort(422, 'Keputusan hanya dapat dicatat untuk estimasi terbaru.');
            }

            // Periksa apakah perangkat sudah pernah menjalani negosiasi.
            $hasNegotiated = $item->estimateHistories()
                ->whereHas('approvalHistories', function ($query) {
                    $query->where('decision', 'MENAWAR');
                })
                ->exists();

            // Negosiasi hanya boleh dilakukan satu kali.
            if ($hasNegotiated && $validated['decision'] === 'MENAWAR') {
                abort(422, 'Negosiasi hanya dapat dilakukan satu kali.');
            }

            // Memastikan kontak benar-benar milik pelanggan pesanan.
            if (!empty($validated['customer_contact_id'])) {
                $customer = $item->serviceOrder->customer;

                $contactBelongsToCustomer = $customer
                    ->contacts()
                    ->whereKey($validated['customer_contact_id'])
                    ->where('is_active', true)
                    ->exists();

                if (!$contactBelongsToCustomer) {
                    abort(422, 'Kontak pelanggan tidak valid atau tidak aktif.');
                }
            }

            $approval = new CustomerApprovalHistory([
                'service_estimate_history_id' => $estimate->id,
                'customer_contact_id' => $validated['customer_contact_id'] ?? null,
                'decision' => $validated['decision'],
                'decided_at' => now(),
                'notes' => $validated['notes'] ?? null,
            ]);

            $approval->recorded_by = Auth::id();
            $approval->save();

            $newStatus = match ($validated['decision']) {
                'DISETUJUI' => 'DISETUJUI',
                'MENAWAR' => 'MENAWAR',
                'DITOLAK' => 'DITOLAK',
            };

            $reason = match ($validated['decision']) {
                'DISETUJUI' => 'Pelanggan menyetujui estimasi biaya.',
                'MENAWAR' => 'Pelanggan meminta satu kali negosiasi estimasi biaya.',
                'DITOLAK' => 'Pelanggan menolak estimasi biaya dan tidak melanjutkan servis.',
            };

            $this->changeStatus($item, $newStatus, $reason);
        });

        return back()
            ->with('success', 'Keputusan pelanggan berhasil dicatat.')
            ->withFragment('approval-item-' . $serviceItem->id);
    }

    /**
     * Mengubah status perangkat sekaligus mencatat riwayatnya.
     */
    private function changeStatus(
        ServiceItem $item,
        string $newStatus,
        ?string $reason = null
    ): void {
        $oldStatus = $item->current_status;

        if ($oldStatus === $newStatus) {
            return;
        }

        $item->current_status = $newStatus;
        $item->save();

        $history = new ServiceStatusHistory([
            'service_item_id' => $item->id,
            'old_status' => $oldStatus,
            'new_status' => $newStatus,
            'changed_at' => now(),
            'reason' => $reason,
        ]);

        $history->changed_by = Auth::id();
        $history->save();
    }
}
