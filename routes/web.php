<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FrontendController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\ArticleController as AdminArticleController;
use App\Http\Controllers\Admin\QuizController as AdminQuizController;

// صفحات اصلی فرانت‌اند
Route::get('/', [FrontendController::class, 'home'])->name('home');
Route::get('/articles', [FrontendController::class, 'articles'])->name('articles');
Route::get('/articles/{article:slug}', [FrontendController::class, 'showArticle'])->name('articles.show');
Route::get('/quizzes', [FrontendController::class, 'quizzes'])->name('quizzes');
Route::get('/about', [FrontendController::class, 'about'])->name('about');
Route::post('/subscribe', [FrontendController::class, 'subscribe'])->name('subscribe');

// پنل مدیریت یکپارچه با محافظت رمز عبور
Route::middleware(['web', 'auth.basic'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/settings', [SettingController::class, 'index'])->name('settings.index');
    Route::post('/settings', [SettingController::class, 'update'])->name('settings.update');
    Route::post('/settings/toggle-coming-soon', [SettingController::class, 'toggleComingSoon'])->name('settings.toggle-coming-soon');

    Route::resource('articles', AdminArticleController::class);
    Route::post('/editor/upload', [AdminArticleController::class, 'uploadEditorMedia'])->name('editor.upload');

    Route::resource('quizzes', AdminQuizController::class);
});

// نقشه سایت داینامیک برای موتورهای جستجو (Sitemap XML)
Route::get('/sitemap.xml', function () {
    $articles = \App\Models\Article::where('is_published', true)->latest()->get();

    $xml = '<?xml version="1.0" encoding="UTF-8"?>';
    $xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';

    // آدرس‌های ثابت و صفحات اصلی
    $staticPages = [
        ['loc' => route('home'), 'priority' => '1.0', 'changefreq' => 'daily'],
        ['loc' => route('articles'), 'priority' => '0.9', 'changefreq' => 'daily'],
        ['loc' => route('about'), 'priority' => '0.85', 'changefreq' => 'weekly'],
        ['loc' => route('quizzes'), 'priority' => '0.8', 'changefreq' => 'weekly'],
    ];

    foreach ($staticPages as $page) {
        $xml .= '<url>';
        $xml .= '<loc>' . $page['loc'] . '</loc>';
        $xml .= '<changefreq>' . $page['changefreq'] . '</changefreq>';
        $xml .= '<priority>' . $page['priority'] . '</priority>';
        $xml .= '</url>';
    }

    // صفحات اختصاصی مقالات آموزشی
    foreach ($articles as $article) {
        $xml .= '<url>';
        $xml .= '<loc>' . route('articles.show', $article->slug) . '</loc>';
        $xml .= '<lastmod>' . ($article->updated_at ? $article->updated_at->tz('UTC')->toAtomString() : now()->toAtomString()) . '</lastmod>';
        $xml .= '<changefreq>weekly</changefreq>';
        $xml .= '<priority>0.85</priority>';
        $xml .= '</url>';
    }

    $xml .= '</urlset>';

    return response($xml, 200)->header('Content-Type', 'application/xml');
});

// فایل راهنمای خزنده‌های گوگل (robots.txt)
Route::get('/robots.txt', function () {
    $content = "User-agent: *\n";
    $content .= "Disallow: /admin\n";
    $content .= "Disallow: /admin/*\n";
    $content .= "Allow: /\n\n";
    $content .= "Sitemap: " . url('/sitemap.xml') . "\n";

    return response($content, 200)->header('Content-Type', 'text/plain');
});
// روت‌های فرانت‌اند برای آزمون‌ها
Route::get('/quizzes', [FrontendController::class, 'quizzes'])->name('quizzes');
Route::get('/quizzes/{quiz}', [FrontendController::class, 'showQuiz'])->name('quizzes.show');
Route::post('/quizzes/{quiz}/unlock', [FrontendController::class, 'unlockQuiz'])->name('quizzes.unlock');