<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\TextSystemConst;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use App\Http\Controllers\Controller;

class PermissionController extends Controller
{
    public function __construct(){
        $this->middleware('permission:view permission', ['only' => ['index']]);
        $this->middleware('permission:delete permission', ['only' => ['destroy']]);
        $this->middleware('permission:update permission', ['only' => ['update','edit']]);
        $this->middleware('permission:create permission', ['only' => ['create','store']]);
       
      }
    public function index()
    {
        $data = Permission::query()->paginate(10);

        $table = [
            'headers'=> [
                ['text' => 'Mã Permission', 'key' => 'id'],
                ['text' => 'Tên Permission', 'key'=>'name'],
            ],
            'actions'=> [
                'text' => 'Thao Tác',
                'create' => false,
                'createExcel' => false,
                'edit' => true,
                'deleteAll' => false,
                'delete' => true,
                'viewDetail' => true,
                'editPermission' =>false
            ],
            'routes'=> [
                'create' =>'permissions.create',
                'edit' =>'permissions.edit',
                'delete'=>'permissions.destroy',
                'editPermission' =>'roles'
            ],
            'list'=>$data
        ];

        return view('role-permission.permission.index',compact('table'));
    }

    public function create()
    {
        return view('role-permission.permission.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' =>'required|unique:permissions'
        ]);
        Permission::create($request->all());

        return redirect()->route('permissions.index')->with('status','Thêm thành công');
    }

    public function show(string $id)
    {
        //
    }

    public function edit(Permission $permission)
    {
        return view('role-permission.permission.edit',compact('permission'));
    }

    public function update(Permission $permission, Request $request)
    {
        $request->validate([
            'name'=>'required|unique:permissions,name,'.$permission->id
        ]);

        $permission->update($request->all());

        return redirect()->back()->with('status',TextSystemConst::UPDATE_SUCCESS);
    }

    public function destroy(Permission $permission)
    {   
        $permission->delete();
        return redirect()->route('permissions.index')->with('status',TextSystemConst::DELETE_SUCCESS);
    }
}
