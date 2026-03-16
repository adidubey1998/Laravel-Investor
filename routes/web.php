<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\TabsController;
use App\Http\Controllers\Admin\TabFilesController;
use App\Http\Controllers\Admin\TabTableRowsController;
use App\Http\Controllers\InvestorController;
use App\Http\Controllers\Admin\NewsController;

Route::get('/', [InvestorController::class, 'index'])
    ->name('welcome');
    
Route::get('investor/{slug}', [InvestorController::class, 'show'])
    ->name('investors.slug');



Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
Route::middleware(['auth', 'is_admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        Route::get('/dashboard', function () {
            return view('admin.dash');
        })->name('dashboard');
        Route::resource('tabs', TabsController::class);

        Route::get('tabs/{tab}/files', [TabFilesController::class, 'index'])
    ->name('tabs.files.index');

Route::post('tabs/{tab}/files', [TabFilesController::class, 'store'])
    ->name('tabs.files.store');
Route::post('tabs/{tab}/files/chunk', [TabFilesController::class, 'storeChunk'])
    ->name('tabs.files.chunk');

Route::delete('tab-files/{file}', [TabFilesController::class, 'destroy'])
    ->name('tabs.files.destroy');
    Route::get('tabs/{tab}/table-rows', [TabTableRowsController::class, 'index'])
    ->name('tabs.table-rows.index');

Route::post('tabs/{tab}/table-rows', [TabTableRowsController::class, 'store'])
    ->name('tabs.table-rows.store');

Route::put('table-rows/{row}', [TabTableRowsController::class, 'update'])
    ->name('tabs.table-rows.update');

Route::delete('table-rows/{row}', [TabTableRowsController::class, 'destroy'])
    ->name('tabs.table-rows.destroy');
    Route::get('news', [NewsController::class, 'index'])->name('news.index');
    Route::get('news/create', [NewsController::class, 'create'])->name('news.create');
    Route::post('news', [NewsController::class, 'store'])->name('news.store');
    Route::delete('news/{news}', [NewsController::class, 'destroy'])->name('news.destroy');

    });

require __DIR__.'/auth.php';
