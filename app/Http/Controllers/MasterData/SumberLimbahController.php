<?php

namespace App\Http\Controllers\MasterData;

use App\Http\Controllers\Controller;
use App\Models\SumberLimbah;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Validator;

class SumberLimbahController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        abort_if(Gate::denies('masterdata'), 403);
        $title = 'Sumber Limbah';
        $sumber_limbah = SumberLimbah::all();
        $dataToView = ['title','sumber_limbah'];
        return view('masterdata.sumber_limbah.index',compact($dataToView));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        abort_if(Gate::denies('masterdata'), 403);
        $title = 'Sumber Limbah';
        $dataToView = ['title'];
        return view('masterdata.sumber_limbah.create',compact($dataToView));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        abort_if(Gate::denies('masterdata'), 403);
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:sumber_limbah|max:255',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        SumberLimbah::create($request->all());
        return redirect('master-data/sumber-limbah')->with('message','Data Berhasil Ditambahkan');

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
        $title = 'Sumber Limbah';
        $sumber_limbah = SumberLimbah::findOrFail($id);
        $dataToView = ['title','sumber_limbah'];
        return view('masterdata.sumber_limbah.edit',compact($dataToView));
        
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, int $id)
    {
        abort_if(Gate::denies('masterdata'), 403);
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:sumber_limbah|max:255',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $sumber_limbah = SumberLimbah::where('id',$id)->update(['name' => $request->input('name')]);
        return redirect('master-data/sumber-limbah')->with('message','Data Berhasil Diupdate');
 
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id)
    {
        abort_if(Gate::denies('masterdata'), 403);
        $sumber_limbah = SumberLimbah::findOrFail($id);
 
        $sumber_limbah->delete();
        
        return redirect()->back()->with('message','Data Berhasil Dihapus');
    }
}
