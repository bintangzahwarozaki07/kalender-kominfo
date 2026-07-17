<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\InstitutionController;
use App\Http\Controllers\ActivityController;
use App\Http\Controllers\DocumentationController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LinkController;

Route::get('/', function () {
    return redirect()->route('dashboard');
});

Route::middleware(['auth'])->group(function () {

    Route::get('/dashboard',[DashboardController::class,'index'])
        ->name('dashboard');

    Route::resource('categories', CategoryController::class);

    Route::resource('institutions', InstitutionController::class);

    Route::get('activities/export/pdf',[ActivityController::class,'exportPdf'])
        ->name('activities.export.pdf');

    Route::resource('activities', ActivityController::class);

    Route::resource('documentations', DocumentationController::class);

    Route::resource('links', LinkController::class);

    Route::get('/calendar-events',[ActivityController::class,'calendar']);

});

require __DIR__.'/auth.php';