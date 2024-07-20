<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\CripsController;
use App\Http\Controllers\ExportController;
use App\Http\Controllers\GuruController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\KelasController;
use App\Http\Controllers\KriteriaController;
use App\Http\Controllers\PelanggaranController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RiwayatController;
use App\Http\Controllers\SanksiController;
use App\Http\Controllers\SiswaController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('login', [LoginController::class, 'login']);
Route::post('login', [LoginController::class, 'check_login'])->name('login');
Route::post('logout', [LoginController::class, 'logout'])->name('logout');

Route::middleware(['auth'])->group(function () {
    // dashboard routes
    Route::get('/', [HomeController::class, 'index'])->name('dashboard.index');

    Route::get('/users', [UserController::class, 'index'])->name('users.index');

    Route::get('/kelas', [KelasController::class, 'index'])->name('kelas.index');
    Route::post('/kelas/store', [KelasController::class, 'store'])->name('kelas.store');
    Route::get('kelas/show/{id}', [KelasController::class, 'show'])->name('kelas.show');
    Route::put('/kelas/{id}', [KelasController::class, 'update'])->name('kelas.update');
    Route::delete('/kelas/{id}', [KelasController::class, 'destroy'])->name('kelas.delete');

    Route::get('/guru', [GuruController::class, 'index'])->name('guru.index');
    Route::post('/guru/store', [GuruController::class, 'store'])->name('guru.store');
    Route::delete('/guru/{id}', [GuruController::class, 'destroy'])->name('guru.delete');

    Route::get('/kriteria', [KriteriaController::class, 'index'])->name('kriteria.index');
    Route::post('/kriteria', [KriteriaController::class, 'store'])->name('kriteria.store');
    Route::get('/kriteria/{id}', [KriteriaController::class, 'show']);
    Route::put('/kriteria/{id}', [KriteriaController::class, 'update'])->name('kriteria.update');
    Route::delete('/kriteria/{id}', [KriteriaController::class, 'destroy'])->name('kriteria.delete');

    Route::get('/bobot', [CripsController::class, 'index'])->name('bobot.index');
    Route::post('/bobot', [CripsController::class, 'store'])->name('bobot.store');
    Route::get('/bobot/{id}', [CripsController::class, 'show']);
    Route::put('/bobot/{id}', [CripsController::class, 'update'])->name('bobot.update');
    Route::delete('/bobot/{id}', [CripsController::class, 'destroy'])->name('bobot.delete');


    Route::get('/sanksi', [SanksiController::class, 'index'])->name('sanksi.index');
    Route::post('/sanksi', [SanksiController::class, 'store'])->name('sanksi.store');
    Route::get('/sanksi/{id}', [SanksiController::class, 'show']);
    Route::put('/sanksi/{id}', [SanksiController::class, 'update'])->name('sanksi.update');
    Route::delete('/sanksi/{id}', [SanksiController::class, 'destroy'])->name('sanksi.delete');

    Route::get('/tambah-siswa', [SiswaController::class, 'create'])->name('tambah-siswa.create');
    Route::post('/tambah-siswa', [SiswaController::class, 'store'])->name('siswa.store');
    Route::get('/siswa', [SiswaController::class, 'index'])->name('siswa.index');
    Route::get('/siswa/{id}', [SiswaController::class, 'show'])->name('siswa.show');
    Route::get('/siswa/edit/{id}', [SiswaController::class, 'edit'])->name('siswa.edit');
    Route::put('/siswa/{id}', [SiswaController::class, 'update'])->name('siswa.update');
    Route::delete('/siswa/{id}', [SiswaController::class, 'destroy'])->name('siswa.delete');
    Route::get('/siswa/kelas/{nama_kelas}', [SiswaController::class, 'siswaByKelas'])->name('siswa.siswa-by-kelas');
    Route::get('/siswa/point/pelanggaran/{id}', [SiswaController::class, 'siswaPoint'])->name('siswa.point-pelanggaran');

    Route::get('/pelanggaran-siswa', [PelanggaranController::class, 'index'])->name('pelanggaran.index');
    Route::post('/siswa/point/create', [PelanggaranController::class, 'store'])->name('point.store');
    Route::delete('/point/delete/{id}', [PelanggaranController::class, 'delete'])->name('point.delete');
    Route::post('/pelanggaran-siswa/{id}', [PelanggaranController::class, 'verif'])->name('pelanggaran.verif');
    Route::post('/pelanggaran-siswa/tolak/{id}', [PelanggaranController::class, 'tolak'])->name('pelanggaran.tolak');

    Route::get('/riwayat', [RiwayatController::class, 'index'])->name('riwayat.index');

    Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
    Route::post('/profile/update-password/{id}', [ProfileController::class, 'updatePassword'])->name('profile.update-password');

    Route::get('/report/siswa/{id}', [ExportController::class, 'download_siswa'])->name('report.siswa');
    Route::get('/reports-excel/{tahun}', [ExportController::class, 'download_excel'])->name('download.excel');
});
