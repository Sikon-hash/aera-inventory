<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\BarangMasukController;
use App\Http\Controllers\BarangKeluarController;
use App\Http\Controllers\StockOpnameController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\UserController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', fn() => redirect('/dashboard'));

require __DIR__.'/auth.php';

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::patch('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password');

    // Barang (Admin & Owner)
    Route::resource('barang', BarangController::class);

    // Supplier (Admin)
    Route::resource('supplier', SupplierController::class)->middleware('role:Admin');

    // Barang Masuk (Admin)
    Route::resource('barang-masuk', BarangMasukController::class)->middleware('role:Admin');

    // Barang Keluar (Admin)
    Route::resource('barang-keluar', BarangKeluarController::class)->middleware('role:Admin');

    // Stock Opname (Admin)
    Route::resource('stock-opname', StockOpnameController::class)->middleware('role:Admin');

    // Laporan (Owner & Admin)
    Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan.index');

    // User Management (Owner only)
    Route::resource('users', UserController::class)->middleware('role:Owner');
});
