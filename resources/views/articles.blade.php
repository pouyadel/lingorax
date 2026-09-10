@extends('layouts.app')

@section('title', 'LINGORAX | مقالات تخصصی و آموزشی زبان انگلیسی')

@php
  $catNames = [
    'listening' => ['fa' => 'شنیداری', 'en' => 'Listening'],
    'grammar'   => ['fa' => 'گرامر', 'en' => 'Grammar'],
    'vocab'     => ['fa' => 'واژگان', 'en' => 'Vocabulary'],
    'ielts'     => ['fa' => 'آیلتس', 'en' => 'IELTS'],
    'reading'   => ['fa' => 'درک مطلب', 'en' => 'Reading'],
  ];

  $dbArticles = $articles->map(function($art) use ($catNames) {
    return [
      'id' => $art->id,
      'title' => [
        'fa' => $art->title_fa,
        'en' => $art->title_en,
      ],
      'desc' => [
        'fa' => is_array($art->excerpt_fa) ? implode(' - ', array_filter($art->excerpt_fa)) : ($art->excerpt_fa ?: mb_substr(strip_tags($art->content_fa), 0, 120) . '...'),
        'en' => is_array($art->excerpt_en) ? implode(' - ', array_filter($art->excerpt_en)) : ($art->excerpt_en ?: mb_substr(strip_tags($art->content_en), 0, 120) . '...'),
      ],
      'level' => $art->level,
      'category' => $art->category,
      'categoryName' => $catNames[$art->category] ?? ['fa' => $art->category, 'en' => ucfirst($art->category)],
      'readTime' => $art->read_time ?? 5,
      'image' => $art->image ? asset('storage/' . $art->image) : asset('images/placeholder.png'),
      'link' => route('articles.show', $art->slug),
    ];
  })->values();
@endphp
@section('content')
<div x-data="articlesArchive()" class="space-y-10 sm:space-y-14 py-8 sm:py-12">
  
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

  <!-- HERO & FILTER CONTROLS -->
  <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="space-y-8 text-center">
      
      <div class="space-y-4 max-w-3xl mx-auto">
        <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full glass-card border-brand-gold/25 text-xs text-brand-goldLight font-semibold">
          <span class="relative flex h-2 w-2">
            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-brand-gold opacity-75"></span>
            <span class="relative inline-flex rounded-full h-2 w-2 bg-brand-gold"></span>
          </span>
          <span x-text="t.pageBadge[lang]"></span>
        </div>

        <h1 class="font-black text-white" :class="lang === 'fa' ? 'text-3xl sm:text-5xl lg:text-6xl leading-tight' : ''">
          <span class="block" x-text="t.pageTitle1[lang]"></span>
          <span class="text-gold-gradient relative inline-block mt-1">
            <span x-text="t.pageTitle2[lang]"></span>
            <svg class="absolute -bottom-2 right-0 w-full text-brand-gold/40" viewBox="0 0 100 10" preserveAspectRatio="none" height="8">
              <path d="M0,5 Q50,10 100,5" stroke="currentColor" stroke-width="4" fill="transparent"/>
            </svg>
          </span>
        </h1>

        <p class="text-brand-slate text-xs sm:text-sm lg:text-base leading-relaxed" x-text="t.pageDesc[lang]"></p>
      </div>

      <!-- SEARCH BAR -->
      <div class="max-w-xl mx-auto">
        <div class="glass-card rounded-2xl p-2 flex items-center gap-3 border border-white/10 focus-within:border-brand-gold/50 focus-within:shadow-glow-gold transition-all">
          <div class="p-2 text-brand-gold flex-shrink-0">
            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
            </svg>
          </div>
          <input
            type="text"
            x-model="searchQuery"
            @input="currentPage = 1"
            :placeholder="t.searchPlaceholder[lang]"
            class="bg-transparent w-full text-sm text-white placeholder-brand-muted/70 focus:outline-none font-semibold"
            :class="lang === 'fa' ? 'text-right' : 'text-left'"
          />
          <button
            x-show="searchQuery"
            @click="searchQuery = ''; currentPage = 1"
            class="p-1.5 text-brand-slate hover:text-white transition-colors"
          >
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
            </svg>
          </button>
        </div>
      </div>

      <!-- FILTER TABS -->
      <div class="space-y-3 pt-1">
        
        <!-- Topics / Skills Filter -->
        <div class="flex items-center justify-center gap-2 flex-wrap text-xs font-semibold">
          <button
            @click="selectedCategory = 'all'; currentPage = 1"
            :class="selectedCategory === 'all' ? 'bg-brand-gold text-brand-darkest font-black shadow-glow-gold' : 'glass-card text-brand-slate hover:text-white border-white/5'"
            class="px-3.5 py-1.5 rounded-xl transition-all active:scale-95"
            x-text="t.catAll[lang]"
          ></button>
          <button
            @click="selectedCategory = 'listening'; currentPage = 1"
            :class="selectedCategory === 'listening' ? 'bg-brand-gold text-brand-darkest font-black shadow-glow-gold' : 'glass-card text-brand-slate hover:text-white border-white/5'"
            class="px-3.5 py-1.5 rounded-xl transition-all active:scale-95"
            x-text="t.catListening[lang]"
          ></button>
          <button
            @click="selectedCategory = 'grammar'; currentPage = 1"
            :class="selectedCategory === 'grammar' ? 'bg-brand-gold text-brand-darkest font-black shadow-glow-gold' : 'glass-card text-brand-slate hover:text-white border-white/5'"
            class="px-3.5 py-1.5 rounded-xl transition-all active:scale-95"
            x-text="t.catGrammar[lang]"
          ></button>
          <button
            @click="selectedCategory = 'vocab'; currentPage = 1"
            :class="selectedCategory === 'vocab' ? 'bg-brand-gold text-brand-darkest font-black shadow-glow-gold' : 'glass-card text-brand-slate hover:text-white border-white/5'"
            class="px-3.5 py-1.5 rounded-xl transition-all active:scale-95"
            x-text="t.catVocab[lang]"
          ></button>
          <button
            @click="selectedCategory = 'ielts'; currentPage = 1"
            :class="selectedCategory === 'ielts' ? 'bg-brand-gold text-brand-darkest font-black shadow-glow-gold' : 'glass-card text-brand-slate hover:text-white border-white/5'"
            class="px-3.5 py-1.5 rounded-xl transition-all active:scale-95"
            x-text="t.catIelts[lang]"
          ></button>
          <button
            @click="selectedCategory = 'reading'; currentPage = 1"
            :class="selectedCategory === 'reading' ? 'bg-brand-gold text-brand-darkest font-black shadow-glow-gold' : 'glass-card text-brand-slate hover:text-white border-white/5'"
            class="px-3.5 py-1.5 rounded-xl transition-all active:scale-95"
            x-text="t.catReading[lang]"
          ></button>
        </div>

        <!-- CEFR Levels Filter -->
        <div class="flex items-center justify-center gap-1.5 flex-wrap text-[11px] font-bold">
          <button
            @click="selectedLevel = 'all'; currentPage = 1"
            :class="selectedLevel === 'all' ? 'border-brand-gold text-brand-gold bg-brand-gold/10' : 'border-white/10 text-brand-slate/80 hover:text-white'"
            class="px-2.5 py-1 rounded-lg border transition-all"
          >
            <span x-text="t.filterAll[lang]"></span>
          </button>
          <button
            @click="selectedLevel = 'A1'; currentPage = 1"
            :class="selectedLevel === 'A1' ? 'border-brand-gold text-brand-gold bg-brand-gold/10' : 'border-white/10 text-brand-slate/80 hover:text-white'"
            class="px-2.5 py-1 rounded-lg border transition-all"
          >
            A1 - A2
          </button>
          <button
            @click="selectedLevel = 'B1'; currentPage = 1"
            :class="selectedLevel === 'B1' ? 'border-brand-gold text-brand-gold bg-brand-gold/10' : 'border-white/10 text-brand-slate/80 hover:text-white'"
            class="px-2.5 py-1 rounded-lg border transition-all"
          >
            B1 - B2
          </button>
          <button
            @click="selectedLevel = 'C1'; currentPage = 1"
            :class="selectedLevel === 'C1' ? 'border-brand-gold text-brand-gold bg-brand-gold/10' : 'border-white/10 text-brand-slate/80 hover:text-white'"
            class="px-2.5 py-1 rounded-lg border transition-all"
          >
            C1 - C2
          </button>
        </div>

      </div>

    </div>
  </section>

  <!-- RESULTS TOOLBAR & ARTICLES GRID -->
  <section id="articles-list" class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">
    
    <!-- Summary Info Bar -->
    <div class="flex items-center justify-between border-b border-white/5 pb-3 text-xs text-brand-slate font-semibold">
      <div class="flex items-center gap-2">
        <span class="w-2 h-2 rounded-full bg-brand-gold"></span>
        <span>
          <span x-text="t.showingCount[lang]"></span>
          <strong class="text-white mx-1 font-bold" x-text="num(paginatedArticles.length)"></strong>
          <span x-text="t.ofTotal[lang]"></span>
          <strong class="text-brand-gold mx-1 font-bold" x-text="num(filteredArticles.length)"></strong>
          <span x-text="t.totalItems[lang]"></span>
        </span>
      </div>

      <div class="text-[11px] text-brand-slate/70">
        <span x-text="t.pageWord[lang]"></span>
        <span class="text-white font-bold" x-text="num(currentPage)"></span>
        /
        <span x-text="num(totalPages)"></span>
      </div>
    </div>

    <!-- Cards Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
      <template x-for="article in paginatedArticles" :key="article.id">
        <article class="glass-card glass-card-hover rounded-3xl overflow-hidden flex flex-col justify-between group">
          <div>
            <div class="relative h-48 sm:h-52 w-full overflow-hidden bg-brand-card">
              <img
                :src="article.image"
                :alt="article.title[lang]"
                class="w-full h-full object-cover object-center transition-transform duration-500 group-hover:scale-105"
              />
              <div class="absolute inset-0 bg-gradient-to-t from-brand-card/90 via-transparent to-black/20"></div>
              
              <span
                class="absolute top-3 right-3 bg-brand-gold text-brand-darkest text-[10px] font-black px-2.5 py-1 rounded-lg shadow-md backdrop-blur-sm z-10"
                x-text="lang === 'fa' ? 'سطح ' + num(article.level) : 'Level ' + article.level"
              ></span>

              <span
                class="absolute bottom-3 left-3 bg-brand-darkest/80 text-brand-goldLight border border-brand-gold/30 text-[10px] font-bold px-2.5 py-1 rounded-lg shadow backdrop-blur-md z-10"
                x-text="article.categoryName[lang]"
              ></span>
            </div>

            <div class="p-5 sm:p-6 space-y-3">
              <div class="flex items-center gap-2 text-[11px] text-brand-slate/80">
                <svg class="w-3.5 h-3.5 text-brand-gold" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <span>
                  <span x-text="num(article.readTime)"></span>
                  <span x-text="t.minRead[lang]"></span>
                </span>
              </div>

              <h3 class="text-base font-bold text-white leading-snug font-heading group-hover:text-brand-gold transition-colors" x-text="article.title[lang]"></h3>
              <p class="text-brand-slate text-xs leading-relaxed line-clamp-2" x-text="article.desc[lang]"></p>
            </div>
          </div>

          <div class="p-5 sm:p-6 pt-0">
            <a
              :href="article.link"
              class="w-full inline-flex items-center justify-center gap-2 bg-brand-cardLight/80 hover:bg-brand-gold hover:text-brand-darkest text-white text-xs font-bold py-3 rounded-xl transition-all active:scale-95"
            >
              <span x-text="t.readArticle[lang]"></span>
              <svg
                class="w-3.5 h-3.5"
                :class="lang === 'en' ? 'rotate-180' : ''"
                fill="none"
                viewBox="0 0 24 24"
                stroke="currentColor"
              >
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 12H5m7 7l-7-7 7-7"/>
              </svg>
            </a>
          </div>
        </article>
      </template>
    </div>

    <!-- Empty State -->
    <div x-show="filteredArticles.length === 0" class="glass-card rounded-3xl p-12 text-center space-y-4 max-w-md mx-auto my-8">
      <div class="w-14 h-14 rounded-2xl bg-brand-cardLight text-brand-gold mx-auto flex items-center justify-center border border-white/5">
        <svg class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
        </svg>
      </div>
      <p class="text-sm text-brand-slate font-medium" x-text="t.noResult[lang]"></p>
      <button
        @click="searchQuery = ''; selectedLevel = 'all'; selectedCategory = 'all'; currentPage = 1"
        class="border border-brand-gold/40 text-brand-gold px-4 py-2 rounded-xl text-xs font-bold hover:bg-brand-gold hover:text-brand-darkest transition-all"
      >
        <span x-text="lang === 'fa' ? 'حذف فیلترها' : 'Clear Filters'"></span>
      </button>
    </div>

    <!-- PAGINATION CONTROLS -->
    <div x-show="totalPages > 1" class="pt-6 flex items-center justify-center gap-2">
      
      <button
        @click="goToPage(currentPage - 1)"
        :disabled="currentPage === 1"
        :class="currentPage === 1 ? 'opacity-40 cursor-not-allowed text-brand-slate' : 'hover:bg-brand-gold hover:text-brand-darkest text-white border-white/10'"
        class="glass-card px-3.5 py-2 rounded-xl border text-xs font-bold transition-all flex items-center gap-1.5"
      >
        <svg class="w-3.5 h-3.5" :class="lang === 'en' ? 'rotate-180' : ''" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/>
        </svg>
        <span x-text="t.prevPage[lang]"></span>
      </button>

      <div class="flex items-center gap-1.5">
        <template x-for="p in totalPages" :key="p">
          <button
            @click="goToPage(p)"
            :class="currentPage === p ? 'bg-gradient-to-r from-brand-gold to-brand-goldHover text-brand-darkest font-black shadow-glow-gold' : 'glass-card text-brand-slate hover:text-white border-white/5 font-bold'"
            class="w-9 h-9 rounded-xl text-xs transition-all flex items-center justify-center active:scale-95"
            x-text="num(p)"
          ></button>
        </template>
      </div>

      <button
        @click="goToPage(currentPage + 1)"
        :disabled="currentPage === totalPages"
        :class="currentPage === totalPages ? 'opacity-40 cursor-not-allowed text-brand-slate' : 'hover:bg-brand-gold hover:text-brand-darkest text-white border-white/10'"
        class="glass-card px-3.5 py-2 rounded-xl border text-xs font-bold transition-all flex items-center gap-1.5"
      >
        <span x-text="t.nextPage[lang]"></span>
        <svg class="w-3.5 h-3.5" :class="lang === 'en' ? 'rotate-180' : ''" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"/>
        </svg>
      </button>

    </div>

  </section>


</div>
@endsection

@push('scripts')
<script>
function articlesArchive() {
  const dbData = @json($dbArticles);

  const fallbackArticles = [
    {
      id: 1,
      title: { fa: 'تکنیک‌های تقویت مهارت شنیداری (Listening)', en: 'Essential Listening Mastery Techniques' },
      desc: { fa: 'روش‌های کلیدی برای افزایش درک شنیداری در آزمون‌های بین‌المللی و مکالمات روزمره...', en: 'Key methods to enhance listening comprehension for international exams and everyday speech...' },
      level: 'B2 - C1',
      category: 'listening',
      categoryName: { fa: 'شنیداری', en: 'Listening' },
      readTime: 6,
      image: "{{ asset('images/image.png') }}",
      link: '#'
    },
    {
      id: 2,
      title: { fa: '۱۰ اشتباه رایج گرامری در مکالمه روزمره', en: '10 Common Grammar Mistakes in Daily English' },
      desc: { fa: 'اشتباهاتی که اکثر زبان‌آموزان انجام می‌دهند و نحوه اصلاح سریع آن‌ها...', en: 'Frequent structural errors made by learners and practical ways to fix them quickly...' },
      level: 'A1 - A2',
      category: 'grammar',
      categoryName: { fa: 'گرامر', en: 'Grammar' },
      readTime: 4,
      image: "{{ asset('images/image.png') }}",
      link: '#'
    },
    {
      id: 3,
      title: { fa: 'چگونه واژگان جدید را برای همیشه حفظ کنیم؟', en: 'How to Permanently Retain New Vocabulary' },
      desc: { fa: 'متد تصویرسازی ذهنی و بکارگیری کالوکیشن‌ها برای تثبیت عمیق لغات...', en: 'Mental visualization techniques and collocations for long-term vocabulary retention...' },
      level: 'B1',
      category: 'vocab',
      categoryName: { fa: 'واژگان', en: 'Vocabulary' },
      readTime: 5,
      image: "{{ asset('images/image.png') }}",
      link: '#'
    },
    {
      id: 4,
      title: { fa: 'استراتژی‌های طلایی اسپیکینگ آیلتس (IELTS Speaking)', en: 'Golden Strategies for IELTS Speaking Band 8+' },
      desc: { fa: 'تکنیک‌های گسترش پاسخ‌ها، مدیریت استرس و استفاده صحیح از اصطلاحات روان‌سازی مکالمه...', en: 'Actionable frameworks to expand answers naturally, avoid fillers, and impress the examiner...' },
      level: 'B2 - C1',
      category: 'ielts',
      categoryName: { fa: 'آیلتس', en: 'IELTS' },
      readTime: 8,
      image: "{{ asset('images/image.png') }}",
      link: '#'
    },
    {
      id: 5,
      title: { fa: 'افعال دو کلمه‌ای و عبارتی پرکاربرد در انگلیسی روزمره', en: 'High-Frequency Phrasal Verbs in Daily Context' },
      desc: { fa: 'یادگیری طبیعی پرکاربردترین Phrasal Verbs به همراه مثال‌های واقعی و مکالمه‌محور...', en: 'Comprehensive guide to high-frequency phrasal verbs used by native speakers in daily conversations...' },
      level: 'B1 - B2',
      category: 'grammar',
      categoryName: { fa: 'گرامر', en: 'Grammar' },
      readTime: 5,
      image: "{{ asset('images/image.png') }}",
      link: '#'
    },
    {
      id: 6,
      title: { fa: 'تکنیک‌های افزایش سرعت خواندن (Skimming & Scanning)', en: 'Speed Reading Mastery: Skimming & Scanning' },
      desc: { fa: 'چگونه متون طولانی آکادمیک و جنرال را در کمترین زمان ممکن تحلیل و درک کنیم؟', en: 'How to navigate lengthy academic texts efficiently under strict exam time constraints...' },
      level: 'B2 - C1',
      category: 'reading',
      categoryName: { fa: 'درک مطلب', en: 'Reading' },
      readTime: 7,
      image: "{{ asset('images/image.png') }}",
      link: '#'
    }
  ];

  return {
    toast: false,
    toastMsg: '',
    searchQuery: '',
    selectedLevel: 'all',
    selectedCategory: 'all',
    currentPage: 1,
    itemsPerPage: 6,
    phoneInput: '',
    articles: (dbData && dbData.length > 0) ? dbData : fallbackArticles,
    
    get filteredArticles() {
      return this.articles.filter(item => {
        const matchLevel = this.selectedLevel === 'all' || item.level.includes(this.selectedLevel);
        const matchCategory = this.selectedCategory === 'all' || item.category === this.selectedCategory;
        const query = this.searchQuery.toLowerCase().trim();
        const titleFa = (item.title?.fa || '').toLowerCase();
        const titleEn = (item.title?.en || '').toLowerCase();
        const descFa = (item.desc?.fa || '').toLowerCase();
        const descEn = (item.desc?.en || '').toLowerCase();
        const matchSearch = !query || titleFa.includes(query) || titleEn.includes(query) || descFa.includes(query) || descEn.includes(query);
        return matchLevel && matchCategory && matchSearch;
      });
    },
    get totalPages() {
      return Math.ceil(this.filteredArticles.length / this.itemsPerPage) || 1;
    },
    get paginatedArticles() {
      const start = (this.currentPage - 1) * this.itemsPerPage;
      return this.filteredArticles.slice(start, start + this.itemsPerPage);
    },
    goToPage(p) {
      if (p >= 1 && p <= this.totalPages) {
        this.currentPage = p;
        document.getElementById('articles-list')?.scrollIntoView({ behavior: 'smooth', block: 'start' });
      }
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
    },
    t: {
      pageBadge: { 
        fa: "{{ $settings['articles_badge_fa'] ?? 'مرجع آموزشی و تحلیلی مقالات' }}", 
        en: "{{ $settings['articles_badge_en'] ?? 'Educational Article Archive' }}" 
      },
      pageTitle1: { 
        fa: "{{ $settings['articles_title1_fa'] ?? 'بانک مقالات تخصصی و' }}", 
        en: "{{ $settings['articles_title1_en'] ?? 'Specialized English' }}" 
      },
      pageTitle2: { 
        fa: "{{ $settings['articles_title2_fa'] ?? 'نکات تحلیلی زبان انگلیسی' }}", 
        en: "{{ $settings['articles_title2_en'] ?? 'Articles & Study Guides' }}" 
      },
      pageDesc: { 
        fa: "{{ $settings['articles_desc_fa'] ?? 'دسته‌بندی مقالات بر اساس سطح زبان و مهارت‌های مورد نیاز، از مبتدی تا آمادگی آزمون‌های آیلتس و تافل.' }}", 
        en: "{{ $settings['articles_desc_en'] ?? 'Curated self-study articles, structural guides, and exam strategies categorized by skill and CEFR level.' }}" 
      },
      searchPlaceholder: { fa: 'جستجو در عنوان یا متن مقاله...', en: 'Search articles by title or keyword...' },
      filterAll: { fa: 'همه سطوح', en: 'All Levels' },
      catAll: { fa: 'همه موضوعات', en: 'All Topics' },
      catListening: { fa: 'شنیداری (Listening)', en: 'Listening' },
      catGrammar: { fa: 'گرامر (Grammar)', en: 'Grammar' },
      catVocab: { fa: 'واژگان (Vocabulary)', en: 'Vocabulary' },
      catIelts: { fa: 'آیلتس و تافل (Exams)', en: 'IELTS & TOEFL' },
      catReading: { fa: 'درک مطلب (Reading)', en: 'Reading' },
      showingCount: { fa: 'نمایش مقالات', en: 'Showing' },
      ofTotal: { fa: 'از مجموع', en: 'of' },
      totalItems: { fa: 'مقاله آموزشی', en: 'articles' },
      minRead: { fa: 'دقیقه مطالعه', en: 'min read' },
      readArticle: { fa: 'مطالعه کامل مقاله', en: 'Read Full Article' },
      noResult: { fa: 'مقاله‌ای مطابق با فیلترها یا عبارت جستجو شده یافت نشد.', en: 'No articles matched your search query or selected filters.' },
      prevPage: { fa: 'قبلی', en: 'Previous' },
      nextPage: { fa: 'بعدی', en: 'Next' },
      pageWord: { fa: 'صفحه', en: 'Page' },
      newsletterBoxTitle: { fa: 'عضویت در خبرنامه مقالات تخصصی', en: 'Subscribe for New Article Alerts' },
      newsletterBoxDesc: { fa: 'به محض انتشار مقاله یا نکته آموزشی جدید، شما را با پیامک مطلع خواهیم کرد.', en: 'Get instant notifications whenever new study guides and tests are published.' },
      newsletterBtn: { fa: 'عضویت سریع', en: 'Subscribe' },
      newsletterPlaceholder: { fa: '۰۹۱۲...', en: '0912...' },
      toastSuccess: { fa: 'شماره شما برای دریافت مقالات جدید ثبت شد!', en: 'Thank you! You will be notified of new articles.' },
      toastInvalid: { fa: 'لطفاً شماره موبایل معتبر وارد کنید.', en: 'Please enter a valid mobile number.' }
    }
  }
}
</script>
@endpush