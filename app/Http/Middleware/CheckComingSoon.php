<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Setting;

class CheckComingSoon
{
    public function handle(Request $request, Closure $next)
    {
        // اجازه دسترسی به مسیرهای ادمین و ورود
        if ($request->is('admin*') || $request->is('login*')) {
            return $next($request);
        }

        // خواندن وضعیت از دیتابیس
        $isComingSoon = Setting::where('key', 'coming_soon_mode')->value('value');

        // اگر روشن بود، نمایش صفحه کامینگ سون
        if ($isComingSoon === '1') {
            return response()->view('coming-soon');
        }

        return $next($request);
    }
}