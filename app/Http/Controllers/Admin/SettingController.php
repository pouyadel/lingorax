<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Setting;

class SettingController extends Controller
{
    public function index()
    {
        $settings = Setting::all()->pluck('value', 'key')->toArray();
        return view('admin.settings.index', compact('settings'));
    }

    public function update(Request $request)
    {
        $data = $request->except(['_token']);

        foreach ($data as $key => $value) {
            Setting::set($key, $value);
        }

        return redirect()->back()->with('success', 'تمامی تغییرات و متون با موفقیت در دیتابیس ذخیره شدند.');
    }

    public function toggleComingSoon()
    {
        $setting = \App\Models\Setting::firstOrCreate(
            ['key' => 'coming_soon_mode'],
            ['value' => '0']
        );

        // تغییر وضعیت (۰ به ۱ و برعکس)
        $setting->update([
            'value' => $setting->value === '1' ? '0' : '1'
        ]);

        return back()->with('success', 'وضعیت نمایش سایت با موفقیت تغییر کرد.');
    }
}