<?php

namespace App\Http\Controllers\MasterData;

use App\Http\Controllers\Controller;
use App\Models\JenisLimbah;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Validator;

class JenisLimbahController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        abort_if(Gate::denies('masterdata'), 403);
        $title = 'Jenis Limbah';
        $jenis_limbah = JenisLimbah::all();
        $dataToView = ['title','jenis_limbah'];
        return view('masterdata.jenis_limbah.index',compact($dataToView));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        abort_if(Gate::denies('masterdata'), 403);
        $title = 'Jenis Limbah';
        $dataToView = ['title'];
        return view('masterdata.jenis_limbah.create',compact($dataToView));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        abort_if(Gate::denies('masterdata'), 403);
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:jenis_limbah|max:255',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        JenisLimbah::create($request->all());
        return redirect('master-data/jenis-limbah')->with('message','Data Berhasil Ditambahkan');

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
        abort_if(Gate::denies('masterdata'), 403);
        $title = 'Jenis Limbah';
        $jenis_limbah = JenisLimbah::findOrFail($id);
        $dataToView = ['title','jenis_limbah'];
        return view('masterdata.jenis_limbah.edit',compact($dataToView));
        
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, int $id)
    {
        abort_if(Gate::denies('masterdata'), 403);
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:jenis_limbah|max:255',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $jenis_limbah = JenisLimbah::where('id',$id)->update(['name' => $request->input('name')]);
        return redirect('master-data/jenis-limbah')->with('message','Data Berhasil Diupdate');
 
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id)
    {
        abort_if(Gate::denies('masterdata'), 403);
        $jenis_limbah = JenisLimbah::findOrFail($id);
 
        $jenis_limbah->delete();
        
        return redirect()->back()->with('message','Data Berhasil Dihapus');
    }
}
