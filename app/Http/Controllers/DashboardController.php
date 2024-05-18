<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\BarangKeluar;
use App\Models\BarangMasuk;
use App\Models\Penerimaan;
use App\Models\Pengeluaran;
use App\Models\PermintaanPengambilan;
use App\Models\Sisa;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index(){
        $title = "Dashboard";
        $total_stock_barang = Barang::sum('stok');
        $total_barang_masuk = BarangMasuk::sum('qty');
        $total_barang_keluar = BarangKeluar::sum('qty');
        $total_users_karyawan = User::role('karyawan')->count();

        $dataToView = ['title','total_stock_barang','total_barang_masuk','total_barang_keluar','total_users_karyawan'];

        return view('dashboard.index',compact($dataToView));
    }
}
