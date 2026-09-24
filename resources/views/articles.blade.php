@extends('layouts.app')

@section('title', 'LINGORAX | مقالات تخصصی و آموزشی زبان انگلیسی')

@php
  $catNames = [
    'speaking'  => ['fa' => 'اسپیکینگ', 'en' => 'Speaking'],
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
        'fa' => is_array($art->excerpt_fa) ? implode(' - ', array_filter($art->excerpt_fa)) : ($art->excerpt_fa ?: mb_substr(strip_tags($art->content_fa), 0, 100) . '...'),
        'en' => is_array($art->excerpt_en) ? implode(' - ', array_filter($art->excerpt_en)) : ($art->excerpt_en ?: mb_substr(strip_tags($art->content_en), 0, 100) . '...'),
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
<div x-data="articlesArchive()" class="space-y-6 sm:space-y-12 py-4 sm:py-10">
  
  <!-- HERO & FILTER CONTROLS -->
  <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="space-y-5 sm:space-y-8 text-center">
      
      <div class="space-y-3 max-w-3xl mx-auto">
        <div class="inline-flex items-center gap-2 px-3.5 py-1 rounded-full glass-card border-brand-gold/25 text-[11px] sm:text-xs text-brand-goldLight font-semibold">
          <span class="relative flex h-2 w-2">
            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-brand-gold opacity-75"></span>
            <span class="relative inline-flex rounded-full h-2 w-2 bg-brand-gold"></span>
          </span>
          <span x-text="t.pageBadge[lang]"></span>
        </div>

        <h1 class="font-black text-white text-2xl sm:text-4xl lg:text-5xl leading-tight">
          <span class="block" x-text="t.pageTitle1[lang]"></span>
          <span class="text-gold-gradient relative inline-block mt-1">
            <span x-text="t.pageTitle2[lang]"></span>
            <svg class="absolute -bottom-1.5 right-0 w-full text-brand-gold/40" viewBox="0 0 100 10" preserveAspectRatio="none" height="6">
              <path d="M0,5 Q50,10 100,5" stroke="currentColor" stroke-width="4" fill="transparent"/>
            </svg>
          </span>
        </h1>

        <p class="text-brand-slate text-xs sm:text-sm max-w-2xl mx-auto leading-relaxed" x-text="t.pageDesc[lang]"></p>
      </div>

      <!-- SEARCH BAR -->
      <div class="max-w-xl mx-auto">
        <div class="glass-card rounded-2xl p-1.5 sm:p-2 flex items-center gap-2.5 border border-white/10 focus-within:border-brand-gold/50 transition-all">
          <div class="p-1.5 text-brand-gold flex-shrink-0">
            <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
            </svg>
          </div>
          <input
            type="text"
            x-model="searchQuery"
            @input="currentPage = 1"
            :placeholder="t.searchPlaceholder[lang]"
            class="bg-transparent w-full text-xs sm:text-sm text-white placeholder-brand-muted/70 focus:outline-none font-medium"
            :class="lang === 'fa' ? 'text-right' : 'text-left'"
          />
          <button
            x-show="searchQuery"
            @click="searchQuery = ''; currentPage = 1"
            class="p-1 text-brand-slate hover:text-white transition-colors"
          >
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
            </svg>
          </button>
        </div>
      </div>

      <!-- FILTER TABS -->
      <div class="space-y-2.5">
        <!-- Topics Filter -->
        <div class="flex items-center justify-center gap-1.5 sm:gap-2 flex-wrap text-[11px] sm:text-xs font-semibold">
          <button
            @click="selectedCategory = 'all'; currentPage = 1"
            :class="selectedCategory === 'all' ? 'bg-brand-gold text-brand-darkest font-bold shadow-glow-gold' : 'glass-card text-brand-slate hover:text-white border-white/5'"
            class="px-3 py-1.5 rounded-xl transition-all"
            x-text="t.catAll[lang]"
          ></button>
          <button
            @click="selectedCategory = 'speaking'; currentPage = 1"
            :class="selectedCategory === 'speaking' ? 'bg-brand-gold text-brand-darkest font-bold shadow-glow-gold' : 'glass-card text-brand-slate hover:text-white border-white/5'"
            class="px-3 py-1.5 rounded-xl transition-all"
            x-text="t.catSpeaking[lang]"
          ></button>
          <button
            @click="selectedCategory = 'listening'; currentPage = 1"
            :class="selectedCategory === 'listening' ? 'bg-brand-gold text-brand-darkest font-bold shadow-glow-gold' : 'glass-card text-brand-slate hover:text-white border-white/5'"
            class="px-3 py-1.5 rounded-xl transition-all"
            x-text="t.catListening[lang]"
          ></button>
          <button
            @click="selectedCategory = 'grammar'; currentPage = 1"
            :class="selectedCategory === 'grammar' ? 'bg-brand-gold text-brand-darkest font-bold shadow-glow-gold' : 'glass-card text-brand-slate hover:text-white border-white/5'"
            class="px-3 py-1.5 rounded-xl transition-all"
            x-text="t.catGrammar[lang]"
          ></button>
          <button
            @click="selectedCategory = 'vocab'; currentPage = 1"
            :class="selectedCategory === 'vocab' ? 'bg-brand-gold text-brand-darkest font-bold shadow-glow-gold' : 'glass-card text-brand-slate hover:text-white border-white/5'"
            class="px-3 py-1.5 rounded-xl transition-all"
            x-text="t.catVocab[lang]"
          ></button>
          <button
            @click="selectedCategory = 'ielts'; currentPage = 1"
            :class="selectedCategory === 'ielts' ? 'bg-brand-gold text-brand-darkest font-bold shadow-glow-gold' : 'glass-card text-brand-slate hover:text-white border-white/5'"
            class="px-3 py-1.5 rounded-xl transition-all"
            x-text="t.catIelts[lang]"
          ></button>
          <button
            @click="selectedCategory = 'reading'; currentPage = 1"
            :class="selectedCategory === 'reading' ? 'bg-brand-gold text-brand-darkest font-bold shadow-glow-gold' : 'glass-card text-brand-slate hover:text-white border-white/5'"
            class="px-3 py-1.5 rounded-xl transition-all"
            x-text="t.catReading[lang]"
          ></button>
        </div>

        <!-- Levels Filter -->
        <div class="flex items-center justify-center gap-1.5 flex-wrap text-[10px] sm:text-[11px] font-bold">
          <button
            @click="selectedLevel = 'all'; currentPage = 1"
            :class="selectedLevel === 'all' ? 'border-brand-gold text-brand-gold bg-brand-gold/10' : 'border-white/10 text-brand-slate/80 hover:text-white'"
            class="px-2.5 py-0.5 rounded-lg border transition-all"
            x-text="t.filterAll[lang]"
          ></button>
          <button
            @click="selectedLevel = 'A1 - A2'; currentPage = 1"
            :class="selectedLevel === 'A1 - A2' ? 'border-brand-gold text-brand-gold bg-brand-gold/10' : 'border-white/10 text-brand-slate/80 hover:text-white'"
            class="px-2.5 py-0.5 rounded-lg border transition-all"
          >A1 - A2</button>
          <button
            @click="selectedLevel = 'B1 - B2'; currentPage = 1"
            :class="selectedLevel === 'B1 - B2' ? 'border-brand-gold text-brand-gold bg-brand-gold/10' : 'border-white/10 text-brand-slate/80 hover:text-white'"
            class="px-2.5 py-0.5 rounded-lg border transition-all"
          >B1 - B2</button>
          <button
            @click="selectedLevel = 'C1 - C2'; currentPage = 1"
            :class="selectedLevel === 'C1 - C2' ? 'border-brand-gold text-brand-gold bg-brand-gold/10' : 'border-white/10 text-brand-slate/80 hover:text-white'"
            class="px-2.5 py-0.5 rounded-lg border transition-all"
          >C1 - C2</button>
          <button
            @click="selectedLevel = 'A1 - C2'; currentPage = 1"
            :class="selectedLevel === 'A1 - C2' ? 'border-brand-gold text-brand-gold bg-brand-gold/10' : 'border-white/10 text-brand-slate/80 hover:text-white'"
            class="px-2.5 py-0.5 rounded-lg border transition-all"
          >A1 - C2</button>
        </div>

    </div>
  </section>

  <!-- ARTICLES LIST -->
  <section id="articles-list" class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-4 sm:space-y-6">
    
    <!-- Info Bar -->
    <div class="flex items-center justify-between border-b border-white/5 pb-2.5 text-xs text-brand-slate font-medium">
      <div class="flex items-center gap-1.5">
        <span class="w-1.5 h-1.5 rounded-full bg-brand-gold"></span>
        <span>
          <span x-text="t.showingCount[lang]"></span>
          <strong class="text-white mx-0.5 font-bold" x-text="num(paginatedArticles.length)"></strong>
          <span x-text="t.ofTotal[lang]"></span>
          <strong class="text-brand-gold mx-0.5 font-bold" x-text="num(filteredArticles.length)"></strong>
        </span>
      </div>

      <div class="text-[11px] text-brand-slate/70">
        <span x-text="t.pageWord[lang]"></span>
        <span class="text-white font-bold" x-text="num(currentPage)"></span> / <span x-text="num(totalPages)"></span>
      </div>
    </div>

    <!-- Cards Layout: فشرده و افقی در موبایل / گرید در تبلت و دسکتاپ -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-3.5 sm:gap-6">
      <template x-for="article in paginatedArticles" :key="article.id">
        <article class="glass-card glass-card-hover rounded-2xl sm:rounded-3xl overflow-hidden flex flex-row md:flex-col justify-between group border border-white/5">
          
          <div class="flex flex-row md:flex-col flex-1 min-w-0">
            <!-- تصویر بندانگشتی در موبایل / کارت عمودی در دسکتاپ -->
            <div class="relative w-28 sm:w-36 md:w-full h-auto md:h-48 flex-shrink-0 overflow-hidden bg-brand-card">
              <img
                :src="article.image"
                :alt="article.title[lang]"
                class="w-full h-full object-cover object-center group-hover:scale-105 transition-transform duration-500"
              />
              <div class="absolute inset-0 bg-gradient-to-t from-brand-card/90 via-transparent to-black/20 hidden md:block"></div>
              
              <span
                class="absolute top-2 right-2 bg-brand-gold text-brand-darkest text-[9px] sm:text-[10px] font-black px-2 py-0.5 rounded-md shadow z-10"
                x-text="article.level"
              ></span>

              <span
                class="absolute bottom-2 left-2 bg-brand-darkest/90 text-brand-goldLight border border-brand-gold/30 text-[9px] font-bold px-2 py-0.5 rounded-md shadow hidden md:block z-10"
                x-text="article.categoryName[lang]"
              ></span>
            </div>

            <!-- متون و خلاصه -->
            <div class="p-3 sm:p-5 flex flex-col justify-between flex-1 min-w-0">
              <div class="space-y-1.5 sm:space-y-2">
                <div class="flex items-center gap-2 text-[10px] sm:text-xs text-brand-slate/80">
                  <span class="md:hidden text-brand-gold font-bold" x-text="article.categoryName[lang]"></span>
                  <span class="md:hidden">•</span>
                  <span class="flex items-center gap-1">
                    <svg class="w-3 h-3 text-brand-gold" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <span x-text="num(article.readTime) + ' ' + t.minRead[lang]"></span>
                  </span>
                </div>

                <h3 class="text-xs sm:text-base font-bold text-white leading-snug font-heading group-hover:text-brand-gold transition-colors line-clamp-2" x-text="article.title[lang]"></h3>
                <p class="text-brand-slate text-[11px] sm:text-xs leading-relaxed line-clamp-1 sm:line-clamp-2 hidden sm:block" x-text="article.desc[lang]"></p>
              </div>

              <!-- دکمه در دسکتاپ مخفی در نمای ساده افقی موبایل با لینک مستقیم -->
              <div class="pt-2 md:pt-4">
                <a
                  :href="article.link"
                  class="inline-flex items-center gap-1.5 text-brand-gold hover:text-brand-goldLight text-[11px] sm:text-xs font-bold md:w-full md:justify-center md:bg-brand-cardLight/80 md:hover:bg-brand-gold md:hover:text-brand-darkest md:text-white md:py-2.5 md:rounded-xl transition-all"
                >
                  <span x-text="t.readArticle[lang]"></span>
                  <svg class="w-3.5 h-3.5" :class="lang === 'en' ? 'rotate-180' : ''" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 12H5m7 7l-7-7 7-7"/>
                  </svg>
                </a>
              </div>
            </div>

          </div>

        </article>
      </template>
    </div>

    <!-- Empty State -->
    <div x-show="filteredArticles.length === 0" class="glass-card rounded-2xl p-8 text-center space-y-3 max-w-sm mx-auto my-6">
      <p class="text-xs sm:text-sm text-brand-slate" x-text="t.noResult[lang]"></p>
      <button
        @click="searchQuery = ''; selectedLevel = 'all'; selectedCategory = 'all'; currentPage = 1"
        class="border border-brand-gold/40 text-brand-gold px-3.5 py-1.5 rounded-xl text-xs font-bold hover:bg-brand-gold hover:text-brand-darkest transition-all"
        x-text="lang === 'fa' ? 'حذف فیلترها' : 'Clear Filters'"
      ></button>
    </div>

    <!-- PAGINATION -->
    <div x-show="totalPages > 1" class="pt-4 flex items-center justify-center gap-1.5">
      <button
        @click="goToPage(currentPage - 1)"
        :disabled="currentPage === 1"
        :class="currentPage === 1 ? 'opacity-30 cursor-not-allowed' : 'hover:bg-brand-gold hover:text-brand-darkest'"
        class="glass-card px-3 py-1.5 rounded-xl border border-white/10 text-xs font-bold text-white transition-all"
        x-text="t.prevPage[lang]"
      ></button>

      <div class="flex items-center gap-1">
        <template x-for="p in totalPages" :key="p">
          <button
            @click="goToPage(p)"
            :class="currentPage === p ? 'bg-brand-gold text-brand-darkest font-black' : 'glass-card text-brand-slate hover:text-white border-white/5 font-bold'"
            class="w-8 h-8 rounded-xl text-xs flex items-center justify-center transition-all"
            x-text="num(p)"
          ></button>
        </template>
      </div>

      <button
        @click="goToPage(currentPage + 1)"
        :disabled="currentPage === totalPages"
        :class="currentPage === totalPages ? 'opacity-30 cursor-not-allowed' : 'hover:bg-brand-gold hover:text-brand-darkest'"
        class="glass-card px-3 py-1.5 rounded-xl border border-white/10 text-xs font-bold text-white transition-all"
        x-text="t.nextPage[lang]"
      ></button>
    </div>

  </section>

</div>
@endsection

@push('scripts')
<script>
function articlesArchive() {
  const dbData = @json($dbArticles);

  return {
    searchQuery: '',
    selectedLevel: 'all',
    selectedCategory: 'all',
    currentPage: 1,
    itemsPerPage: 6,
    articles: dbData || [],
    
    get filteredArticles() {
      return this.articles.filter(item => {
        const matchLevel = this.selectedLevel === 'all' 
          || item.level === this.selectedLevel 
          || item.level === 'A1 - C2';
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
      catSpeaking: { fa: 'اسپیکینگ', en: 'Speaking' },
      catListening: { fa: 'شنیداری', en: 'Listening' },
      catGrammar: { fa: 'گرامر', en: 'Grammar' },
      catVocab: { fa: 'واژگان', en: 'Vocabulary' },
      catIelts: { fa: 'آیلتس و تافل', en: 'IELTS & TOEFL' },
      catReading: { fa: 'درک مطلب', en: 'Reading' },
      showingCount: { fa: 'نمایش', en: 'Showing' },
      ofTotal: { fa: 'از', en: 'of' },
      minRead: { fa: 'دقیقه', en: 'min' },
      readArticle: { fa: 'مطالعه مقاله', en: 'Read' },
      noResult: { fa: 'مقاله‌ای مطابق با فیلترها یافت نشد.', en: 'No articles matched your filters.' },
      prevPage: { fa: 'قبلی', en: 'Prev' },
      nextPage: { fa: 'بعدی', en: 'Next' },
      pageWord: { fa: 'صفحه', en: 'Page' }
    }
  }
}
</script>
@endpush