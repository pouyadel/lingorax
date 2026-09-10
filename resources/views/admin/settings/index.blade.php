@extends('admin.layout')

@section('title', 'ویرایش متون دوزبانه سایت')
@section('page-title', 'مدیریت متون سایت (فارسی و انگلیسی)')

@section('content')
<form action="{{ route('admin.settings.update') }}" method="POST" class="max-w-5xl space-y-6">
    @csrf

    <!-- بخش هیرو -->
    <div class="glass-card p-6 rounded-3xl border border-white/5 space-y-4">
        <h3 class="text-sm font-bold text-brand-gold border-b border-white/5 pb-3">متون صفحه اصلی (Hero Section)</h3>
        
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div class="space-y-2">
                <label class="text-xs text-brand-slate font-bold">بج بالای عنوان (FA)</label>
                <input type="text" name="hero_badge_fa" value="{{ $settings['hero_badge_fa'] ?? 'انگلیسی رو دقیق تر یاد بگیر، حرفه ای تر استفاده کن' }}" class="w-full bg-brand-dark border border-white/10 rounded-xl px-4 py-2.5 text-xs text-white focus:outline-none focus:border-brand-gold" />
            </div>

            <div class="space-y-2">
                <label class="text-xs text-brand-slate font-bold">Hero Badge (EN)</label>
                <input type="text" name="hero_badge_en" dir="ltr" value="{{ $settings['hero_badge_en'] ?? 'Master English with Precision, Apply It Professionally' }}" class="w-full bg-brand-dark border border-white/10 rounded-xl px-4 py-2.5 text-xs text-white focus:outline-none focus:border-brand-gold" />
            </div>

            <div class="space-y-2">
                <label class="text-xs text-brand-slate font-bold">توضیحات کوتاه (FA)</label>
                <textarea name="hero_desc_fa" rows="3" class="w-full bg-brand-dark border border-white/10 rounded-xl p-3 text-xs text-white focus:outline-none focus:border-brand-gold">{{ $settings['hero_desc_fa'] ?? 'دسترسی به مقالات تخصصی، نکات آزمون‌های بین‌المللی و کوئیزهای موضوعی.' }}</textarea>
            </div>

            <div class="space-y-2">
                <label class="text-xs text-brand-slate font-bold">Hero Description (EN)</label>
                <textarea name="hero_desc_en" dir="ltr" rows="3" class="w-full bg-brand-dark border border-white/10 rounded-xl p-3 text-xs text-white focus:outline-none focus:border-brand-gold">{{ $settings['hero_desc_en'] ?? 'Explore expert educational articles, exam strategies, and interactive quizzes.' }}</textarea>
            </div>

            <div class="sm:col-span-2 space-y-2">
                <label class="text-xs text-brand-slate font-bold">لینک ویدیوی معرفی (آپارات / Embed)</label>
                <input type="text" name="intro_video_url" dir="ltr" value="{{ $settings['intro_video_url'] ?? 'https://www.aparat.com/video/video/embed/videohash/ketf724/vt/frame' }}" class="w-full bg-brand-dark border border-white/10 rounded-xl px-4 py-2.5 text-xs text-white focus:outline-none focus:border-brand-gold" />
            </div>
        </div>
    </div>

    <!-- بخش بیوگرافی و درباره من -->
    <div class="glass-card p-6 rounded-3xl border border-white/5 space-y-4">
        <h3 class="text-sm font-bold text-brand-gold border-b border-white/5 pb-3">اطلاعات و بیوگرافی استاد</h3>
        
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div class="space-y-2">
                <label class="text-xs text-brand-slate font-bold">نام استاد (FA)</label>
                <input type="text" name="teacher_name_fa" value="{{ $settings['teacher_name_fa'] ?? 'یاشیل رزمیان‌زاده' }}" class="w-full bg-brand-dark border border-white/10 rounded-xl px-4 py-2.5 text-xs text-white focus:outline-none focus:border-brand-gold" />
            </div>

            <div class="space-y-2">
                <label class="text-xs text-brand-slate font-bold">Teacher Name (EN)</label>
                <input type="text" name="teacher_name_en" dir="ltr" value="{{ $settings['teacher_name_en'] ?? 'Yashil Razmiyanzadeh' }}" class="w-full bg-brand-dark border border-white/10 rounded-xl px-4 py-2.5 text-xs text-white focus:outline-none focus:border-brand-gold" />
            </div>

            <div class="space-y-2">
                <label class="text-xs text-brand-slate font-bold">عنوان و تخصص (FA)</label>
                <input type="text" name="teacher_role_fa" value="{{ $settings['teacher_role_fa'] ?? 'مدرس تخصصی آیلتس، تافل و زبان عمومی' }}" class="w-full bg-brand-dark border border-white/10 rounded-xl px-4 py-2.5 text-xs text-white focus:outline-none focus:border-brand-gold" />
            </div>

            <div class="space-y-2">
                <label class="text-xs text-brand-slate font-bold">Teacher Role (EN)</label>
                <input type="text" name="teacher_role_en" dir="ltr" value="{{ $settings['teacher_role_en'] ?? 'Specialized IELTS, TOEFL & General English Instructor' }}" class="w-full bg-brand-dark border border-white/10 rounded-xl px-4 py-2.5 text-xs text-white focus:outline-none focus:border-brand-gold" />
            </div>

            <div class="space-y-2">
                <label class="text-xs text-brand-slate font-bold">بیوگرافی کامل (FA)</label>
                <textarea name="teacher_bio_full_fa" rows="4" class="w-full bg-brand-dark border border-white/10 rounded-xl p-3 text-xs text-white focus:outline-none focus:border-brand-gold">{{ $settings['teacher_bio_full_fa'] ?? 'من یاشیل رزمیان‌زاده هستم. سال‌هاست که مسیر تدریس زبان انگلیسی را با هدف ایجاد تغییرات بنیادین انتخاب کرده‌ام.' }}</textarea>
            </div>

            <div class="space-y-2">
                <label class="text-xs text-brand-slate font-bold">Full Biography (EN)</label>
                <textarea name="teacher_bio_full_en" dir="ltr" rows="4" class="w-full bg-brand-dark border border-white/10 rounded-xl p-3 text-xs text-white focus:outline-none focus:border-brand-gold">{{ $settings['teacher_bio_full_en'] ?? 'I am Yashil Razmiyanzadeh. For years, I have dedicated myself to transforming how students learn English.' }}</textarea>
            </div>
        </div>
    </div>

    <button type="submit" class="bg-gradient-to-r from-brand-gold to-brand-goldHover text-brand-darkest font-black px-8 py-3 rounded-xl text-xs shadow-glow-gold hover:scale-105 active:scale-95 transition-all">
        ذخیره کلیه تنظیمات دوزبانه
    </button>
</form>
@endsection