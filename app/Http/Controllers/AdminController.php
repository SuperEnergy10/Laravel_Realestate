<?php

namespace App\Http\Controllers;

use Spatie\Permission\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role as ModelsRole;

class AdminController extends Controller
{
    public function AdminDashboard()
    {
        return view('admin.index');
    }

    public function AdminLogout(Request $request)
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        $notification = [
            'message' => 'Agent Logout Successfully',
            'alert-type' => 'success'
        ];

        return redirect('admin/login')->with($notification);
    }

    public function AdminLogin()
    {
        return view('admin.admin_login');
    }
    public function AdminProfile()
    {
        $id = Auth::user()->id;
        $profileData = User::find($id);
        return view('admin.admin_profile_view', compact('profileData'));
    }
    public function AdminProfileStore(Request $request)
    {
        $id = Auth::user()->id;
        $data = User::find($id);
        $data->username = $request->username;
        $data->name = $request->name;
        $data->email = $request->email;
        $data->phone = $request->phone;
        $data->address = $request->address;

        if ($request->file('photo')) {
            $file = $request->file('photo');
            @unlink(public_path('upload/admin_images/') . $data->photo);
            $filename = date('YmdHi') . $file->getClientOriginalName();
            $file->move(public_path('upload/admin_images'), $filename);
            $data['photo'] = $filename;
        }

        $data->save();

        $notification = array(
            'message' => 'Admin Profile Updated Successfully',
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification);
    }

    public function AdminChangePassword()
    {
        $id = Auth::user()->id;
        $profileData = User::find($id);
        return view('admin.admin_change_password', compact('profileData'));
    }

    public function AdminUpdatePassword(Request $request)
    {
        // validation

        $request->validate([
            'old_password' => 'required',
            'new_password' => 'required|confirmed',
        ]);

        // match the old password

        if (!Hash::check($request->old_password, Auth::user()->password)) {
            $notification = [
                'message' => 'Old Password Does Not Match!',
                'alert-type' => 'error'
            ];
            return redirect()->back()->with($notification);
        }

        // update the new password

        User::whereId(Auth::user()->id)->update([
            'password' => Hash::make($request->new_password)
        ]);

        $notification = [
            'message' => 'Password Change Successfully',
            'alert-type' => 'success'
        ];

        return redirect()->back()->with($notification);
    }

    // Agent user all methods

    public function AllAgent()
    {
        $allagent = User::where('role', 'agent')->get();
        return view('backend.agentuser.all_agent', compact('allagent'));
    }

    public function AddAgent()
    {
        return view('backend.agentuser.add_agent');
    }

    public function StoreAgent(Request $request)
    {
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'address' => $request->address,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
            'role' => 'agent',
            'status' => 'active'
        ]);

        $notification = [
            'message' => 'Created Agent Successfully',
            'alert-type' => 'success'
        ];

        return redirect()->route('all.agent')->with($notification);
    }

    public function EditAgent($id)
    {
        $allagent = User::findOrFail($id);
        return view('backend.agentuser.edit_agent', compact('allagent'));
    }

    public function UpdateAgent(Request $request)
    {
        User::findOrFail($request->id)->update([
            'name' => $request->name,
            'email' => $request->email,
            'address' => $request->address,
            'phone' => $request->phone,
        ]);

        $notification = [
            'message' => 'Updated Agent Successfully',
            'alert-type' => 'success'
        ];

        return redirect()->route('all.agent')->with($notification);
    }

    public function DeleteAgent($id)
    {
        User::findOrFail($id)->delete();
        $notification = [
            'message' => 'Deleted Agent Successfully',
            'alert-type' => 'success'
        ];

        return redirect()->back()->with($notification);
    }

    public function changeStatus(Request $request)
    {
        $user = User::find($request->user_id);
        $user->status = $request->status;
        $user->save();


        return response()->json(['success' => 'Status change successfully']);
    }


    // Admin user all methods

    public function AllAdmin()
    {
        $alladmin = User::where('role', 'admin')->get();
        return view('backend.pages.admin.all_admin', compact('alladmin'));
    }

    public function AddAdmin()
    {
        $roles = Role::all();
        return view('backend.pages.admin.add_admin', compact('roles'));
    }

    public function StoreAdmin(Request $request){
        $user = new User();

        $user->username = $request->username;
        $user->name = $request->name;
        $user->address = $request->address;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->address= $request->address;
        $user->password = Hash::make($request->password) ;
        $user->role = 'admin';
        $user->status = 'active';

        $user->save();

        if($request->roles){
            $user->assignRole($request->roles);
        }

        $notification = [
            'message' => 'New Admin User Created Successfully',
            'alert-type' => 'success'
        ];

        return redirect()->route('all.admin')->with($notification);
    }

    public function EditAdmin($id){
        $user = User::findOrFail($id);
        $roles = Role::all();

        return view('backend.pages.admin.edit_admin', compact('roles','user'));
    }

    public function UpdateAdmin(Request $request, $id){
        $user = User::findOrFail($id);

        $user->username = $request->username;
        $user->name = $request->name;
        $user->address = $request->address;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->address= $request->address;
        $user->role = 'admin';
        $user->status = 'active';

        $user->save();

        $user->roles()->detach();

        if($request->roles){
            $user->assignRole($request->roles);
        }

        $notification = [
            'message' => 'New Admin User Updated Successfully',
            'alert-type' => 'success'
        ];

        return redirect()->route('all.admin')->with($notification);
    }

    public function DeleteAdmin($id)
    {
        $user = User::findOrFail($id);

        if(!is_null($user)){
            $user->delete();
        }
        
        $notification = [
            'message' => 'Deleted Admin Successfully',
            'alert-type' => 'success'
        ];

        return redirect()->back()->with($notification);
    }

}
