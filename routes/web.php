<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\BarangKeluarController;
use App\Http\Controllers\BarangMasukController;
use App\Http\Controllers\MasterData\JenisLimbahController;
use App\Http\Controllers\MasterData\SumberLimbahController;
use App\Http\Controllers\MasterData\VendorController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\Transaksi\PermintaanPengambilanController;
use App\Http\Controllers\Transaksi\PenerimaanController;
use App\Http\Controllers\Transaksi\PengeluaranController;
use App\Http\Controllers\UserManagement\UserController;
use App\Models\User;
use Illuminate\Support\Facades\Route;

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
Route::middleware(['auth'])->group(function () {
    Route::get('/', [DashboardController::class,'index']);

    //barang
    Route::resource('barang',BarangController::class);
    Route::resource('barang-masuk',BarangMasukController::class);
    Route::resource('barang-keluar',BarangKeluarController::class);

    //users
    Route::resource('user-management/user',UserController::class);

    //report
    Route::get('report',[ReportController::class,'index']);
    Route::get('report-penjualan',[ReportController::class,'exportPenjualan']);

});


Route::get('/sign-in',[AuthController::class, 'index'])->name('login');
Route::post('/sign-in',[AuthController::class, 'authenticate'])->name('authenticate');
Route::get('/sign-out',[AuthController::class, 'logout'])->name('logout');
