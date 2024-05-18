<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Barang;
use App\Models\BarangKeluar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Validator;

class BarangKeluarController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        abort_if(Gate::denies('Barang Keluar'), 403);
        $title = 'Barang Keluar';
        $barang_keluar = BarangKeluar::with(['barang'])->orderBy('id','desc')->get();
        $dataToView = ['title','barang_keluar'];
        return view('barang_keluar.index',compact($dataToView));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        abort_if(Gate::denies('Barang Keluar'), 403);
        $title = 'Barang Keluar';
        $barang = Barang::select('id','nama_barang','harga_satuan')->get();
        $dataToView = ['title','barang'];
        return view('barang_keluar.create',compact($dataToView));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        abort_if(Gate::denies('Barang Keluar'), 403);
        $validator = Validator::make($request->all(), [
            'qty' => 'required',
            'harga_satuan' => 'required',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        //insert karyawan
        $input = $request->all();
        $input["nama_karyawan"] = $request->user()->name;

        $barang = Barang::find($request->barang_id);

        //hitung margin
        $harga_modal = $barang->harga_satuan * $request->qty ;
        $harga_jual = $request->harga_satuan * $request->qty ;
        $input["margin"] = $harga_jual - $harga_modal;

        if ($barang->stok < $request->qty){
            return redirect()->back()->withErrors('Stok Habis')->withInput();
        }
        $barang->stok = $barang->stok - $request->qty;
        $barang->save();
        BarangKeluar::create($input);

        return redirect('barang-keluar')->with('message','Data Berhasil Ditambahkan');

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
        abort_if(Gate::denies('Barang Keluar'), 403);
        $title = 'Barang Keluar';
        $barang_keluar = BarangKeluar::findOrFail($id);
        $dataToView = ['title','barang_keluar'];
        return view('barang_keluar.edit',compact($dataToView));

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, int $id)
    {
        abort_if(Gate::denies('Barang Keluar'), 403);
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:barang_keluar|max:255',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $barang_keluar = BarangKeluar::where('id',$id)->update(['name' => $request->input('name')]);
        return redirect('barang-keluar')->with('message','Data Berhasil Diupdate');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id)
    {
        abort_if(Gate::denies('Barang Keluar'), 403);
        $barang_keluar = BarangKeluar::findOrFail($id);

        $barang_keluar->delete();

        return redirect()->back()->with('message','Data Berhasil Dihapus');
    }
}
