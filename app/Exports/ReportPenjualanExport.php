<?php namespace App\Exports;

use App\Invoice;
use App\Models\Barang;
use App\Models\BarangKeluar;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromView;

class ReportPenjualanExport implements FromView
{
    public function view(): View
    {

        return view('exports.penjualan', [
            'barangKeluar' => BarangKeluar::select('barang_id', DB::raw('SUM(qty) as total_keluar'),DB::raw('SUM(margin) as total_margin'))
            ->groupBy('barang_id')
            ->get(),
            'barang' => Barang::all()

        ]);
    }
}
?>
