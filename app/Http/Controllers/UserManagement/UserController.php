<?php

namespace App\Http\Controllers\UserManagement;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        abort_if(Gate::denies('user management'), 403);
        $title = 'Users';
        $users = User::all();
        $dataToView = ['title','users'];
        return view('usermanagement.users.index',compact($dataToView));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        abort_if(Gate::denies('user management'), 403);
        $title = 'Users';
        $role = Role::all()->pluck('id','name');
        $dataToView = ['title','role'];
        return view('usermanagement.users.create',compact($dataToView));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        abort_if(Gate::denies('user management'), 403);
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:users|max:255',
            'email' => 'required|unique:users|max:255',
            'password' => 'required|confirmed|min:3',
            'role' => 'required',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $input = $request->all();
        $input['password'] = bcrypt($input['password']);
        $user = User::create($input);
        $role = Role::find($request->role);
        $user->assignRole($role);
        return redirect('user-management/user')->with('message','Data Berhasil Ditambahkan');

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
        abort_if(Gate::denies('user management'), 403);
        $title = 'Users';
        $user = User::findOrFail($id);
        $dataToView = ['title','user    '];
        return view('usermanagement.users.edit',compact($dataToView));
        
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, int $id)
    {
        abort_if(Gate::denies('user management'), 403);
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:users|max:255',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $users = User::where('id',$id)->update(['name' => $request->input('name')]);
        return redirect('user-management/user')->with('message','Data Berhasil Diupdate');
 
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id)
    {
        abort_if(Gate::denies('user management'), 403);
        $users = User::findOrFail($id);
 
        $users->delete();
        
        return redirect()->back()->with('message','Data Berhasil Dihapus');
    }
}
