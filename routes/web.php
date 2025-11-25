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
    // Profile management
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Archive management (RESTful resource)
    Route::resource('archives', ArchiveItemController::class)->parameters([
        'archives' => 'archive'
    ]);

    // Asset management (nested resource)
    Route::post('archives/{archive}/assets', [AssetController::class, 'store'])
        ->middleware('throttle:60,1')
        ->name('archives.assets.store');

    Route::get('assets/{asset}/download', [AssetController::class, 'download'])
        ->name('assets.download');

    Route::delete('assets/{asset}', [AssetController::class, 'destroy'])
        ->name('assets.destroy');
});

require __DIR__.'/auth.php';
