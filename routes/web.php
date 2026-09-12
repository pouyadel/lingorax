<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FrontendController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\ArticleController as AdminArticleController;
use App\Http\Controllers\Admin\QuizController as AdminQuizController;

// صفحات فرانت‌اند
Route::get('/', [FrontendController::class, 'home'])->name('home');
Route::get('/articles', [FrontendController::class, 'articles'])->name('articles');
Route::get('/articles/{article:slug}', [FrontendController::class, 'showArticle'])->name('articles.show');
Route::get('/quizzes', [FrontendController::class, 'quizzes'])->name('quizzes');
Route::get('/about', [FrontendController::class, 'about'])->name('about');
Route::post('/subscribe', [FrontendController::class, 'subscribe'])->name('subscribe');

// پنل مدیریت یکپارچه با محافظت رمز عبور
Route::middleware(['web', 'auth.basic'])->prefix('admin')->name('admin.')->group(function () {
    
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    
    // تنظیمات و تغییر وضعیت کامینگ‌سون
    Route::get('/settings', [SettingController::class, 'index'])->name('settings.index');
    Route::post('/settings', [SettingController::class, 'update'])->name('settings.update');
    Route::post('/settings/toggle-coming-soon', [SettingController::class, 'toggleComingSoon'])->name('settings.toggle-coming-soon');

    // مقالات و آپلود عکس ادیتور
    Route::resource('articles', AdminArticleController::class);
    Route::post('/editor/upload', [AdminArticleController::class, 'uploadEditorMedia'])->name('editor.upload');

    // کوئیزها
    Route::resource('quizzes', AdminQuizController::class);
});