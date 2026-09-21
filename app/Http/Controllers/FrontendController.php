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

    // ۱. لیست آزمون‌های عمومی (آزمون‌های اختصاصی اینجا نمایش داده نمی‌شوند)
    public function quizzes()
    {
        $quizzes = Quiz::where('is_published', true)
            ->where('is_private', false)
            ->withCount('questions')
            ->latest()
            ->get();

        return view('quizzes', compact('quizzes'));
    }
    // ۲. مشاهده آزمون با لینک مستقیم
    public function showQuiz(Quiz $quiz)
    {
        // اگر آزمون اختصاصی است و کاربر هنوز رمز صحیح را وارد نکرده، صفحه قفل نمایش داده می‌شود
        if ($quiz->is_private && !session()->has('quiz_unlocked_' . $quiz->id)) {
            return view('quizzes.locked', compact('quiz'));
        }

        $quiz->load(['questions.options']);
        return view('quizzes.show', compact('quiz'));
    }
    // ۳. بررسی رمز وارد شده توسط کاربر
    public function unlockQuiz(Request $request, Quiz $quiz)
    {
        $request->validate([
            'password' => 'required|string',
        ]);

        if ($request->password === $quiz->password) {
            session()->put('quiz_unlocked_' . $quiz->id, true);
            return redirect()->route('quizzes.show', $quiz)->with('success', 'رمز عبور با موفقیت تأیید شد.');
        }

        return back()->withErrors(['password' => 'رمز عبور وارد شده صحیح نمی‌باشد.']);
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