<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class ProfilController extends Controller
{
    public function edit()
    {
        return view('profil.edit', ['user' => Auth::user()]);
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name'        => 'required|string|max:100',
            'no_telepon'  => 'nullable|string|max:20',
            'jabatan'     => 'nullable|string|max:100',
            'foto_profil' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $user->name       = $request->name;
        $user->no_telepon = $request->no_telepon;
        $user->jabatan    = $request->jabatan;

        if ($request->hasFile('foto_profil')) {
            if ($user->foto_profil) {
                Storage::disk('public')->delete($user->foto_profil);
            }
            $path = $request->file('foto_profil')->store('profil', 'public');
            $user->foto_profil = $path;
        }

        $user->save();

        return redirect()->route('profil.edit')
                         ->with('success', 'Profil berhasil diperbarui.');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'password_lama' => 'required',
            'password_baru' => 'required|min:8|confirmed',
        ]);

        $user = Auth::user();

        if (!Hash::check($request->password_lama, $user->password)) {
            return back()->withErrors(['password_lama' => 'Password lama tidak sesuai.']);
        }

        $user->password = Hash::make($request->password_baru);
        $user->save();

        return redirect()->route('profil.edit')
                         ->with('success', 'Password berhasil diperbarui.');
    }
}
