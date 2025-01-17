<?php

use App\Http\Controllers\KategoriController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\SupplierController;
use App\Models\Supplier;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('/login');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('home');
    })->name('dashboard');
});

// Kategori Kontroller
Route::middleware('auth')->group(function () {
    Route::get('/kategori/data', [KategoriController::class, 'data'])->name('kategori.data');
    Route::resource('/kategori', KategoriController::class);

    Route::get('/produk/data', [ProductController::class, 'data'])->name('produk.data');
    Route::post('/produk/delete-selected', [ProductController::class, 'deleteSelected'])->name('produk.delete.selected');
    Route::post('/produk/cetak-barcode', [ProductController::class, 'cetakBarcode'])->name('produk.cetak.barcode');
    // Route::resource('produk', ProductController::class);
    Route::resource('produk', ProductController::class);

    Route::get('/member/data', [MemberController::class, 'data'])->name('member.data');
    Route::resource('/member', MemberController::class);

    Route::get('/supplier/data', [SupplierController::class, 'data'])->name('supplier.data');
    Route::post('/supplier/delete-selected', [SupplierController::class, 'deleteSelected'])->name('supplier.delete.selected');
    Route::resource('/supplier', SupplierController::class);
});
