@extends('admin.layout')

@section('title', 'لیست مقالات')
@section('page-title', 'مدیریت و آرشیو مقالات')

@section('content')
<div class="space-y-5 sm:space-y-6">

    <!-- هدر بالای صفحه -->
    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-3 bg-brand-card/40 p-4 sm:p-6 rounded-2xl sm:rounded-3xl border border-white/5">
        <div>
            <h2 class="text-sm sm:text-base font-black text-white font-heading">لیست مقالات</h2>
            <span class="text-xs text-brand-slate mt-0.5 block">مجموع: {{ $articles->total() }} مقاله</span>
        </div>
        <a href="{{ route('admin.articles.create') }}" class="w-full sm:w-auto inline-flex items-center justify-center gap-1.5 bg-brand-gold hover:bg-brand-goldHover text-brand-darkest text-xs font-black px-5 py-2.5 rounded-xl shadow-glow-gold transition-all active:scale-95">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4" />
            </svg>
            <span>+ افزودن مقاله جدید</span>
        </a>
    </div>

    <!-- نمای کارت برای موبایل (صفحه‌نمایش‌های زیر 768px) -->
    <div class="grid grid-cols-1 gap-3.5 md:hidden">
        @forelse($articles as $article)
            <div class="glass-card p-4 rounded-2xl border border-white/5 space-y-3.5 shadow-md">
                <div class="flex items-center gap-3">
                    @if($article->image)
                        <img src="{{ asset('storage/' . $article->image) }}" class="w-14 h-14 object-cover rounded-xl border border-white/10 flex-shrink-0" alt="">
                    @else
                        <div class="w-14 h-14 rounded-xl bg-white/5 border border-white/10 flex items-center justify-center text-[10px] text-brand-slate flex-shrink-0 text-center p-1">
                            بدون تصویر
                        </div>
                    @endif
                    <div class="min-w-0 flex-1 space-y-1">
                        <div class="flex items-center gap-1.5 flex-wrap">
                            <span class="px-2 py-0.5 rounded-md text-[10px] font-bold {{ $article->is_published ? 'bg-emerald-500/15 text-emerald-400 border border-emerald-500/20' : 'bg-red-500/15 text-red-400 border border-red-500/20' }}">
                                {{ $article->is_published ? 'منتشر شده' : 'پیش‌نویس' }}
                            </span>
                            <span class="px-2 py-0.5 rounded-md text-[10px] font-bold bg-white/5 text-brand-gold border border-white/10">
                                {{ $article->category }}
                            </span>
                            @if($article->level)
                                <span class="px-2 py-0.5 rounded-md text-[10px] text-brand-slate bg-white/5 border border-white/10">
                                    {{ $article->level }}
                                </span>
                            @endif
                        </div>
                        <h3 class="text-xs font-bold text-white truncate">
                            {{ $article->title ?? $article->title_fa ?? $article->title_en }}
                        </h3>
                    </div>
                </div>

                <!-- دکمه‌های عملیات مشخص در موبایل -->
                <div class="grid grid-cols-2 gap-2 pt-2 border-t border-white/5">
                    <a href="{{ route('admin.articles.edit', $article) }}" class="inline-flex items-center justify-center gap-1.5 py-2 rounded-xl bg-brand-gold/15 text-brand-gold border border-brand-gold/30 text-xs font-bold hover:bg-brand-gold hover:text-brand-darkest transition-all">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/>
                        </svg>
                        <span>ویرایش</span>
                    </a>

                    <form action="{{ route('admin.articles.destroy', $article) }}" method="POST" onsubmit="return confirm('آیا از حذف این مقاله مطمئن هستید؟');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="w-full inline-flex items-center justify-center gap-1.5 py-2 rounded-xl bg-red-500/15 text-red-400 border border-red-500/30 text-xs font-bold hover:bg-red-500 hover:text-white transition-all">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                            </svg>
                            <span>حذف</span>
                        </button>
                    </form>
                </div>
            </div>
        @empty
            <div class="glass-card p-6 rounded-2xl text-center text-xs text-brand-slate border border-white/5">
                هیچ مقاله‌ای یافت نشد.
            </div>
        @endforelse
    </div>

    <!-- نمای جدول برای تبلت و دسکتاپ (صفحه‌نمایش‌های بالای 768px) -->
    <div class="hidden md:block glass-card rounded-3xl overflow-hidden border border-white/5 shadow-xl">
        <div class="overflow-x-auto">
            <table class="w-full text-right text-xs">
                <thead class="bg-white/5 text-brand-slate font-bold border-b border-white/5 text-[11px]">
                    <tr>
                        <th class="p-4 px-6">تصویر و عنوان مقاله</th>
                        <th class="p-4 text-center">دسته‌بندی</th>
                        <th class="p-4 text-center">سطح</th>
                        <th class="p-4 text-center">وضعیت انتشار</th>
                        <th class="p-4 px-6 text-center">عملیات</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-white/5">
                    @forelse($articles as $article)
                        <tr class="hover:bg-white/[0.03] transition-all">
                            <td class="p-4 px-6">
                                <div class="flex items-center gap-3">
                                    @if($article->image)
                                        <img src="{{ asset('storage/' . $article->image) }}" class="w-12 h-10 object-cover rounded-lg border border-white/10 flex-shrink-0" alt="">
                                    @else
                                        <div class="w-12 h-10 rounded-lg bg-white/5 border border-white/10 flex items-center justify-center text-[9px] text-brand-slate flex-shrink-0 text-center p-1">بدون تصویر</div>
                                    @endif
                                    <span class="font-bold text-white max-w-xs truncate">
                                        {{ $article->title ?? $article->title_fa ?? $article->title_en }}
                                    </span>
                                </div>
                            </td>
                            <td class="p-4 text-center">
                                <span class="px-2.5 py-1 rounded-lg bg-white/5 text-brand-gold font-bold text-[11px] border border-white/10">
                                    {{ $article->category }}
                                </span>
                            </td>
                            <td class="p-4 text-center text-brand-slate font-medium">
                                {{ $article->level ?? '—' }}
                            </td>
                            <td class="p-4 text-center">
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[10px] font-bold {{ $article->is_published ? 'bg-emerald-500/10 text-emerald-400 border border-emerald-500/20' : 'bg-red-500/10 text-red-400 border border-red-500/20' }}">
                                    <span class="w-1.5 h-1.5 rounded-full {{ $article->is_published ? 'bg-emerald-400' : 'bg-red-400' }}"></span>
                                    {{ $article->is_published ? 'منتشر شده' : 'پیش‌نویس' }}
                                </span>
                            </td>
                            <td class="p-4 px-6 text-center">
                                <div class="inline-flex items-center justify-center gap-2">
                                    <a href="{{ route('admin.articles.edit', $article) }}" class="inline-flex items-center gap-1 px-3 py-1.5 bg-brand-gold/15 hover:bg-brand-gold text-brand-gold hover:text-brand-darkest rounded-xl border border-brand-gold/30 text-[11px] font-bold transition-all" title="ویرایش">
                                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/>
                                        </svg>
                                        <span>ویرایش</span>
                                    </a>
                                    <form action="{{ route('admin.articles.destroy', $article) }}" method="POST" onsubmit="return confirm('آیا از حذف این مقاله مطمئن هستید؟');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="inline-flex items-center gap-1 px-3 py-1.5 bg-red-500/15 hover:bg-red-500 text-red-400 hover:text-white rounded-xl border border-red-500/30 text-[11px] font-bold transition-all" title="حذف">
                                            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                            </svg>
                                            <span>حذف</span>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="p-6 text-center text-brand-slate">هیچ مقاله‌ای یافت نشد.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- صفحه‌بندی -->
    <div class="pt-2 flex justify-center">
        {{ $articles->links() }}
    </div>
</div>
@endsection