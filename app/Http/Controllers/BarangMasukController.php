<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Barang;
use App\Models\BarangMasuk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Validator;

class BarangMasukController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        abort_if(Gate::denies('Barang Masuk'), 403);
        $title = 'Barang Masuk';
        $barang_masuk = BarangMasuk::with(['barang'])->orderBy('id','desc')->get();
        $dataToView = ['title','barang_masuk'];
        return view('barang_masuk.index',compact($dataToView));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        abort_if(Gate::denies('Barang Masuk'), 403);
        $title = 'Barang Masuk';
        $barang = Barang::pluck('id','nama_barang');
        $dataToView = ['title','barang'];
        return view('barang_masuk.create',compact($dataToView));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        abort_if(Gate::denies('Barang Masuk'), 403);
        $validator = Validator::make($request->all(), [
            'qty' => 'required',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        //insert karyawan
        $input = $request->all();
        $input["nama_karyawan"] = $request->user()->name;
        BarangMasuk::create($input);

        //add stock
        $barang = Barang::find($request->barang_id);
        $barang->stok = $barang->stok + $request->qty;
        $barang->save();
        return redirect('barang-masuk')->with('message','Data Berhasil Ditambahkan');

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
        abort_if(Gate::denies('Barang Masuk'), 403);
        $title = 'Barang Masuk';
        $barang_masuk = BarangMasuk::findOrFail($id);
        $dataToView = ['title','barang_masuk'];
        return view('barang_masuk.edit',compact($dataToView));

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, int $id)
    {
        abort_if(Gate::denies('Barang Masuk'), 403);
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:barang_masuk|max:255',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $barang_masuk = BarangMasuk::where('id',$id)->update(['name' => $request->input('name')]);
        return redirect('barang-masuk')->with('message','Data Berhasil Diupdate');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id)
    {
        abort_if(Gate::denies('Barang Masuk'), 403);
        $barang_masuk = BarangMasuk::findOrFail($id);

        $barang_masuk->delete();

        return redirect()->back()->with('message','Data Berhasil Dihapus');
    }
}
