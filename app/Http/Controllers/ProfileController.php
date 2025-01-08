<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Http\RedirectResponse;
use App\Models\DataPengguna;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Inertia\Response;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): Response
    {
        return Inertia::render('Profile/Edit', [
            'mustVerifyEmail' => $request->user() instanceof MustVerifyEmail,
            'status' => session('status'),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('profile.edit');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validate([
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }

    // Menampilkan halaman profil
    public function profile()
    {
        $dataPengguna = DataPengguna::first();
        return view('anggota.profile-user', compact('dataPengguna'));
    }

    // Menampilkan halaman Edit Profile
    // public function editProfile()
    // {
    //     $dataPengguna = DataPengguna::first();
    //     return view('profile-edit', compact('dataPengguna'));
    // }

    // Memperbarui data profil
    // public function updateProfile(Request $request)
    // {
    //     $validatedData = $request->validate([
    //         'email' => 'required|email',
    //         'tipe_member' => 'required|string',
    //         'nama_usaha' => 'required|string',
    //         'alamat' => 'required|string',
    //         'kota' => 'required|string',
    //         'kecamatan' => 'required|string',
    //         'kode_pos' => 'required|numeric',
    //         'no_telp' => 'required|string',
    //         'nama_pemilik' => 'required|string',
    //         'no_ktp' => 'required|numeric',
    //         'no_sku' => 'nullable|string',
    //         'no_npwp' => 'nullable|string',
    //         'k_usaha' => 'required|string',
    //         'j_usaha' => 'required|string',
    //     ]);

    //     $dataPengguna = DataPengguna::first();
    //     $dataPengguna->update($validatedData);

    //     return redirect()->route('profile')->with('success', 'Profil berhasil diperbarui.');
    // }

    // Menampilkan halaman Edit Password
    // public function editPassword()
    // {
    //     return view('profile-password');
    // }

    // Memperbarui password
    // public function updatePassword(Request $request)
    // {
    //     $validatedData = $request->validate([
    //         'current_password' => 'required|string',
    //         'new_password' => 'required|string|min:8|confirmed',
    //     ]);

    //     // Validasi password lama dan ubah ke password baru
    //     $user = auth()->user();  // Pastikan pengguna sudah login
    //     if (password_verify($request->current_password, $user->password)) {
    //         $user->update([
    //             'password' => bcrypt($request->new_password),
    //         ]);
    //         return redirect()->route('profile')->with('success', 'Password berhasil diperbarui.');
    //     }

    //     return back()->withErrors(['current_password' => 'Password lama salah']);
    // }
}
