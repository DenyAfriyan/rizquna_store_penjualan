<?php

namespace App\Http\Controllers\Transaksi;

use App\Http\Controllers\Controller;
use App\Models\JenisLimbah;
use App\Models\PermintaanPengambilan;
use App\Models\SumberLimbah;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Validator;

class PermintaanPengambilanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $title = 'Permintaan Pengambilan';
        $permintaan_pengambilan = PermintaanPengambilan::with(['jenis_limbah','sumber_limbah'])->get();
        $dataToView = ['title','permintaan_pengambilan'];
        return view('transaksi.permintaan_pengambilan.index',compact($dataToView));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        abort_if(Gate::denies('permintaan pengambilan'), 403);
        $title = 'Permintaan Pengambilan';
        $jenis_limbah = JenisLimbah::pluck('id','name');
        $sumber_limbah = SumberLimbah::pluck('id','name');
        
        $dataToView = ['title','jenis_limbah','sumber_limbah'];
        return view('transaksi.permintaan_pengambilan.create',compact($dataToView));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        abort_if(Gate::denies('permintaan pengambilan'), 403);
        $validator = Validator::make($request->all(), [
            'jenis_limbah_id' => 'required',
            'sumber_limbah_id' => 'required',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        PermintaanPengambilan::create($request->all());
        return redirect('permintaan-pengambilan')->with('message','Data Berhasil Ditambahkan');

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
        abort_if(Gate::denies('permintaan pengambilan'), 403);
        $title = 'Permintaan Pengambilan';
        $jenis_limbah = JenisLimbah::findOrFail($id);
        $dataToView = ['title','jenis_limbah'];
        return view('transaksi.permintaan_pengambilan.edit',compact($dataToView));
        
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, int $id)
    {
        abort_if(Gate::denies('setujui pengambilan'), 403);
        $permintaan_pengambilan = PermintaanPengambilan::findOrFail($id);
        $permintaan_pengambilan->is_approved = 1;
        $permintaan_pengambilan->save(); 
        return redirect('permintaan-pengambilan')->with('message','Data Berhasil Disetujui');
 
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id)
    {
        abort_if(Gate::denies('setujui pengambilan'), 403);
        $jenis_limbah = PermintaanPengambilan::findOrFail($id);
 
        $jenis_limbah->delete();
        
        return redirect()->back()->with('message','Data Berhasil Dihapus');
    }
}
