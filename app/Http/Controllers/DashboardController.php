<?php

namespace App\Http\Controllers;

use App\Models\Penerimaan;
use App\Models\Pengeluaran;
use App\Models\PermintaanPengambilan;
use App\Models\Sisa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index(){
        $title = "Dashboard";
        $sisa_akhir = Sisa::with(['jenis_limbah'])->select(DB::raw('MAX(id) as max_id'),'jenis_limbah_id')->groupBy('jenis_limbah_id')->get();
        $sisa_akhir_id = [];
        foreach($sisa_akhir as $row){
            array_push($sisa_akhir_id,$row->max_id);
        }
        $sisa = Sisa::with(['jenis_limbah'])->whereIn('id',$sisa_akhir_id)->where('sisa_akhir','>',0)->get();
        $total_sisa = Sisa::select(DB::raw('SUM(sisa_akhir) as sisa_akhir'))->whereIn('id',$sisa_akhir_id)->where('sisa_akhir','>',0)->first();
        $permintaan_pengambilan_baru = PermintaanPengambilan::where('is_approved',0)->count();
        $limbah_keluar = Pengeluaran::all()->count();
        $limbah_masuk = Penerimaan::all()->count();

        $dataToView = ['title','sisa','permintaan_pengambilan_baru','total_sisa','limbah_keluar','limbah_masuk'];
    
        return view('dashboard.index',compact($dataToView));
    }
}
