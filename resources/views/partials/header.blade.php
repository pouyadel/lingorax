<header class="border-b border-white/5 bg-brand-darkest/80 sticky top-0 z-40 backdrop-blur-xl">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-20 flex items-center justify-between">
    
    <!-- دکمه‌های تغییر زبان با ماندگاری در تمام صفحات -->
    <div class="flex items-center">
      <div class="glass-card p-1 rounded-2xl border border-white/10 flex items-center gap-1 shadow-inner">
        <button
          type="button"
          @click="setLang('fa')"
          :class="lang === 'fa' ? 'bg-gradient-to-r from-brand-gold to-brand-goldHover text-brand-darkest font-black shadow-glow-gold' : 'text-brand-slate hover:text-white font-semibold'"
          class="px-3.5 py-1.5 rounded-xl text-xs transition-all duration-300 flex items-center gap-1.5"
        >
          <span>فا</span>
        </button>
        <button
          type="button"
          @click="setLang('en')"
          :class="lang === 'en' ? 'bg-gradient-to-r from-brand-gold to-brand-goldHover text-brand-darkest font-black shadow-glow-gold' : 'text-brand-slate hover:text-white font-semibold'"
          class="px-3.5 py-1.5 rounded-xl text-xs transition-all duration-300 font-bold"
        >
          <span>EN</span>
        </button>
      </div>
    </div>

    <!-- لینک‌های منو داینامیک از دیتابیس -->
    <nav class="hidden md:flex items-center gap-8 text-sm font-semibold">
      <a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'text-brand-gold font-black' : 'text-brand-slate hover:text-brand-gold transition-colors' }}">
        <span x-show="lang === 'fa'">{{ $settings['nav_home_fa'] ?? 'صفحه اصلی' }}</span>
        <span x-show="lang === 'en'">{{ $settings['nav_home_en'] ?? 'Home' }}</span>
      </a>
      <a href="{{ route('articles') }}" class="{{ request()->routeIs('articles*') ? 'text-brand-gold font-black' : 'text-brand-slate hover:text-brand-gold transition-colors' }}">
        <span x-show="lang === 'fa'">{{ $settings['nav_articles_fa'] ?? 'مقالات آموزشی' }}</span>
        <span x-show="lang === 'en'">{{ $settings['nav_articles_en'] ?? 'Articles' }}</span>
      </a>
      <a href="{{ route('quizzes') }}" class="{{ request()->routeIs('quizzes*') ? 'text-brand-gold font-black' : 'text-brand-slate hover:text-brand-gold transition-colors' }}">
        <span x-show="lang === 'fa'">{{ $settings['nav_quizzes_fa'] ?? 'بانک آزمون‌ها' }}</span>
        <span x-show="lang === 'en'">{{ $settings['nav_quizzes_en'] ?? 'Quizzes' }}</span>
      </a>
      <a href="{{ route('about') }}" class="{{ request()->routeIs('about') ? 'text-brand-gold font-black' : 'text-brand-slate hover:text-brand-gold transition-colors' }}">
        <span x-show="lang === 'fa'">{{ $settings['nav_about_fa'] ?? 'درباره من' }}</span>
        <span x-show="lang === 'en'">{{ $settings['nav_about_en'] ?? 'About Me' }}</span>
      </a>
    </nav>

    <!-- لوگو -->
    <a href="{{ route('home') }}" class="flex items-center group">
      <img
        src="{{ asset('images/logo.png') }}"
        alt="LINGORAX Logo"
        class="h-10 sm:h-12 w-auto object-contain transition-transform duration-300 group-hover:scale-105"
      />
    </a>

  </div>
</header>