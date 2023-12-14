<?php

namespace App\Http\Controllers;

use App\Exports\ReportExport;
use App\Exports\ReportExportPerItem;
use App\Models\JenisLimbah;
use App\Models\Penerimaan;
use App\Models\Sisa;
use Illuminate\Database\Query\JoinClause;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class ReportController extends Controller
{
    public function index(){
        $title = "Report";
        $jenis_limbah_id = JenisLimbah::all()->pluck('id','name');

        return view('report.index',compact('title','jenis_limbah_id'));
    }

    public function datatable(Request $request){
         ## Read value
         $draw = $request->get('draw');
         $start = $request->get("start");
         $start_date_limbah_masuk = $request->get('start_date_limbah_masuk');
         $end_date_limbah_masuk = $request->get('end_date_limbah_masuk');
         $start_date_limbah_keluar = $request->get('start_date_limbah_keluar');
         $end_date_limbah_keluar = $request->get('end_date_limbah_keluar');

         $start_date_limbah_masuk = $start_date_limbah_masuk." 00:00:00";
         $end_date_limbah_masuk = $end_date_limbah_masuk." 23:59:59";
         $start_date_limbah_keluar = $start_date_limbah_keluar." 00:00:00";
         $end_date_limbah_keluar = $end_date_limbah_keluar." 23:59:59";
      

         $rowperpage = $request->get("length"); // Rows display per page
         $columnIndex_arr = $request->get('order');
         $columnName_arr = $request->get('columns');
         $order_arr = $request->get('order');
         $search_arr = $request->get('search');
         $columnIndex = $columnIndex_arr[0]['column']; // Column index
         $columnName = $columnName_arr[$columnIndex]['data']; // Column name
         $columnSortOrder = $order_arr[0]['dir']; // asc or desc
         $searchValue = $search_arr['value']; // Search value
         
   
         // Total records
         $totalRecords = DB::table('jenis_limbah')
         ->leftJoin('sisa','sisa.jenis_limbah_id','=', 'jenis_limbah.id')
         ->leftJoin('penerimaan','sisa.id','=', 'penerimaan.sisa_id')
         ->leftJoin('pengeluaran','sisa.id','=', 'pengeluaran.sisa_id')
         ->when(
          function ($query) {
            return $query->whereNotNull('pengeluaran.tanggal_keluar');
          },
          function ($query) use ($start_date_limbah_masuk,$end_date_limbah_masuk){
              // Add additional conditions or other where clauses if needed
              return $query->whereBetween('pengeluaran.tanggal_keluar',[$start_date_limbah_masuk,$end_date_limbah_masuk]);
          }
        )
        ->when(
          function ($query) {
            return $query->orWhereNotNull('penerimaan.tanggal_masuk');
          },
          function ($query) use ($start_date_limbah_masuk,$end_date_limbah_masuk){
              // Add additional conditions or other where clauses if needed
              return $query->whereBetween('penerimaan.tanggal_masuk',[$start_date_limbah_masuk,$end_date_limbah_masuk]);
          }
        )
         ->whereNotNull('sisa.id')
         ->count();
         $totalRecordswithFilter = DB::table('jenis_limbah')
         ->leftJoin('sisa','sisa.jenis_limbah_id','=', 'jenis_limbah.id')
         ->leftJoin('penerimaan','sisa.id','=', 'penerimaan.sisa_id')
         ->leftJoin('pengeluaran','sisa.id','=', 'pengeluaran.sisa_id')
         ->whereNotNull('sisa.id')
         ->when(
          function ($query) {
            return $query->whereNotNull('pengeluaran.tanggal_keluar');
          },
          function ($query) use ($start_date_limbah_masuk,$end_date_limbah_masuk){
              // Add additional conditions or other where clauses if needed
              return $query->whereBetween('pengeluaran.tanggal_keluar',[$start_date_limbah_masuk,$end_date_limbah_masuk]);
          }
        )
        ->when(
          function ($query) {
            return $query->orWhereNotNull('penerimaan.tanggal_masuk');
          },
          function ($query) use ($start_date_limbah_masuk,$end_date_limbah_masuk){
              // Add additional conditions or other where clauses if needed
              return $query->whereBetween('penerimaan.tanggal_masuk',[$start_date_limbah_masuk,$end_date_limbah_masuk]);
          }
        )
         ->where('jenis_limbah.name', 'like', '%' .$searchValue . '%')
         ->count();

         // Fetch records
          $records  = DB::table('sisa')
          ->select('sisa.id as sisa_id','jenis_limbah.name as jenis_limbah_name', 'penerimaan.tanggal_masuk',
          'sumber_limbah.name as sumber_limbah_name',
          'penerimaan.jumlah_limbah_masuk', 'penerimaan.maksimal_penyimpanan',
          'pengeluaran.tanggal_keluar', 'vendors.name as vendors_name',
          'pengeluaran.jumlah_limbah_keluar',
          'pengeluaran.bukti_nomor_dokumen',
          'sisa.sisa_akhir',
          'sisa.jenis_transaksi')
          ->where('jenis_limbah.name', 'like', '%' .$searchValue . '%')
          ->whereNotNull('sisa.id')
          // ->where(function ($query) use ($start_date_limbah_keluar,$end_date_limbah_keluar){
          //   $query->whereNotNull('pengeluaran.tanggal_keluar')
          //         ->where('title', '=', 'Admin');
          // })
          ->when(
            function ($query) {
              return $query->whereNotNull('pengeluaran.tanggal_keluar');
            },
            function ($query) use ($start_date_limbah_masuk,$end_date_limbah_masuk){
                // Add additional conditions or other where clauses if needed
                return $query->whereBetween('pengeluaran.tanggal_keluar',[$start_date_limbah_masuk,$end_date_limbah_masuk]);
            }
          )
          ->when(
            function ($query) {
              return $query->orWhereNotNull('penerimaan.tanggal_masuk');
            },
            function ($query) use ($start_date_limbah_masuk,$end_date_limbah_masuk){
                // Add additional conditions or other where clauses if needed
                return $query->whereBetween('penerimaan.tanggal_masuk',[$start_date_limbah_masuk,$end_date_limbah_masuk]);
            }
          )
          ->leftJoin('jenis_limbah','sisa.jenis_limbah_id','=', 'jenis_limbah.id')
          ->leftJoin('penerimaan','sisa.id','=', 'penerimaan.sisa_id')
          ->leftJoin('sumber_limbah','sumber_limbah.id','=', 'penerimaan.sumber_limbah_id')
          ->leftJoin('pengeluaran','sisa.id','=', 'pengeluaran.sisa_id')
          ->leftJoin('vendors','pengeluaran.vendor_id','=', 'vendors.id')
          ->orderBy('sisa.jenis_limbah_id','ASC')
          ->orderBy('sisa.id', 'ASC')
          ->skip($start)
          ->take($rowperpage)
          ->get();

         $data_arr = array();
         foreach($records as $record){
           $sisa_id = $record->sisa_id;
           $jenis_limbah_name = $record->jenis_limbah_name;
           $sisa_akhir  = $record->sisa_akhir ;
           $tanggal_masuk  = $record->tanggal_masuk ;
           $sumber_limbah_name = $record->sumber_limbah_name;
           $jumlah_limbah_masuk = $record->jumlah_limbah_masuk;
           $maksimal_penyimpanan = $record->maksimal_penyimpanan;
           $tanggal_keluar = $record->tanggal_keluar;
           $vendors_name = $record->vendors_name;
           $jumlah_limbah_keluar = $record->jumlah_limbah_keluar;
           $bukti_nomor_dokumen = $record->bukti_nomor_dokumen;

           $data_arr[] = array(
             "sisa_id" => $sisa_id,
             "jenis_limbah_name" => $jenis_limbah_name,
             "tanggal_masuk" => $tanggal_masuk != '' ? date("d-M-Y",strtotime($tanggal_masuk)) : '',
             "sumber_limbah_name" => $sumber_limbah_name,
             "jumlah_limbah_masuk" => $jumlah_limbah_masuk,
             "maksimal_penyimpanan" => $maksimal_penyimpanan != '' ? date("d-M-Y",strtotime($maksimal_penyimpanan)) : '',
             "tanggal_keluar" => $tanggal_keluar != '' ? date("d-M-Y",strtotime($tanggal_keluar)) : '',  
             "vendors_name" => $vendors_name,
             "jumlah_limbah_keluar" => $jumlah_limbah_keluar,
             "bukti_nomor_dokumen" => $bukti_nomor_dokumen,
             "sisa_akhir" => $sisa_akhir,
           );
         }
   
         $response = array(
           "draw" => intval($draw),
           "iTotalRecords" => $totalRecords,
           "iTotalDisplayRecords" => $totalRecordswithFilter,
           "aaData" => $data_arr
         );
         echo json_encode($response);
         exit;
       }

       public function export($start_date_limbah_masuk,$end_date_limbah_masuk,$start_date_limbah_keluar, $end_date_limbah_keluar) 
      {
          return Excel::download(new ReportExport($start_date_limbah_masuk,$end_date_limbah_masuk,$start_date_limbah_keluar, $end_date_limbah_keluar), 'report_'.date("Y-m-d").'.xlsx');
      }
       public function exportPerItem($start_date_limbah_masuk,$end_date_limbah_masuk,$start_date_limbah_keluar, $end_date_limbah_keluar,$jenis_limbah_id) 
      {
          return Excel::download(new ReportExportPerItem($start_date_limbah_masuk,$end_date_limbah_masuk,$start_date_limbah_keluar, $end_date_limbah_keluar,$jenis_limbah_id), 'report_per_item_'.date("Y-m-d").'.xlsx');
      }

}
