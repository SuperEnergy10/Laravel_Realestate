<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Amenities;
use App\Models\PropertyType;
use Illuminate\Http\Request;

class PropertyTypeController extends Controller
{
    public function AllType(){
        $types = PropertyType::latest()->get();
        return view('backend.type.all_type', compact('types'));
    }
    public function AddType(){
        return view('backend.type.add_type');
    }

    public function StoreType(Request $request){
        $request->validate([
            'type_name' => 'required|unique:property_types|max:200',
            'type_icon' => 'required',
        ]);

        PropertyType::insert([
            'type_name' => $request->type_name,
            'type_icon' => $request->type_icon
        ]);

        $notification = [
            'message' => 'Property Type Created Successfully',
            'alert-type' => 'success'
        ];

        return redirect()->route('all.type')->with($notification);
    }

    public function EditType($id){
        $types = PropertyType::findOrFail($id);
        return view('backend.type.edit_type', compact('types'));
    }

    public function UpdateType(Request $request){
        $pid = $request->id;
        $request->validate([
            'type_name' => 'required|unique:property_types|max:200',
            'type_icon' => 'required',
        ]);

        PropertyType::findOrFail($pid)->update([
            'type_name' => $request->type_name,
            'type_icon' => $request->type_icon
        ]);

        $notification = [
            'message' => 'Property Type Created Successfully',
            'alert-type' => 'success'
        ];

        return redirect()->route('all.type')->with($notification);
    }

    public function DeleteType($id){
        PropertyType::findOrFail($id)->delete();

        $notification = [
            'message' => 'Property Type Deleted Successfully',
            'alert-type' => 'success'
        ];
        return redirect()->back()->with($notification);

    }

    // Amenities

    public function AllAmenitie(){
        $amenities = Amenities::latest()->get();
        return view('backend.amenities.all_amenitie', compact('amenities'));
    }

    public function AddAmenitie(){
        return view('backend.amenities.add_amenitie');
    }

    public function StoreAmenitie(Request $request){
       

        Amenities::insert([
            'amenitie_name' => $request->amenitie_name,
        ]);

        $notification = [
            'message' => 'Property Amenitie Created Successfully',
            'alert-type' => 'success'
        ];

        return redirect()->route('all.amenitie')->with($notification);
    }

    public function EditAmenitie($id){
        $amenitie = Amenities::findOrFail($id);
        return view('backend.amenities.edit_amenitie', compact('amenitie'));
    }


    public function UpdateAmenitie(Request $request){
        $ame_id = $request->id;
        // $request->validate([
        //     'type_name' => 'required|unique:property_types|max:200',
        //     'type_icon' => 'required',
        // ]);

        Amenities::findOrFail($ame_id)->update([
            'amenitie_name' => $request->amenitie_name,
        ]);

        $notification = [
            'message' => 'Property Amenitie Created Successfully',
            'alert-type' => 'success'
        ];

        return redirect()->route('all.amenitie')->with($notification);
    }

    public function DeleteAmenitie($id){
        Amenities::findOrFail($id)->delete();

        $notification = [
            'message' => 'Property Amenitie Deleted Successfully',
            'alert-type' => 'success'
        ];
        return redirect()->back()->with($notification);

    }


}
