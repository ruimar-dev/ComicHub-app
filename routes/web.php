<?php
use App\Http\Controllers\ContactController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ComicController;
use App\Http\Controllers\BuscadorController;
use App\Http\Controllers\ReadingListController;

Route::get('/', function () {
    return view('welcome');
})->name('welcome');

Route::get('/about', function () {
    return view('about_us');
})->name('about');

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', [ComicController::class, 'index'])->name('dashboard');
    Route::get('/dashboard/search', [ComicController::class, 'search'])->name('search');
    Route::post('/reading-list/add', [ReadingListController::class, 'add'])->name('readingList.add');
    Route::put('/reading-list/update/{id}', [ReadingListController::class, 'update'])->name('readingList.update');
    Route::get('/reading-list', [ReadingListController::class, 'index'])->name('readingList.index');
    Route::delete('/reading-list/remove/{id}', [ReadingListController::class, 'destroy'])->name('readingList.destroy');
});

Route::get('/comics/{id}', [ComicController::class, 'show'])->name('comics.show');


Route::get('/dashboard/load-more', [ComicController::class, 'loadMore'])->name('comics.loadMore');

Route::get('/contact',  [ContactController::class, 'index'])->name('contact.index');

Route::post('/contact',  [ContactController::class, 'store'])->name('contact.store');



