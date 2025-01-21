<?php

use App\Http\Controllers\LandingPageController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AnggotaController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\PengajuanSertifikatController;
use App\Http\Controllers\KelayakanUsahaController;
use App\Http\Controllers\RegisterController;
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

// Rute untuk halaman admin
Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/event', [AdminController::class, 'event'])->name('admin.event');
    Route::post('/event', [AdminController::class, 'store'])->name('event.store');
    Route::put('/event/update/{id_event}', [AdminController::class, 'update'])->name('event.update');
    Route::delete('/event/{id_event}', [AdminController::class, 'destroy'])->name('event.delete');
    Route::get('/event/{id_event}', [AdminController::class, 'show'])->name('event.show');
    
    // Halaman-halaman lain untuk admin
    Route::get('/halal', [PengajuanSertifikatController::class, 'halal'])->name('halal');
    Route::post('/halal/{id_detail}/update', [PengajuanSertifikatController::class, 'updateHalal'])->name('updateHalal');
    Route::post('/halal/{id_detail}/reject', [PengajuanSertifikatController::class, 'rejectHalal'])->name('rejectHalal');
    Route::get('/koki', [PengajuanSertifikatController::class, 'koki'])->name('koki');
    Route::post('/koki/{id_detail}/update', [PengajuanSertifikatController::class, 'updateKoki'])->name('updateKoki');
    Route::post('/koki/{id_detail}/reject', [PengajuanSertifikatController::class, 'rejectKoki'])->name('rejectKoki');
    Route::get('/asisten-koki', [PengajuanSertifikatController::class, 'asisten'])->name('asisten');
    Route::post('/asisten-koki/{id_detail}/update', [PengajuanSertifikatController::class, 'updateAsisten'])->name('updateAsisten');
    Route::post('/asisten-koki/{id_detail}/reject', [PengajuanSertifikatController::class, 'rejectAsisten'])->name('rejectAsisten');
    Route::get('/finansial', [KelayakanUsahaController::class, 'finansial'])->name('finansial');
    Route::post('/finansial/{id_finansial}/update', [KelayakanUsahaController::class, 'updateFinansial'])->name('updateFinansial');
    Route::post('/finansial/{id_finansial}/reject', [KelayakanUsahaController::class, 'rejectFinansial'])->name('rejectFinansial');
    Route::get('/operasional', [KelayakanUsahaController::class, 'operasional'])->name('operasional');
    Route::post('/operasional/update/{id_operasional}', [KelayakanUsahaController::class, 'updateOperasional'])->name('updateOperasional');
    Route::post('/operasional/reject/{id_operasional}', [KelayakanUsahaController::class, 'rejectOperasional'])->name('rejectOperasional');
    Route::get('/pemasaran', [KelayakanUsahaController::class, 'pemasaran'])->name('pemasaran');
    Route::post('/pemasaran/{id_pemasaran}/update', [KelayakanUsahaController::class, 'updatePemasaran'])->name('updatePemasaran');
    Route::post('/pemasaran/{id_pemasaran}/reject', [KelayakanUsahaController::class, 'rejectPemasaran'])->name('rejectPemasaran');
});

// Rute untuk halaman anggota
Route::middleware(['auth', 'anggota'])->group(function () {
    Route::get('/anggota/dashboard', [AnggotaController::class, 'dashboard'])->name('dashboard');
    Route::get('/pengajuan-sertifikat', [AnggotaController::class, 'pengajuan'])->name('pengajuan');
    // Route::get('/ajukan-sertifikat-halal', [PengajuanSertifikatController::class, 'create'])->name('pengajuan.sertifikat-halal.create');
    Route::post('/ajukan-sertifikat-halal', [PengajuanSertifikatController::class, 'storeHalal']);
    Route::get('/ajukan-sertifikat-halal', [PengajuanSertifikatController::class, 'create'])->name('anggota.pengajuanSertifikat');
    Route::get('/ajukan-sertifikat-koki', [PengajuanSertifikatController::class, 'createKoki'])->name('anggota.pengajuanSertifikat');
    Route::post('/ajukan-sertifikat-koki', [PengajuanSertifikatController::class, 'storeKoki']);
    Route::get('/ajukan-sertifikat-asisten-koki', [PengajuanSertifikatController::class, 'createAsisten'])->name('anggota.pengajuanSertifikat');
    // Route::post('/ajukan-sertifikat-halal', [PengajuanSertifikatController::class, 'storeHalal'])->name('pengajuan.sertifikat-halal.store');
    Route::post('/ajukan-sertifikat-asisten-koki', [PengajuanSertifikatController::class, 'storeAsisten']);
    Route::get('/event-anggota', [AnggotaController::class, 'event'])->name('event');
    Route::get('/riwayat-event', [AnggotaController::class, 'riwayat'])->name('riwayat');
    Route::get('/kelayakan-usaha', [AnggotaController::class, 'kelayakanUsaha'])->name('kelayakanUsaha');
    Route::post('/ajukan-kelayakan-finansial', [KelayakanUsahaController::class, 'storeFinansial'])->name('anggota.kelayakanUsaha');
    Route::post('/ajukan-kelayakan-operasional', [KelayakanUsahaController::class, 'storeOperasional']);
    Route::post('/ajukan-kelayakan-pemasaran', [KelayakanUsahaController::class, 'storePemasaran']);
    Route::get('/profile-user', [ProfileController::class, 'profile'])->name('profile');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::post('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
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