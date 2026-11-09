
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

    // Cetak PDF kegiatan
    Route::get(
        'activities/{activity}/export/pdf',
        [ActivityController::class, 'exportPdf']
    )->name('activities.export.pdf');

    // Manajemen kegiatan
    Route::resource('activities', ActivityController::class);

    // Kalender kegiatan
    Route::get(
        '/calendar-events',
        [ActivityController::class, 'calendar']
    )->name('calendar.events');

    // Manajemen dokumentasi dan link publikasi
    Route::resource('documentations', DocumentationController::class);

    // Route link lama tetap dipertahankan untuk menjaga kompatibilitas
    Route::resource('links', LinkController::class);
});

/*
|--------------------------------------------------------------------------
| Autentikasi
|--------------------------------------------------------------------------
*/

require __DIR__ . '/auth.php';
