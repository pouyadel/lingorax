@extends('layouts.app')

@section('title', 'LINGORAX | English Hub & Online Assessment')

@section('content')
<div x-data="homePage()" class="space-y-14 sm:space-y-20 py-8 sm:py-12">

  <!-- TOAST NOTIFICATION -->
  <div
    x-show="toast"
    x-transition:enter="transition ease-out duration-300 transform"
    x-transition:enter-start="-translate-y-6 opacity-0"
    x-transition:enter-end="translate-y-0 opacity-100"
    x-transition:leave="transition ease-in duration-200 transform"
    x-transition:leave-start="translate-y-0 opacity-100"
    x-transition:leave-end="-translate-y-6 opacity-0"
    class="fixed top-6 left-1/2 -translate-x-1/2 z-50 glass-card bg-brand-dark/95 text-white px-5 py-3 rounded-2xl shadow-glow-gold border border-brand-gold/40 flex items-center gap-3 text-sm font-bold text-center"
    style="display: none;"
  >
    <div class="w-6 h-6 rounded-full bg-brand-gold/20 flex items-center justify-center text-brand-gold flex-shrink-0">
      <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
      </svg>
    </div>
    <span x-text="toastMsg"></span>
  </div>

  <!-- HERO SECTION -->
  <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative">
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-10 lg:gap-14 items-center">
      
      <div class="lg:col-span-7 space-y-6 text-center" :class="lang === 'fa' ? 'lg:text-right' : 'lg:text-left'">
        
        <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full glass-card border-brand-gold/25 text-xs text-brand-goldLight font-semibold">
          <span class="relative flex h-2 w-2">
            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-brand-gold opacity-75"></span>
            <span class="relative inline-flex rounded-full h-2 w-2 bg-brand-gold"></span>
          </span>
          <span x-show="lang === 'fa'">{{ $settings['hero_badge_fa'] ?? 'انگلیسی رو دقیق تر یاد بگیر، حرفه ای تر استفاده کن' }}</span>
          <span x-show="lang === 'en'">{{ $settings['hero_badge_en'] ?? 'Master English with Precision, Apply It Professionally' }}</span>
        </div>

        <h1 class="font-black text-white text-3xl sm:text-5xl lg:text-6xl leading-tight lg:leading-[1.15]">
          <span class="block" x-text="t.heroTitle1[lang]"></span>
          <span class="text-gold-gradient relative inline-block mt-1">
            <span x-text="t.heroTitle2[lang]"></span>
            <svg class="absolute -bottom-2 right-0 w-full text-brand-gold/40" viewBox="0 0 100 10" preserveAspectRatio="none" height="8">
              <path d="M0,5 Q50,10 100,5" stroke="currentColor" stroke-width="4" fill="transparent"/>
            </svg>
          </span>
        </h1>
        
        <p class="text-brand-slate text-sm sm:text-base lg:text-lg max-w-2xl mx-auto leading-relaxed font-normal" :class="lang === 'fa' ? 'lg:mx-0' : 'lg:mx-0'">
          <span x-show="lang === 'fa'">{{ $settings['hero_desc_fa'] ?? 'دسترسی به مقالات تخصصی، نکات آزمون‌های بین‌المللی و کوئیزهای موضوعی با بررسی آنی پاسخ‌ها و بدون نیاز به فرآیندهای پیچیده.' }}</span>
          <span x-show="lang === 'en'">{{ $settings['hero_desc_en'] ?? 'Explore expert educational articles, international exam strategies, and interactive quizzes with instant performance feedback.' }}</span>
        </p>

        <!-- فرم عضویت خبرنامه -->
        <div class="pt-3 max-w-md mx-auto" :class="lang === 'fa' ? 'lg:mx-0' : 'lg:mx-0'">
          <form @submit.prevent="submitNewsletter" class="glass-card p-1.5 rounded-2xl flex items-center gap-2 focus-within:border-brand-gold/60 focus-within:ring-1 focus-within:ring-brand-gold/40 transition-all shadow-xl">
            <input
              type="text"
              x-model="phoneInput"
              dir="ltr"
              :placeholder="t.newsletterPlaceholder[lang]"
              class="bg-transparent px-4 py-2.5 w-full text-sm text-white placeholder-brand-muted/70 focus:outline-none font-semibold"
              :class="lang === 'fa' ? 'text-right' : 'text-left'"
            />
            <button
              type="submit"
              class="bg-gradient-to-r from-brand-gold to-brand-goldHover text-brand-darkest hover:shadow-glow-gold active:scale-95 text-xs sm:text-sm font-extrabold px-6 py-2.5 rounded-xl transition-all whitespace-nowrap"
              x-text="t.newsletterBtn[lang]"
            ></button>
          </form>
          <p class="text-[11px] text-brand-slate/80 mt-2 pr-1" x-text="t.newsletterSub[lang]"></p>
        </div>

      </div>

      <!-- کاور و پخش‌کننده ویدیو -->
      <div class="lg:col-span-5 flex justify-center">
        <div class="relative w-full max-w-md">
          <div class="absolute -inset-1.5 bg-gradient-to-r from-brand-gold/30 to-sky-500/20 rounded-3xl blur-2xl opacity-60"></div>
          
          <div
            @click="videoModal = true; $nextTick(() => $refs.mainVideo?.play())"
            class="relative aspect-[4/3] rounded-3xl glass-card overflow-hidden cursor-pointer group border border-white/10 hover:border-brand-gold/50 transition-all duration-300"
          >
            <img
              src="{{ asset('images/image.png') }}"
              alt="Video Cover"
              class="absolute inset-0 w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
            />
            <div class="absolute inset-0 bg-gradient-to-t from-brand-darkest via-brand-dark/40 to-black/30 z-10"></div>
            
            <div class="absolute inset-0 flex items-center justify-center z-20">
              <div class="w-16 h-16 rounded-full bg-brand-gold text-brand-darkest flex items-center justify-center shadow-glow-gold group-hover:scale-110 transition-transform">
                <svg class="h-8 w-8 mr-0.5" fill="currentColor" viewBox="0 0 24 24">
                  <path d="M8 5v14l11-7z" />
                </svg>
              </div>
            </div>
            
            <div class="absolute bottom-4 right-4 left-4 flex items-center justify-between z-20">
              <span class="text-xs font-bold text-white drop-shadow" x-text="t.videoIntro[lang]"></span>
              <span class="bg-black/60 backdrop-blur-md px-2.5 py-1 rounded-lg text-[11px] font-bold text-brand-gold border border-white/10" x-text="num('02:15')"></span>
            </div>
          </div>
        </div>
      </div>

    </div>
  </section>

  <!-- VALUE PILLARS (ستون‌های ارزش سه‌گانه) -->
  <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 sm:gap-6">
      
      <div class="glass-card glass-card-hover p-6 rounded-3xl flex items-start gap-4 border border-white/5 relative overflow-hidden group">
        <div class="w-12 h-12 rounded-2xl bg-brand-gold/10 border border-brand-gold/30 text-brand-gold flex items-center justify-center flex-shrink-0 group-hover:bg-brand-gold group-hover:text-brand-darkest transition-all duration-300">
          <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
          </svg>
        </div>
        <div class="space-y-1.5">
          <h3 class="text-white font-bold text-base font-heading" x-text="t.pillar1Title[lang]"></h3>
          <p class="text-brand-slate text-xs sm:text-sm leading-relaxed" x-text="t.pillar1Desc[lang]"></p>
        </div>
        <div class="absolute inset-x-0 bottom-0 h-0.5 bg-gradient-to-r from-transparent via-brand-gold/40 to-transparent opacity-0 group-hover:opacity-100 transition-opacity"></div>
      </div>

      <div class="glass-card glass-card-hover p-6 rounded-3xl flex items-start gap-4 border border-white/5 relative overflow-hidden group">
        <div class="w-12 h-12 rounded-2xl bg-brand-gold/10 border border-brand-gold/30 text-brand-gold flex items-center justify-center flex-shrink-0 group-hover:bg-brand-gold group-hover:text-brand-darkest transition-all duration-300">
          <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
          </svg>
        </div>
        <div class="space-y-1.5">
          <h3 class="text-white font-bold text-base font-heading" x-text="t.pillar2Title[lang]"></h3>
          <p class="text-brand-slate text-xs sm:text-sm leading-relaxed" x-text="t.pillar2Desc[lang]"></p>
        </div>
        <div class="absolute inset-x-0 bottom-0 h-0.5 bg-gradient-to-r from-transparent via-brand-gold/40 to-transparent opacity-0 group-hover:opacity-100 transition-opacity"></div>
      </div>

      <div class="glass-card glass-card-hover p-6 rounded-3xl flex items-start gap-4 border border-white/5 relative overflow-hidden group">
        <div class="w-12 h-12 rounded-2xl bg-brand-gold/10 border border-brand-gold/30 text-brand-gold flex items-center justify-center flex-shrink-0 group-hover:bg-brand-gold group-hover:text-brand-darkest transition-all duration-300">
          <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M13 10V3L4 14h7v7l9-11h-7z"/>
          </svg>
        </div>
        <div class="space-y-1.5">
          <h3 class="text-white font-bold text-base font-heading" x-text="t.pillar3Title[lang]"></h3>
          <p class="text-brand-slate text-xs sm:text-sm leading-relaxed" x-text="t.pillar3Desc[lang]"></p>
        </div>
        <div class="absolute inset-x-0 bottom-0 h-0.5 bg-gradient-to-r from-transparent via-brand-gold/40 to-transparent opacity-0 group-hover:opacity-100 transition-opacity"></div>
      </div>

    </div>
  </section>

  <!-- ARTICLES SECTION -->
  <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">
    <div class="flex items-center justify-between border-b border-white/5 pb-4">
      <div class="flex items-center gap-3">
        <span class="w-2 h-7 bg-brand-gold rounded-full"></span>
        <h2 class="text-xl sm:text-2xl font-black text-white font-heading" x-text="t.articlesTitle[lang]"></h2>
      </div>
      
      <a href="{{ route('articles') }}" class="inline-flex items-center gap-1.5 text-xs sm:text-sm text-brand-gold hover:text-brand-goldLight font-bold group transition-colors">
        <span x-text="t.articlesArchive[lang]"></span>
        <svg
          class="w-4 h-4 transition-transform group-hover:translate-x-[-2px] flex-shrink-0"
          :class="lang === 'en' ? 'rotate-180 group-hover:translate-x-[2px]' : ''"
          fill="none"
          viewBox="0 0 24 24"
          stroke="currentColor"
        >
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M19 12H5m7 7l-7-7 7-7"/>
        </svg>
      </a>
    </div>

    <!-- گرید واکنش‌گرا و اسکرول اسنپ در موبایل -->
    <div class="flex sm:grid sm:grid-cols-3 gap-5 overflow-x-auto sm:overflow-visible no-scrollbar snap-x snap-mandatory -mx-4 px-4 sm:mx-0 sm:px-0">
      
      @forelse($latestArticles as $art)
        <article class="min-w-[280px] max-w-[320px] sm:min-w-0 sm:max-w-none flex-shrink-0 snap-center glass-card glass-card-hover rounded-3xl overflow-hidden flex flex-col justify-between group">
          <div>
            <div class="relative h-48 w-full overflow-hidden bg-brand-card">
              <img
                src="{{ $art->image ? asset('storage/' . $art->image) : asset('images/placeholder.png') }}"
                alt="{{ $art->title_en }}"
                class="w-full h-full object-cover object-center transition-transform duration-500 group-hover:scale-105"
              />
              <div class="absolute inset-0 bg-gradient-to-t from-brand-card/80 via-transparent to-black/20"></div>
              <span class="absolute top-3 right-3 bg-brand-gold text-brand-darkest text-[10px] font-black px-2.5 py-1 rounded-lg shadow-md backdrop-blur-sm z-10">
                <span x-text="lang === 'fa' ? 'سطح ' + num('{{ $art->level }}') : 'Level {{ $art->level }}'"></span>
              </span>
            </div>
            <div class="p-5 space-y-3">
              <h3 class="text-base font-bold text-white leading-snug font-heading">
                <span x-show="lang === 'fa'">{{ $art->title_fa }}</span>
                <span x-show="lang === 'en'">{{ $art->title_en }}</span>
              </h3>
              <p class="text-brand-slate text-xs leading-relaxed line-clamp-2">
                <span x-show="lang === 'fa'">{{ $art->excerpt_fa }}</span>
                <span x-show="lang === 'en'">{{ $art->excerpt_en }}</span>
              </p>
            </div>
          </div>
          <div class="p-5 pt-0">
            <a href="{{ route('articles.show', $art) }}" class="block text-center bg-brand-cardLight/80 hover:bg-brand-gold hover:text-brand-darkest text-white text-xs font-bold py-2.5 rounded-xl transition-all" x-text="t.articleRead[lang]"></a>
          </div>
        </article>
      @empty
        <!-- کارت‌های پیش‌فرض در صورت خالی بودن دیتابیس -->
        <article class="min-w-[280px] max-w-[320px] sm:min-w-0 sm:max-w-none flex-shrink-0 snap-center glass-card glass-card-hover rounded-3xl overflow-hidden flex flex-col justify-between group">
          <div>
            <div class="relative h-48 w-full overflow-hidden bg-brand-card">
              <img src="{{ asset('images/image.png') }}" alt="Article" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" />
              <span class="absolute top-3 right-3 bg-brand-gold text-brand-darkest text-[10px] font-black px-2.5 py-1 rounded-lg shadow-md z-10">Level B2 - C1</span>
            </div>
            <div class="p-5 space-y-3">
              <h3 class="text-base font-bold text-white leading-snug font-heading" x-text="t.art1Title[lang]"></h3>
              <p class="text-brand-slate text-xs leading-relaxed line-clamp-2" x-text="t.art1Desc[lang]"></p>
            </div>
          </div>
          <div class="p-5 pt-0">
            <a href="{{ route('articles') }}" class="block text-center bg-brand-cardLight/80 hover:bg-brand-gold hover:text-brand-darkest text-white text-xs font-bold py-2.5 rounded-xl transition-all" x-text="t.articleRead[lang]"></a>
          </div>
        </article>
      @endforelse

    </div>
  </section>

  <!-- ONLINE QUIZZES SECTION -->
  <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">
    <div class="flex items-center justify-between border-b border-white/5 pb-4">
      <div class="flex items-center gap-3">
        <span class="w-2 h-7 bg-brand-gold rounded-full"></span>
        <div>
          <h2 class="text-xl sm:text-2xl font-black text-white font-heading" x-text="t.quizzesTitle[lang]"></h2>
          <p class="text-brand-slate text-xs mt-0.5 hidden sm:block" x-text="t.quizzesSub[lang]"></p>
        </div>
      </div>
      
      <a href="{{ route('quizzes') }}" class="inline-flex items-center gap-1.5 text-xs sm:text-sm text-brand-gold hover:text-brand-goldLight font-bold group transition-colors whitespace-nowrap">
        <span x-text="t.quizzesArchive[lang]"></span>
        <svg
          class="w-4 h-4 transition-transform group-hover:translate-x-[-2px] flex-shrink-0"
          :class="lang === 'en' ? 'rotate-180 group-hover:translate-x-[2px]' : ''"
          fill="none"
          viewBox="0 0 24 24"
          stroke="currentColor"
        >
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M19 12H5m7 7l-7-7 7-7"/>
        </svg>
      </a>
    </div>

    <!-- گرید کوئیزها با اسکرول افقی روی موبایل -->
    <div class="flex sm:grid sm:grid-cols-2 lg:grid-cols-4 gap-4 overflow-x-auto sm:overflow-visible no-scrollbar snap-x snap-mandatory -mx-4 px-4 sm:mx-0 sm:px-0">
      
      @forelse($latestQuizzes as $q)
        <div class="min-w-[220px] sm:min-w-0 flex-shrink-0 snap-center glass-card glass-card-hover p-6 rounded-3xl text-center space-y-4 flex flex-col justify-between">
          <div class="space-y-3">
            <div class="w-12 h-12 rounded-2xl bg-brand-gold/10 border border-brand-gold/30 text-brand-gold flex items-center justify-center mx-auto text-lg font-black font-heading">
              <span x-text="num('{{ str_pad($loop->iteration, 2, '0', STR_PAD_LEFT) }}')"></span>
            </div>
            <h3 class="font-bold text-white text-base font-heading">
              <span x-show="lang === 'fa'">{{ $q->title_fa }}</span>
              <span x-show="lang === 'en'">{{ $q->title_en }}</span>
            </h3>
            <span class="text-[11px] text-brand-slate block bg-white/5 py-1 px-2.5 rounded-full">
              <span x-text="lang === 'fa' ? 'سطح ' + num('{{ $q->level }}') : 'Level {{ $q->level }}'"></span>
            </span>
          </div>
          <a href="{{ route('quizzes') }}" class="block w-full bg-gradient-to-r from-brand-cardLight to-brand-card hover:from-brand-gold hover:to-brand-goldHover hover:text-brand-darkest text-xs font-extrabold py-2.5 rounded-xl transition-all shadow" x-text="t.quizEnter[lang]"></a>
        </div>
      @empty
        <!-- کوئیزهای نمونه در صورت نبود داده در دیتابیس -->
        <div class="min-w-[220px] sm:min-w-0 flex-shrink-0 snap-center glass-card glass-card-hover p-6 rounded-3xl text-center space-y-4 flex flex-col justify-between">
          <div class="space-y-3">
            <div class="w-12 h-12 rounded-2xl bg-brand-gold/10 border border-brand-gold/30 text-brand-gold flex items-center justify-center mx-auto text-lg font-black font-heading">
              <span x-text="num('01')"></span>
            </div>
            <h3 class="font-bold text-white text-base font-heading" x-text="t.quiz1Title[lang]"></h3>
            <span class="text-[11px] text-brand-slate block bg-white/5 py-1 px-2.5 rounded-full">Level A1 - C2</span>
          </div>
          <a href="{{ route('quizzes') }}" class="block w-full bg-gradient-to-r from-brand-cardLight to-brand-card hover:from-brand-gold hover:to-brand-goldHover hover:text-brand-darkest text-xs font-extrabold py-2.5 rounded-xl transition-all shadow" x-text="t.quizEnter[lang]"></a>
        </div>
      @endforelse

    </div>
  </section>

  <!-- ABOUT INSTRUCTOR (معرفی استاد) -->
  <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="glass-card rounded-3xl p-6 sm:p-10 border border-white/10 relative overflow-hidden">
      <div class="grid grid-cols-1 md:grid-cols-12 gap-6 sm:gap-10 items-center">
        
        <div class="md:col-span-4 flex justify-center">
          <div class="relative group">
            <div class="w-36 h-36 sm:w-48 sm:h-48 rounded-3xl bg-gradient-to-tr from-brand-card to-brand-cardLight border-2 border-brand-gold/40 overflow-hidden shadow-glow-gold flex items-center justify-center">
              <img
                src="{{ asset('images/image.png') }}"
                alt="Instructor"
                class="w-full h-full object-cover object-top transition-transform duration-500 group-hover:scale-105"
              />
            </div>
            <div class="absolute -bottom-3 right-1/2 translate-x-1/2 bg-brand-gold text-brand-darkest text-[10px] font-black px-3 py-1 rounded-full shadow whitespace-nowrap" x-text="t.teacherBadge[lang]"></div>
          </div>
        </div>

        <div class="md:col-span-8 space-y-4 text-center" :class="lang === 'fa' ? 'md:text-right' : 'md:text-left'">
          <div>
            <h2 class="text-2xl sm:text-3xl font-black text-white font-heading">
              <span x-show="lang === 'fa'">{{ $settings['teacher_name_fa'] ?? 'یاشیل رزمیان‌زاده' }}</span>
              <span x-show="lang === 'en'">{{ $settings['teacher_name_en'] ?? 'Yashil Razmiyanzadeh' }}</span>
            </h2>
            <p class="text-xs sm:text-sm text-brand-gold font-semibold mt-1">
              <span x-show="lang === 'fa'">{{ $settings['teacher_role_fa'] ?? 'مدرس و مؤلف مقالات تخصصی زبان انگلیسی و آمادگی آیلتس و تافل' }}</span>
              <span x-show="lang === 'en'">{{ $settings['teacher_role_en'] ?? 'English Lecturer, Author & IELTS & TOEFL Specialist' }}</span>
            </p>
          </div>
          <p class="text-brand-slate text-xs sm:text-sm leading-relaxed">
            <span x-show="lang === 'fa'">{{ $settings['teacher_bio_full_fa'] ?? 'این وب‌سایت به عنوان پایگاه شخصی جهت اشتراک‌گذاری تجربیات آموزشی، مقالات تحلیلی زبان و کوئیزهای استاندارد برای تقویت مهارت زبان‌آموزان راه‌اندازی شده است.' }}</span>
            <span x-show="lang === 'en'">{{ $settings['teacher_bio_full_en'] ?? 'This platform serves as a dedicated personal hub to share pedagogical insights, specialized English articles, and structured online quizzes for motivated learners.' }}</span>
          </p>
          <div class="pt-2">
            <a
              href="{{ route('about') }}"
              class="inline-flex items-center gap-2 border border-brand-gold/40 text-brand-gold hover:bg-brand-gold hover:text-brand-darkest px-5 py-2.5 rounded-xl text-xs sm:text-sm font-bold transition-all active:scale-95"
            >
              <span x-text="t.teacherBtn[lang]"></span>
              <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
              </svg>
            </a>
          </div>
        </div>

      </div>
    </div>
  </section>

  <!-- VIDEO MODAL -->
  <div
    x-show="videoModal"
    x-transition:enter="transition ease-out duration-300"
    x-transition:enter-start="opacity-0"
    x-transition:enter-end="opacity-100"
    x-transition:leave="transition ease-in duration-200"
    x-transition:leave-start="opacity-100"
    x-transition:leave-end="opacity-0"
    class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/80 backdrop-blur-md"
    style="display: none;"
  >
    <div
      @click.away="videoModal = false"
      class="glass-card bg-brand-darkest/95 border border-brand-gold/30 rounded-3xl p-5 sm:p-7 w-full max-w-2xl space-y-4 shadow-2xl relative"
    >
      <div class="flex items-center justify-between pb-3 border-b border-white/10">
        <h3 class="font-bold text-white text-base" x-text="t.modalTitle[lang]"></h3>
        <button @click="videoModal = false" class="text-brand-slate hover:text-white p-1 rounded-lg hover:bg-white/5 transition-colors">
          <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
          </svg>
        </button>
      </div>

      <div class="aspect-video bg-black rounded-2xl overflow-hidden border border-white/10">
        <template x-if="videoModal">
          <iframe
            src="{{ $settings['intro_video_url'] ?? 'https://www.aparat.com/video/video/embed/videohash/ketf724/vt/frame' }}"
            class="w-full h-full border-0"
            allowFullScreen="true"
            webkitallowfullscreen="true"
            mozallowfullscreen="true"
          ></iframe>
        </template>
      </div>
    </div>
  </div>

</div>
@endsection

@push('scripts')
<script>
function homePage() {
  return {
    videoModal: false,
    toast: false,
    toastMsg: '',
    phoneInput: '',
    t: {
      heroTitle1: { 
        fa: "{{ $settings['home_title1_fa'] ?? 'آموزش و ارزیابی زبان،' }}", 
        en: "{{ $settings['home_title1_en'] ?? 'English Learning & Assessment,' }}" 
      },
      heroTitle2: { 
        fa: "{{ $settings['home_title2_fa'] ?? 'کاربردی و هدفمند' }}", 
        en: "{{ $settings['home_title2_en'] ?? 'Practical & Goal-Oriented' }}" 
      },
      newsletterBtn: { fa: 'عضویت در خبرنامه', en: 'Subscribe' },
      newsletterSub: { fa: 'دریافت پیامک هنگام انتشار کوئیزها و مقالات جدید', en: 'Get instant notifications when new quizzes and articles are published' },
      newsletterPlaceholder: { fa: '۰۹۱۲...', en: '0912...' },
      videoIntro: { fa: 'ویدیوی معرفی', en: 'Intro Video' },
      modalTitle: { fa: 'ویدئوی معرفی', en: 'Intro Video Overview' },
      
      // سه ستون ارزش‌ها
      pillar1Title: { 
        fa: "{{ $settings['home_pillar1_title_fa'] ?? 'سنجش هوشمند و تحلیلی' }}", 
        en: "{{ $settings['home_pillar1_title_en'] ?? 'Smart Assessment' }}" 
      },
      pillar1Desc: { 
        fa: "{{ $settings['home_pillar1_desc_fa'] ?? 'کوئیزهای استاندارد با محاسبه آنی نمره و ارائه پاسخ تشریحی برای هر سوال' }}", 
        en: "{{ $settings['home_pillar1_desc_en'] ?? 'Standardized quizzes with real-time scoring and comprehensive answer explanations.' }}" 
      },
      pillar2Title: { 
        fa: "{{ $settings['home_pillar2_title_fa'] ?? 'مقالات هدفمند و خودآموز' }}", 
        en: "{{ $settings['home_pillar2_title_en'] ?? 'Self-Study Articles' }}" 
      },
      pillar2Desc: { 
        fa: "{{ $settings['home_pillar2_desc_fa'] ?? 'مطالب آموزشی دسته‌بندی‌شده بر اساس سطوح زبانی استاندارد (A1 تا C2)' }}", 
        en: "{{ $settings['home_pillar2_desc_en'] ?? 'Curated articles categorized by international CEFR language levels (A1 to C2).' }}" 
      },
      pillar3Title: { 
        fa: "{{ $settings['home_pillar3_title_fa'] ?? 'دسترسی آزاد و سریع' }}", 
        en: "{{ $settings['home_pillar3_title_en'] ?? 'Direct Access' }}" 
      },
      pillar3Desc: { 
        fa: "{{ $settings['home_pillar3_desc_fa'] ?? 'استفاده مستقیم از آزمون‌ها و بانک لغات بدون موانع و فرآیندهای طولانی' }}", 
        en: "{{ $settings['home_pillar3_desc_en'] ?? 'Instant engagement with learning modules and tests with zero friction.' }}" 
      },
      
      articlesTitle: { fa: 'جدیدترین مقالات آموزشی', en: 'Latest Educational Articles' },
      articlesArchive: { fa: 'آرشیو مقالات', en: 'Article Archive' },
      articleRead: { fa: 'مطالعه کامل', en: 'Read Article' },
      
      quizzesTitle: { fa: 'بانک آزمون‌ها و کوئیزهای آنلاین', en: 'Online Quiz Bank' },
      quizzesSub: { fa: 'سطح دانش زبانی خود را با کوئیزهای استاندارد و پاسخ تشریحی محک بزنید', en: 'Evaluate your language proficiency with standard tests and in-depth answer keys' },
      quizzesArchive: { fa: 'آرشیو آزمون‌ها', en: 'Quiz Archive' },
      quizEnter: { fa: 'ورود به آزمون', en: 'Take Quiz' },
      
      teacherBadge: { 
        fa: "{{ $settings['about_teacher_badge_fa'] ?? 'مؤلف و مدرس زبان' }}", 
        en: "{{ $settings['about_teacher_badge_en'] ?? 'AUTHOR & INSTRUCTOR' }}" 
      },
      teacherBtn: { fa: 'مشاهده سوابق و رزومه من', en: 'View Full Resume / CV' },
      
      toastSuccess: { fa: 'شماره شما برای اطلاع از مقالات و آزمون‌های جدید ثبت شد!', en: 'Thank you! You will be notified of new content.' },
      toastInvalid: { fa: 'لطفاً شماره موبایل معتبر وارد کنید.', en: 'Please enter a valid mobile number.' }
    },
    showToast(msg) {
      this.toastMsg = msg;
      this.toast = true;
      setTimeout(() => this.toast = false, 3500);
    },
    async submitNewsletter() {
      if(this.phoneInput.length >= 8) {
        try {
          let res = await fetch("{{ route('subscribe') }}", {
            method: "POST",
            headers: { "Content-Type": "application/json", "X-CSRF-TOKEN": "{{ csrf_token() }}" },
            body: JSON.stringify({ phone: this.phoneInput })
          });
          if (res.ok) {
            this.showToast(this.t.toastSuccess[this.lang]);
            this.phoneInput = '';
          } else {
            this.showToast(this.t.toastInvalid[this.lang]);
          }
        } catch (e) {
          this.showToast(this.t.toastSuccess[this.lang]);
          this.phoneInput = '';
        }
      } else {
        this.showToast(this.t.toastInvalid[this.lang]);
      }
    }
  }
}
</script>
@endpush