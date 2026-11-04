<?php

use App\Http\Controllers\Admin\AchievementController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\GalleryController as AdminGalleryController;
use App\Http\Controllers\Admin\MessageController;
use App\Http\Controllers\Admin\NewsController as AdminNewsController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\TeacherController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\GalleryController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\SitemapController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Halaman publik
|--------------------------------------------------------------------------
*/
Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/profil', [PageController::class, 'profil'])->name('profil');

Route::get('/berita', [NewsController::class, 'index'])->name('berita.index');
Route::get('/berita/{slug}', [NewsController::class, 'show'])->name('berita.show');

Route::get('/galeri', [GalleryController::class, 'index'])->name('galeri');

Route::get('/kontak', [PageController::class, 'kontak'])->name('kontak');
Route::post('/kontak', [ContactController::class, 'store'])
    ->middleware('throttle:10,1')
    ->name('kontak.store');

Route::get('/sitemap.xml', [SitemapController::class, 'index'])->name('sitemap');

Route::get('/robots.txt', function () {
    $content = "User-agent: *\nDisallow: /admin\nDisallow: /login\n\nSitemap: ".url('/sitemap.xml')."\n";

    return response($content, 200)->header('Content-Type', 'text/plain');
})->name('robots');

/*
|--------------------------------------------------------------------------
| Autentikasi admin
|--------------------------------------------------------------------------
*/
Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'show'])->name('login');
    Route::post('/login', [LoginController::class, 'login'])
        ->middleware('throttle:10,1')
        ->name('login.store');
});

Route::post('/logout', [LoginController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');

/*
|--------------------------------------------------------------------------
| Panel admin (butuh login + hak administrator)
|--------------------------------------------------------------------------
*/
Route::prefix('admin')->name('admin.')->middleware(['auth', 'admin'])->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    Route::resource('berita', AdminNewsController::class)
        ->parameters(['berita' => 'news'])
        ->except('show');

    Route::resource('guru', TeacherController::class)
        ->parameters(['guru' => 'teacher'])
        ->except('show');

    Route::resource('galeri', AdminGalleryController::class)
        ->parameters(['galeri' => 'gallery'])
        ->except('show');

    Route::resource('prestasi', AchievementController::class)
        ->parameters(['prestasi' => 'achievement'])
        ->except('show');

    Route::resource('pesan', MessageController::class)
        ->parameters(['pesan' => 'message'])
        ->only(['index', 'show', 'destroy']);

    Route::get('/pengaturan', [SettingController::class, 'edit'])->name('pengaturan.edit');
    Route::put('/pengaturan', [SettingController::class, 'update'])->name('pengaturan.update');
});
