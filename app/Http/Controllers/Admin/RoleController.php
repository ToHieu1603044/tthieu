<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\TextSystemConst;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;

class RoleController extends Controller
{
    public function __construct(){
      $this->middleware('permission:update role', ['only' => ['update','edit']]);
      $this->middleware('permission:view role', ['only' => ['index']]);
      $this->middleware('permission:delete role', ['only' => ['destroy']]);
      $this->middleware('permission:create role', ['only' => ['create','store']]);
    }
    public function index()
    {
        $data = Role::query()->paginate(10);

        $table = [
            'headers' => [
                ['text' => 'Mã Role', 'key' => 'id'],
                ['text' => 'Tên Role', 'key' => 'name'],
            ],
            'actions' => [
                'text' => 'Thao Tác',
                'create' => false,
                'createExcel' => false,
                'edit' => true,
                'deleteAll' => true,
                'delete' => true,
                'viewDetail' => true,
                'editPermission' => true
            ],
            'routes' => [
                'create' => 'roles.create',
                'edit' => 'roles.edit',
                'delete' => 'roles.destroy',
                'editPermission' => 'addPermissionRole'
            ],
            'list' => $data
        ];

        return view('role-permission.role.index', compact('table'));
    }

    public function create()
    {
        return view('role-permission.role.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:roles'
        ]);
        Role::create($request->all());

        return redirect()->route('roles.index')->with('status', 'Thêm thành công');
    }

    public function show(string $id)
    {
        //
    }

    public function edit(Role $role)
    {
        return view('role-permission.role.edit', compact('role'));
    }

    public function update(Role $role, Request $request)
    {
        $request->validate([
            'name' => 'required|unique:roles,name,' . $role->id
        ]);

        $role->update($request->all());

        return redirect()->back()->with('status', TextSystemConst::UPDATE_SUCCESS);
    }

    public function destroy(Role $role)
    {
        $role->delete();
        return redirect()->route('roles.index')->with('status', TextSystemConst::DELETE_SUCCESS);
    }
    public function addPermissionRole($roleid)
    {
        $permission = Permission::query()->get();
        $role = Role::findOrFail($roleid);
        $rolePermissions = DB::table('role_has_permissions')
            ->where('role_has_permissions.role_id', $role->id) //lấy từ bảng role_has_permissions và cột role_id = $role->id
            ->pluck('role_has_permissions.permission_id', 'role_has_permissions.permission_id') //và pluck cột permission_id VD: SELECT permission_id  FROM role_has_permissionsWHERE role_id = 2;
            ->all();

        $role = Role::findOrFail($roleid);

        return view('role-permission.role.add-permission', compact('role', 'permission', 'rolePermissions'));
    }
    public function updatePermissionRole(Request $request, $id)
    {
        $request->validate([
            'permission' => 'required'
        ]);

        $role = Role::findOrFail($id);
        $role->syncPermissions($request->permission);

        return redirect()->back()->with('status', 'Permission add to Role');
    }
}
