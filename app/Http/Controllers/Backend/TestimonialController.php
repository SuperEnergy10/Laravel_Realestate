<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Testimonial;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;


class TestimonialController extends Controller
{
    //

    public function AllTestimonials()
    {
        $testimonial = Testimonial::latest()->get();
        return view('backend.testimonial.all_testimonial', compact('testimonial'));
    }

    public function AddTestimonials()
    {
        return view('backend.testimonial.add_testimonial');
    }

    public function StoreTestimonials(Request $request)
    {
        $request->validate([
            'name' => 'required|max:200',
            'position' => 'required',
            'message' => 'required',
            'image' => 'required',
        ]);

        $img = $request->file('image');
        $make_name = hexdec(uniqid()) . '.' . $img->getClientOriginalExtension();
        Image::make($img)->resize(100, 100)->save('upload/testimonial/' . $make_name);
        $save_url = 'upload/testimonial/' . $make_name;



        Testimonial::insert([
            'name' => $request->name,
            'position' => $request->position,
            'message' => $request->message,
            'image' => $save_url
        ]);

        $notification = [
            'message' => 'Testimonial Created Successfully',
            'alert-type' => 'success'
        ];

        return redirect()->route('all.testimonials')->with($notification);
    }

    public function EditTestimonials($id)
    {
        $testimonial = Testimonial::findOrFail($id);
        return view('backend.testimonial.edit_testimonial', compact('testimonial'));
    }

    public function UpdateTestimonials(Request $request)
    {
        $testimonial_id = $request->id;
        $testimonial = Testimonial::findOrFail($testimonial_id);

        if ($request->file('image')) {
            // Xóa ảnh cũ nếu có
            if ($testimonial->image) {
                @unlink($testimonial->image);
            }

            // Lưu ảnh mới
            $img = $request->file('image');
            $make_name = hexdec(uniqid()) . '.' . $img->getClientOriginalExtension();
            Image::make($img)->resize(100, 100)->save('upload/testimonial/' . $make_name);
            $save_url = 'upload/testimonial/' . $make_name;

            // Cập nhật ảnh trong database
            $testimonial->update([
                'name' => $request->name,
                'position' => $request->position,
                'message' => $request->message,
                'image' => $save_url // Cập nhật đường dẫn ảnh mới
            ]);

            $notification = [
                'message' => 'Testimonial Updated with Image Successfully',
                'alert-type' => 'success'
            ];
        } else {
            // Chỉ cập nhật tên nếu không có ảnh mới
            $testimonial->update([
                'name' => $request->name,
                'position' => $request->position,
                'message' => $request->message
            ]);

            $notification = [
                'message' => 'Testimonial Updated without Image Successfully',
                'alert-type' => 'success'
            ];
        }

        return redirect()->route('all.testimonials')->with($notification);
    }

    public function DeleteTestimonials($id) {
        $testimonial = Testimonial::findOrFail($id);
        $img = $testimonial->image;
        unlink($img);

        Testimonial::findOrFail($id)->delete();

        $notification = [
            'message' => 'Testimonial Deleted Successfully',
            'alert-type' => 'success'
        ];

        return redirect()->back()->with($notification);
    }
}
