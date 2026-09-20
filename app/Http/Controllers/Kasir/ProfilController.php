<?php

namespace App\Http\Controllers\Kasir;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ProfilController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        return view('kasir.profil.index', compact('user'));
    }

    public function update(Request $request)
    {
        $user = auth()->user();

        // Cek apakah ganti password atau update profil
        if ($request->ganti_password) {
            $request->validate([
                'password_lama' => 'required',
                'password'      => 'required|min:8|confirmed',
            ]);

            if (!Hash::check($request->password_lama, $user->password)) {
                return back()->withErrors(['password_lama' => 'Password lama tidak sesuai.']);
            }

            $user->update(['password' => Hash::make($request->password)]);

            return back()->with('success', 'Password berhasil diubah.');
        }

        // Update profil biasa
        $request->validate([
            'name'        => 'required|string|max:100',
            'jabatan'     => 'nullable|string|max:100',
            'no_telepon'  => 'nullable|string|max:20',
        ]);

        $user->update($request->only('name', 'jabatan', 'no_telepon'));

        return back()->with('success', 'Profil berhasil diperbarui.');
    }
}
