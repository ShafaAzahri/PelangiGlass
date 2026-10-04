<?php

use App\Http\Controllers\AboutController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\InquiryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\PromoController;
use App\Http\Controllers\ServiceController;
use App\Services\DataImportService;
use Illuminate\Support\Facades\Route;
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/tentang', [AboutController::class, 'index'])->name('about');
Route::get('/produk', [ProductController::class, 'index'])->name('products.index');
Route::get('/produk/{slug}', [ProductController::class, 'show'])->name('products.show');
Route::get('/servis', [ServiceController::class, 'index'])->name('services.index');
Route::get('/servis/{slug}', [ServiceController::class, 'show'])->name('services.show');
Route::get('/artikel', [ArticleController::class, 'index'])->name('articles.index');
Route::get('/artikel/{slug}', [ArticleController::class, 'show'])->name('articles.show');
Route::get('/promo', [PromoController::class, 'index'])->name('promos.index');
Route::get('/promo/{slug}', [PromoController::class, 'show'])->name('promos.show');
Route::get('/layanan', [ServiceController::class, 'index']);
Route::get('/layanan/{slug}', [ServiceController::class, 'show']);
// Leads Form Submission
Route::post('/kontak', [InquiryController::class, 'store'])->middleware('throttle:5,1')->name('inquiries.store');

// Admin CSV Import Templates
Route::get('/admin/template/products-csv', function () {
    return response(DataImportService::getProductCsvTemplate(), 200, [
        'Content-Type' => 'text/csv; charset=UTF-8',
        'Content-Disposition' => 'attachment; filename="template_import_produk.csv"',
    ]);
})->name('templates.products');

Route::get('/admin/template/services-csv', function () {
    return response(DataImportService::getServiceCsvTemplate(), 200, [
        'Content-Type' => 'text/csv; charset=UTF-8',
        'Content-Disposition' => 'attachment; filename="template_import_layanan.csv"',
    ]);
})->name('templates.services');
