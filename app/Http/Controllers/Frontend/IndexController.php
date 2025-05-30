<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Facility;
use App\Models\MultiImage;
use App\Models\Property;
use App\Models\PropertyMessage;
use App\Models\PropertyType;
use App\Models\Schedule;
use App\Models\State;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IndexController extends Controller
{
    //
    public function PropertyDetails($id, $slug)
    {
        $property = Property::findOrFail($id);
        $multiImage = MultiImage::where('property_id', $id)->get();
        $amenities = $property->amenities_id;
        $property_amen = explode(',', $amenities);
        $facility = Facility::where('property_id', $id)->get();

        $type_id = $property->ptype_id;
        $relatedProperty = Property::where('ptype_id', $type_id)->where('id', '!=', $id)
            ->orderBy('id', 'DESC')->limit(3)->get();

        return view('frontend.property.property_details', compact(
            'property',
            'multiImage',
            'property_amen',
            'facility',
            'relatedProperty'
        ));
    }

    public function PropertyMessage(Request $request)
    {
        $pid = $request->property_id;
        $aid = $request->agent_id;

        if (Auth::check()) {
            PropertyMessage::create([
                'user_id' => Auth::user()->id,
                'property_id' => $pid,
                'agent_id' => $aid,
                'msg_name' => $request->msg_name,
                'msg_email' => $request->msg_email,
                'msg_phone' => $request->msg_phone,
                'message' => $request->message,
                'created_at' => Carbon::now(),
            ]);

            $notification = array(
                'message' => 'Send Message Successfully',
                'alert-type' => 'success'
            );
            return redirect()->back()->with($notification);
        } else {
            $notification = array(
                'message' => 'Please Login Your Account First',
                'alert-type' => 'error'
            );
            return redirect()->back()->with($notification);
        }
    }

    public function AgentDetails($id)
    {
        $agent = User::findOrFail($id);
        $property = Property::where('agent_id', $id)->get();
        $featured = Property::where('featured', '1')->limit(3)->get();
        $rentproperty = Property::where('property_status', 'rent')->get();
        $buyproperty = Property::where('property_status', 'buy')->get();

        return view('frontend.agent.agent_details', compact(
            'agent',
            'property',
            'featured',
            'rentproperty',
            'buyproperty'
        ));
    }

    public function AgentDetailsMessage(Request $request)
    {
        $aid = $request->agent_id;

        if (Auth::check()) {
            PropertyMessage::create([
                'user_id' => Auth::user()->id,
                'agent_id' => $aid,
                'msg_name' => $request->msg_name,
                'msg_email' => $request->msg_email,
                'msg_phone' => $request->msg_phone,
                'message' => $request->message,
                'created_at' => Carbon::now(),
            ]);

            $notification = array(
                'message' => 'Send Message Successfully',
                'alert-type' => 'success'
            );
            return redirect()->back()->with($notification);
        } else {
            $notification = array(
                'message' => 'Please Login Your Account First',
                'alert-type' => 'error'
            );
            return redirect()->back()->with($notification);
        }
    }

    public function RentProperty()
    {
        $property = Property::where('status', '1')->where('property_status', 'rent')->paginate(5);

        return view('frontend.property.rent_property', compact('property'));
    }

    public function BuyProperty()
    {
        $property = Property::where('status', '1')->where('property_status', 'buy')->get();

        return view('frontend.property.buy_property', compact('property'));
    }

    public function Property()
    {
        $property = Property::where('status', '1')->paginate(10);

        return view('frontend.property.property', compact('property'));
    }



    public function PropertyType($id)
    {
        $property = Property::where('status', '1')->where('ptype_id', $id)->get();
        $pbread = PropertyType::where('id', $id)->first();

        return view('frontend.property.property_type', compact('property', 'pbread'));
    }

    public function StateDetails($id)
    {
        $property = Property::where('status', '1')->where('state', $id)->get();
        $bstate = State::where('id', $id)->first();
        return view('frontend.property.state_property', compact('property', 'bstate'));
    }

    public function BuyPropertySearch(Request $request)
    {
        // dd($request->all());

        $request->validate([
            'search' => 'required'
        ]);

        $item = $request->search;
        $stype = $request->ptype_id;
        $sstate = $request->state;

        $property = Property::where('property_status', 'buy')
            ->where('property_name', 'like', '%' . $item . '%')
            ->with('type', 'pstate');

        if (!empty($sstate)) {
            $property->whereHas('pstate', function ($q) use ($sstate) {
                $q->where('state_name', 'like', '%' . $sstate . '%');
            });
        }

        // Kiểm tra nếu 'ptype_id' không phải là "All Type"
        if (!empty($stype) && $stype != 'All Type') {
            $property->whereHas('type', function ($q) use ($stype) {
                $q->where('type_name', 'like', '%' . $stype . '%');
            });
        }

        // Lấy kết quả
        $property = $property->get();

        return view('frontend.property.property_search', compact('property'));
    }


    public function RentPropertySearch(Request $request)
    {
        // Xem tất cả các dữ liệu từ yêu cầu
        // dd($request->all());

        // Kiểm tra điều kiện bắt buộc với trường 'search'
        $request->validate([
            'search' => 'required'
        ]);

        // Gán giá trị từ yêu cầu
        $item = $request->search;
        $stype = $request->ptype_id;
        $sstate = $request->state;

        // Bắt đầu truy vấn
        $property = Property::where('property_status', 'rent')
            ->where('property_name', 'like', '%' . $item . '%')
            ->with('type', 'pstate');

        // Kiểm tra nếu 'state' không rỗng và áp dụng điều kiện tìm kiếm
        if (!empty($sstate)) {
            $property->whereHas('pstate', function ($q) use ($sstate) {
                $q->where('state_name', 'like', '%' . $sstate . '%');
            });
        }

        // Kiểm tra nếu 'ptype_id' không phải là "All Type"
        if (!empty($stype) && $stype != 'All Type') {
            $property->whereHas('type', function ($q) use ($stype) {
                $q->where('type_name', 'like', '%' . $stype . '%');
            });
        }

        // Lấy kết quả
        $property = $property->get();

        // Trả về view với kết quả tìm kiếm
        return view('frontend.property.property_search', compact('property'));
    }


    public function AllPropertySearch(Request $request)
    {
        // Xem tất cả dữ liệu request gửi lên (xóa sau khi kiểm tra xong)
        // dd($request->all());

        $query = Property::query()
            ->where('status', '1') // Trạng thái bất động sản
            ->with('type', 'pstate'); // Tải thông tin loại và trạng thái

        // Lọc theo số phòng ngủ nếu có
        if (!empty($request->bedrooms)) {
            $query->where('bedrooms', $request->bedrooms);
        }

        // Lọc theo số phòng tắm nếu có
        if (!empty($request->bathrooms)) {
            $query->where('bathrooms', $request->bathrooms);
        }

        // Lọc theo trạng thái bất động sản nếu có
        if (!empty($request->property_status) && $request->property_status !== "All Status") {
            $query->where('property_status', $request->property_status);
        }

        // Lọc theo tên hoặc ID của trạng thái nếu có
        if (!empty($request->state)) {
            $query->whereHas('pstate', function ($q) use ($request) {
                $q->where('state_name', 'like', '%' . $request->state . '%');
            });
        }

        // Lọc theo loại bất động sản (tên loại) nếu có
        if (!empty($request->ptype_id)) {
            // Nếu `ptype_id` là tên, so sánh với `type_name` của bảng `types`
            $query->whereHas('type', function ($q) use ($request) {
                $q->where('type_name', 'like', '%' . $request->ptype_id . '%'); // So sánh với `type_name`
            });
        }

        // Lấy kết quả tìm kiếm (hoặc phân trang nếu cần)
        $property = $query->get(); // hoặc paginate(6) để phân trang

        return view('frontend.property.property_search', compact('property'));
    }


    public function StoreSchedule(Request $request)
    {
        $aid = $request->agent_id;
        $pid = $request->property_id;

        if (Auth::check()) {
            Schedule::insert([
                'user_id' => Auth::user()->id,
                'agent_id' => $aid,
                'property_id' => $pid,
                'tour_date' => $request->tour_date,
                'tour_time' => $request->tour_time,
                'message' => $request->message,
                'created_at' => Carbon::now()
            ]);

            $notification = array(
                'message' => 'Send Request Successfully',
                'alert-type' => 'success'
            );

            return redirect()->back()->with($notification);
        } else {
            $notification = array(
                'message' => 'Please Login Your Account First',
                'alert-type' => 'error'
            );
            return redirect()->back()->with($notification);
        }
    }
}
