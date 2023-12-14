<?php

namespace App\Exports;

use App\Models\User;

use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithDrawings;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromView;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;

class ReportExport implements  WithDrawings, FromView, ShouldAutoSize, WithStyles
{

    protected $start_date_limbah_masuk;
    protected $end_date_limbah_masuk;
    protected $start_date_limbah_keluar;
    protected $end_date_limbah_keluar;  
    
    public function __construct($start_date_limbah_masuk,$end_date_limbah_masuk,$start_date_limbah_keluar, $end_date_limbah_keluar)
    {
        $this->start_date_limbah_masuk = $start_date_limbah_masuk;
        $this->end_date_limbah_masuk = $end_date_limbah_masuk;
        $this->start_date_limbah_keluar = $start_date_limbah_keluar;
        $this->end_date_limbah_keluar = $end_date_limbah_keluar;
    }
    public function drawings()
    {
        $drawing = new Drawing();
        $drawing->setName('Logo');
        $drawing->setDescription('Logo FDR');
        $drawing->setPath(public_path('assets/img/logo-excel.png'));
        $drawing->setHeight(30);
        $drawing->setCoordinates('B2');

        return $drawing;
    }
    public function title(): string
    {
        return 'Report Limbah';
    }
    
    public function view(): View
    {
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
        ->whereNotNull('sisa.id')
        // ->where(function ($query) use ($start_date_limbah_keluar,$end_date_limbah_keluar){
        //   $query->whereNotNull('pengeluaran.tanggal_keluar')
        //         ->where('title', '=', 'Admin');
        // })
        ->when(
          function ($query) {
            return $query->whereNotNull('pengeluaran.tanggal_keluar');
          },
          function ($query){
              // Add additional conditions or other where clauses if needed
              return $query->whereBetween('pengeluaran.tanggal_keluar',[$this->start_date_limbah_masuk,$this->end_date_limbah_masuk]);
          }
        )
        ->when(
          function ($query) {
            return $query->orWhereNotNull('penerimaan.tanggal_masuk');
          },
          function ($query){
              // Add additional conditions or other where clauses if needed
              return $query->whereBetween('penerimaan.tanggal_masuk',[$this->start_date_limbah_masuk,$this->end_date_limbah_masuk]);
          }
        )
        ->leftJoin('jenis_limbah','sisa.jenis_limbah_id','=', 'jenis_limbah.id')
        ->leftJoin('penerimaan','sisa.id','=', 'penerimaan.sisa_id')
        ->leftJoin('sumber_limbah','sumber_limbah.id','=', 'penerimaan.sumber_limbah_id')
        ->leftJoin('pengeluaran','sisa.id','=', 'pengeluaran.sisa_id')
        ->leftJoin('vendors','pengeluaran.vendor_id','=', 'vendors.id')
        ->orderBy('sisa.jenis_limbah_id','ASC')
        ->orderBy('sisa.id', 'ASC')
        ->get();
        return view('exports.reports', [
            'report_data' => $records
        ]);
    }
    public function styles(Worksheet $sheet)
{
    // Set alignment to center for rows 1 to 4 and columns A to AU
    $centerAlignment = new Alignment();
    $centerAlignment->setHorizontal(Alignment::HORIZONTAL_CENTER);
    $centerAlignment->setVertical(Alignment::VERTICAL_CENTER);

    // Apply center alignment for the entire worksheet range (A1 to AU1000 or any desired range)
    $sheet->getStyle('A2:BG10')->getAlignment()->setWrapText(true);
    $sheet->getStyle('A2:BG10')->getAlignment()->setHorizontal($centerAlignment->getHorizontal());
    $sheet->getStyle('A2:BG10')->getAlignment()->setVertical($centerAlignment->getVertical());

    // Set alignment to top-left for all rows starting from row 5 and columns A to AU
    $topLeftAlignment = new Alignment();
    $topLeftAlignment->setHorizontal(Alignment::HORIZONTAL_LEFT);
    $topLeftAlignment->setVertical(Alignment::VERTICAL_TOP);

    // Apply top-left alignment for the entire worksheet range starting from row 5 (A5 to AU1000 or any desired range)
    $sheet->getStyle('A11:BG1000')->getAlignment()->setWrapText(true);
    $sheet->getStyle('A11:BG1000')->getAlignment()->setHorizontal($topLeftAlignment->getHorizontal());
    $sheet->getStyle('A11:BG1000')->getAlignment()->setVertical($topLeftAlignment->getVertical());

    // Set BGtosize for all columns (A to BG)
    for ($col = 'A'; $col <= 'BG'; $col++) {
        $sheet->getColumnDimension($col)->setAutoSize(true);
    }
    
    // Set specific column width for row 4
    $sheet->getRowDimension(2)->setRowHeight(20);
    $sheet->getRowDimension(3)->setRowHeight(20);
    $sheet->getRowDimension(4)->setRowHeight(20);
    $sheet->getRowDimension(5)->setRowHeight(20);
    $sheet->getRowDimension(6)->setRowHeight(20);
    $sheet->getRowDimension(7)->setRowHeight(20);
    $sheet->getRowDimension(10)->setRowHeight(40);

 
    return [
        // Define other styles if needed
    ];
}
}
