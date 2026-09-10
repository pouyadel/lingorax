@extends('admin.layout')

@section('title', 'مدیریت جامع متون و تنظیمات وب‌سایت')
@section('page-title', 'مدیریت متون و لینک‌های تمامی صفحات')

@section('content')
<div x-data="{ activeTab: 'general' }" class="space-y-6 max-w-6xl">

    <!-- نوار تب‌های دسته‌بندی صفحات -->
    <div class="glass-card p-2 rounded-2xl border border-white/10 flex items-center gap-2 flex-wrap">
        <button type="button" @click="activeTab = 'general'" :class="activeTab === 'general' ? 'bg-brand-gold text-brand-darkest font-black shadow-glow-gold' : 'text-brand-slate hover:text-white'" class="px-4 py-2.5 rounded-xl text-xs font-bold transition-all">
            هدر، فوتر و ارتباطات
        </button>
        <button type="button" @click="activeTab = 'home'" :class="activeTab === 'home' ? 'bg-brand-gold text-brand-darkest font-black shadow-glow-gold' : 'text-brand-slate hover:text-white'" class="px-4 py-2.5 rounded-xl text-xs font-bold transition-all">
            متون صفحه اصلی
        </button>
        <button type="button" @click="activeTab = 'articles'" :class="activeTab === 'articles' ? 'bg-brand-gold text-brand-darkest font-black shadow-glow-gold' : 'text-brand-slate hover:text-white'" class="px-4 py-2.5 rounded-xl text-xs font-bold transition-all">
            متون صفحه مقالات
        </button>
        <button type="button" @click="activeTab = 'quizzes'" :class="activeTab === 'quizzes' ? 'bg-brand-gold text-brand-darkest font-black shadow-glow-gold' : 'text-brand-slate hover:text-white'" class="px-4 py-2.5 rounded-xl text-xs font-bold transition-all">
            متون صفحه آزمون‌ها
        </button>
        <button type="button" @click="activeTab = 'about'" :class="activeTab === 'about' ? 'bg-brand-gold text-brand-darkest font-black shadow-glow-gold' : 'text-brand-slate hover:text-white'" class="px-4 py-2.5 rounded-xl text-xs font-bold transition-all">
            متون صفحه درباره من
        </button>
    </div>

    <form action="{{ route('admin.settings.update') }}" method="POST" class="space-y-6">
        @csrf

        <!-- تب ۱: هدر، فوتر و شبکه‌های اجتماعی -->
        <div x-show="activeTab === 'general'" x-transition class="space-y-6">
            <div class="glass-card p-6 rounded-3xl border border-white/5 space-y-4">
                <h3 class="text-sm font-bold text-brand-gold border-b border-white/5 pb-3">عناوین منوی ناوبری (Header Nav)</h3>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div class="space-y-1">
                        <label class="text-[11px] text-brand-slate font-bold">خانه (فارسی)</label>
                        <input type="text" name="nav_home_fa" value="{{ $settings['nav_home_fa'] ?? 'صفحه اصلی' }}" class="w-full bg-brand-dark border border-white/10 rounded-xl px-4 py-2 text-xs text-white" />
                    </div>
                    <div class="space-y-1">
                        <label class="text-[11px] text-brand-slate font-bold">Home (English)</label>
                        <input type="text" name="nav_home_en" dir="ltr" value="{{ $settings['nav_home_en'] ?? 'Home' }}" class="w-full bg-brand-dark border border-white/10 rounded-xl px-4 py-2 text-xs text-white" />
                    </div>

                    <div class="space-y-1">
                        <label class="text-[11px] text-brand-slate font-bold">مقالات (فارسی)</label>
                        <input type="text" name="nav_articles_fa" value="{{ $settings['nav_articles_fa'] ?? 'مقالات آموزشی' }}" class="w-full bg-brand-dark border border-white/10 rounded-xl px-4 py-2 text-xs text-white" />
                    </div>
                    <div class="space-y-1">
                        <label class="text-[11px] text-brand-slate font-bold">Articles (English)</label>
                        <input type="text" name="nav_articles_en" dir="ltr" value="{{ $settings['nav_articles_en'] ?? 'Articles' }}" class="w-full bg-brand-dark border border-white/10 rounded-xl px-4 py-2 text-xs text-white" />
                    </div>

                    <div class="space-y-1">
                        <label class="text-[11px] text-brand-slate font-bold">آزمون‌ها (فارسی)</label>
                        <input type="text" name="nav_quizzes_fa" value="{{ $settings['nav_quizzes_fa'] ?? 'بانک آزمون‌ها' }}" class="w-full bg-brand-dark border border-white/10 rounded-xl px-4 py-2 text-xs text-white" />
                    </div>
                    <div class="space-y-1">
                        <label class="text-[11px] text-brand-slate font-bold">Quizzes (English)</label>
                        <input type="text" name="nav_quizzes_en" dir="ltr" value="{{ $settings['nav_quizzes_en'] ?? 'Quizzes' }}" class="w-full bg-brand-dark border border-white/10 rounded-xl px-4 py-2 text-xs text-white" />
                    </div>

                    <div class="space-y-1">
                        <label class="text-[11px] text-brand-slate font-bold">درباره من (فارسی)</label>
                        <input type="text" name="nav_about_fa" value="{{ $settings['nav_about_fa'] ?? 'درباره من' }}" class="w-full bg-brand-dark border border-white/10 rounded-xl px-4 py-2 text-xs text-white" />
                    </div>
                    <div class="space-y-1">
                        <label class="text-[11px] text-brand-slate font-bold">About Me (English)</label>
                        <input type="text" name="nav_about_en" dir="ltr" value="{{ $settings['nav_about_en'] ?? 'About Me' }}" class="w-full bg-brand-dark border border-white/10 rounded-xl px-4 py-2 text-xs text-white" />
                    </div>
                </div>
            </div>

            <div class="glass-card p-6 rounded-3xl border border-white/5 space-y-4">
                <h3 class="text-sm font-bold text-brand-gold border-b border-white/5 pb-3">لینک‌های شبکه‌های اجتماعی و ارتباطی (Footer)</h3>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div class="space-y-1">
                        <label class="text-[11px] text-brand-slate font-bold">آدرس اینستاگرام</label>
                        <input type="text" name="social_instagram" dir="ltr" value="{{ $settings['social_instagram'] ?? 'https://instagram.com/Lingorax' }}" class="w-full bg-brand-dark border border-white/10 rounded-xl px-4 py-2 text-xs text-white" />
                    </div>
                    <div class="space-y-1">
                        <label class="text-[11px] text-brand-slate font-bold">لینک واتساپ</label>
                        <input type="text" name="social_whatsapp" dir="ltr" value="{{ $settings['social_whatsapp'] ?? 'https://wa.me/989911911683' }}" class="w-full bg-brand-dark border border-white/10 rounded-xl px-4 py-2 text-xs text-white" />
                    </div>
                    <div class="space-y-1">
                        <label class="text-[11px] text-brand-slate font-bold">ایمیل تماس</label>
                        <input type="email" name="social_email" dir="ltr" value="{{ $settings['social_email'] ?? 'yashil.razmiyanzade@gmail.com' }}" class="w-full bg-brand-dark border border-white/10 rounded-xl px-4 py-2 text-xs text-white" />
                    </div>
                    <div class="space-y-1">
                        <label class="text-[11px] text-brand-slate font-bold">شماره تماس</label>
                        <input type="text" name="social_phone" dir="ltr" value="{{ $settings['social_phone'] ?? '09911911683' }}" class="w-full bg-brand-dark border border-white/10 rounded-xl px-4 py-2 text-xs text-white" />
                    </div>
                    <div class="space-y-1">
                        <label class="text-[11px] text-brand-slate font-bold">متن کپی‌رایت فوتر (فارسی)</label>
                        <input type="text" name="footer_copy_fa" value="{{ $settings['footer_copy_fa'] ?? '© پایگاه آموزشی و تحلیلی LINGORAX | یاشیل رزمیان‌زاده' }}" class="w-full bg-brand-dark border border-white/10 rounded-xl px-4 py-2 text-xs text-white" />
                    </div>
                    <div class="space-y-1">
                        <label class="text-[11px] text-brand-slate font-bold">Copyright Footer Text (English)</label>
                        <input type="text" name="footer_copy_en" dir="ltr" value="{{ $settings['footer_copy_en'] ?? '© LINGORAX Educational Hub | Yashil Razmiyanzadeh' }}" class="w-full bg-brand-dark border border-white/10 rounded-xl px-4 py-2 text-xs text-white" />
                    </div>
                </div>
            </div>
        </div>

        <!-- تب ۲: متون صفحه اصلی -->
        <div x-show="activeTab === 'home'" x-transition class="space-y-6">
            <div class="glass-card p-6 rounded-3xl border border-white/5 space-y-4">
                <h3 class="text-sm font-bold text-brand-gold border-b border-white/5 pb-3">بخش هیرو (Hero Section)</h3>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div class="space-y-1">
                        <label class="text-[11px] text-brand-slate font-bold">بج بالای عنوان (FA)</label>
                        <input type="text" name="home_badge_fa" value="{{ $settings['home_badge_fa'] ?? 'انگلیسی رو دقیق تر یاد بگیر، حرفه ای تر استفاده کن' }}" class="w-full bg-brand-dark border border-white/10 rounded-xl px-4 py-2 text-xs text-white" />
                    </div>
                    <div class="space-y-1">
                        <label class="text-[11px] text-brand-slate font-bold">Badge (EN)</label>
                        <input type="text" name="home_badge_en" dir="ltr" value="{{ $settings['home_badge_en'] ?? 'Master English with Precision, Apply It Professionally' }}" class="w-full bg-brand-dark border border-white/10 rounded-xl px-4 py-2 text-xs text-white" />
                    </div>
                    <div class="space-y-1">
                        <label class="text-[11px] text-brand-slate font-bold">عنوان اصلی خط اول (FA)</label>
                        <input type="text" name="home_title1_fa" value="{{ $settings['home_title1_fa'] ?? 'آموزش و ارزیابی زبان،' }}" class="w-full bg-brand-dark border border-white/10 rounded-xl px-4 py-2 text-xs text-white" />
                    </div>
                    <div class="space-y-1">
                        <label class="text-[11px] text-brand-slate font-bold">Title Line 1 (EN)</label>
                        <input type="text" name="home_title1_en" dir="ltr" value="{{ $settings['home_title1_en'] ?? 'English Learning & Assessment,' }}" class="w-full bg-brand-dark border border-white/10 rounded-xl px-4 py-2 text-xs text-white" />
                    </div>
                    <div class="space-y-1">
                        <label class="text-[11px] text-brand-slate font-bold">عنوان اصلی طلایی (FA)</label>
                        <input type="text" name="home_title2_fa" value="{{ $settings['home_title2_fa'] ?? 'کاربردی و هدفمند' }}" class="w-full bg-brand-dark border border-white/10 rounded-xl px-4 py-2 text-xs text-white" />
                    </div>
                    <div class="space-y-1">
                        <label class="text-[11px] text-brand-slate font-bold">Gold Title Line 2 (EN)</label>
                        <input type="text" name="home_title2_en" dir="ltr" value="{{ $settings['home_title2_en'] ?? 'Practical & Goal-Oriented' }}" class="w-full bg-brand-dark border border-white/10 rounded-xl px-4 py-2 text-xs text-white" />
                    </div>
                    <div class="space-y-1">
                        <label class="text-[11px] text-brand-slate font-bold">توضیحات هیرو (FA)</label>
                        <textarea name="home_desc_fa" rows="2" class="w-full bg-brand-dark border border-white/10 rounded-xl p-3 text-xs text-white">{{ $settings['home_desc_fa'] ?? 'دسترسی به مقالات تخصصی، نکات آزمون‌های بین‌المللی و کوئیزهای موضوعی با بررسی آنی پاسخ‌ها و بدون نیاز به فرآیندهای پیچیده.' }}</textarea>
                    </div>
                    <div class="space-y-1">
                        <label class="text-[11px] text-brand-slate font-bold">Description (EN)</label>
                        <textarea name="home_desc_en" dir="ltr" rows="2" class="w-full bg-brand-dark border border-white/10 rounded-xl p-3 text-xs text-white">{{ $settings['home_desc_en'] ?? 'Explore expert educational articles, international exam strategies, and interactive quizzes with instant performance feedback.' }}</textarea>
                    </div>
                    <div class="sm:col-span-2 space-y-1">
                        <label class="text-[11px] text-brand-slate font-bold">لینک Embed ویدیوی آپارات</label>
                        <input type="text" name="home_video_url" dir="ltr" value="{{ $settings['home_video_url'] ?? 'https://www.aparat.com/video/video/embed/videohash/ketf724/vt/frame' }}" class="w-full bg-brand-dark border border-white/10 rounded-xl px-4 py-2 text-xs text-white" />
                    </div>
                </div>
            </div>

            <!-- ستون‌های ارزش ۳ گانه -->
            <div class="glass-card p-6 rounded-3xl border border-white/5 space-y-4">
                <h3 class="text-sm font-bold text-brand-gold border-b border-white/5 pb-3">کارت‌های سه‌گانه ارزش (Value Pillars)</h3>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div class="space-y-1">
                        <label class="text-[11px] text-brand-slate font-bold">عنوان کارت اول (FA)</label>
                        <input type="text" name="home_pillar1_title_fa" value="{{ $settings['home_pillar1_title_fa'] ?? 'سنجش هوشمند و تحلیلی' }}" class="w-full bg-brand-dark border border-white/10 rounded-xl px-4 py-2 text-xs text-white" />
                    </div>
                    <div class="space-y-1">
                        <label class="text-[11px] text-brand-slate font-bold">Pillar 1 Title (EN)</label>
                        <input type="text" name="home_pillar1_title_en" dir="ltr" value="{{ $settings['home_pillar1_title_en'] ?? 'Smart Assessment' }}" class="w-full bg-brand-dark border border-white/10 rounded-xl px-4 py-2 text-xs text-white" />
                    </div>
                    <div class="space-y-1">
                        <label class="text-[11px] text-brand-slate font-bold">توضیح کارت اول (FA)</label>
                        <textarea name="home_pillar1_desc_fa" rows="2" class="w-full bg-brand-dark border border-white/10 rounded-xl p-3 text-xs text-white">{{ $settings['home_pillar1_desc_fa'] ?? 'کوئیزهای استاندارد با محاسبه آنی نمره و ارائه پاسخ تشریحی برای هر سوال' }}</textarea>
                    </div>
                    <div class="space-y-1">
                        <label class="text-[11px] text-brand-slate font-bold">Pillar 1 Desc (EN)</label>
                        <textarea name="home_pillar1_desc_en" dir="ltr" rows="2" class="w-full bg-brand-dark border border-white/10 rounded-xl p-3 text-xs text-white">{{ $settings['home_pillar1_desc_en'] ?? 'Standardized quizzes with real-time scoring and comprehensive answer explanations.' }}</textarea>
                    </div>

                    <div class="space-y-1 pt-2 border-t border-white/5 sm:col-span-2"></div>

                    <div class="space-y-1">
                        <label class="text-[11px] text-brand-slate font-bold">عنوان کارت دوم (FA)</label>
                        <input type="text" name="home_pillar2_title_fa" value="{{ $settings['home_pillar2_title_fa'] ?? 'مقالات هدفمند و خودآموز' }}" class="w-full bg-brand-dark border border-white/10 rounded-xl px-4 py-2 text-xs text-white" />
                    </div>
                    <div class="space-y-1">
                        <label class="text-[11px] text-brand-slate font-bold">Pillar 2 Title (EN)</label>
                        <input type="text" name="home_pillar2_title_en" dir="ltr" value="{{ $settings['home_pillar2_title_en'] ?? 'Self-Study Articles' }}" class="w-full bg-brand-dark border border-white/10 rounded-xl px-4 py-2 text-xs text-white" />
                    </div>
                    <div class="space-y-1">
                        <label class="text-[11px] text-brand-slate font-bold">توضیح کارت دوم (FA)</label>
                        <textarea name="home_pillar2_desc_fa" rows="2" class="w-full bg-brand-dark border border-white/10 rounded-xl p-3 text-xs text-white">{{ $settings['home_pillar2_desc_fa'] ?? 'مطالب آموزشی دسته‌بندی‌شده بر اساس سطوح زبانی استاندارد (A1 تا C2)' }}</textarea>
                    </div>
                    <div class="space-y-1">
                        <label class="text-[11px] text-brand-slate font-bold">Pillar 2 Desc (EN)</label>
                        <textarea name="home_pillar2_desc_en" dir="ltr" rows="2" class="w-full bg-brand-dark border border-white/10 rounded-xl p-3 text-xs text-white">{{ $settings['home_pillar2_desc_en'] ?? 'Curated articles categorized by international CEFR language levels (A1 to C2).' }}</textarea>
                    </div>

                    <div class="space-y-1 pt-2 border-t border-white/5 sm:col-span-2"></div>

                    <div class="space-y-1">
                        <label class="text-[11px] text-brand-slate font-bold">عنوان کارت سوم (FA)</label>
                        <input type="text" name="home_pillar3_title_fa" value="{{ $settings['home_pillar3_title_fa'] ?? 'دسترسی آزاد و سریع' }}" class="w-full bg-brand-dark border border-white/10 rounded-xl px-4 py-2 text-xs text-white" />
                    </div>
                    <div class="space-y-1">
                        <label class="text-[11px] text-brand-slate font-bold">Pillar 3 Title (EN)</label>
                        <input type="text" name="home_pillar3_title_en" dir="ltr" value="{{ $settings['home_pillar3_title_en'] ?? 'Direct Access' }}" class="w-full bg-brand-dark border border-white/10 rounded-xl px-4 py-2 text-xs text-white" />
                    </div>
                    <div class="space-y-1">
                        <label class="text-[11px] text-brand-slate font-bold">توضیح کارت سوم (FA)</label>
                        <textarea name="home_pillar3_desc_fa" rows="2" class="w-full bg-brand-dark border border-white/10 rounded-xl p-3 text-xs text-white">{{ $settings['home_pillar3_desc_fa'] ?? 'استفاده مستقیم از آزمون‌ها و بانک لغات بدون موانع و فرآیندهای طولانی' }}</textarea>
                    </div>
                    <div class="space-y-1">
                        <label class="text-[11px] text-brand-slate font-bold">Pillar 3 Desc (EN)</label>
                        <textarea name="home_pillar3_desc_en" dir="ltr" rows="2" class="w-full bg-brand-dark border border-white/10 rounded-xl p-3 text-xs text-white">{{ $settings['home_pillar3_desc_en'] ?? 'Instant engagement with learning modules and tests with zero friction.' }}</textarea>
                    </div>
                </div>
            </div>
        </div>

        <!-- تب ۳: متون صفحه مقالات -->
        <div x-show="activeTab === 'articles'" x-transition class="space-y-6">
            <div class="glass-card p-6 rounded-3xl border border-white/5 space-y-4">
                <h3 class="text-sm font-bold text-brand-gold border-b border-white/5 pb-3">عناوین و سرتیتر صفحه مقالات</h3>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div class="space-y-1">
                        <label class="text-[11px] text-brand-slate font-bold">بج بالای صفحه مقالات (FA)</label>
                        <input type="text" name="articles_badge_fa" value="{{ $settings['articles_badge_fa'] ?? 'مرجع آموزشی و تحلیلی مقالات' }}" class="w-full bg-brand-dark border border-white/10 rounded-xl px-4 py-2 text-xs text-white" />
                    </div>
                    <div class="space-y-1">
                        <label class="text-[11px] text-brand-slate font-bold">Articles Badge (EN)</label>
                        <input type="text" name="articles_badge_en" dir="ltr" value="{{ $settings['articles_badge_en'] ?? 'Educational Article Archive' }}" class="w-full bg-brand-dark border border-white/10 rounded-xl px-4 py-2 text-xs text-white" />
                    </div>
                    <div class="space-y-1">
                        <label class="text-[11px] text-brand-slate font-bold">عنوان خط اول (FA)</label>
                        <input type="text" name="articles_title1_fa" value="{{ $settings['articles_title1_fa'] ?? 'بانک مقالات تخصصی و' }}" class="w-full bg-brand-dark border border-white/10 rounded-xl px-4 py-2 text-xs text-white" />
                    </div>
                    <div class="space-y-1">
                        <label class="text-[11px] text-brand-slate font-bold">Title 1 (EN)</label>
                        <input type="text" name="articles_title1_en" dir="ltr" value="{{ $settings['articles_title1_en'] ?? 'Specialized English' }}" class="w-full bg-brand-dark border border-white/10 rounded-xl px-4 py-2 text-xs text-white" />
                    </div>
                    <div class="space-y-1">
                        <label class="text-[11px] text-brand-slate font-bold">عنوان طلایی خط دوم (FA)</label>
                        <input type="text" name="articles_title2_fa" value="{{ $settings['articles_title2_fa'] ?? 'نکات تحلیلی زبان انگلیسی' }}" class="w-full bg-brand-dark border border-white/10 rounded-xl px-4 py-2 text-xs text-white" />
                    </div>
                    <div class="space-y-1">
                        <label class="text-[11px] text-brand-slate font-bold">Title 2 Gold (EN)</label>
                        <input type="text" name="articles_title2_en" dir="ltr" value="{{ $settings['articles_title2_en'] ?? 'Articles & Study Guides' }}" class="w-full bg-brand-dark border border-white/10 rounded-xl px-4 py-2 text-xs text-white" />
                    </div>
                    <div class="space-y-1 sm:col-span-2">
                        <label class="text-[11px] text-brand-slate font-bold">توضیحات بالای صفحه مقالات (FA)</label>
                        <textarea name="articles_desc_fa" rows="2" class="w-full bg-brand-dark border border-white/10 rounded-xl p-3 text-xs text-white">{{ $settings['articles_desc_fa'] ?? 'دسته‌بندی مقالات بر اساس سطح زبان و مهارت‌های مورد نیاز، از مبتدی تا آمادگی آزمون‌های آیلتس و تافل.' }}</textarea>
                    </div>
                    <div class="space-y-1 sm:col-span-2">
                        <label class="text-[11px] text-brand-slate font-bold">Description (EN)</label>
                        <textarea name="articles_desc_en" dir="ltr" rows="2" class="w-full bg-brand-dark border border-white/10 rounded-xl p-3 text-xs text-white">{{ $settings['articles_desc_en'] ?? 'Curated self-study articles, structural guides, and exam strategies categorized by skill and CEFR level.' }}</textarea>
                    </div>
                </div>
            </div>
        </div>

        <!-- تب ۴: متون صفحه آزمون‌ها -->
        <div x-show="activeTab === 'quizzes'" x-transition class="space-y-6">
            <div class="glass-card p-6 rounded-3xl border border-white/5 space-y-4">
                <h3 class="text-sm font-bold text-brand-gold border-b border-white/5 pb-3">عناوین و سرتیتر صفحه آزمون‌ها</h3>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div class="space-y-1">
                        <label class="text-[11px] text-brand-slate font-bold">بج بالای صفحه آزمون‌ها (FA)</label>
                        <input type="text" name="quizzes_badge_fa" value="{{ $settings['quizzes_badge_fa'] ?? 'ارزیابی هوشمند و هدفمند' }}" class="w-full bg-brand-dark border border-white/10 rounded-xl px-4 py-2 text-xs text-white" />
                    </div>
                    <div class="space-y-1">
                        <label class="text-[11px] text-brand-slate font-bold">Quizzes Badge (EN)</label>
                        <input type="text" name="quizzes_badge_en" dir="ltr" value="{{ $settings['quizzes_badge_en'] ?? 'Smart & Targeted Assessment' }}" class="w-full bg-brand-dark border border-white/10 rounded-xl px-4 py-2 text-xs text-white" />
                    </div>
                    <div class="space-y-1">
                        <label class="text-[11px] text-brand-slate font-bold">عنوان خط اول (FA)</label>
                        <input type="text" name="quizzes_title1_fa" value="{{ $settings['quizzes_title1_fa'] ?? 'بانک آزمون‌ها و' }}" class="w-full bg-brand-dark border border-white/10 rounded-xl px-4 py-2 text-xs text-white" />
                    </div>
                    <div class="space-y-1">
                        <label class="text-[11px] text-brand-slate font-bold">Title 1 (EN)</label>
                        <input type="text" name="quizzes_title1_en" dir="ltr" value="{{ $settings['quizzes_title1_en'] ?? 'Online Quiz Bank &' }}" class="w-full bg-brand-dark border border-white/10 rounded-xl px-4 py-2 text-xs text-white" />
                    </div>
                    <div class="space-y-1">
                        <label class="text-[11px] text-brand-slate font-bold">عنوان طلایی خط دوم (FA)</label>
                        <input type="text" name="quizzes_title2_fa" value="{{ $settings['quizzes_title2_fa'] ?? 'کوئیزهای آنلاین' }}" class="w-full bg-brand-dark border border-white/10 rounded-xl px-4 py-2 text-xs text-white" />
                    </div>
                    <div class="space-y-1">
                        <label class="text-[11px] text-brand-slate font-bold">Title 2 Gold (EN)</label>
                        <input type="text" name="quizzes_title2_en" dir="ltr" value="{{ $settings['quizzes_title2_en'] ?? 'Language Assessment' }}" class="w-full bg-brand-dark border border-white/10 rounded-xl px-4 py-2 text-xs text-white" />
                    </div>
                    <div class="space-y-1 sm:col-span-2">
                        <label class="text-[11px] text-brand-slate font-bold">توضیحات بالای صفحه آزمون‌ها (FA)</label>
                        <textarea name="quizzes_desc_fa" rows="2" class="w-full bg-brand-dark border border-white/10 rounded-xl p-3 text-xs text-white">{{ $settings['quizzes_desc_fa'] ?? 'آزمون مورد نظر خود را انتخاب کنید و سطح دانش زبانی خود را با سؤالات استاندارد بسنجید.' }}</textarea>
                    </div>
                    <div class="space-y-1 sm:col-span-2">
                        <label class="text-[11px] text-brand-slate font-bold">Description (EN)</label>
                        <textarea name="quizzes_desc_en" dir="ltr" rows="2" class="w-full bg-brand-dark border border-white/10 rounded-xl p-3 text-xs text-white">{{ $settings['quizzes_desc_en'] ?? 'Select a quiz below and evaluate your language proficiency with standardized questions.' }}</textarea>
                    </div>
                </div>
            </div>
        </div>

        <!-- تب ۵: متون صفحه درباره من -->
        <div x-show="activeTab === 'about'" x-transition class="space-y-6">
            <div class="glass-card p-6 rounded-3xl border border-white/5 space-y-4">
                <h3 class="text-sm font-bold text-brand-gold border-b border-white/5 pb-3">اطلاعات بیوگرافی و رزومه</h3>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div class="space-y-1">
                        <label class="text-[11px] text-brand-slate font-bold">بج روی تصویر پروفایل (FA)</label>
                        <input type="text" name="about_teacher_badge_fa" value="{{ $settings['about_teacher_badge_fa'] ?? 'مؤلف و مدرس زبان' }}" class="w-full bg-brand-dark border border-white/10 rounded-xl px-4 py-2 text-xs text-white" />
                    </div>
                    <div class="space-y-1">
                        <label class="text-[11px] text-brand-slate font-bold">Badge (EN)</label>
                        <input type="text" name="about_teacher_badge_en" dir="ltr" value="{{ $settings['about_teacher_badge_en'] ?? 'AUTHOR & INSTRUCTOR' }}" class="w-full bg-brand-dark border border-white/10 rounded-xl px-4 py-2 text-xs text-white" />
                    </div>

                    <div class="space-y-1">
                        <label class="text-[11px] text-brand-slate font-bold">نام استاد (FA)</label>
                        <input type="text" name="about_teacher_name_fa" value="{{ $settings['about_teacher_name_fa'] ?? 'یاشیل رزمیان‌زاده' }}" class="w-full bg-brand-dark border border-white/10 rounded-xl px-4 py-2 text-xs text-white" />
                    </div>
                    <div class="space-y-1">
                        <label class="text-[11px] text-brand-slate font-bold">Teacher Name (EN)</label>
                        <input type="text" name="about_teacher_name_en" dir="ltr" value="{{ $settings['about_teacher_name_en'] ?? 'Yashil Razmiyanzadeh' }}" class="w-full bg-brand-dark border border-white/10 rounded-xl px-4 py-2 text-xs text-white" />
                    </div>

                    <div class="space-y-1">
                        <label class="text-[11px] text-brand-slate font-bold">عنوان شغلی و تخصص (FA)</label>
                        <input type="text" name="about_teacher_role_fa" value="{{ $settings['about_teacher_role_fa'] ?? 'مدرس تخصصی آیلتس، تافل و زبان عمومی' }}" class="w-full bg-brand-dark border border-white/10 rounded-xl px-4 py-2 text-xs text-white" />
                    </div>
                    <div class="space-y-1">
                        <label class="text-[11px] text-brand-slate font-bold">Teacher Role (EN)</label>
                        <input type="text" name="about_teacher_role_en" dir="ltr" value="{{ $settings['about_teacher_role_en'] ?? 'Specialized IELTS, TOEFL & General English Instructor' }}" class="w-full bg-brand-dark border border-white/10 rounded-xl px-4 py-2 text-xs text-white" />
                    </div>

                    <div class="space-y-1 sm:col-span-2">
                        <label class="text-[11px] text-brand-slate font-bold">متن کامل بیوگرافی (FA)</label>
                        <textarea name="about_teacher_bio_fa" rows="3" class="w-full bg-brand-dark border border-white/10 rounded-xl p-3 text-xs text-white">{{ $settings['about_teacher_bio_fa'] ?? 'من یاشیل رزمیان‌زاده هستم. سال‌هاست که مسیر تدریس زبان انگلیسی را با هدف ایجاد تغییرات بنیادین در شیوه یادگیری زبان‌آموزان انتخاب کرده‌ام. پلتفرم LINGORAX نتیجه تلاش من برای ارائه منابع استاندارد، مقالات تحلیلی عمیق و کوئیزهای هدفمند است تا مسیر رسیدن به نمرات برتر بین‌المللی را برای شما هموارتر کنم.' }}</textarea>
                    </div>
                    <div class="space-y-1 sm:col-span-2">
                        <label class="text-[11px] text-brand-slate font-bold">Full Biography (EN)</label>
                        <textarea name="about_teacher_bio_en" dir="ltr" rows="3" class="w-full bg-brand-dark border border-white/10 rounded-xl p-3 text-xs text-white">{{ $settings['about_teacher_bio_en'] ?? 'I am Yashil Razmiyanzadeh. For years, I have dedicated myself to transforming how students learn English. LINGORAX is the culmination of my effort to provide standard resources, in-depth analytical articles, and targeted quizzes to pave your way toward achieving top international scores.' }}</textarea>
                    </div>
                </div>
            </div>

            <!-- آمار ۴ گانه -->
            <div class="glass-card p-6 rounded-3xl border border-white/5 space-y-4">
                <h3 class="text-sm font-bold text-brand-gold border-b border-white/5 pb-3">آمار چهارگانه (Statistics)</h3>
                <div class="grid grid-cols-1 sm:grid-cols-4 gap-4">
                    <div class="space-y-1">
                        <label class="text-[11px] text-brand-slate font-bold">مقدار آمار ۱</label>
                        <input type="text" name="about_stat1_val" value="{{ $settings['about_stat1_val'] ?? '+8' }}" class="w-full bg-brand-dark border border-white/10 rounded-xl px-3 py-2 text-xs text-white" />
                        <input type="text" name="about_stat1_lbl_fa" placeholder="برچسب فارسی" value="{{ $settings['about_stat1_lbl_fa'] ?? 'سال سابقه تدریس' }}" class="w-full bg-brand-dark border border-white/10 rounded-xl px-3 py-2 text-xs text-white mt-1" />
                        <input type="text" name="about_stat1_lbl_en" dir="ltr" placeholder="Label EN" value="{{ $settings['about_stat1_lbl_en'] ?? 'Years Experience' }}" class="w-full bg-brand-dark border border-white/10 rounded-xl px-3 py-2 text-xs text-white mt-1" />
                    </div>

                    <div class="space-y-1">
                        <label class="text-[11px] text-brand-slate font-bold">مقدار آمار ۲</label>
                        <input type="text" name="about_stat2_val" value="{{ $settings['about_stat2_val'] ?? '+1000' }}" class="w-full bg-brand-dark border border-white/10 rounded-xl px-3 py-2 text-xs text-white" />
                        <input type="text" name="about_stat2_lbl_fa" placeholder="برچسب فارسی" value="{{ $settings['about_stat2_lbl_fa'] ?? 'زبان‌آموز موفق' }}" class="w-full bg-brand-dark border border-white/10 rounded-xl px-3 py-2 text-xs text-white mt-1" />
                        <input type="text" name="about_stat2_lbl_en" dir="ltr" placeholder="Label EN" value="{{ $settings['about_stat2_lbl_en'] ?? 'Successful Students' }}" class="w-full bg-brand-dark border border-white/10 rounded-xl px-3 py-2 text-xs text-white mt-1" />
                    </div>

                    <div class="space-y-1">
                        <label class="text-[11px] text-brand-slate font-bold">مقدار آمار ۳</label>
                        <input type="text" name="about_stat3_val" value="{{ $settings['about_stat3_val'] ?? '8.5' }}" class="w-full bg-brand-dark border border-white/10 rounded-xl px-3 py-2 text-xs text-white" />
                        <input type="text" name="about_stat3_lbl_fa" placeholder="برچسب فارسی" value="{{ $settings['about_stat3_lbl_fa'] ?? 'نمره آیلتس آکادمیک' }}" class="w-full bg-brand-dark border border-white/10 rounded-xl px-3 py-2 text-xs text-white mt-1" />
                        <input type="text" name="about_stat3_lbl_en" dir="ltr" placeholder="Label EN" value="{{ $settings['about_stat3_lbl_en'] ?? 'IELTS Academic Band' }}" class="w-full bg-brand-dark border border-white/10 rounded-xl px-3 py-2 text-xs text-white mt-1" />
                    </div>

                    <div class="space-y-1">
                        <label class="text-[11px] text-brand-slate font-bold">مقدار آمار ۴</label>
                        <input type="text" name="about_stat4_val" value="{{ $settings['about_stat4_val'] ?? '+50' }}" class="w-full bg-brand-dark border border-white/10 rounded-xl px-3 py-2 text-xs text-white" />
                        <input type="text" name="about_stat4_lbl_fa" placeholder="برچسب فارسی" value="{{ $settings['about_stat4_lbl_fa'] ?? 'مقاله تخصصی' }}" class="w-full bg-brand-dark border border-white/10 rounded-xl px-3 py-2 text-xs text-white mt-1" />
                        <input type="text" name="about_stat4_lbl_en" dir="ltr" placeholder="Label EN" value="{{ $settings['about_stat4_lbl_en'] ?? 'Published Articles' }}" class="w-full bg-brand-dark border border-white/10 rounded-xl px-3 py-2 text-xs text-white mt-1" />
                    </div>
                </div>
            </div>

            <!-- بخش فلسفه آموزشی -->
            <div class="glass-card p-6 rounded-3xl border border-white/5 space-y-4">
                <h3 class="text-sm font-bold text-brand-gold border-b border-white/5 pb-3">فلسفه و رویکرد آموزشی</h3>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div class="space-y-1">
                        <label class="text-[11px] text-brand-slate font-bold">عنوان بخش فلسفه (FA)</label>
                        <input type="text" name="about_philosophy_title_fa" value="{{ $settings['about_philosophy_title_fa'] ?? 'فلسفه و رویکرد آموزشی من' }}" class="w-full bg-brand-dark border border-white/10 rounded-xl px-4 py-2 text-xs text-white" />
                    </div>
                    <div class="space-y-1">
                        <label class="text-[11px] text-brand-slate font-bold">Philosophy Title (EN)</label>
                        <input type="text" name="about_philosophy_title_en" dir="ltr" value="{{ $settings['about_philosophy_title_en'] ?? 'My Teaching Philosophy' }}" class="w-full bg-brand-dark border border-white/10 rounded-xl px-4 py-2 text-xs text-white" />
                    </div>
                    <div class="space-y-1 sm:col-span-2">
                        <label class="text-[11px] text-brand-slate font-bold">پاراگراف اول فلسفه (FA)</label>
                        <textarea name="about_philosophy_p1_fa" rows="2" class="w-full bg-brand-dark border border-white/10 rounded-xl p-3 text-xs text-white">{{ $settings['about_philosophy_p1_fa'] ?? 'یادگیری زبان انگلیسی نباید به حفظ کردن طوطی‌وار گرامر و لغت محدود شود. در کلاس‌ها و مقالات من، زبان به عنوان یک ابزار ارتباطی زنده بررسی می‌شود.' }}</textarea>
                    </div>
                    <div class="space-y-1 sm:col-span-2">
                        <label class="text-[11px] text-brand-slate font-bold">Paragraph 1 (EN)</label>
                        <textarea name="about_philosophy_p1_en" dir="ltr" rows="2" class="w-full bg-brand-dark border border-white/10 rounded-xl p-3 text-xs text-white">{{ $settings['about_philosophy_p1_en'] ?? 'Learning English should not be limited to rote memorization of grammar and vocabulary. In my classes and articles, language is treated as a living communication tool.' }}</textarea>
                    </div>
                    <div class="space-y-1 sm:col-span-2">
                        <label class="text-[11px] text-brand-slate font-bold">پاراگراف دوم فلسفه (FA)</label>
                        <textarea name="about_philosophy_p2_fa" rows="2" class="w-full bg-brand-dark border border-white/10 rounded-xl p-3 text-xs text-white">{{ $settings['about_philosophy_p2_fa'] ?? 'ما در LINGORAX با تمرکز بر ارزیابی‌های مستمر و یادگیری خودآموز، تلاش می‌کنیم فرآیند آموزش را شخصی‌سازی کرده و بالاترین بازدهی را برای هر فرد به ارمغان بیاوریم.' }}</textarea>
                    </div>
                    <div class="space-y-1 sm:col-span-2">
                        <label class="text-[11px] text-brand-slate font-bold">Paragraph 2 (EN)</label>
                        <textarea name="about_philosophy_p2_en" dir="ltr" rows="2" class="w-full bg-brand-dark border border-white/10 rounded-xl p-3 text-xs text-white">{{ $settings['about_philosophy_p2_en'] ?? 'At LINGORAX, by focusing on continuous assessment and self-study, we strive to personalize the learning process and bring about the highest efficiency for each individual.' }}</textarea>
                    </div>
                </div>
            </div>
        </div>

        <!-- دکمه ثابت ذخیره -->
        <div class="sticky bottom-4 z-20">
            <button type="submit" class="w-full sm:w-auto bg-gradient-to-r from-brand-gold to-brand-goldHover text-brand-darkest font-black px-10 py-3.5 rounded-2xl text-xs shadow-glow-gold hover:scale-105 active:scale-95 transition-all">
                ذخیره کلیه تنظیمات و متون وب‌سایت
            </button>
        </div>
    </form>
</div>
@endsection