<?php

use App\Http\Controllers\BuktiPelanggaranController;
use App\Http\Controllers\KonselingController;
use App\Http\Controllers\PelanggaranController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SesiKonselingController;
use App\Http\Controllers\TindakLanjutController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    /*
    |----------------------------------------------------------------------
    | PELANGGARAN
    |----------------------------------------------------------------------
    | - index/show : semua role (read)
    | - create/store/edit/update/destroy : Wali kelas & Kesiswaan
    */
    Route::get('pelanggaran', [PelanggaranController::class, 'index'])->name('pelanggaran.index');
    Route::get('pelanggaran/create', [PelanggaranController::class, 'create'])
        ->middleware('role:Wali kelas,Kesiswaan')
        ->name('pelanggaran.create');
    Route::post('pelanggaran', [PelanggaranController::class, 'store'])
        ->middleware('role:Wali kelas,Kesiswaan')
        ->name('pelanggaran.store');
    Route::get('pelanggaran/{pelanggaran}', [PelanggaranController::class, 'show'])->name('pelanggaran.show');
    Route::get('pelanggaran/{pelanggaran}/edit', [PelanggaranController::class, 'edit'])
        ->middleware('role:Wali kelas,Kesiswaan')
        ->name('pelanggaran.edit');
    Route::put('pelanggaran/{pelanggaran}', [PelanggaranController::class, 'update'])
        ->middleware('role:Wali kelas,Kesiswaan')
        ->name('pelanggaran.update');
    Route::delete('pelanggaran/{pelanggaran}', [PelanggaranController::class, 'destroy'])
        ->middleware('role:Wali kelas,Kesiswaan')
        ->name('pelanggaran.destroy');

    /*
    |----------------------------------------------------------------------
    | BUKTI PELANGGARAN (nested resource)
    |----------------------------------------------------------------------
    | Hanya Wali kelas & Kesiswaan yang boleh tambah/hapus lampiran.
    */
    Route::get('pelanggaran/{pelanggaran}/bukti', [BuktiPelanggaranController::class, 'index'])
        ->name('bukti-pelanggaran.index');
    Route::get('pelanggaran/{pelanggaran}/bukti/create', [BuktiPelanggaranController::class, 'create'])
        ->middleware('role:Wali kelas,Kesiswaan')
        ->name('bukti-pelanggaran.create');
    Route::post('pelanggaran/{pelanggaran}/bukti', [BuktiPelanggaranController::class, 'store'])
        ->middleware('role:Wali kelas,Kesiswaan')
        ->name('bukti-pelanggaran.store');
    Route::get('bukti-pelanggaran/{buktiPelanggaran}', [BuktiPelanggaranController::class, 'show'])
        ->name('bukti-pelanggaran.show');
    Route::delete('bukti-pelanggaran/{buktiPelanggaran}', [BuktiPelanggaranController::class, 'destroy'])
        ->middleware('role:Wali kelas,Kesiswaan')
        ->name('bukti-pelanggaran.destroy');

    /*
    |----------------------------------------------------------------------
    | TINDAK LANJUT
    |----------------------------------------------------------------------
    | - index/show : semua role (read)
    | - create/store/edit/update/destroy : hanya BK
    */
    Route::get('tindak-lanjut', [TindakLanjutController::class, 'index'])->name('tindak-lanjut.index');
    Route::get('tindak-lanjut/create', [TindakLanjutController::class, 'create'])
        ->middleware('role:BK')
        ->name('tindak-lanjut.create');
    Route::post('tindak-lanjut', [TindakLanjutController::class, 'store'])
        ->middleware('role:BK')
        ->name('tindak-lanjut.store');
    Route::get('tindak-lanjut/{tindakLanjut}', [TindakLanjutController::class, 'show'])->name('tindak-lanjut.show');
    Route::get('tindak-lanjut/{tindakLanjut}/edit', [TindakLanjutController::class, 'edit'])
        ->middleware('role:BK')
        ->name('tindak-lanjut.edit');
    Route::put('tindak-lanjut/{tindakLanjut}', [TindakLanjutController::class, 'update'])
        ->middleware('role:BK')
        ->name('tindak-lanjut.update');
    Route::delete('tindak-lanjut/{tindakLanjut}', [TindakLanjutController::class, 'destroy'])
        ->middleware('role:BK')
        ->name('tindak-lanjut.destroy');

    /*
    |----------------------------------------------------------------------
    | KONSELING
    |----------------------------------------------------------------------
    | - index/show : semua role (read)
    | - create/store/edit/update/destroy : hanya BK
    */
    Route::get('konseling', [KonselingController::class, 'index'])->name('konseling.index');
    Route::get('konseling/create', [KonselingController::class, 'create'])
        ->middleware('role:BK')
        ->name('konseling.create');
    Route::post('konseling', [KonselingController::class, 'store'])
        ->middleware('role:BK')
        ->name('konseling.store');
    Route::get('konseling/{konseling}', [KonselingController::class, 'show'])->name('konseling.show');
    Route::get('konseling/{konseling}/edit', [KonselingController::class, 'edit'])
        ->middleware('role:BK')
        ->name('konseling.edit');
    Route::put('konseling/{konseling}', [KonselingController::class, 'update'])
        ->middleware('role:BK')
        ->name('konseling.update');
    Route::delete('konseling/{konseling}', [KonselingController::class, 'destroy'])
        ->middleware('role:BK')
        ->name('konseling.destroy');

    /*
    |----------------------------------------------------------------------
    | SESI KONSELING
    |----------------------------------------------------------------------
    | - index/show : semua role (read)
    | - create/store/edit/update/destroy : hanya BK
    */
    Route::get('sesi-konseling', [SesiKonselingController::class, 'index'])->name('sesi-konseling.index');
    Route::get('sesi-konseling/create', [SesiKonselingController::class, 'create'])
        ->middleware('role:BK')
        ->name('sesi-konseling.create');
    Route::post('sesi-konseling', [SesiKonselingController::class, 'store'])
        ->middleware('role:BK')
        ->name('sesi-konseling.store');
    Route::get('sesi-konseling/{sesiKonseling}', [SesiKonselingController::class, 'show'])->name('sesi-konseling.show');
    Route::get('sesi-konseling/{sesiKonseling}/edit', [SesiKonselingController::class, 'edit'])
        ->middleware('role:BK')
        ->name('sesi-konseling.edit');
    Route::put('sesi-konseling/{sesiKonseling}', [SesiKonselingController::class, 'update'])
        ->middleware('role:BK')
        ->name('sesi-konseling.update');
    Route::delete('sesi-konseling/{sesiKonseling}', [SesiKonselingController::class, 'destroy'])
        ->middleware('role:BK')
        ->name('sesi-konseling.destroy');
});

require __DIR__.'/auth.php';
