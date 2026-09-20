<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use App\Models\ApprovalRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;

class PersetujuanController extends Controller
{
    public function index(Request $request)
    {
        if (!Schema::hasTable('approval_requests')) {
            return view('manager.persetujuan', [
                'requests'   => collect(),
                'counts'     => ['pending' => 0, 'approved' => 0, 'rejected' => 0, 'all' => 0],
                'notifCount' => 0,
            ]);
        }

        $status = $request->get('status', 'pending');

        $counts = [
            'pending'  => ApprovalRequest::where('status', 'pending')->count(),
            'approved' => ApprovalRequest::where('status', 'approved')->count(),
            'rejected' => ApprovalRequest::where('status', 'rejected')->count(),
            'all'      => ApprovalRequest::count(),
        ];

        $query = ApprovalRequest::with('requestedBy')->latest();

        if ($status !== 'all') {
            $query->where('status', $status);
        }

        if ($q = $request->get('q')) {
            $query->where(fn($qb) => $qb
                ->where('judul', 'like', "%{$q}%")
                ->orWhere('deskripsi', 'like', "%{$q}%")
            );
        }

        $requests = $query->paginate(15)
                          ->through(fn($req) => $this->mapIcons($req));

        return view('manager.persetujuan', [
            'requests'   => $requests,
            'counts'     => $counts,
            'notifCount' => $counts['pending'],
        ]);
    }

    public function approve($id)
    {
        $req = ApprovalRequest::findOrFail($id);
        $req->update([
            'status'      => 'approved',
            'approved_by' => auth()->id(),
            'approved_at' => now(),
        ]);

        return back()->with('success', "Permintaan \"{$req->judul}\" telah disetujui.");
    }

    public function reject(Request $request, $id)
    {
        $request->validate([
            'reason' => 'nullable|string|max:255',
        ]);

        $req = ApprovalRequest::findOrFail($id);
        $req->update([
            'status'        => 'rejected',
            'approved_by'   => auth()->id(),
            'approved_at'   => now(),
            'reject_reason' => $request->reason,
        ]);

        return back()->with('info', "Permintaan \"{$req->judul}\" telah ditolak.");
    }

    private function mapIcons($req)
    {
        $map = [
            'restock'     => ['type' => 'warn',   'icon' => 'truck-delivery'],
            'supplier'    => ['type' => 'info',   'icon' => 'exchange'],
            'hapus_batch' => ['type' => 'danger', 'icon' => 'trash'],
            'tambah_obat' => ['type' => 'ok',     'icon' => 'pill'],
        ];

        $tipe = $req->tipe ?? '';
        $req->icon_type = $map[$tipe]['type'] ?? 'info';
        $req->icon      = $map[$tipe]['icon'] ?? 'file-text';

        return $req;
    }
}
