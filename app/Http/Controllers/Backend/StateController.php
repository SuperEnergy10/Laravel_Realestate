<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\State;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;


class StateController extends Controller
{
    //
    public function AllState(){
        $types = State::latest()->get();
        return view('backend.state.all_state', compact('types'));
    }

    public function AddState(){
        return view('backend.state.add_state');
    }

    public function StoreState(Request $request){
        $request->validate([
            'state_name' => 'required|max:200',
            'state_image' => 'required',
        ]);

        $img = $request->file('state_image');
        $make_name = hexdec(uniqid()) . '.' . $img->getClientOriginalExtension();
        Image::make($img)->resize(370, 275)->save('upload/state/' . $make_name);
        $save_url = 'upload/state/' . $make_name;



        State::insert([
            'state_name' => $request->state_name,
            'state_image' => $save_url
        ]);

        $notification = [
            'message' => 'Property State Created Successfully',
            'alert-type' => 'success'
        ];

        return redirect()->route('all.state')->with($notification);
    }

    public function EditState($id){
        $state = State::findOrFail($id);
        return view('backend.state.edit_state', compact('state'));
    }

    public function UpdateState(Request $request){
        $state_id = $request->id;
        $state = State::findOrFail($state_id);
    
        if($request->file('state_image')){
            // Xóa ảnh cũ nếu có
            if ($state->state_image) {
                @unlink($state->state_image);
            }
    
            // Lưu ảnh mới
            $img = $request->file('state_image');
            $make_name = hexdec(uniqid()) . '.' . $img->getClientOriginalExtension();
            Image::make($img)->resize(370, 275)->save('upload/state/' . $make_name);
            $save_url = 'upload/state/' . $make_name;
    
            // Cập nhật ảnh trong database
            $state->update([
                'state_name' => $request->state_name,
                'state_image' => $save_url, // Cập nhật đường dẫn ảnh mới
            ]);
    
            $notification = [
                'message' => 'Property State Updated with Image Successfully',
                'alert-type' => 'success'
            ];
        } else {
            // Chỉ cập nhật tên nếu không có ảnh mới
            $state->update([
                'state_name' => $request->state_name,
            ]);
    
            $notification = [
                'message' => 'Property State Updated without Image Successfully',
                'alert-type' => 'success'
            ];
        }
    
        return redirect()->route('all.state')->with($notification);
    }
    

    public function DeleteState($id){
        $state = State::findOrFail($id);
        $img = $state->state_image;
        unlink($img);

        State::findOrFail($id)->delete();

        $notification = [
            'message' => 'Property State Deleted Successfully',
            'alert-type' => 'success'
        ];

        return redirect()->back()->with($notification);
    }
}
