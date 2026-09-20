<?php

namespace App\Http\Controllers;

use App\Models\ApprovalRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Notification;
use App\Models\User;

class ApprovalRequestController extends Controller
{
    // ── Index ──────────────────────────────────────────────────
    public function index(Request $request)
    {
       $this->authorize('viewAny', ApprovalRequest::class);

        $user = Auth::user();

        $requests = ApprovalRequest::with(['requester', 'approver'])
            ->byRole($user)
            ->when($request->status, fn($q) => $q->where('status', $request->status))
            ->when($request->tipe,   fn($q) => $q->where('tipe',   $request->tipe))
            ->when($request->search, fn($q) => $q->where('judul',  'like', '%'.$request->search.'%'))
            ->latest()
            ->paginate(10)
            ->through(fn($req) => $this->withIcon($req));

       $view = $user->role === 'manajer'
    ? 'approval.manager.index'
    : 'approval.index';

        return view($view, [
            'requests' => $requests,
            'counts'   => ApprovalRequest::counts(),
        ]);
    }

    // ── Create ─────────────────────────────────────────────────
    public function create()
    {
        $this->authorize('create', ApprovalRequest::class);

        return view('approval.create');
    }

    // ── Store ──────────────────────────────────────────────────
    public function store(Request $request)
    {
        $this->authorize('create', ApprovalRequest::class);

        $validated = $request->validate([
            'judul'     => 'required|string|max:255',
            'deskripsi' => 'nullable|string|max:255',
            'tipe'      => 'required|in:restock,supplier,hapus_batch,tambah_obat',
        ]);

        ApprovalRequest::create([
            ...$validated,
            'status'       => 'pending',
            'requested_by' => Auth::id(),
        ]);
// Kirim notifikasi ke semua Manager
User::where('role', 'manajer')->each(function($manajer) use ($validated) {
    Notification::kirim(
        userId : $manajer->id,
        type   : 'approval_new',
        title  : 'Pengajuan Baru Masuk',
        message: "Admin mengajukan: {$validated['judul']}",
        url    : route('approval-requests.index'),
    );
});
        return redirect()->route('approval-requests.index')
            ->with('success', 'Pengajuan berhasil dikirim, menunggu persetujuan Manager.');
    }

    // ── Show ───────────────────────────────────────────────────
    public function show(ApprovalRequest $approvalRequest)
    {
        return view('approval.show', [
            'approvalRequest' => $this->withIcon($approvalRequest),
        ]);
    }

    // ── Approve ────────────────────────────────────────────────
    public function approve(ApprovalRequest $approvalRequest)
    {
        $this->authorize('decide', $approvalRequest);

        // Atomic — aman dari race condition
        $updated = ApprovalRequest::where('id', $approvalRequest->id)
            ->where('status', 'pending')
            ->update([
                'status'      => 'approved',
                'approved_by' => Auth::id(),
                'approved_at' => now(),
            ]);
// Kirim notifikasi ke Admin yang mengajukan
if ($updated) {
    Notification::kirim(
        userId : $approvalRequest->requested_by,
        type   : 'approval_approved',
        title  : 'Pengajuan Disetujui ✔',
        message: "Pengajuan \"{$approvalRequest->judul}\" telah disetujui oleh Manager.",
        url    : route('approval-requests.show', $approvalRequest->id),
    );
}

        $message = $updated
            ? "Pengajuan \"{$approvalRequest->judul}\" berhasil disetujui."
            : 'Request ini sudah diproses sebelumnya.';

        $flash = $updated ? 'success' : 'error';

        return redirect()->route('approval-requests.index')
            ->with($flash, $message);
    }

    // ── Reject ─────────────────────────────────────────────────
    public function reject(Request $request, ApprovalRequest $approvalRequest)
    {
        $this->authorize('decide', $approvalRequest);

        $request->validate([
            'reason' => 'nullable|string|max:255',
        ]);

        $updated = ApprovalRequest::where('id', $approvalRequest->id)
            ->where('status', 'pending')
            ->update([
                'status'        => 'rejected',
                'approved_by'   => Auth::id(),
                'approved_at'   => now(),
                'reject_reason' => $request->reason,
            ]);
// Kirim notifikasi ke Admin yang mengajukan
if ($updated) {
    Notification::kirim(
        userId : $approvalRequest->requested_by,
        type   : 'approval_rejected',
        title  : 'Pengajuan Ditolak ✕',
        message: "Pengajuan \"{$approvalRequest->judul}\" telah ditolak oleh Manager.",
        url    : route('approval-requests.show', $approvalRequest->id),
    );
}
        $message = $updated
            ? "Pengajuan \"{$approvalRequest->judul}\" berhasil ditolak."
            : 'Request ini sudah diproses sebelumnya.';

        $flash = $updated ? 'info' : 'error';

        return redirect()->route('approval-requests.index')
            ->with($flash, $message);
    }

    // ── Riwayat ────────────────────────────────────────────────
    public function riwayat(Request $request)
    {
        $this->authorize('riwayat', ApprovalRequest::class);

        $managerId = Auth::id();

        $riwayat = ApprovalRequest::with('requester')
            ->where('approved_by', $managerId)
            ->whereIn('status', ['approved', 'rejected'])
            ->when($request->status, fn($q) => $q->where('status', $request->status))
            ->when($request->tipe,   fn($q) => $q->where('tipe',   $request->tipe))
            ->when($request->dari,   fn($q) => $q->whereDate('approved_at', '>=', $request->dari))
            ->when($request->sampai, fn($q) => $q->whereDate('approved_at', '<=', $request->sampai))
            ->latest('approved_at')
            ->paginate(15)
            ->through(fn($req) => $this->withIcon($req));

        return view('approval.manager.riwayat', [
            'riwayat' => $riwayat,
            'stats'   => ApprovalRequest::managerStats($managerId),
        ]);
    }

    // ── Private Helper ─────────────────────────────────────────
    private function withIcon(ApprovalRequest $req): ApprovalRequest
    {
        $config         = $req->iconConfig();
        $req->icon_type = $config['type'];
        $req->icon      = $config['icon'];
        return $req;
    }
}
