<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Hash;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    public function index()
    {
        $data = User::query()->paginate(5);

         $table = [
             'headers' => [
                 ['text' => 'Mã', 'key' => 'id'],
                 ['text' => 'Tên nhân viên', 'key' => 'name'],
                 ['text' => 'Email', 'key' => 'email'],
             ],
             'actions' => [
                 'text' => 'Thao Tác',
                 'create' => true,
                 'createExcel' => false,
                 'edit' => true,
                 'deleteAll' => true,
                 'delete' => true,
                 'viewDetail' => true,
                 'editPermission' =>false
             ],
             'routes' => [
                 'create' => 'users.create',
                 'delete' => 'users.destroy',
                 'edit' => 'users.edit',
             ],
             'list' => $data,
         ];
        return view('role-permission.user.index',compact('table'));
    }

    public function create()
    {
        $roles = Role::pluck('name','name')->all();
        return view('role-permission.user.create',compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->all();
        $data =  $request->validate([
            'name' =>'required',
            'email'=>'required',
            'password'=>'required',
            'roles'=>'required'
        ]);
        $data['password'] = Hash::make($request->password);
        
        $user =User::create($data);

        $user->syncRoles($request->roles);
        return redirect()->route('users.create');

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
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
