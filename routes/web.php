<?php

use App\Http\Controllers\LandingPageController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AnggotaController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\PengajuanSertifikatController;
use App\Http\Controllers\KelayakanUsahaController;
use App\Http\Controllers\RegisterController;
<<<<<<< HEAD
use App\Http\Controllers\GuideController;
use App\Http\Controllers\LaporanController;
=======
use App\Http\Controllers\WhatsAppResetController;
use App\Http\Middleware\PreventBackHistory;
>>>>>>> Bima
use App\Models\PengajuanHalal;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

// Route::get('/', function () {
//     return Inertia::render('Welcome', [
//         'canLogin' => Route::has('login'),
//         'canRegister' => Route::has('register'),
//         'laravelVersion' => Application::VERSION,
//         'phpVersion' => PHP_VERSION,
//     ]);
// });


Route::get('/', [LandingPageController::class, 'landingPage'])->name('landingPage'); // Rute landing page
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Rute untuk halaman login
Route::get('/loginForm', [LoginController::class, 'login'])->name('login');

// Rute untuk halaman register
Route::get('/register', [RegisterController::class, 'registerShow'])->name('registerShow');
Route::post('/register', [RegisterController::class, 'register'])->name('register');

// Rute untuk proses autentikasi (login)
Route::post('/authenticate', [LoginController::class, 'authenticate'])->name('authenticate');

//Rute untuk reset password menggunakan OTP whatssapp
Route::get('/forgot-password', [WhatsAppResetController::class, 'showForgotForm'])->name('password.forgot');
Route::post('/send-otp', [WhatsAppResetController::class, 'sendOtp'])->name('password.sendOtp');
Route::get('/verify-otp', [WhatsAppResetController::class, 'showVerifyOtpForm'])->name('password.verifyOtp');
Route::post('/verify-otp', [WhatsAppResetController::class, 'verifyOtp'])->name('password.verifyOtp.post');
Route::get('/reset-password', [WhatsAppResetController::class, 'showResetForm'])->name('password.reset');
Route::post('/reset-password', [WhatsAppResetController::class, 'reset'])->name('password.update');

// Rute untuk halaman admin
Route::middleware(['auth', 'admin','prevent-back-history'])->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/admin/laporan', [LaporanController::class, 'index'])->name('admin.laporan');
    Route::get('/laporan/export', [LaporanController::class, 'export'])->name('laporan.export');
    Route::get('/event', [AdminController::class, 'eventAdmin'])->name('admin.event');
    Route::get('/event-riwayat', [AdminController::class, 'riwayatAdmin'])->name('admin.event-riwayat');
    Route::get('/detail-event', [AdminController::class, 'detailEvent'])->name('detailEvent');
    Route::post('/event', [AdminController::class, 'store'])->name('event.store');
    Route::put('/event/update/{id_event}', [AdminController::class, 'update'])->name('event.update');
    Route::delete('/event/{id_event}', [AdminController::class, 'destroy'])->name('event.delete');
    Route::get('/event/{id_event}', [AdminController::class, 'show'])->name('event.show');
    
    // Halaman-halaman lain untuk admin
    Route::get('/halal', [PengajuanSertifikatController::class, 'halal'])->name('halal');
    Route::post('/halal/{id}/update', [PengajuanSertifikatController::class, 'updateHalal'])->name('updateHalal');
    Route::post('/halal/{id_detail}/reject', [PengajuanSertifikatController::class, 'rejectHalal'])->name('rejectHalal');
    Route::get('/koki', [PengajuanSertifikatController::class, 'koki'])->name('koki');
    Route::post('/koki/{id_detail}/update', [PengajuanSertifikatController::class, 'updateKoki'])->name('updateKoki');
    Route::post('/koki/{id_detail}/reject', [PengajuanSertifikatController::class, 'rejectKoki'])->name('rejectKoki');
    Route::get('/asisten-koki', [PengajuanSertifikatController::class, 'asisten'])->name('asisten');
    Route::post('/asisten-koki/{id_detail}/update', [PengajuanSertifikatController::class, 'updateAsisten'])->name('updateAsisten');
    Route::get('/asisten-koki/{id_detail}/getFileUrl', [PengajuanSertifikatController::class, 'getFileUrl'])->name('getFileUrl');
    Route::post('/asisten-koki/{id_detail}/reject', [PengajuanSertifikatController::class, 'rejectAsisten'])->name('rejectAsisten');
    Route::get('/finansial', [KelayakanUsahaController::class, 'finansial'])->name('finansial');
    Route::post('/finansial/{id_finansial}/update', [KelayakanUsahaController::class, 'updateFinansial'])->name('updateFinansial');
    Route::post('/finansial/{id_finansial}/reject', [KelayakanUsahaController::class, 'rejectFinansial'])->name('rejectFinansial');
    // Route::post('/finansial/{id_finansial}/reject', [KelayakanUsahaController::class, 'rejectFinansial'])->name('rejectFinansial');
    Route::get('/operasional', [KelayakanUsahaController::class, 'operasional'])->name('operasional');
    Route::post('/operasional/{id_operasional}/update', [KelayakanUsahaController::class, 'updateOperasional'])->name('updateOperasional');
    Route::post('/operasional/reject/{id_operasional}', [KelayakanUsahaController::class, 'rejectOperasional'])->name('rejectOperasional');
    Route::get('/pemasaran', [KelayakanUsahaController::class, 'pemasaran'])->name('pemasaran');
    Route::post('/pemasaran/{id_pemasaran}/update', [KelayakanUsahaController::class, 'updatePemasaran'])->name('updatePemasaran');
    Route::post('/pemasaran/{id_pemasaran}/reject', [KelayakanUsahaController::class, 'rejectPemasaran'])->name('rejectPemasaran');
});

// Rute untuk halaman anggota
Route::middleware(['auth', 'anggota','prevent-back-history'])->group(function () {
    Route::get('/anggota/dashboard', [AnggotaController::class, 'dashboard'])->name('dashboard');
    Route::get('/guide', [GuideController::class, 'index'])->name('anggota.guide');
    Route::get('/pengajuan-sertifikat', [AnggotaController::class, 'pengajuan'])->name('pengajuan');
    // Route::get('/ajukan-sertifikat-halal', [PengajuanSertifikatController::class, 'create'])->name('pengajuan.sertifikat-halal.create');
    Route::post('/ajukan-sertifikat-halal', [PengajuanSertifikatController::class, 'storeHalal']);
    Route::get('/ajukan-sertifikat-halal', [PengajuanSertifikatController::class, 'create'])->name('anggota.pengajuanSertifikat');
    Route::post('/ajukan-sertifikat-halal/{id_detail}/updateUserHalal', [PengajuanSertifikatController::class, 'updateUserHalal'])->name('updateUserHalal');
    Route::get('/ajukan-sertifikat-koki', [PengajuanSertifikatController::class, 'createKoki'])->name('anggota.pengajuanSertifikat');
    Route::post('/ajukan-sertifikat-koki', [PengajuanSertifikatController::class, 'storeKoki']);
    Route::post('/ajukan-sertifikat-koki/{id_detail}/updateUserKoki', [PengajuanSertifikatController::class, 'updateUserKoki'])->name('updateUserKoki');
    Route::get('/ajukan-sertifikat-asisten-koki', [PengajuanSertifikatController::class, 'createAsisten'])->name('anggota.pengajuanSertifikat');
    // Route::post('/ajukan-sertifikat-halal', [PengajuanSertifikatController::class, 'storeHalal'])->name('pengajuan.sertifikat-halal.store');
    Route::post('/ajukan-sertifikat-asisten-koki', [PengajuanSertifikatController::class, 'storeAsisten']);
    Route::post('/ajukan-sertifikat-asisten-koki/{id_detail}/updateUserAsisten', [PengajuanSertifikatController::class, 'updateUserAsisten'])->name('updateUserAsisten');
    // Route::get('/file/{id}', function ($id) {
    //     $filePath = public_path("app/public/sertifikat_asisten_koki/{$id}.pdf");
    
    //     if (!file_exists($filePath)) {
    //         abort(404, 'File not found');
    //     }
    
    //     return response()->file($filePath);
    // });

    

    
    Route::get('/event-anggota', [AnggotaController::class, 'event'])->name('event');
    Route::get('/riwayat-event', [AnggotaController::class, 'riwayat'])->name('riwayat');
    Route::get('/event-detail', [AnggotaController::class, 'Detail'])->name('Detail');
    Route::get('/kelayakan-usaha', [AnggotaController::class, 'kelayakanUsaha'])->name('kelayakanUsaha');
    Route::post('/ajukan-kelayakan-finansial', [KelayakanUsahaController::class, 'storeFinansial'])->name('anggota.kelayakanUsaha');
    Route::put('/ajukan-kelayakan-finansial/{id_finansial}', [KelayakanUsahaController::class, 'updateUserFinansial'])->name('anggota.kelayakanUsaha.update.finansial');
    Route::post('/ajukan-kelayakan-operasional', [KelayakanUsahaController::class, 'storeOperasional'])->name('anggota.kelayakanUsaha');
    Route::put('/ajukan-kelayakan-operasional/{id_operasional}', [KelayakanUsahaController::class, 'updateUserOperasional'])->name('anggota.kelayakanUsaha.update');
    Route::post('/ajukan-kelayakan-pemasaran', [KelayakanUsahaController::class, 'storePemasaran'])->name('anggota.kelayakanUsaha');
    Route::post('/ajukan-kelayakan-pemasaran/{id_pemasaran}/updateUserPemasaran', [KelayakanUsahaController::class, 'updateUserPemasaran'])->name('anggota.kelayakanUsaha');
    Route::get('/profile-user', [ProfileController::class, 'profile'])->name('profile');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::post('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
    // Route::get('/get-file-url/{id}', function ($id) {
    //     // Cari data di database berdasarkan ID
    //     $data = \App\Models\PengajuanAsistenKoki::find($id);
    
    //     if ($data && $data->file) {
    //         // Cek apakah file ada di direktori storage
    //         $filePath = 'sertifikat_asisten_koki/' . $data->file;
    //         if (Storage::exists($filePath)) {
    //             return response()->json(['url' => asset('storage/' . $filePath)]);
    //         }
    //     }
    
    //     return response()->json(['url' => null], 404); // Kembalikan 404 jika file tidak ditemukan
    // })->name('getFileUrl');
});
// Route::get('/profile-edit', [ProfileController::class, 'editProfile'])->name('profile.edit');
// Route::get('/profile/password', [ProfileController::class, 'editPassword'])->name('profile.password');
// Route::post('/profile/edit', [ProfileController::class, 'updateProfile'])->name('profile.update');
// Route::post('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.updatePassword');

// Route::middleware('auth')->group(function () {
//     Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
//     Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
//     Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
// });



// require __DIR__ . '/auth.php';