@extends('admin.layout')

@section('title', 'داشبورد مدیریت')
@section('page-title', 'داشبورد اصلی')

@section('content')
<div class="space-y-6">

    <!-- دکمه مدیریت وضعیت Coming Soon سایت -->
    <div class="glass-card p-4 rounded-2xl border border-white/5 flex flex-col sm:flex-row items-center justify-between gap-4">
        <div>
            <div class="text-sm font-bold text-white">وضعیت دسترسی عمومی سایت</div>
            <div class="text-xs text-brand-slate mt-1">
                وضعیت فعلی: 
                <span class="font-extrabold {{ $isComingSoon ? 'text-rose-400' : 'text-emerald-400' }}">
                    {{ $isComingSoon ? 'صفحه به زودی (Coming Soon) فعال است' : 'سایت برای همه باز است' }}
                </span>
            </div>
        </div>

        <form action="{{ route('admin.settings.toggle-coming-soon') }}" method="POST">
            @csrf
            <button type="submit" class="px-5 py-2.5 rounded-xl font-bold text-xs transition-all shadow-md {{ $isComingSoon ? 'bg-rose-500 hover:bg-rose-600 text-white' : 'bg-emerald-500 hover:bg-emerald-600 text-white' }}">
                {{ $isComingSoon ? '🔓 بازگشایی سایت برای عموم' : '🔒 فعال‌سازی صفحه به زودی' }}
            </button>
        </form>
    </div>

    <!-- کارت‌های آمار -->
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
        <div class="glass-card p-6 rounded-3xl border border-white/5 space-y-2">
            <span class="text-xs text-brand-slate font-bold">کل مقالات</span>
            <div class="text-3xl font-black text-gold-gradient">{{ $articlesCount }}</div>
        </div>
        <div class="glass-card p-6 rounded-3xl border border-white/5 space-y-2">
            <span class="text-xs text-brand-slate font-bold">آزمون‌های فعال</span>
            <div class="text-3xl font-black text-gold-gradient">{{ $quizzesCount }}</div>
        </div>
        <div class="glass-card p-6 rounded-3xl border border-white/5 space-y-2">
            <span class="text-xs text-brand-slate font-bold">اعضای خبرنامه</span>
            <div class="text-3xl font-black text-gold-gradient">{{ $subscribersCount }}</div>
        </div>
    </div>

    <!-- لیست آخرین مقالات -->
    <div class="glass-card rounded-3xl p-6 border border-white/5 space-y-4">
        <div class="flex items-center justify-between pb-3 border-b border-white/5">
            <h3 class="font-bold text-sm text-white">آخرین مقالات اضافه شده</h3>
            <a href="{{ route('admin.articles.create') }}" class="bg-brand-gold hover:bg-brand-goldHover text-brand-darkest text-xs font-extrabold px-4 py-2 rounded-xl transition-all">
                + افزودن مقاله
            </a>
        </div>
        
        <div class="space-y-3">
            @forelse($recentArticles as $art)
                <div class="flex items-center justify-between p-3 rounded-xl hover:bg-white/5 transition-all text-xs">
                    <span class="font-bold text-white">{{ $art->title }}</span>
                    <span class="text-brand-slate">{{ $art->created_at->format('Y/m/d') }}</span>
                </div>
            @empty
                <p class="text-xs text-brand-slate text-center py-4">هنوز مقاله‌ای ثبت نشده است.</p>
            @endforelse
        </div>
    </div>
</div>
@endsection