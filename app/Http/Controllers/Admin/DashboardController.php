<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Quiz;
use App\Models\Subscriber;

class DashboardController extends Controller
{
    public function index()
    {
        $articlesCount = Article::count();
        $quizzesCount = Quiz::count();
        $subscribersCount = Subscriber::count();
        $recentArticles = Article::latest()->take(5)->get();

        return view('admin.dashboard', compact('articlesCount', 'quizzesCount', 'subscribersCount', 'recentArticles'));
    }
}