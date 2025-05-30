<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Amenities;
use App\Models\Facility;
use App\Models\MultiImage;
use App\Models\PackagePlan;
use App\Models\Property;
use App\Models\PropertyMessage;
use App\Models\PropertyType;
use App\Models\State;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use Illuminate\Support\Str;

use function PHPUnit\Framework\fileExists;

class PropertyController extends Controller
{
    public function Property(){
        return view('frontend.dashboard.property');

    }
    public function AllProperty()
    {
        $property = Property::latest()->get();
        return view('backend.property.all_property', compact('property'));
    }

    public function AddProperty()
    {
        $propertyType = PropertyType::latest()->get();
        $amenities = Amenities::latest()->get();
        $pstate = State::latest()->get();
        $activeAgent = User::where('status', 'active')->where('role', 'agent')->latest()->get();
        return view('backend.property.add_property', compact('propertyType', 'amenities', 'activeAgent', 'pstate'));
    }

    public function StoreProperty(Request $request)
    {
        $amen = $request->amenities_id;
        $amenities = implode(",", $amen);

        $pcode = IdGenerator::generate([
            'table' => 'properties',
            'field' => 'property_code',
            'length' => 5,
            'prefix' => 'PC'
        ]);
        $image = $request->file('main_thumbnail');
        $name_gen = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();
        Image::make($image)->resize(370, 250)->save('upload/property/thumbnail/' . $name_gen);
        $save_url = 'upload/property/thumbnail/' . $name_gen;

        $property_id = Property::insertGetId([
            'ptype_id' => $request->ptype_id,
            'amenities_id' => $amenities,
            'property_name' => $request->property_name,
            'property_slug' => Str::slug($request->property_name),
            'property_code' => $pcode,
            'property_status' => $request->property_status,
            'lowest_price' => $request->lowest_price,
            'max_price' => $request->max_price,
            'short_descp' => $request->short_descp,
            'long_descp' => $request->long_descp,
            'bedrooms' => $request->bedrooms,
            'bathrooms' => $request->bathrooms,
            'garage' => $request->garage,
            'garage_size' => $request->garage_size,
            'property_size' => $request->property_size,
            'property_video' => $request->property_video,
            'address' => $request->address,
            'city' => $request->city,
            'state' => $request->state,
            'postal_code' => $request->postal_code,
            'neighborhood' => $request->neighborhood,
            'latitude' => $request->latitude,
            'longtitude' => $request->longtitude,
            'featured' => $request->featured,
            'hot' => $request->hot,
            'agent_id' => $request->agent_id,
            'status' => 1,
            'property_thumbnail' => $save_url,
            'created_at' => Carbon::now()

        ]);

        $images = $request->file('multi_img');

        foreach ($images as $img) {
            $make_name = hexdec(uniqid()) . '.' . $img->getClientOriginalExtension();
            Image::make($img)->resize(770, 520)->save('upload/property/multi-image/' . $make_name);
            $uploadPath = 'upload/property/multi-image/' . $make_name;

            MultiImage::insert(
                [
                    'property_id' => $property_id,
                    'photo_name' => $uploadPath,
                    'created_at' => Carbon::now()
                ]
            );
        }



        // Facilities add from here

        if (!empty($request->facility_name) && is_array($request->facility_name)) {
            foreach ($request->facility_name as $index => $facility) {
                $fcount = new Facility();
                $fcount->property_id = $property_id;
                $fcount->facility_name = $facility;
                $fcount->distance = $request->distance[$index] ?? null; // Tránh lỗi nếu distance không tồn tại
                $fcount->save();
            }
        }



        $notification = [
            'message' => 'Property Insert Successfully',
            'alert-type' => 'success'
        ];

        return redirect()->route('all.property')->with($notification);
    }

    public function EditProperty($id)
    {
        $facilities = Facility::where('property_id', $id)->get();
        $property = Property::findOrFail($id);
        $pstate = State::latest()->get();

        $multiImage = MultiImage::where('property_id', $id)->get();

        // get amenities
        $type = $property->amenities_id;
        $property_ami = explode(',', $type);

        //


        $propertyType = PropertyType::latest()->get();
        $amenities = Amenities::latest()->get();
        $activeAgent = User::where('status', 'active')->where('role', 'agent')->latest()->get();

        return view('backend.property.edit_property', compact(
            'property',
            'propertyType',
            'amenities',
            'activeAgent',
            'property_ami',
            'multiImage',
            'facilities',
            'pstate'
        ));
    }

    public function UpdateProperty(Request $request)
    {

        $amen = $request->amenities_id;
        $amenities = $amen ? implode(",", $amen) : null;

        $property_id = $request->id;

        Property::findOrFail($property_id)->update(
            [
                'ptype_id' => $request->ptype_id,
                'amenities_id' => $amenities,
                'property_name' => $request->property_name,
                'property_slug' => Str::slug($request->property_name),
                'property_status' => $request->property_status,
                'lowest_price' => $request->lowest_price,
                'max_price' => $request->max_price,
                'short_descp' => $request->short_descp,
                'long_descp' => $request->long_descp,
                'bedrooms' => $request->bedrooms,
                'bathrooms' => $request->bathrooms,
                'garage' => $request->garage,
                'garage_size' => $request->garage_size,
                'property_size' => $request->property_size,
                'property_video' => $request->property_video,
                'address' => $request->address,
                'city' => $request->city,
                'state' => $request->state,
                'postal_code' => $request->postal_code,
                'neighborhood' => $request->neighborhood,
                'latitude' => $request->latitude,
                'longtitude' => $request->longtitude,
                'featured' => $request->featured,
                'hot' => $request->hot,
                'agent_id' => $request->agent_id,
                'status' => 1,
                'updated_at' => Carbon::now()

            ]
        );


        $notification = [
            'message' => 'Property Updated Successfully',
            'alert-type' => 'success'
        ];

        return redirect()->route('all.property')->with($notification);
    }

    public function UpdatePropertyThumbnail(Request $request)
    {
        $pro_id = $request->id;
        $oldImage = $request->old_img;

        $image = $request->file('main_thumbnail');

        $name_gen = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();
        Image::make($image)->resize(370, 250)->save('upload/property/thumbnail/' . $name_gen);
        $save_url = 'upload/property/thumbnail/' . $name_gen;

        if (file_exists($oldImage)) {
            unlink($oldImage);
        }

        Property::findOrFail($pro_id)->update([
            'property_thumbnail' => $save_url,
            'updated_at' => Carbon::now()
        ]);

        $notification = [
            'message' => 'Property Updated Thumbnail Image Successfully',
            'alert-type' => 'success'
        ];

        return redirect()->back()->with($notification);
    }

    public function UpdatePropertyMultiimage(Request $request)
    {
        $images = $request->file('multi_img');

        foreach ($images as $id => $img) {
            $imgDel = MultiImage::findOrFail($id);
            unlink($imgDel->photo_name);

            $make_name = hexdec(uniqid()) . '.' . $img->getClientOriginalExtension();
            Image::make($img)->resize(770, 520)->save('upload/property/multi-image/' . $make_name);
            $uploadPath = 'upload/property/multi-image/' . $make_name;

            MultiImage::where('id', $id)->update(
                [
                    'photo_name' => $uploadPath,
                    'updated_at' => Carbon::now()
                ]
            );

            $notification = [
                'message' => 'Property Updated Multi Image Successfully',
                'alert-type' => 'success'
            ];

            return redirect()->back()->with($notification);
        }
    }

    public function DeletePropertyMultiimage($id)
    {
        $oldImage = MultiImage::findOrFail($id);
        unlink($oldImage->photo_name);
        MultiImage::findOrFail($id)->delete();

        $notification = [
            'message' => 'Property Deleted Multi Image Successfully',
            'alert-type' => 'success'
        ];

        return redirect()->back()->with($notification);
    }

    public function StoreNewMultiimage(Request $request)
    {
        if (!$request->hasFile('multi_img')) {
            return redirect()->back()->with([
                'message' => 'No file selected!',
                'alert-type' => 'error'
            ]);
        }
        $new_multi = $request->imageid;
        $img = $request->file('multi_img');
        $make_name = hexdec(uniqid()) . '.' . $img->getClientOriginalExtension();
        Image::make($img)->resize(770, 520)->save('upload/property/multi-image/' . $make_name);
        $uploadPath = 'upload/property/multi-image/' . $make_name;

        MultiImage::create(
            [
                'property_id' => $new_multi,
                'photo_name' => $uploadPath,
                'created_at' => Carbon::now()
            ]
        );

        $notification = [
            'message' => 'Property Added Multi Image Successfully',
            'alert-type' => 'success'
        ];

        return redirect()->back()->with($notification);
    }

    public function UpdatePropertyFacilities(Request $request)
    {
        $pid = $request->id;


        if ($request->facility_name == NUlL) {
            return redirect()->back();
        } else {
            Facility::where('property_id', $pid)->delete();

            if (!empty($request->facility_name) && is_array($request->facility_name)) {
                foreach ($request->facility_name as $index => $facility) {
                    $fcount = new Facility();
                    $fcount->property_id = $pid;
                    $fcount->facility_name = $facility;
                    $fcount->distance = $request->distance[$index] ?? null; // Tránh lỗi nếu distance không tồn tại
                    $fcount->save();
                }
            }
        }

        $notification = [
            'message' => 'Property Facility Updated Successfully',
            'alert-type' => 'success'
        ];

        return redirect()->back()->with($notification);
    }

    public function DeleteProperty($id)
    {
        $property = Property::findOrFail($id);

        // Kiểm tra và xóa ảnh thumbnail
        if (file_exists($property->property_thumbnail)) {
            unlink($property->property_thumbnail);
        }

        // Xóa property
        Property::findOrFail($id)->delete();

        // Xóa ảnh đa ảnh (MultiImage)
        $images = MultiImage::where('property_id', $id)->get();
        foreach ($images as $img) {
            if (file_exists($img->photo_name)) {
                unlink($img->photo_name);
            }
        }
        MultiImage::where('property_id', $id)->delete(); // Xóa tất cả ảnh một lần

        // Xóa tiện ích (Facility)
        Facility::where('property_id', $id)->delete(); // Xóa tất cả tiện ích một lần



        // Thông báo thành công
        $notification = [
            'message' => 'Property Deleted Successfully',
            'alert-type' => 'success'
        ];

        return redirect()->back()->with($notification);
    }

    public function DetailsProperty($id)
    {
        $facilities = Facility::where('property_id', $id)->get();
        $property = Property::findOrFail($id);
        $pstate = State::latest()->get();

        $multiImage = MultiImage::where('property_id', $id)->get();

        // get amenities
        $type = $property->amenities_id;
        $property_ami = explode(',', $type);

        //


        $propertyType = PropertyType::latest()->get();
        $amenities = Amenities::latest()->get();
        $activeAgent = User::where('status', 'active')->where('role', 'agent')->latest()->get();

        return view('backend.property.details_property', compact(
            'property',
            'propertyType',
            'amenities',
            'activeAgent',
            'property_ami',
            'multiImage',
            'facilities',
            'pstate'
        ));
    }

    public function InactiveProperty(Request $request)
    {
        Property::findOrFail($request->id)->update(
            [
                'status' => 0,
            ]
        );

        $notification = [
            'message' => 'Property State Inactivated Successfully',
            'alert-type' => 'success'
        ];

        return redirect()->route('all.property')->with($notification);
    }
    public function ActiveProperty(Request $request)
    {
        Property::findOrFail($request->id)->update(
            [
                'status' => 1,
            ]
        );

        $notification = [
            'message' => 'Property State Activated Successfully',
            'alert-type' => 'success'
        ];

        return redirect()->route('all.property')->with($notification);
    }

    public function AdminPackageHistory(){
        $packageHistory = PackagePlan::latest()->get();
        return view('admin.package.package_history', compact('packageHistory'));
    }

    public function AdminPackageInvoice($id){
        $packageHistory = PackagePlan::where('id', $id)->first();
        $pdf = Pdf::loadView('admin.package.package_history_invoice', compact('packageHistory'))
        ->setPaper('a4')->setOption([
            'tempDir' => public_path(),
            'choroot' => public_path()
        ]);

        return $pdf->download('invoice.pdf');
    }


    // show message admin

    public function AdminPropertyMessage(){
        $usermsg = PropertyMessage::latest()->get();
        return view('backend.message.all_message', compact('usermsg'));
    }
}
