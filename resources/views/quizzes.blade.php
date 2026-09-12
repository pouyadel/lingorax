@extends('layouts.app')

@section('title', 'LINGORAX | بانک آزمون‌ها و کوئیزهای آنلاین')

@php
  $dbQuizzes = $quizzes->map(function($q) {
    return [
      'id' => $q->id,
      'title' => [
        'fa' => $q->title_fa,
        'en' => $q->title_en,
      ],
      'desc' => [
        'fa' => $q->description_fa ?? '',
        'en' => $q->description_en ?? '',
      ],
      'level' => $q->level,
      'category' => $q->category,
      'questions' => $q->questions->map(function($ques) {
        $correctIndex = 0;
        $optionsList = [];
        foreach ($ques->options as $idx => $opt) {
          if ($opt->is_correct) {
            $correctIndex = $idx;
          }
          $optionsList[] = [
            'en' => $opt->text_en,
            'fa' => $opt->text_fa ?: $opt->text_en,
          ];
        }
        return [
          'text' => [
            'en' => $ques->text_en,
            'fa' => $ques->text_fa ?: $ques->text_en,
          ],
          'options' => $optionsList,
          'correct' => $correctIndex,
        ];
      })->values(),
    ];
  })->values();
@endphp

@section('content')
<div x-data="quizApp()" class="space-y-6 sm:space-y-12 py-4 sm:py-10">
  
  <!-- QUIZ SELECTION & FILTERS -->
  <section x-show="!activeQuiz" x-transition.opacity class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">
    
    <!-- PAGE TITLE -->
    <div class="space-y-3 max-w-3xl mx-auto text-center">
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

    <!-- SEARCH & FILTER -->
    <div class="max-w-xl mx-auto space-y-3">
      <div class="glass-card rounded-2xl p-1.5 sm:p-2 flex items-center gap-2 border border-white/10 focus-within:border-brand-gold/50 transition-all">
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
      </div>

      <div class="flex items-center justify-center gap-1.5 sm:gap-2 flex-wrap text-[11px] sm:text-xs font-semibold">
        <button
          @click="selectedCategory = 'all'; currentPage = 1"
          :class="selectedCategory === 'all' ? 'bg-brand-gold text-brand-darkest font-bold shadow-glow-gold' : 'glass-card text-brand-slate hover:text-white border-white/5'"
          class="px-3 py-1.5 rounded-xl transition-all"
          x-text="t.catAll[lang]"
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
          @click="selectedCategory = 'listening'; currentPage = 1"
          :class="selectedCategory === 'listening' ? 'bg-brand-gold text-brand-darkest font-bold shadow-glow-gold' : 'glass-card text-brand-slate hover:text-white border-white/5'"
          class="px-3 py-1.5 rounded-xl transition-all"
          x-text="t.catListening[lang]"
        ></button>
      </div>
    </div>

    <!-- SUMMARY BAR -->
    <div class="flex items-center justify-between border-b border-white/5 pb-2 text-xs text-brand-slate font-medium">
      <div class="flex items-center gap-1.5">
        <span class="w-1.5 h-1.5 rounded-full bg-brand-gold"></span>
        <span>
          <span x-text="t.showingCount[lang]"></span>
          <strong class="text-white mx-0.5 font-bold" x-text="num(paginatedQuizzes.length)"></strong>
          <span x-text="t.ofTotal[lang]"></span>
          <strong class="text-brand-gold mx-0.5 font-bold" x-text="num(filteredQuizzes.length)"></strong>
        </span>
      </div>
      <div class="text-[11px] text-brand-slate/70">
        <span x-text="t.pageWord[lang]"></span>
        <span class="text-white font-bold" x-text="num(currentPage)"></span> / <span x-text="num(totalPages)"></span>
      </div>
    </div>

    <!-- QUIZZES GRID: کارت‌های فشرده برای خوانایی بیشتر در موبایل -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-3.5 sm:gap-6">
      <template x-for="quiz in paginatedQuizzes" :key="quiz.id">
        <div class="glass-card glass-card-hover p-4 sm:p-6 rounded-2xl sm:rounded-3xl flex flex-col justify-between space-y-3.5 sm:space-y-5 group border border-white/5">
          <div>
            <div class="flex items-center justify-between gap-2">
              <span class="text-[10px] bg-brand-gold/15 text-brand-gold font-bold px-2 py-0.5 rounded-md border border-brand-gold/25" x-text="quiz.level"></span>
              <span class="text-[10px] text-brand-slate/80 font-medium" x-text="num(quiz.questions.length) + ' ' + (lang === 'fa' ? 'سؤال' : 'Q')"></span>
            </div>
            <h3 class="text-sm sm:text-lg font-bold text-white mt-2.5 sm:mt-3 font-heading group-hover:text-brand-gold transition-colors leading-snug" x-text="quiz.title[lang]"></h3>
            <p class="text-brand-slate text-xs mt-1.5 leading-relaxed line-clamp-2" x-text="quiz.desc[lang]"></p>
          </div>
          
          <button @click="startQuiz(quiz)" class="w-full inline-flex items-center justify-center gap-1.5 bg-brand-cardLight/80 hover:bg-brand-gold hover:text-brand-darkest text-white text-xs font-bold py-2.5 rounded-xl transition-all active:scale-95">
            <span x-text="t.startBtn[lang]"></span>
            <svg class="w-3.5 h-3.5" :class="lang === 'en' ? 'rotate-180' : ''" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 12H5m7 7l-7-7 7-7"/>
            </svg>
          </button>
        </div>
      </template>
    </div>

    <!-- EMPTY STATE -->
    <div x-show="filteredQuizzes.length === 0" class="glass-card rounded-2xl p-8 text-center space-y-3 max-w-sm mx-auto my-6">
      <p class="text-xs sm:text-sm text-brand-slate" x-text="t.noResult[lang]"></p>
    </div>

    <!-- PAGINATION -->
    <div x-show="totalPages > 1" class="pt-4 flex items-center justify-center gap-1.5">
      <button @click="goToPage(currentPage - 1)" :disabled="currentPage === 1" :class="currentPage === 1 ? 'opacity-30 cursor-not-allowed' : 'hover:bg-brand-gold hover:text-brand-darkest'" class="glass-card px-3 py-1.5 rounded-xl border border-white/10 text-xs font-bold text-white transition-all">
        <span x-text="t.prevPage[lang]"></span>
      </button>
      <div class="flex items-center gap-1">
        <template x-for="p in totalPages" :key="p">
          <button @click="goToPage(p)" :class="currentPage === p ? 'bg-brand-gold text-brand-darkest font-black' : 'glass-card text-brand-slate hover:text-white border-white/5 font-bold'" class="w-8 h-8 rounded-xl text-xs flex items-center justify-center transition-all" x-text="num(p)"></button>
        </template>
      </div>
      <button @click="goToPage(currentPage + 1)" :disabled="currentPage === totalPages" :class="currentPage === totalPages ? 'opacity-30 cursor-not-allowed' : 'hover:bg-brand-gold hover:text-brand-darkest'" class="glass-card px-3 py-1.5 rounded-xl border border-white/10 text-xs font-bold text-white transition-all">
        <span x-text="t.nextPage[lang]"></span>
      </button>
    </div>

  </section>

  <!-- ACTIVE QUIZ INTERFACE -->
  <section x-show="activeQuiz" x-transition.opacity style="display: none;" class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
    <button @click="activeQuiz = null; showResults = false" class="text-brand-slate hover:text-white mb-4 flex items-center gap-2 text-xs font-bold transition-all group">
      <svg class="w-4 h-4 transition-transform group-hover:-translate-x-1" :class="lang === 'en' ? 'rotate-180 group-hover:translate-x-1' : ''" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
      <span x-text="t.backBtn[lang]"></span>
    </button>

    <div class="glass-card p-5 sm:p-10 rounded-2xl sm:rounded-3xl relative overflow-hidden border border-white/5 shadow-xl">
      <!-- PROGRESS -->
      <div x-show="!showResults" class="mb-6">
        <div class="flex justify-between text-xs text-brand-slate mb-2.5 font-bold">
          <span x-text="lang === 'fa' ? 'سوال ' + num(currentQIndex + 1) + ' از ' + num(activeQuiz?.questions.length) : 'Question ' + (currentQIndex + 1) + ' of ' + activeQuiz?.questions.length"></span>
        </div>
        <div class="w-full bg-brand-dark rounded-full h-1.5 border border-white/5 overflow-hidden">
          <div class="bg-gradient-to-r from-brand-gold to-brand-goldHover h-full rounded-full transition-all duration-300" :style="'width: ' + (((currentQIndex + 1) / (activeQuiz?.questions.length || 1)) * 100) + '%'"></div>
        </div>
      </div>

      <!-- QUESTION -->
      <div x-show="!showResults" x-transition>
        <h2 class="text-base sm:text-xl font-bold text-white mb-6 font-heading" dir="ltr" x-text="typeof activeQuiz?.questions[currentQIndex]?.text === 'object' ? (activeQuiz?.questions[currentQIndex]?.text[lang] || activeQuiz?.questions[currentQIndex]?.text.en) : activeQuiz?.questions[currentQIndex]?.text"></h2>
        
        <div class="space-y-2.5">
          <template x-for="(option, idx) in activeQuiz?.questions[currentQIndex]?.options" :key="idx">
            <button 
              @click="selectOption(idx)"
              :class="selectedOption === idx ? 'border-brand-gold bg-brand-gold/10 text-white shadow-glow-gold' : 'border-white/10 text-brand-slate hover:bg-white/5'"
              class="w-full text-left p-3.5 rounded-xl border transition-all duration-200 text-xs sm:text-sm font-medium"
              dir="ltr"
            >
              <span class="mr-2 font-bold text-brand-gold" x-text="['A', 'B', 'C', 'D'][idx] + '.'"></span>
              <span x-text="typeof option === 'object' ? (option[lang] || option.en) : option"></span>
            </button>
          </template>
        </div>

        <div class="mt-6 flex justify-end">
          <button 
            @click="nextQuestion()"
            :disabled="selectedOption === null"
            :class="selectedOption === null ? 'opacity-50 cursor-not-allowed bg-brand-cardLight text-white/50' : 'bg-gradient-to-r from-brand-gold to-brand-goldHover text-brand-darkest shadow-glow-gold active:scale-95'"
            class="px-6 py-2.5 rounded-xl font-extrabold text-xs sm:text-sm transition-all"
            x-text="currentQIndex === (activeQuiz?.questions.length - 1) ? t.finishBtn[lang] : t.nextBtn[lang]"
          ></button>
        </div>
      </div>

      <!-- RESULTS -->
      <div x-show="showResults" x-transition class="text-center py-8 space-y-5">
        <div class="w-20 h-20 sm:w-24 sm:h-24 rounded-full bg-brand-gold/10 border-2 sm:border-4 border-brand-gold mx-auto flex items-center justify-center shadow-glow-gold">
          <span class="text-2xl sm:text-3xl font-black text-brand-gold" x-text="num(score) + '/' + num(activeQuiz?.questions.length)"></span>
        </div>
        <div>
          <h2 class="text-xl sm:text-2xl font-black text-white font-heading mb-1.5" x-text="t.resultTitle[lang]"></h2>
          <p class="text-brand-slate text-xs sm:text-sm max-w-md mx-auto leading-relaxed" x-text="t.resultDesc[lang]"></p>
        </div>
        <div class="pt-2">
          <button @click="activeQuiz = null; showResults = false" class="bg-brand-cardLight/80 hover:bg-brand-gold hover:text-brand-darkest text-white px-6 py-2.5 rounded-xl font-bold text-xs border border-white/10 transition-all active:scale-95" x-text="t.tryAgainBtn[lang]"></button>
        </div>
      </div>

    </div>
  </section>

</div>
@endsection

@push('scripts')
<script>
function quizApp() {
  const dbData = @json($dbQuizzes);

  return {
    activeQuiz: null,
    currentQIndex: 0,
    selectedOption: null,
    score: 0,
    showResults: false,
    searchQuery: '',
    selectedCategory: 'all',
    currentPage: 1,
    itemsPerPage: 6,
    quizzes: dbData || [],

    get filteredQuizzes() {
      return this.quizzes.filter(q => {
        const matchCat = this.selectedCategory === 'all' || q.category === this.selectedCategory;
        const query = this.searchQuery.toLowerCase().trim();
        const titleFa = (q.title?.fa || '').toLowerCase();
        const titleEn = (q.title?.en || '').toLowerCase();
        const descFa = (q.desc?.fa || '').toLowerCase();
        const descEn = (q.desc?.en || '').toLowerCase();
        const matchSearch = !query || titleFa.includes(query) || titleEn.includes(query) || descFa.includes(query) || descEn.includes(query);
        return matchCat && matchSearch;
      });
    },
    get totalPages() {
      return Math.ceil(this.filteredQuizzes.length / this.itemsPerPage) || 1;
    },
    get paginatedQuizzes() {
      const start = (this.currentPage - 1) * this.itemsPerPage;
      return this.filteredQuizzes.slice(start, start + this.itemsPerPage);
    },
    goToPage(p) {
      if (p >= 1 && p <= this.totalPages) {
        this.currentPage = p;
        window.scrollTo({ top: 0, behavior: 'smooth' });
      }
    },
    startQuiz(quiz) {
      this.activeQuiz = quiz;
      this.currentQIndex = 0;
      this.score = 0;
      this.selectedOption = null;
      this.showResults = false;
      window.scrollTo({ top: 0, behavior: 'smooth' });
    },
    selectOption(idx) {
      this.selectedOption = idx;
    },
    nextQuestion() {
      if (this.selectedOption === this.activeQuiz.questions[this.currentQIndex].correct) {
        this.score++;
      }
      if (this.currentQIndex < this.activeQuiz.questions.length - 1) {
        this.currentQIndex++;
        this.selectedOption = null;
        window.scrollTo({ top: 0, behavior: 'smooth' });
      } else {
        this.showResults = true;
      }
    },
    t: {
      pageBadge: { 
        fa: "{{ $settings['quizzes_badge_fa'] ?? 'ارزیابی هوشمند و هدفمند' }}", 
        en: "{{ $settings['quizzes_badge_en'] ?? 'Smart & Targeted Assessment' }}" 
      },
      pageTitle1: { 
        fa: "{{ $settings['quizzes_title1_fa'] ?? 'بانک آزمون‌ها و' }}", 
        en: "{{ $settings['quizzes_title1_en'] ?? 'Online Quiz Bank &' }}" 
      },
      pageTitle2: { 
        fa: "{{ $settings['quizzes_title2_fa'] ?? 'کوئیزهای آنلاین' }}", 
        en: "{{ $settings['quizzes_title2_en'] ?? 'Language Assessment' }}" 
      },
      pageDesc: { 
        fa: "{{ $settings['quizzes_desc_fa'] ?? 'آزمون مورد نظر خود را انتخاب کنید و سطح دانش زبانی خود را با سؤالات استاندارد بسنجید.' }}", 
        en: "{{ $settings['quizzes_desc_en'] ?? 'Select a quiz below and evaluate your language proficiency with standardized questions.' }}" 
      },
      searchPlaceholder: { fa: 'جستجو در آزمون‌ها...', en: 'Search quizzes...' },
      catAll: { fa: 'همه', en: 'All' },
      catGrammar: { fa: 'گرامر', en: 'Grammar' },
      catVocab: { fa: 'واژگان', en: 'Vocabulary' },
      catListening: { fa: 'شنیداری', en: 'Listening' },
      showingCount: { fa: 'نمایش', en: 'Showing' },
      ofTotal: { fa: 'از', en: 'of' },
      pageWord: { fa: 'صفحه', en: 'Page' },
      prevPage: { fa: 'قبلی', en: 'Prev' },
      nextPage: { fa: 'بعدی', en: 'Next' },
      startBtn: { fa: 'شروع آزمون', en: 'Start' },
      backBtn: { fa: 'بازگشت به آزمون‌ها', en: 'Back' },
      nextBtn: { fa: 'سوال بعدی', en: 'Next' },
      finishBtn: { fa: 'پایان آزمون', en: 'Finish' },
      resultTitle: { fa: 'نتیجه آزمون', en: 'Quiz Result' },
      resultDesc: { fa: 'نمره شما محاسبه شد؛ می‌توانید مجدداً این آزمون را تکرار کنید.', en: 'Your score has been calculated. You can retry anytime.' },
      tryAgainBtn: { fa: 'آزمون مجدد', en: 'Retry' },
      noResult: { fa: 'آزمونی یافت نشد.', en: 'No quizzes found.' }
    }
  }
}
</script>
@endpush