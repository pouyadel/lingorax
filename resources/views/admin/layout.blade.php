<!doctype html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'پنل مدیریت LINGORAX')</title>

    <link rel="icon" type="image/png" href="{{ asset('images/favicon.png') }}" />
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">

    <!-- استفاده از فایل‌های محلی جاوااسکریپت به جای CDN -->
    <script src="{{ asset('js/tailwindcss.js') }}"></script>
    <script defer src="{{ asset('js/alpine.min.js') }}"></script>

    <script>
      tailwind.config = {
        theme: {
          extend: {
            colors: {
              brand: {
                darkest: "#080F1D",
                dark: "#0E1A2E",
                card: "#16253F",
                cardLight: "#203456",
                gold: "#D4AF37",
                goldHover: "#BA9524",
                slate: "#94A3B8",
              }
            }
          }
        }
      }
    </script>
    @stack('styles')
</head>
<body 
    x-data="{ mobileMenuOpen: false }" 
    class="bg-[#080F1D] text-[#f8fafc] min-h-screen flex antialiased selection:bg-brand-gold selection:text-brand-darkest"
>

    <!-- پس‌زمینه تاریک هنگام باز شدن منوی موبایل -->
    <div 
        x-show="mobileMenuOpen"
        x-transition:enter="transition-opacity ease-linear duration-300"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="transition-opacity ease-linear duration-300"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        @click="mobileMenuOpen = false"
        class="fixed inset-0 bg-black/80 backdrop-blur-sm z-40 md:hidden"
        style="display: none;"
    ></div>

    <!-- سایدبار کشویی مخصوص موبایل (Off-canvas) -->
    <aside 
        x-show="mobileMenuOpen"
        x-transition:enter="transition ease-in-out duration-300 transform"
        x-transition:enter-start="translate-x-full"
        x-transition:enter-end="translate-x-0"
        x-transition:leave="transition ease-in-out duration-300 transform"
        x-transition:leave-start="translate-x-0"
        x-transition:leave-end="translate-x-full"
        class="fixed inset-y-0 right-0 z-50 w-64 bg-brand-dark border-l border-white/10 p-6 flex flex-col justify-between shadow-2xl md:hidden overflow-y-auto"
        style="display: none;"
    >
        <div class="space-y-6">
            <div class="flex items-center justify-between pb-4 border-b border-white/5">
                <div class="flex items-center gap-3">
                    <img src="{{ asset('images/logo.png') }}" class="h-8 w-auto" alt="Logo">
                    <span class="text-xs font-bold text-brand-gold">پنل مدیریت</span>
                </div>
                <button 
                    @click="mobileMenuOpen = false" 
                    type="button" 
                    class="p-1.5 text-brand-slate hover:text-white rounded-lg hover:bg-white/5 transition-colors"
                >
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <nav class="space-y-2 text-sm font-semibold">
                <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all {{ request()->routeIs('admin.dashboard') ? 'bg-brand-gold text-brand-darkest font-black shadow-glow-gold' : 'text-brand-slate hover:bg-white/5 hover:text-white' }}">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                    داشبورد
                </a>
                <a href="{{ route('admin.articles.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all {{ request()->routeIs('admin.articles.*') ? 'bg-brand-gold text-brand-darkest font-black shadow-glow-gold' : 'text-brand-slate hover:bg-white/5 hover:text-white' }}">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/></svg>
                    مدیریت مقالات
                </a>
                <a href="{{ route('admin.quizzes.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all {{ request()->routeIs('admin.quizzes.*') ? 'bg-brand-gold text-brand-darkest font-black shadow-glow-gold' : 'text-brand-slate hover:bg-white/5 hover:text-white' }}">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/></svg>
                    مدیریت آزمون‌ها
                </a>
                <a href="{{ route('admin.settings.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all {{ request()->routeIs('admin.settings.*') ? 'bg-brand-gold text-brand-darkest font-black shadow-glow-gold' : 'text-brand-slate hover:bg-white/5 hover:text-white' }}">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                    متون و تنظیمات سایت
                </a>
            </nav>
        </div>

        <a href="{{ route('home') }}" target="_blank" class="flex items-center justify-center gap-2 py-2.5 px-4 rounded-xl border border-white/10 text-xs font-bold text-brand-slate hover:text-white hover:border-brand-gold transition-all mt-6">
            نمایش وب‌سایت
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
        </a>
    </aside>

    <!-- Sidebar اصلی دسکتاپ -->
    <aside class="w-64 bg-brand-dark/95 border-l border-white/5 p-6 flex flex-col justify-between hidden md:flex sticky top-0 h-screen">
        <div class="space-y-8">
            <div class="flex items-center gap-3">
                <img src="{{ asset('images/logo.png') }}" class="h-9 w-auto" alt="Logo">
                <span class="text-xs font-bold text-brand-gold">پنل مدیریت</span>
            </div>

            <nav class="space-y-2 text-sm font-semibold">
                <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all {{ request()->routeIs('admin.dashboard') ? 'bg-brand-gold text-brand-darkest font-black shadow-glow-gold' : 'text-brand-slate hover:bg-white/5 hover:text-white' }}">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                    داشبورد
                </a>
                <a href="{{ route('admin.articles.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all {{ request()->routeIs('admin.articles.*') ? 'bg-brand-gold text-brand-darkest font-black shadow-glow-gold' : 'text-brand-slate hover:bg-white/5 hover:text-white' }}">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/></svg>
                    مدیریت مقالات
                </a>
                <a href="{{ route('admin.quizzes.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all {{ request()->routeIs('admin.quizzes.*') ? 'bg-brand-gold text-brand-darkest font-black shadow-glow-gold' : 'text-brand-slate hover:bg-white/5 hover:text-white' }}">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/></svg>
                    مدیریت آزمون‌ها
                </a>
                <a href="{{ route('admin.settings.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all {{ request()->routeIs('admin.settings.*') ? 'bg-brand-gold text-brand-darkest font-black shadow-glow-gold' : 'text-brand-slate hover:bg-white/5 hover:text-white' }}">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                    متون و تنظیمات سایت
                </a>
            </nav>
        </div>

        <a href="{{ route('home') }}" target="_blank" class="flex items-center justify-center gap-2 py-2.5 px-4 rounded-xl border border-white/10 text-xs font-bold text-brand-slate hover:text-white hover:border-brand-gold transition-all">
            نمایش وب‌سایت
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
        </a>
    </aside>

    <!-- ناحیه محتوای اصلی -->
    <div class="flex-1 flex flex-col min-w-0">
        <!-- هدر بالا با دکمه همبرگری موبایل -->
        <header class="h-16 border-b border-white/5 px-4 sm:px-6 flex items-center justify-between bg-brand-dark/50 sticky top-0 z-20 backdrop-blur-md">
            <div class="flex items-center gap-3">
                <button 
                    @click="mobileMenuOpen = true" 
                    type="button" 
                    class="p-2 rounded-xl bg-white/5 text-brand-gold border border-white/10 hover:bg-white/10 focus:outline-none md:hidden"
                    aria-label="باز کردن منو"
                >
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>
                <h2 class="text-xs sm:text-sm font-bold text-white">@yield('page-title', 'پنل ادمین')</h2>
            </div>
            <div class="text-[11px] sm:text-xs text-brand-slate">خوش آمدید، مدیر سایت</div>
        </header>

        <!-- پیام‌های سیستم -->
        @if(session('success'))
            <div class="m-4 sm:m-6 mb-0 p-3.5 sm:p-4 rounded-2xl bg-emerald-500/10 border border-emerald-500/30 text-emerald-400 text-xs font-bold">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="m-4 sm:m-6 mb-0 p-3.5 sm:p-4 rounded-2xl bg-red-500/10 border border-red-500/30 text-red-400 text-xs font-bold">
                {{ session('error') }}
            </div>
        @endif

        @if($errors->any())
            <div class="m-4 sm:m-6 mb-0 p-3.5 sm:p-4 rounded-2xl bg-red-500/10 border border-red-500/30 text-red-400 text-xs font-bold space-y-1">
                @foreach($errors->all() as $err)
                    <p>• {{ $err }}</p>
                @endforeach
            </div>
        @endif

        <main class="p-4 sm:p-6 flex-1">
            @yield('content')
        </main>
    </div>

    @stack('scripts')
</body>
</html>