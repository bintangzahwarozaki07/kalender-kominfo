
<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\InstitutionController;
use App\Http\Controllers\ActivityController;
use App\Http\Controllers\DocumentationController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LinkController;

use App\Http\Controllers\Pemohon\ActivitySubmissionController;
use App\Http\Controllers\Admin\ActivitySubmissionController as AdminActivitySubmissionController;


/*
|--------------------------------------------------------------------------
| HALAMAN UTAMA
|--------------------------------------------------------------------------
*/

Route::get('/', function () {

    if (!auth()->check()) {
        return redirect()->route('login');
    }

    if (auth()->user()->role === 'admin') {
        return redirect()->route('dashboard');
    }

    if (auth()->user()->role === 'pemohon') {
        return redirect()->route('pemohon.dashboard');
    }

    abort(403, 'Akun tidak memiliki hak akses aplikasi.');

});


/*
|--------------------------------------------------------------------------
| HALAMAN ADMINISTRATOR
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:admin'])->group(function () {

    // Dashboard Admin
    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');

    // Master Data Kategori
    Route::resource('categories', CategoryController::class);

    // Master Data Instansi
    Route::resource('institutions', InstitutionController::class);

    // Export Kegiatan PDF
    Route::get(
        'activities/{activity}/export/pdf',
        [ActivityController::class, 'exportPdf']
    )->name('activities.export.pdf');

    // Manajemen Kegiatan
    Route::resource('activities', ActivityController::class);

    // Kalender Kegiatan
    Route::get(
        '/calendar-events',
        [ActivityController::class, 'calendar']
    )->name('calendar.events');

    // Dokumentasi dan Link Publikasi
    Route::resource('documentations', DocumentationController::class);

    // Route lama Link tetap dipertahankan
    Route::resource('links', LinkController::class);


    /*
    |--------------------------------------------------------------------------
    | PENGELOLAAN PENGAJUAN PEMOHON
    |--------------------------------------------------------------------------
    */

    // Daftar pengajuan
    Route::get(
        '/admin/pengajuan',
        [AdminActivitySubmissionController::class, 'index']
    )->name('admin.submissions.index');

    // Detail pengajuan
    Route::get(
        '/admin/pengajuan/{submission}',
        [AdminActivitySubmissionController::class, 'show']
    )->name('admin.submissions.show');

    // Setujui pengajuan
    Route::post(
        '/admin/pengajuan/{submission}/setujui',
        [AdminActivitySubmissionController::class, 'approve']
    )->name('admin.submissions.approve');

    // Tolak pengajuan
    Route::post(
        '/admin/pengajuan/{submission}/tolak',
        [AdminActivitySubmissionController::class, 'reject']
    )->name('admin.submissions.reject');

    // Minta revisi pengajuan
    Route::post(
        '/admin/pengajuan/{submission}/revisi',
        [AdminActivitySubmissionController::class, 'revision']
    )->name('admin.submissions.revision');

});


/*
|--------------------------------------------------------------------------
| HALAMAN PEMOHON
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:pemohon'])->group(function () {

    /*
    |--------------------------------------------------------------------------
    | DASHBOARD PEMOHON
    |--------------------------------------------------------------------------
    */

    Route::get('/pemohon/dashboard', function () {

        $query = \App\Models\ActivitySubmission::where(
            'user_id',
            auth()->id()
        );

        // Pengajuan menunggu
        $menunggu = (clone $query)
            ->where('status', 'Menunggu')
            ->count();

        // Pengajuan disetujui
        $disetujui = (clone $query)
            ->where('status', 'Disetujui')
            ->count();

        // Pengajuan perlu revisi
        $revisi = (clone $query)
            ->where('status', 'Perlu Revisi')
            ->count();

        // Pengajuan ditolak
        $ditolak = (clone $query)
            ->where('status', 'Ditolak')
            ->count();

        // Lima pengajuan terbaru
        $pengajuanTerbaru = (clone $query)
            ->latest()
            ->take(5)
            ->get();

        return view('pemohon.dashboard', compact(
            'menunggu',
            'disetujui',
            'revisi',
            'ditolak',
            'pengajuanTerbaru'
        ));

    })->name('pemohon.dashboard');


    /*
    |--------------------------------------------------------------------------
    | PENGAJUAN KEGIATAN PEMOHON
    |--------------------------------------------------------------------------
    */

    // Daftar pengajuan
    Route::get(
        '/pemohon/pengajuan',
        [ActivitySubmissionController::class, 'index']
    )->name('pemohon.submissions.index');

    // Form pengajuan baru
    Route::get(
        '/pemohon/pengajuan/create',
        [ActivitySubmissionController::class, 'create']
    )->name('pemohon.submissions.create');

    // Simpan pengajuan baru
    Route::post(
        '/pemohon/pengajuan',
        [ActivitySubmissionController::class, 'store']
    )->name('pemohon.submissions.store');

    // Form edit pengajuan yang perlu revisi
    Route::get(
        '/pemohon/pengajuan/{submission}/edit',
        [ActivitySubmissionController::class, 'edit']
    )->name('pemohon.submissions.edit');

    // Simpan hasil perbaikan pengajuan
    Route::put(
        '/pemohon/pengajuan/{submission}',
        [ActivitySubmissionController::class, 'update']
    )->name('pemohon.submissions.update');

});


/*
|--------------------------------------------------------------------------
| ROUTE AUTHENTICATION
|--------------------------------------------------------------------------
*/

require __DIR__.'/auth.php';
