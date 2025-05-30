<?php

namespace App\Http\Controllers;

use App\Models\Schedule;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index(){
        return view('frontend.index');
    }

    public function UserProfile(){
        $id = Auth::user()->id;
        $dataUser = User::find($id);

        return view('frontend.dashboard.edit_profile', compact('dataUser'));
    }

    public function UserProfileStore(Request $request)
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
            @unlink(public_path('upload/user_images/') . $data->photo);
            $filename = date('YmdHi') . $file->getClientOriginalName();
            $file->move(public_path('upload/user_images'), $filename);
            $data['photo'] = $filename;
        }

        $data->save();

        $notification = array(
            'message' => 'User Profile Updated Successfully',
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification);
    }

    public function UserLogout(Request $request)
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        $notification = [
            'message' => 'User Logout Successfully',
            'alert-type' => 'success'
        ];

        return redirect('/login')->with($notification);
    }

    public function UserChangePassword()
    {
        $id = Auth::user()->id;
        $profileData = User::find($id);
        return view('frontend.dashboard.change_password', compact('profileData'));
    }

    public function UserUpdatePassword(Request $request)
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


    public function UserScheduleRequest(){
        $id = Auth::user()->id;
        $dataUser = User::find($id);
        $srequest = Schedule::where('user_id', $id)->get();

        return view('frontend.message.schedule_request', compact('dataUser', 'srequest'));
    }

    // live chat

    public function LiveChat(){
        $id = Auth::user()->id;
        $dataUser = User::find($id);

        return view('frontend.dashboard.live_chat', compact('dataUser'));
    }

    // About Us

    public function About(){
        return view('frontend.dashboard.about');

    }

    // Contact Us

    public function Contact(){
        return view('frontend.dashboard.contact');

    }

}