<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\SiteSetting;
use App\Models\SmtpSetting;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;


class SettingController extends Controller
{
    //

    public function SmtpSetting()
    {
        $setting = SmtpSetting::find(1);
        return view('backend.setting.smtp_update', compact('setting'));
    }


    public function UpdateSmtpSetting(Request $request)
    {
        $smtp_id = $request->id;

        SmtpSetting::findOrFail($smtp_id)->update([
            'mailer' => $request->mailer,
            'host' => $request->host,
            'port' => $request->port,
            'username' => $request->username,
            'password' => $request->password,
            'encryption' => $request->encryption,
            'from_address' => $request->from_address,
        ]);

        $notification = [
            'message' => 'SMTP Setting Updated Successfully',
            'alert-type' => 'success'
        ];

        return redirect()->back()->with($notification);
    }

    // site setting


    public function SiteSetting()
    {
        $setting = SiteSetting::find(1);
        return view('backend.setting.site_update', compact('setting'));
    }

    public function UpdateSiteSetting(Request $request)
    {
        $setting_id = $request->id;
        $setting = SiteSetting::findOrFail($setting_id);

        if ($request->file('logo')) {
            // Xóa ảnh cũ nếu có
            if ($setting->logo) {
                @unlink($setting->logo);
            }

            // Lưu ảnh mới
            $img = $request->file('logo');
            $make_name = hexdec(uniqid()) . '.' . $img->getClientOriginalExtension();
            Image::make($img)->resize(1500, 386)->save('upload/logo/' . $make_name);
            $save_url = 'upload/logo/' . $make_name;

            // Cập nhật ảnh trong database
            $setting->update([
                'support_phone' => $request->support_phone,
                'company_address' => $request->company_address,
                'email' => $request->email,
                'facebook' => $request->facebook,
                'twitter' => $request->twitter,
                'copyright' => $request->copyright,
                'logo' => $save_url, // Cập nhật đường dẫn ảnh mới
            ]);

            $notification = [
                'message' => 'Site Setting Updated with Image Successfully',
                'alert-type' => 'success'
            ];
        } else {
            // Chỉ cập nhật tên nếu không có ảnh mới
            $setting->update([
                'support_phone' => $request->support_phone,
                'company_address' => $request->company_address,
                'email' => $request->email,
                'facebook' => $request->facebook,
                'twitter' => $request->twitter,
                'copyright' => $request->copyright,
            ]);

            $notification = [
                'message' => 'Site Setting Updated without Image Successfully',
                'alert-type' => 'success'
            ];
        }

        return redirect()->back()->with($notification);
    }
}
