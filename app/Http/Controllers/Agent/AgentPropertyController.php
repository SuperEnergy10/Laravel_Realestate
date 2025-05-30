<?php

namespace App\Http\Controllers\Agent;

use App\Http\Controllers\Controller;
use App\Mail\ScheduleMail;
use App\Models\Amenities;
use App\Models\Facility;
use App\Models\MultiImage;
use App\Models\PackagePlan;
use App\Models\Property;
use App\Models\PropertyMessage;
use App\Models\PropertyType;
use App\Models\Schedule;
use App\Models\State;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Str;

class AgentPropertyController extends Controller
{
    //

    public function AgentAllProperty(){

        $id = Auth::user()->id;
        $property = Property::where('agent_id', $id)->latest()->get();
        return view('agent.property.all_property', compact('property'));

    }

    public function AgentAddProperty()
    {
        $propertyType = PropertyType::latest()->get();
        $amenities = Amenities::latest()->get();
        $pstate = State::latest()->get();


        $id = Auth::user()->id;
        $property = User::where('role', 'agent')->where('id', $id)->first();
        $pcount = $property->credit;

        if($pcount == 1 || $pcount == 7 ){
            return redirect()->route('buy.package');
        }else{
            return view('agent.property.add_property', compact('propertyType', 'amenities', 'pstate'));

        }

    }

    public function AgentStoreProperty(Request $request)
    {
        $id = Auth::user()->id;
        $uid = User::findOrFail($id);
        $nid = $uid->creadit;

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
            'agent_id' => Auth::user()->id,
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

        // User::where('id', $id)->update([
        //     'credit' => DB::raw('1 + ?', [$nid]) //dấu ? để tránh SQL Injection
        // ]);

        User::where('id', $id)->update([
            'credit' => DB::raw('1 + '.intval($nid))
        ]);

        // User::where('id', $id)->update([
        //     'credit' => DB::raw('credit + '.$nid) // ✅ Đúng
        // ]);
        
        
        


        $notification = [
            'message' => 'Property Insert Successfully',
            'alert-type' => 'success'
        ];

        return redirect()->route('agent.all.property')->with($notification);
    }

    public function AgentEditProperty($id)
    {
        $facilities = Facility::where('property_id', $id)->get();
        $property = Property::findOrFail($id);

        $multiImage = MultiImage::where('property_id', $id)->get();

        $pstate = State::latest()->get();


        // get amenities
        $type = $property->amenities_id;
        $property_ami = explode(',', $type);

        //


        $propertyType = PropertyType::latest()->get();
        $amenities = Amenities::latest()->get();
        $activeAgent = User::where('status', 'active')->where('role', 'agent')->latest()->get();

        return view('agent.property.edit_property', compact(
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

    public function AgentUpdateProperty(Request $request)
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
                'agent_id' => Auth::user()->id,
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
    public function AgentUpdatePropertyThumbnail(Request $request)
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

    public function AgentDeletePropertyMultiimage($id)
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

    public function AgentStoreNewMultiimage(Request $request)
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

    public function AgentUpdatePropertyFacilities(Request $request)
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

    public function AgentDetailsProperty($id)
    {
        $facilities = Facility::where('property_id', $id)->get();
        $property = Property::findOrFail($id);

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
            'property_ami',
            'multiImage',
            'facilities'
        ));
    }

    public function AgentDeleteProperty($id)
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

    public function BuyPackage(){
        return view('agent.package.buy_package');
    }
    public function BuyBusinessPlan(){
        $id = Auth::user()->id;
        $data = User::find($id);
        return view('agent.package.business_plan', compact('data'));
    }

    public function StoreBusinessPlan(Request $request){
        $id = Auth::user()->id;
        $uid = User::findOrFail($id);
        $nid = $uid->creadit;

        PackagePlan::create([
            'user_id' => $id,
            'package_name' => 'Business',
            'package_credits' => '3',
            'invoice' => 'ERT'.mt_rand(10000000, 99999999),
            'package_amount' => '20',
            'created_at' => Carbon::now()

        ]);

        User::where('id', $id)->update([
            'credit' => DB::raw('3 + '.intval($nid))
        ]);

        $notification = [
            'message' => 'You have purchase Basic Package Successfully',
            'alert-type' => 'success'
        ];

        return redirect()->route('agent.all.property')->with($notification);
    }

    public function BuyProfessionalPlan(){
        $id = Auth::user()->id;
        $data = User::find($id);
        return view('agent.package.professional_plan', compact('data'));
    }

    public function StoreProfessionalPlan(Request $request){
        $id = Auth::user()->id;
        $uid = User::findOrFail($id);
        $nid = $uid->creadit;

        PackagePlan::create([
            'user_id' => $id,
            'package_name' => 'Professional',
            'package_credits' => '10',
            'invoice' => 'ERT'.mt_rand(10000000, 99999999),
            'package_amount' => '50',
            'created_at' => Carbon::now()

        ]);

        User::where('id', $id)->update([
            'credit' => DB::raw('10 + '.intval($nid))
        ]);

        $notification = [
            'message' => 'You have purchase Professional Package Successfully',
            'alert-type' => 'success'
        ];

        return redirect()->route('agent.all.property')->with($notification);
    }

    public function PackageHistory(){
        $id = Auth::user()->id;
        $packageHistory = PackagePlan::where('user_id', $id)->get();
        return view('agent.package.package_history', compact('packageHistory'));
    }

    public function AgentPackageInvoice($id){
        $packageHistory = PackagePlan::where('id', $id)->first();
        $pdf = Pdf::loadView('agent.package.package_history_invoice', compact('packageHistory'))
        ->setPaper('a4')->setOption([
            'tempDir' => public_path(),
            'choroot' => public_path()
        ]);

        return $pdf->download('invoice.pdf');
    }

    public function AgentPropertyMessage(){
        $id = Auth::user()->id;
        $usermsg = PropertyMessage::where('agent_id', $id)->get();

        return view('agent.message.all_message', compact('usermsg'));
    }


    public function AgentMessageDetails($id){
        $agent_id = Auth::user()->id; // ✅ Lấy đúng ID của agent hiện tại
    
        // Lấy danh sách tin nhắn của agent
        $usermsg = PropertyMessage::where('agent_id', $agent_id)->get();
    
        // Chỉ lấy tin nhắn nếu nó thuộc về agent
        $msgdetails = PropertyMessage::where('id', $id)
                                     ->where('agent_id', $agent_id)
                                     ->firstOrFail();
    
        return view('agent.message.message_details', compact('usermsg', 'msgdetails'));
    }

    public function AgentScheduleRequest(){
        $id = Auth::user()->id;

        $usermsg = Schedule::where('agent_id', $id)->get();

        return view('agent.schedule.schedule_request', compact('usermsg'));

    }

    public function AgentDetailsSchedule($id){

        $schedule = Schedule::findOrFail($id);

        return view('agent.schedule.schedule_details', compact('schedule'));

    }

    public function AgentUpdateSchedule(Request $request){
        $sid = $request->id;

        Schedule::findOrFail($sid)->update([
            'status' => '1'
        ]);


        $sendmail = Schedule::findOrFail($sid);

        $data = [
            'tour_date' => $sendmail->tour_date,
            'tour_time' => $sendmail->tour_time,
        ];

        Mail::to($request->email)->send(new ScheduleMail($data));

        $notification = [
            'message' => 'You have confirm schedule successfully',
            'alert-type' => 'success'
        ];

        return redirect()->route('agent.schedule.request')->with($notification);
    }
    
}
