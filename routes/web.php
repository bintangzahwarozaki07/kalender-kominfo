
<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\InstitutionController;
use App\Http\Controllers\ActivityController;
use App\Http\Controllers\DocumentationController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LinkController;

/*
|--------------------------------------------------------------------------
| Halaman Utama
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return redirect()->route('dashboard');
});

/*
|--------------------------------------------------------------------------
| Route Admin (Memerlukan Login)
|--------------------------------------------------------------------------
*/

Route::middleware(['auth'])->group(function () {

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');

    // Manajemen kategori
    Route::resource('categories', CategoryController::class);

    // Manajemen instansi
    Route::resource('institutions', InstitutionController::class);

    /*
    |--------------------------------------------------------------------------
    | Manajemen Kegiatan
    |--------------------------------------------------------------------------
    */

    // Cetak surat undangan PDF untuk satu kegiatan
    // Letakkan sebelum Route::resource('activities', ...)
    Route::get(
        'activities/{activity}/export/pdf',
        [ActivityController::class, 'exportPdf']
    )->name('activities.export.pdf');

    // Daftar, tambah, simpan, edit, perbarui, dan hapus kegiatan
    Route::resource('activities', ActivityController::class);

    // Data kalender kegiatan
    Route::get(
        '/calendar-events',
        [ActivityController::class, 'calendar']
    )->name('calendar.events');

    // Dokumentasi kegiatan
    Route::resource('documentations', DocumentationController::class);

    // Tautan publikasi
    Route::resource('links', LinkController::class);
});

/*
|--------------------------------------------------------------------------
| Autentikasi
|--------------------------------------------------------------------------
*/

require __DIR__ . '/auth.php';
