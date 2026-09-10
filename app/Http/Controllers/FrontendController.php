<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Quiz;
use App\Models\Setting;
use App\Models\Subscriber;
use Illuminate\Http\Request;

class FrontendController extends Controller
{
    public function home()
    {
        $settings = Setting::all()->pluck('value', 'key');
        $latestArticles = Article::where('is_published', true)->latest()->take(3)->get();
        $latestQuizzes = Quiz::where('is_published', true)->latest()->take(4)->get();

        return view('home', compact('settings', 'latestArticles', 'latestQuizzes'));
    }

    public function articles(Request $request)
    {
        $query = Article::where('is_published', true);

        if ($request->filled('category') && $request->category !== 'all') {
            $query->where('category', $request->category);
        }

        if ($request->filled('level') && $request->level !== 'all') {
            $query->where('level', 'like', '%' . $request->level . '%');
        }

        if ($request->filled('search')) {
            $s = $request->search;
            $query->where(function($q) use ($s) {
                $q->where('title', 'like', "%$s%")
                  ->orWhere('excerpt', 'like', "%$s%");
            });
        }

        $articles = Article::where('is_published', true)->latest()->get();
        return view('articles', compact('articles'));
    }

    public function showArticle(Article $article)
    {
        abort_if(!$article->is_published, 404);
        return view('article-show', compact('article'));
    }

    public function quizzes()
    {
        $quizzes = Quiz::where('is_published', true)
            ->with(['questions.options'])
            ->latest()
            ->get();

        return view('quizzes', compact('quizzes'));
    }

    public function about()
    {
        $settings = Setting::all()->pluck('value', 'key');
        return view('about', compact('settings'));
    }

    public function subscribe(Request $request)
    {
        $request->validate([
            'phone' => 'required|min:8|max:15|unique:subscribers,phone'
        ]);

        Subscriber::create(['phone' => $request->phone]);

        return response()->json(['success' => true, 'message' => 'شماره شما با موفقیت ثبت شد!']);
    }
}