<?php

use App\Http\Controllers\ArchiveItemController;
use App\Http\Controllers\AssetController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    if (auth()->check()) {
        return redirect()->route('archives.index');
    }
    return view('welcome');
});

Route::get('/dashboard', function () {
    return redirect()->route('archives.index');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Archive items CRUD
    Route::get('/archives', [ArchiveItemController::class, 'index'])->name('archives.index');
    Route::get('/archives/create', [ArchiveItemController::class, 'create'])->name('archives.create');
    Route::post('/archives', [ArchiveItemController::class, 'store'])->name('archives.store');
    Route::get('/archives/{archive}', [ArchiveItemController::class, 'show'])->name('archives.show');
    Route::get('/archives/{archive}/edit', [ArchiveItemController::class, 'edit'])->name('archives.edit');
    Route::put('/archives/{archive}', [ArchiveItemController::class, 'update'])->name('archives.update');
    Route::delete('/archives/{archive}', [ArchiveItemController::class, 'destroy'])->name('archives.destroy');

    // Assets (files) for an archive - with throttle on uploads
    Route::post('/archives/{archive}/assets', [AssetController::class, 'store'])
        ->middleware('throttle:60,1')
        ->name('archives.assets.store');

    Route::get('/assets/{asset}/download', [AssetController::class, 'download'])
        ->name('assets.download');

    Route::delete('/assets/{asset}', [AssetController::class, 'destroy'])
        ->name('assets.destroy');
});

require __DIR__.'/auth.php';
