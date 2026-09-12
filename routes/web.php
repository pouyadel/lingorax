<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FrontendController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\ArticleController as AdminArticleController;
use App\Http\Controllers\Admin\QuizController as AdminQuizController;
use App\Http\Controllers\Admin\ArticleController;

// صفحات فرانت‌اند
Route::get('/', [FrontendController::class, 'home'])->name('home');
Route::get('/articles', [FrontendController::class, 'articles'])->name('articles');
Route::get('/articles/{article:slug}', [FrontendController::class, 'showArticle'])->name('articles.show');
Route::get('/quizzes', [FrontendController::class, 'quizzes'])->name('quizzes');
Route::get('/about', [FrontendController::class, 'about'])->name('about');
Route::post('/subscribe', [FrontendController::class, 'subscribe'])->name('subscribe');

// پنل مدیریت
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/settings', [SettingController::class, 'index'])->name('settings.index');
    Route::post('/settings', [SettingController::class, 'update'])->name('settings.update');
    Route::resource('articles', AdminArticleController::class);
    Route::resource('quizzes', AdminQuizController::class);
});

Route::post('/admin/editor/upload', [ArticleController::class, 'uploadEditorMedia'])->name('admin.editor.upload');

Route::middleware(['web', 'auth.basic'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [\App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('dashboard');
    Route::resource('articles', \App\Http\Controllers\Admin\ArticleController::class);
    Route::post('/editor/upload', [\App\Http\Controllers\Admin\ArticleController::class, 'uploadEditorMedia'])->name('editor.upload');
    // سایر روت‌های ادمین...
});