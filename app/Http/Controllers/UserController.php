<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Symfony\Component\HttpFoundation\StreamedResponse;


class UserController extends Controller
{

    public function index()
    {
        $users = User::orderBy('role')->orderBy('name')->paginate(15);

        $stats = [
            'total'    => User::count(),
            'admin'    => User::byRole('admin')->count(),
            'apoteker' => User::byRole('apoteker')->count(),
            'kasir'    => User::byRole('kasir')->count(),
            'aktif'    => User::where('aktif', true)->count(),   // ← FIX: key aktif ditambahkan
            'nonaktif' => User::where('aktif', false)->count(),
        ];

        return view('users.index', compact('users', 'stats'));
    }

    public function create()
    {
        return view('users.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:100',
            'email'    => 'required|email|unique:users,email',
            'role'     => 'required|in:admin,apoteker,kasir',
            'no_hp'    => 'nullable|string|max:20',
            'password' => ['required', 'confirmed', Password::min(8)],
        ], [
            'name.required'      => 'Nama wajib diisi.',
            'email.required'     => 'Email wajib diisi.',
            'email.unique'       => 'Email sudah digunakan.',
            'role.required'      => 'Role wajib dipilih.',
            'password.required'  => 'Password wajib diisi.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
            'password.min'       => 'Password minimal 8 karakter.',
        ]);

        User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'role'     => $request->role,
            'no_hp'    => $request->no_hp,
            'aktif'    => true,
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('users.index')
                         ->with('success', "Akun {$request->name} berhasil dibuat.");
    }

    public function edit(User $user)
    {
        return view('users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name'  => 'required|string|max:100',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'role'  => 'required|in:admin,apoteker,kasir',
            'no_hp' => 'nullable|string|max:20',
        ]);

        // Cegah admin terakhir diganti role-nya
        if ($user->isAdmin() && $request->role !== 'admin') {
            $jumlahAdmin = User::byRole('admin')->count();
            if ($jumlahAdmin <= 1) {
                return back()->with('error', 'Tidak bisa mengubah role. Harus ada minimal 1 admin aktif.');
            }
        }

        $data = $request->only('name', 'email', 'role', 'no_hp');

        // Update password hanya jika diisi
        if ($request->filled('password')) {
            $request->validate([
                'password' => ['confirmed', Password::min(8)],
            ]);
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        return redirect()->route('users.index')
                         ->with('success', "Data {$user->name} berhasil diperbarui.");
    }


    public function toggleAktif(User $user)
    {
        // Jangan nonaktifkan diri sendiri
        if ($user->id === auth()->id()) {
            return back()->with('error', 'Tidak bisa menonaktifkan akun sendiri.');
        }

        // Cegah nonaktifkan admin terakhir
        if ($user->isAdmin() && $user->aktif) {
            $jumlahAdmin = User::byRole('admin')->aktif()->count();
            if ($jumlahAdmin <= 1) {
                return back()->with('error', 'Tidak bisa menonaktifkan admin terakhir.');
            }
        }

        $user->update(['aktif' => !$user->aktif]);

        $status = $user->aktif ? 'diaktifkan' : 'dinonaktifkan';
        return back()->with('success', "Akun {$user->name} berhasil {$status}.");
    }

    public function destroy(User $user)
    {
        // Jangan hapus diri sendiri
        if ($user->id === auth()->id()) {
            return back()->with('error', 'Tidak bisa menghapus akun sendiri.');
        }

        // Cegah hapus admin terakhir
        if ($user->isAdmin()) {
            $jumlahAdmin = User::byRole('admin')->count();
            if ($jumlahAdmin <= 1) {
                return back()->with('error', 'Tidak bisa menghapus admin terakhir.');
            }
        }

        $nama = $user->name;
        $user->delete();

        return redirect()->route('users.index')
                         ->with('success', "Akun {$nama} berhasil dihapus.");
    }

    // Reset password oleh admin
    public function resetPassword(Request $request, User $user)
    {
        $request->validate([
            'password' => ['required', 'confirmed', Password::min(8)],
        ]);

        $user->update(['password' => Hash::make($request->password)]);

        return back()->with('success', "Password {$user->name} berhasil direset.");
    }
    public function export(Request $request): StreamedResponse
{
    $users = User::orderBy('role')->orderBy('name')->get();

    $filename = 'users_' . now()->format('Ymd_His') . '.csv';

    return response()->streamDownload(function () use ($users) {
        $handle = fopen('php://output', 'w');

        // Header kolom
        fputcsv($handle, ['No', 'Nama', 'Email', 'Role', 'No HP', 'Status']);

        foreach ($users as $i => $user) {
            fputcsv($handle, [
                $i + 1,
                $user->name,
                $user->email,
                $user->role,
                $user->no_hp ?? '-',
                $user->aktif ? 'Aktif' : 'Nonaktif',
            ]);
        }

        fclose($handle);
    }, $filename, [
        'Content-Type' => 'text/csv',
    ]);
}
}
