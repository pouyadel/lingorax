<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class ArticleController extends Controller
{
    public function index()
    {
        $articles = Article::latest()->paginate(10);
        return view('admin.articles.index', compact('articles'));
    }

    public function create()
    {
        return view('admin.articles.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title_fa' => 'required|string|max:255',
            'title_en' => 'required|string|max:255',
            'level' => 'required|string|max:50',
            'category' => 'required|string|max:50',
            'read_time' => 'required|numeric|min:1',
            'excerpt_fa' => 'nullable|array',
            'excerpt_fa.*' => 'nullable|string',
            'excerpt_en' => 'nullable|array',
            'excerpt_en.*' => 'nullable|string',
            'content_fa' => 'required|string',
            'content_en' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        $validated['slug'] = Str::slug($validated['title_en']) . '-' . time();
        $validated['is_published'] = $request->has('is_published');

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('articles', 'public');
        }

        Article::create($validated);
        return redirect()->route('admin.articles.index')->with('success', 'مقاله دوزبانه با موفقیت ثبت شد.');
    }

    public function edit(Article $article)
    {
        return view('admin.articles.edit', compact('article'));
    }

    public function update(Request $request, Article $article)
    {
        $validated = $request->validate([
            'title_fa' => 'required|string|max:255',
            'title_en' => 'required|string|max:255',
            'level' => 'required|string',
            'category' => 'required|string',
            'read_time' => 'required|numeric|min:1',
            'excerpt_fa' => 'nullable|array',
            'excerpt_fa.*' => 'nullable|string',
            'excerpt_en' => 'nullable|array',
            'excerpt_en.*' => 'nullable|string',
            'content_fa' => 'required|string',
            'content_en' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        $validated['is_published'] = $request->has('is_published');

        if ($request->hasFile('image')) {
            if ($article->image && Storage::disk('public')->exists($article->image)) {
                Storage::disk('public')->delete($article->image);
            }
            $validated['image'] = $request->file('image')->store('articles', 'public');
        }

        $article->update($validated);
        return redirect()->route('admin.articles.index')->with('success', 'تغییرات مقاله ذخیره شد.');
    }

    public function destroy(Article $article)
    {
        if ($article->image && Storage::disk('public')->exists($article->image)) {
            Storage::disk('public')->delete($article->image);
        }
        $article->delete();
        return redirect()->route('admin.articles.index')->with('success', 'مقاله با موفقیت حذف شد.');
    }

    public function uploadEditorMedia(\Illuminate\Http\Request $request)
    {
    $request->validate([
        'file' => 'required|file|mimes:jpg,jpeg,png,webp,gif,mp3,wav,ogg,m4a|max:20480'
    ]);

    if ($request->hasFile('file')) {
        $path = $request->file('file')->store('articles_media', 'public');
        return response()->json([
            'location' => asset('storage/' . $path)
        ]);
    }

    return response()->json(['error' => 'خطا در آپلود فایل'], 500);
    }
}