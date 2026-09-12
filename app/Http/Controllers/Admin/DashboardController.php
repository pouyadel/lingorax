<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Quiz;
use App\Models\Subscriber;
use App\Models\Setting;

class DashboardController extends Controller
{
    public function index()
    {
        $articlesCount = Article::count();
        $quizzesCount = Quiz::count();
        $subscribersCount = Subscriber::count();
        $recentArticles = Article::latest()->take(5)->get();

        // بررسی وضعیت حالت Coming Soon از جدول settings
        $isComingSoon = Setting::where('key', 'coming_soon_mode')->value('value') === '1';

        return view('admin.dashboard', compact(
            'articlesCount',
            'quizzesCount',
            'subscribersCount',
            'recentArticles',
            'isComingSoon'
        ));
    }
}