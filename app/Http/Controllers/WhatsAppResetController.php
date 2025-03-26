<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\DataPengguna;
use Twilio\Rest\Client;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Hash;

class WhatsAppResetController extends Controller
{
    // Form input nomor WhatsApp
    public function showForgotForm()
    {
        return view('login.forgot-password');
    }

    // Kirim OTP via WhatsApp
    public function sendOtp(Request $request)
    {
        $request->validate([
            'phone' => 'required|numeric'
        ]);

        // Cari pengguna berdasarkan nomor telepon
        $pengguna = DataPengguna::where('no_telp', $request->phone)->first();

        if (!$pengguna) {
            return back()->withErrors(['phone' => 'Nomor tidak ditemukan.']);
        }

        // Ambil user berdasarkan ID yang ada di tabel users
        $user = User::where('id', $pengguna->id)->first();
        if (!$user) {
            return back()->withErrors(['phone' => 'User tidak ditemukan.']);
        }

        // Generate kode OTP
        $otp = rand(100000, 999999);

        // Simpan OTP di session
        Session::put('otp', $otp);
        Session::put('user_id', $user->id);

        // Kirim OTP ke WhatsApp menggunakan Twilio
        try {
            $twilio = new Client(env('TWILIO_SID'), env('TWILIO_AUTH_TOKEN'));
            $twilio->messages->create(
                "whatsapp:" . $request->phone,
                [
                    'from' => env('TWILIO_WHATSAPP_FROM'),
                    'body' => "Kode OTP Anda untuk reset password adalah: $otp. Jangan berikan kode ini kepada siapa pun."
                ]
            );
        } catch (\Exception $e) {
            return back()->withErrors(['phone' => 'Gagal mengirim OTP. Pastikan nomor terdaftar di Twilio Sandbox.']);
        }

        return redirect()->route('password.verifyOtp')->with('success', 'Kode OTP telah dikirim ke WhatsApp Anda.');
    }

    // Form verifikasi OTP
    public function showVerifyOtpForm()
    {
        return view('login.verify-otp');
    }

    // Verifikasi OTP
    public function verifyOtp(Request $request)
    {
        $request->validate([
            'otp' => 'required|numeric'
        ]);

        if ($request->otp != Session::get('otp')) {
            return back()->withErrors(['otp' => 'Kode OTP salah atau sudah kedaluwarsa.']);
        }

        return redirect()->route('password.reset')->with('success', 'Kode OTP benar. Silakan buat password baru.');
    }

    // Form reset password
    public function showResetForm()
    {
        return view('login.reset-password');
    }

    // Proses reset password
    public function reset(Request $request)
    {
        $request->validate([
            'password' => 'required|confirmed|min:6',
        ]);

        $user = User::find(Session::get('user_id'));

        if (!$user) {
            return back()->withErrors(['error' => 'Terjadi kesalahan, user tidak ditemukan.']);
        }

        // Update password
        $user->password = Hash::make($request->password);
        $user->save();

        // Hapus session
        Session::forget('otp');
        Session::forget('user_id');

        return redirect()->route('login')->with('success', 'Password berhasil direset.');
    }
}
