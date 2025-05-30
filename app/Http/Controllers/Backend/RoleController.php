<?php

namespace App\Http\Controllers\Backend;

use App\Exports\PermissionExport;
use App\Http\Controllers\Controller;
use App\Imports\PermissionImport;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    //

    public function AllPermission()
    {
        $permissions = Permission::all();

        return view('backend.pages.permission.all_permission', compact('permissions'));
    }

    public function AddPermission()
    {
        return view('backend.pages.permission.add_permission');
    }

    public function StorePermission(Request $request)
    {
        $permissions = Permission::create([
            'name' => $request->name,
            'group_name' => $request->group_name
        ]);



        $notification = [
            'message' => 'Permission Created Successfully',
            'alert-type' => 'success'
        ];


        return redirect()->route('all.permission')->with($notification);
    }

    public function EditPermission($id)
    {
        $permissions = Permission::findOrFail($id);

        return view('backend.pages.permission.edit_permission', compact('permissions'));
    }

    public function UpdatePermission(Request $request)
    {
        $per_id = $request->id;
        Permission::findOrFail($per_id)->update([
            'name' => $request->name,
            'group_name' => $request->group_name
        ]);


        $notification = [
            'message' => 'Permission Updated Successfully',
            'alert-type' => 'success'
        ];


        return redirect()->route('all.permission')->with($notification);
    }

    public function DeletePermission($id)
    {

        Permission::findOrFail($id)->delete();

        $notification = [
            'message' => 'Permission Deleted Successfully',
            'alert-type' => 'success'
        ];

        return redirect()->route('all.permission')->with($notification);
    }

    public function ImportPermission()
    {

        return view('backend.pages.permission.import_permission');
    }

    public function Export()
    {
        return Excel::download(new PermissionExport, 'permission.xlsx');
    }

    public function import(Request $request)
    {
        Excel::import(new PermissionImport, $request->import_file);


        $notification = [
            'message' => 'Permission Imported Successfully',
            'alert-type' => 'success'
        ];

        return redirect()->route('all.permission')->with($notification);
    }


    // Role

    public function AllRoles()
    {
        $roles = Role::all();

        return view('backend.pages.roles.all_roles', compact('roles'));
    }

    public function AddRoles()
    {
        return view('backend.pages.roles.add_roles');
    }


    public function StoreRoles(Request $request)
    {
        $permissions = Role::create([
            'name' => $request->name,
        ]);



        $notification = [
            'message' => 'Roles Created Successfully',
            'alert-type' => 'success'
        ];


        return redirect()->route('all.roles')->with($notification);
    }

    public function EditRoles($id)
    {
        $roles = Role::findOrFail($id);

        return view('backend.pages.roles.edit_roles', compact('roles'));
    }
    public function UpdateRoles(Request $request)
    {
        $role_id = $request->id;
        Role::findOrFail($role_id)->update([
            'name' => $request->name,
        ]);


        $notification = [
            'message' => 'Role Updated Successfully',
            'alert-type' => 'success'
        ];


        return redirect()->route('all.roles')->with($notification);
    }
    public function DeleteRoles($id)
    {
        Role::findOrFail($id)->delete();

        $notification = [
            'message' => 'Role Deleted Successfully',
            'alert-type' => 'success'
        ];

        return redirect()->route('all.roles')->with($notification);
    }


    // role in permission

    public function AddRolesPermission()
    {
        $roles = Role::all();
        $permissions = Permission::all();
        $permission_group = User::getpermissionGroups();

        return view('backend.pages.rolesetup.add_roles_permission', compact('roles', 'permissions', 'permission_group'));
    }

    public function RolePermissionStore(Request $request)
    {
        $data = array();

        $permissions = $request->permission;

        foreach ($permissions as $key => $item) {
            $data['role_id'] = $request->role_id;
            $data['permission_id'] = $item;

            DB::table('role_has_permissions')->insert($data);
        }

        $notification = [
            'message' => 'Role Permission Added Successfully',
            'alert-type' => 'success'
        ];

        return redirect()->route('all.roles.permission')->with($notification);
    }

    public function AllRolesPermission()
    {
        $roles = Role::all();
        return view('backend.pages.rolesetup.all_roles_permission', compact('roles'));
    }

    public function EditRolesPermission($id){
        $role = Role::findOrFail($id);
        $permissions = Permission::all();
        $permission_group = User::getpermissionGroups();

        return view('backend.pages.rolesetup.edit_roles_permission', compact('role', 'permissions', 'permission_group'));

    }

    public function UpdateRolePermission(Request $request, $id){
        $role = Role::findOrFail($id);
        $permissions = $request->permission;

        if(!empty($permissions)){
            $role->syncPermissions($permissions);
        }

        $notification = [
            'message' => 'Role Permission Updated Successfully',
            'alert-type' => 'success'
        ];

        return redirect()->route('all.roles.permission')->with($notification);

    }

    public function DeleteRolePermission($id){
        $role = Role::findOrFail($id);

        if(!is_null($role)){
            $role->delete();
        }

        $notification = [
            'message' => 'Role Permission Deleted Successfully',
            'alert-type' => 'success'
        ];

        return redirect()->route('all.roles.permission')->with($notification);
    }
}
