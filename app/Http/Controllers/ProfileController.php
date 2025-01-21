<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Http\RedirectResponse;
use App\Models\DataPengguna;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Inertia\Response;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    // public function edit(Request $request): Response
    // {
    //     return Inertia::render('Profile/Edit', [
    //         'mustVerifyEmail' => $request->user() instanceof MustVerifyEmail,
    //         'status' => session('status'),
    //     ]);
    // }

    public function edit()
    {
        $user = Auth::user();

        $dataPengguna = $user->dataPengguna;

        return view('anggota.profile-user', compact('dataPengguna'));
    }

    /**
     * Update the user's profile information.
     */
    // public function update(ProfileUpdateRequest $request): RedirectResponse
    // {
    //     $request->user()->fill($request->validated());

    //     if ($request->user()->isDirty('email')) {
    //         $request->user()->email_verified_at = null;
    //     }

    //     $request->user()->save();

    //     return Redirect::route('profile.edit');
    // }

    public function update(Request $request)
    {
        // Validasi data
        $validated = $request->validate([
            'email' => 'required|email',
            'tipe_member' => 'nullable|string|max:255',
            'nama_usaha' => 'nullable|string|max:255',
            'alamat' => 'nullable|string|max:500',
            'provinsi' => 'nullable|string|max:255',
            'kota' => 'nullable|string|max:255',
            'kecamatan' => 'nullable|string|max:255',
            'kode_pos' => 'nullable|string|max:10',
            'no_telp' => 'nullable|string|max:15',
            'nama_pemilik' => 'nullable|string|max:255',
            'no_ktp' => 'nullable|string|max:20',
            'no_sku' => 'nullable|string|max:20',
            'no_npwp' => 'nullable|string|max:20',
            'k_usaha' => 'nullable|string|max:255',
            'j_usaha' => 'nullable|string|max:255',
        ]);

        // Ambil pengguna login
        $user = Auth::user();

        if (!$user) {
            return redirect()->route('profile.edit')->withErrors('Gagal memperbarui profil. Pengguna tidak ditemukan.');
        }

        // Perbarui data di tabel data_pengguna
        try {
            $dataPengguna = $user->dataPengguna; // Relasi ke data_pengguna

            if (!$dataPengguna) {
                return redirect()->route('profile.edit')->withErrors('Data pengguna tidak ditemukan.');
            }

            $dataPengguna->update($validated);

            return redirect()->route('profile.edit')->with('success', 'Profil berhasil diperbarui.');
        } catch (\Exception $e) {
            return redirect()->route('profile.edit')->withErrors('Gagal memperbarui profil. Error: ' . $e->getMessage());
        }
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
        // Ambil pengguna yang sedang login
        $dataPengguna = DataPengguna::where('email', auth()->user()->email)->first();

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
