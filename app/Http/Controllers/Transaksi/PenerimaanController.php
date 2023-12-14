<?php

namespace App\Http\Controllers\Transaksi;

use App\Http\Controllers\Controller;
use App\Models\JenisLimbah;
use App\Models\Penerimaan;
use App\Models\Sisa;
use App\Models\SumberLimbah;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Validator;

class PenerimaanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        abort_if(Gate::denies('transaksi limbah'), 403);
        $title = 'Penerimaan Limbah';
        $penerimaan = Penerimaan::with(['jenis_limbah','sumber_limbah'])->orderBy('id','desc')->get();
        $dataToView = ['title','penerimaan'];
        return view('transaksi.penerimaan.index',compact($dataToView));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        abort_if(Gate::denies('transaksi limbah'), 403);
        $title = 'Penerimaan Limbah';
        $jenis_limbah = JenisLimbah::pluck('id','name');
        $sumber_limbah = SumberLimbah::pluck('id','name');
        $dataToView = ['title','jenis_limbah', 'sumber_limbah'];
        return view('transaksi.penerimaan.create',compact($dataToView));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        abort_if(Gate::denies('transaksi limbah'), 403);
        $validator = Validator::make($request->all(), [
            'jenis_limbah_id' => 'required',
            'jumlah_limbah_masuk' => 'required',
            'sumber_limbah_id' => 'required',
            'tanggal_masuk' => 'required',
            'maksimal_penyimpanan' => 'required',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        //check id sisa pengeluaran
        $pengeluaran = Sisa::where('sisa.jenis_limbah_id',$request->post('jenis_limbah_id'))
        ->leftJoin('pengeluaran','pengeluaran.sisa_id','=','sisa.id')
        ->where('jenis_transaksi','Pengeluaran')
        ->where('tanggal_keluar','>=',$request->post('tanggal_masuk'))
        ->orderBy('sisa.id','desc')->first();

        //harap hapus terlebih dahulu limbah keluar
        if(!empty($pengeluaran)){
            return redirect()->back()->withErrors('Tanggal masuk kurang dari tanggal keluar Harap hapus/edit limbah keluar terlebih dahulu')->withInput();
        }

        // update stock
        $sisa_limbah = Sisa::where('jenis_limbah_id',$request->post('jenis_limbah_id'))->orderBy('id','desc')->first();

        if ($sisa_limbah){
            $sisa_limbah_baru = Sisa::create([
                'jenis_limbah_id' => $request->post('jenis_limbah_id'),
                'sisa_akhir' => $sisa_limbah->sisa_akhir + $request->post('jumlah_limbah_masuk'),
                'jenis_transaksi' => 'Penerimaan'
            ]);
        }else{
            $sisa_limbah_baru = Sisa::create([
                'jenis_limbah_id' => $request->post('jenis_limbah_id'),
                'sisa_akhir' => $request->post('jumlah_limbah_masuk'),
                'jenis_transaksi' => 'Penerimaan'
            ]);
        }

        //tambah penerimaan
        $penerimaan = Penerimaan::create([
            'jenis_limbah_id' => $request->post('jenis_limbah_id'),
            'sisa_id' => $sisa_limbah_baru->id,
            'sumber_limbah_id' => $request->post('sumber_limbah_id'),
            'jumlah_limbah_masuk' => $request->post('jumlah_limbah_masuk'),
            'tanggal_masuk' => $request->post('tanggal_masuk'),
            'maksimal_penyimpanan' => $request->post('maksimal_penyimpanan')
        ]);
        
        return redirect('transaksi/penerimaan')->with('message','Data Berhasil Ditambahkan');

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
        $title = 'Penerimaan Limbah';
        $penerimaan = Penerimaan::findOrFail($id);
        $jenis_limbah = JenisLimbah::pluck('id','name');
        $sumber_limbah = SumberLimbah::pluck('id','name');
        $dataToView = ['title','penerimaan','jenis_limbah','sumber_limbah'];
        return view('transaksi.penerimaan.edit',compact($dataToView));
        
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, int $id)
    {
        abort_if(Gate::denies('transaksi limbah'), 403);
        $validator = Validator::make($request->all(), [
            'jenis_limbah_id' => 'required',
            'jumlah_limbah_masuk' => 'required',
            'sumber_limbah_id' => 'required',
            'tanggal_masuk' => 'required',
            'maksimal_penyimpanan' => 'required',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $penerimaan = Penerimaan::find($id);
        //decrement sisa limbah
        if ($penerimaan->jumlah_limbah_masuk > $request->jumlah_limbah_masuk){
            $selisih = $penerimaan->jumlah_limbah_masuk - $request->jumlah_limbah_masuk;
            $update_sisa_limbah = Sisa::where('id','>=',$penerimaan->sisa_id)->where('jenis_limbah_id',$penerimaan->jenis_limbah_id)->decrement('sisa_akhir',$selisih);
        }
        // increment sisa limbah
        if ($penerimaan->jumlah_limbah_masuk < $request->jumlah_limbah_masuk){
            $selisih =  $request->jumlah_limbah_masuk - $penerimaan->jumlah_limbah_masuk;
            $update_sisa_limbah = Sisa::where('id','>=',$penerimaan->sisa_id)->where('jenis_limbah_id',$penerimaan->jenis_limbah_id)->increment('sisa_akhir',$selisih);
        }

        //update penerimaan
        $penerimaan->jumlah_limbah_masuk = $request->jumlah_limbah_masuk;
        $penerimaan->sumber_limbah_id = $request->sumber_limbah_id;
        $penerimaan->tanggal_masuk = $request->tanggal_masuk;
        $penerimaan->maksimal_penyimpanan = $request->maksimal_penyimpanan;
        $penerimaan->save();
       
        return redirect('transaksi/penerimaan')->with('message','Data Berhasil Diupdate');
 
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id)
    {
        abort_if(Gate::denies('transaksi limbah'), 403);

        $penerimaan = Penerimaan::findOrFail($id);
        $sisa_limbah_akhir = Sisa::where('jenis_limbah_id',$penerimaan->jenis_limbah_id)->orderBy('id','desc')->first();
        $sisa_limbah = Sisa::find($penerimaan->sisa_id);


        //harap hapus terlebih dahulu limbah keluar
        if($sisa_limbah_akhir->sisa_akhir < $sisa_limbah->sisa_akhir){
            return redirect()->back()->withErrors('Sisa Limbah lebih sedikit dari stock');
        }


        // update sisa limbah
        if ($sisa_limbah->id != $sisa_limbah_akhir->id){
            $update_sisa_limbah = Sisa::where('id','>',$sisa_limbah->id)->where('jenis_limbah_id',$penerimaan->jenis_limbah_id)->decrement('sisa_akhir',$penerimaan->jumlah_limbah_masuk);
        }
        $penerimaan->delete();
        $sisa_limbah->delete();

        return redirect()->back()->with('message','Data Berhasil Dihapus');
    }

}
