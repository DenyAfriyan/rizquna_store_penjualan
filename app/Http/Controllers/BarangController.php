<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Barang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Validator;

class BarangController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        abort_if(Gate::denies('Barang'), 403);
        $title = 'Barang';
        $barang = Barang::all();
        $dataToView = ['title','barang'];
        return view('barang.index',compact($dataToView));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        abort_if(Gate::denies('Barang'), 403);
        $title = 'Barang';
        $dataToView = ['title'];
        return view('barang.create',compact($dataToView));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        abort_if(Gate::denies('Barang'), 403);
        $validator = Validator::make($request->all(), [
            'nama_barang' => 'required|unique:barang|max:255',
            'gambar_barang' => 'required|image'
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $file = $request->file('gambar_barang');
        $nama_file = time()."_".$file->getClientOriginalName();
        $tujuan_upload = 'data_file_barang';
        $file->move($tujuan_upload,$nama_file);

        $input = $request->all();
        $input["stok"] = 0;
        $input["gambar_barang"] = $nama_file;
        Barang::create($input);
        return redirect('barang')->with('message','Data Berhasil Ditambahkan');

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
        abort_if(Gate::denies('Barang'), 403);
        $title = 'Barang';
        $barang = Barang::findOrFail($id);
        $dataToView = ['title','barang'];
        return view('barang.edit',compact($dataToView));

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, int $id)
    {
        abort_if(Gate::denies('Barang'), 403);
        $validator = Validator::make($request->all(), [
            'nama_barang' => 'required|max:255',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $input = $request->except(['_method', '_token']);
        if($request->hasFile('gambar_barang')){
            $file = $request->file('gambar_barang');
            $nama_file = time()."_".$file->getClientOriginalName();
            $tujuan_upload = 'data_file_barang';
            $file->move($tujuan_upload,$nama_file);
            $input["gambar_barang"] = $nama_file;
        }
        $barang = Barang::where('id',$id)->update($input);
        return redirect('barang')->with('message','Data Berhasil Diupdate');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id)
    {
        abort_if(Gate::denies('Barang'), 403);
        $barang = Barang::findOrFail($id);

        $barang->delete();

        return redirect()->back()->with('message','Data Berhasil Dihapus');
    }
}
