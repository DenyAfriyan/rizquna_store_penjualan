<?php

namespace App\Http\Controllers\Transaksi;

use App\Http\Controllers\Controller;
use App\Models\JenisLimbah;
use App\Models\Pengeluaran;
use App\Models\PermintaanPengambilan;
use App\Models\Sisa;
use App\Models\SumberLimbah;
use App\Models\vendor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Validator;

class PengeluaranController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        abort_if(Gate::denies('transaksi limbah'), 403);
        $title = 'Pengeluaran Limbah';
        $pengeluaran = Pengeluaran::with(['jenis_limbah','vendor'])->orderBy('id','desc')->get();
        $dataToView = ['title','pengeluaran'];
        return view('transaksi.pengeluaran.index',compact($dataToView));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        abort_if(Gate::denies('transaksi limbah'), 403);
        $title = 'Pengeluaran Limbah';
        $sisa_akhir = Sisa::with(['jenis_limbah'])->select(DB::raw('MAX(id) as max_id'),'jenis_limbah_id')->groupBy('jenis_limbah_id')->get();
        $sisa_akhir_id = [];
        foreach($sisa_akhir as $row){
            array_push($sisa_akhir_id,$row->max_id);
        }
        $sisa = Sisa::with(['jenis_limbah'])->whereIn('id',$sisa_akhir_id)->where('sisa_akhir','>',0)->get();
        $vendor = vendor::pluck('id','name');
        $dataToView = ['title','sisa','vendor'];
        return view('transaksi.pengeluaran.create',compact($dataToView));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        abort_if(Gate::denies('transaksi limbah'), 403);
        $validator = Validator::make($request->all(), [
            'jenis_limbah_id' => 'required',
            'vendor_id' => 'required',
            'jumlah_limbah_keluar' => 'required',
            'bukti_nomor_dokumen' => 'required',
            'tanggal_keluar' => 'required',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // validasi limbahh
        $sisa_limbah = Sisa::where('jenis_limbah_id',$request->post('jenis_limbah_id'))->orderBy('id','desc')->first();
        if ($sisa_limbah->sisa_akhir < $request->jumlah_limbah_keluar){
            return redirect()->back()->withErrors("Limbah Keluar lebih banyak dari limbah di TPS")->withInput();
        }

        //check id sisa pengeluaran
        $pengeluaran = Pengeluaran::orderBy('id','DESC')->where('jenis_limbah_id',$request->post('jenis_limbah_id'))
        ->where('tanggal_keluar','>=',$request->tanggal_keluar)
        ->first();

        //data limbah tidak sesuai
        if(!empty($pengeluaran)){
            return redirect()->back()->withErrors('Tanggal keluar kurang dari tanggal keluar terbaru Harap hapus/edit limbah keluar terlebih dahulu')->withInput();
        }

        //update stock
        $sisa_limbah_baru = Sisa::create([
            'jenis_limbah_id' => $request->post('jenis_limbah_id'),
            'sisa_akhir' => $sisa_limbah->sisa_akhir - $request->post('jumlah_limbah_keluar'),
            'jenis_transaksi' => 'Pengeluaran'
        ]);

        //tambah pengeluaran
        $pengeluaran = Pengeluaran::create([
            'jenis_limbah_id' => $request->post('jenis_limbah_id'),
            'sisa_id' => $sisa_limbah_baru->id,
            'vendor_id' => $request->post('vendor_id'),
            'jumlah_limbah_keluar' => $request->post('jumlah_limbah_keluar'),
            'bukti_nomor_dokumen' => $request->post('bukti_nomor_dokumen'),
            'tanggal_keluar' => $request->post('tanggal_keluar')
        ]);
        
        return redirect('transaksi/pengeluaran')->with('message','Data Berhasil Ditambahkan');

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(int $id)
    {
        abort_if(Gate::denies('transaksi limbah'), 403);
        $title = 'Pengeluaran Limbah';
        $pengeluaran = Pengeluaran::findOrFail($id);
        $jenis_limbah = JenisLimbah::pluck('id','name');
        $sumber_limbah = SumberLimbah::pluck('id','name');
        $vendor = vendor::pluck('id','name');
        $dataToView = ['title','pengeluaran','jenis_limbah','vendor'];
        return view('transaksi.pengeluaran.edit',compact($dataToView));
        
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, int $id)
    {
        abort_if(Gate::denies('transaksi limbah'), 403);
        $validator = Validator::make($request->all(), [
            'jenis_limbah_id' => 'required',
            'vendor_id' => 'required',
            'jumlah_limbah_keluar' => 'required',
            'bukti_nomor_dokumen' => 'required',
            'tanggal_keluar' => 'required',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $pengeluaran = Pengeluaran::find($id);
        //increment sisa limbah
        if ($pengeluaran->jumlah_limbah_keluar > $request->jumlah_limbah_keluar){
            $selisih = $pengeluaran->jumlah_limbah_keluar - $request->jumlah_limbah_keluar;
            $update_sisa_limbah = Sisa::where('id','>=',$pengeluaran->sisa_id)->where('jenis_limbah_id',$pengeluaran->jenis_limbah_id)->increment('sisa_akhir',$selisih);
        }
        // decrement sisa limbah
        if ($pengeluaran->jumlah_limbah_keluar < $request->jumlah_limbah_keluar){
            $selisih =  $request->jumlah_limbah_keluar - $pengeluaran->jumlah_limbah_keluar;
            $update_sisa_limbah = Sisa::where('id','>=',$pengeluaran->sisa_id)->where('jenis_limbah_id',$pengeluaran->jenis_limbah_id)->decrement('sisa_akhir',$selisih);
        }

        //update pengeluaran
        $pengeluaran->vendor_id = $request->vendor_id;
        $pengeluaran->bukti_nomor_dokumen = $request->vendor_id;
        $pengeluaran->jumlah_limbah_keluar = $request->jumlah_limbah_keluar;
        $pengeluaran->tanggal_keluar = $request->tanggal_keluar;
        $pengeluaran->save();
       
        return redirect('transaksi/pengeluaran')->with('message','Data Berhasil Diupdate');
 
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id)
    {
        abort_if(Gate::denies('transaksi limbah'), 403);

        $pengeluaran = Pengeluaran::findOrFail($id);
        $sisa_limbah_akhir = Sisa::where('jenis_limbah_id',$pengeluaran->jenis_limbah_id)->orderBy('id','desc')->first();
        $sisa_limbah = Sisa::find($pengeluaran->sisa_id);

        // update sisa limbah
        if ($sisa_limbah->id != $sisa_limbah_akhir->id){
            $update_sisa_limbah = Sisa::where('id','>',$sisa_limbah->id)->where('jenis_limbah_id',$pengeluaran->jenis_limbah_id)->increment('sisa_akhir',$pengeluaran->jumlah_limbah_keluar);
        }
        $pengeluaran->delete();
        $sisa_limbah->delete();

        return redirect()->back()->with('message','Data Berhasil Dihapus');
    }

}
