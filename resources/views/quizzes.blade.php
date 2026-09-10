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
<div x-data="quizApp()" class="space-y-10 sm:space-y-14 py-8 sm:py-12">
  
  <!-- QUIZ SELECTION & FILTERS -->
  <section x-show="!activeQuiz" x-transition.opacity class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">
    
    <!-- PAGE TITLE -->
    <div class="space-y-4 max-w-3xl mx-auto text-center">
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

    <!-- SEARCH & FILTER CONTROLS -->
    <div class="max-w-xl mx-auto space-y-4">
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

      <!-- LEVEL & CATEGORY FILTER BUTTONS -->
      <div class="flex items-center justify-center gap-2 flex-wrap text-xs font-semibold">
        <button
          @click="selectedCategory = 'all'; currentPage = 1"
          :class="selectedCategory === 'all' ? 'bg-brand-gold text-brand-darkest font-black shadow-glow-gold' : 'glass-card text-brand-slate hover:text-white border-white/5'"
          class="px-3.5 py-1.5 rounded-xl transition-all"
          x-text="t.catAll[lang]"
        ></button>
        <button
          @click="selectedCategory = 'grammar'; currentPage = 1"
          :class="selectedCategory === 'grammar' ? 'bg-brand-gold text-brand-darkest font-black shadow-glow-gold' : 'glass-card text-brand-slate hover:text-white border-white/5'"
          class="px-3.5 py-1.5 rounded-xl transition-all"
          x-text="t.catGrammar[lang]"
        ></button>
        <button
          @click="selectedCategory = 'vocab'; currentPage = 1"
          :class="selectedCategory === 'vocab' ? 'bg-brand-gold text-brand-darkest font-black shadow-glow-gold' : 'glass-card text-brand-slate hover:text-white border-white/5'"
          class="px-3.5 py-1.5 rounded-xl transition-all"
          x-text="t.catVocab[lang]"
        ></button>
        <button
          @click="selectedCategory = 'listening'; currentPage = 1"
          :class="selectedCategory === 'listening' ? 'bg-brand-gold text-brand-darkest font-black shadow-glow-gold' : 'glass-card text-brand-slate hover:text-white border-white/5'"
          class="px-3.5 py-1.5 rounded-xl transition-all"
          x-text="t.catListening[lang]"
        ></button>
      </div>
    </div>

    <!-- SUMMARY BAR -->
    <div class="flex items-center justify-between border-b border-white/5 pb-3 text-xs text-brand-slate font-semibold pt-4">
      <div class="flex items-center gap-2">
        <span class="w-2 h-2 rounded-full bg-brand-gold"></span>
        <span>
          <span x-text="t.showingCount[lang]"></span>
          <strong class="text-white mx-1 font-bold" x-text="num(paginatedQuizzes.length)"></strong>
          <span x-text="t.ofTotal[lang]"></span>
          <strong class="text-brand-gold mx-1 font-bold" x-text="num(filteredQuizzes.length)"></strong>
          <span x-text="t.totalItems[lang]"></span>
        </span>
      </div>
      <div class="text-[11px] text-brand-slate/70 font-bold">
        <span x-text="t.pageWord[lang]"></span>
        <span class="text-white font-bold" x-text="num(currentPage)"></span> / <span x-text="num(totalPages)"></span>
      </div>
    </div>

    <!-- QUIZZES GRID -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
      <template x-for="quiz in paginatedQuizzes" :key="quiz.id">
        <div class="glass-card glass-card-hover p-6 rounded-3xl flex flex-col justify-between space-y-5 group">
          <div>
            <span class="text-[10px] bg-brand-gold/20 text-brand-gold font-bold px-2.5 py-1 rounded-lg border border-brand-gold/20" x-text="quiz.level"></span>
            <h3 class="text-xl font-bold text-white mt-4 font-heading group-hover:text-brand-gold transition-colors" x-text="quiz.title[lang]"></h3>
            <p class="text-brand-slate text-sm mt-2 leading-relaxed" x-text="quiz.desc[lang]"></p>
          </div>
          <button @click="startQuiz(quiz)" class="w-full inline-flex items-center justify-center gap-2 bg-brand-cardLight/80 hover:bg-brand-gold hover:text-brand-darkest text-white text-xs font-bold py-3 rounded-xl transition-all active:scale-95">
            <span x-text="t.startBtn[lang]"></span>
            <svg class="w-3.5 h-3.5" :class="lang === 'en' ? 'rotate-180' : ''" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 12H5m7 7l-7-7 7-7"/>
            </svg>
          </button>
        </div>
      </template>
    </div>

    <!-- EMPTY STATE -->
    <div x-show="filteredQuizzes.length === 0" class="glass-card rounded-3xl p-12 text-center space-y-4 max-w-md mx-auto my-8">
      <p class="text-sm text-brand-slate font-medium" x-text="t.noResult[lang]"></p>
    </div>

    <!-- PAGINATION -->
    <div x-show="totalPages > 1" class="pt-6 flex items-center justify-center gap-2">
      <button @click="goToPage(currentPage - 1)" :disabled="currentPage === 1" :class="currentPage === 1 ? 'opacity-40 cursor-not-allowed text-brand-slate' : 'hover:bg-brand-gold hover:text-brand-darkest text-white border-white/10'" class="glass-card px-3.5 py-2 rounded-xl border text-xs font-bold transition-all">
        <span x-text="t.prevPage[lang]"></span>
      </button>
      <div class="flex items-center gap-1.5">
        <template x-for="p in totalPages" :key="p">
          <button @click="goToPage(p)" :class="currentPage === p ? 'bg-gradient-to-r from-brand-gold to-brand-goldHover text-brand-darkest font-black shadow-glow-gold' : 'glass-card text-brand-slate hover:text-white border-white/5 font-bold'" class="w-9 h-9 rounded-xl text-xs font-bold transition-all flex items-center justify-center" x-text="num(p)"></button>
        </template>
      </div>
      <button @click="goToPage(currentPage + 1)" :disabled="currentPage === totalPages" :class="currentPage === totalPages ? 'opacity-40 cursor-not-allowed text-brand-slate' : 'hover:bg-brand-gold hover:text-brand-darkest text-white border-white/10'" class="glass-card px-3.5 py-2 rounded-xl border text-xs font-bold transition-all">
        <span x-text="t.nextPage[lang]"></span>
      </button>
    </div>

  </section>

  <!-- ACTIVE QUIZ INTERFACE -->
  <section x-show="activeQuiz" x-transition.opacity style="display: none;" class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
    
    <button @click="activeQuiz = null; showResults = false" class="text-brand-slate hover:text-white mb-6 flex items-center gap-2 text-sm font-bold transition-all group">
      <svg class="w-4 h-4 transition-transform group-hover:-translate-x-1" :class="lang === 'en' ? 'rotate-180 group-hover:translate-x-1' : ''" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
      <span x-text="t.backBtn[lang]"></span>
    </button>

    <div class="glass-card p-6 sm:p-10 rounded-3xl relative overflow-hidden border border-white/5 shadow-xl">
      
      <!-- PROGRESS BAR -->
      <div x-show="!showResults" class="mb-8">
        <div class="flex justify-between text-xs text-brand-slate mb-3 font-bold">
          <span x-text="lang === 'fa' ? 'سوال ' + num(currentQIndex + 1) + ' از ' + num(activeQuiz?.questions.length) : 'Question ' + (currentQIndex + 1) + ' of ' + activeQuiz?.questions.length"></span>
        </div>
        <div class="w-full bg-brand-dark rounded-full h-2 border border-white/5 overflow-hidden">
          <div class="bg-gradient-to-r from-brand-gold to-brand-goldHover h-full rounded-full transition-all duration-300" :style="'width: ' + (((currentQIndex + 1) / (activeQuiz?.questions.length || 1)) * 100) + '%'"></div>
        </div>
      </div>

      <!-- QUESTION -->
      <div x-show="!showResults" x-transition>
        <h2 class="text-lg sm:text-2xl font-bold text-white mb-8 font-heading" dir="ltr" x-text="typeof activeQuiz?.questions[currentQIndex]?.text === 'object' ? (activeQuiz?.questions[currentQIndex]?.text[lang] || activeQuiz?.questions[currentQIndex]?.text.en) : activeQuiz?.questions[currentQIndex]?.text"></h2>
        
        <div class="space-y-3">
          <template x-for="(option, idx) in activeQuiz?.questions[currentQIndex]?.options" :key="idx">
            <button 
              @click="selectOption(idx)"
              :class="selectedOption === idx ? 'border-brand-gold bg-brand-gold/10 text-white shadow-glow-gold' : 'border-white/10 text-brand-slate hover:bg-white/5 hover:border-white/20'"
              class="w-full text-left p-4 rounded-xl border transition-all duration-200 font-medium"
              dir="ltr"
            >
              <span class="mr-3 font-bold text-brand-gold" x-text="['A', 'B', 'C', 'D'][idx] + '.'"></span>
              <span class="text-base" x-text="typeof option === 'object' ? (option[lang] || option.en) : option"></span>
            </button>
          </template>
        </div>

        <div class="mt-8 flex justify-end">
          <button 
            @click="nextQuestion()"
            :disabled="selectedOption === null"
            :class="selectedOption === null ? 'opacity-50 cursor-not-allowed bg-brand-cardLight text-white/50' : 'bg-gradient-to-r from-brand-gold to-brand-goldHover text-brand-darkest shadow-glow-gold active:scale-95'"
            class="px-8 py-3 rounded-xl font-extrabold text-sm transition-all"
            x-text="currentQIndex === (activeQuiz?.questions.length - 1) ? t.finishBtn[lang] : t.nextBtn[lang]"
          ></button>
        </div>
      </div>

      <!-- RESULTS -->
      <div x-show="showResults" x-transition class="text-center py-10 space-y-6">
        <div class="w-28 h-28 rounded-full bg-brand-gold/10 border-4 border-brand-gold mx-auto flex items-center justify-center shadow-glow-gold">
          <span class="text-4xl font-black text-brand-gold" x-text="num(score) + '/' + num(activeQuiz?.questions.length)"></span>
        </div>
        <div>
          <h2 class="text-2xl sm:text-3xl font-black text-white font-heading mb-2" x-text="t.resultTitle[lang]"></h2>
          <p class="text-brand-slate text-sm sm:text-base leading-relaxed" x-text="t.resultDesc[lang]"></p>
        </div>
        <div class="pt-4">
          <button @click="activeQuiz = null; showResults = false" class="bg-brand-cardLight/80 hover:bg-brand-gold hover:text-brand-darkest text-white px-8 py-3 rounded-xl font-bold text-sm border border-white/10 transition-all active:scale-95 shadow" x-text="t.tryAgainBtn[lang]"></button>
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

  const fallbackQuizzes = [
    {
      id: 1,
      title: { fa: 'آزمون تعیین سطح گرامر', en: 'Grammar Placement Test' },
      desc: { fa: 'ارزیابی ساختارهای پایه تا پیشرفته زبان انگلیسی با تمرکز بر کاربرد در مکالمه', en: 'Evaluate your basic to advanced grammatical structures with focus on context' },
      level: 'B1 - B2',
      category: 'grammar',
      questions: [
        { text: "I _____ to the cinema yesterday.", options: ["go", "went", "gone", "going"], correct: 1 },
        { text: "She has been living here _____ 2015.", options: ["for", "since", "in", "from"], correct: 1 }
      ]
    },
    {
      id: 2,
      title: { fa: 'لغات ضروری آیلتس', en: 'Essential IELTS Vocab' },
      desc: { fa: 'لغات پرتکرار و آکادمیک آزمون آیلتس بر اساس تست‌های سال‌های اخیر کمبریج', en: 'High-frequency academic vocabulary based on recent Cambridge IELTS tests' },
      level: 'C1',
      category: 'vocab',
      questions: [
        { text: "The new policy is expected to _____ economic growth.", options: ["mitigate", "hinder", "stimulate", "diminish"], correct: 2 }
      ]
    },
    {
      id: 3,
      title: { fa: 'درک مطلب پیشرفته', en: 'Advanced Reading Comprehension' },
      desc: { fa: 'تمرین متون آکادمیک و تکنیک‌های اسکن متن برای آزمون‌های بین‌المللی', en: 'Practice academic texts and scanning techniques for international exams' },
      level: 'B2 - C1',
      category: 'reading',
      questions: [
        { text: "What is the primary purpose of the passage?", options: ["To criticize", "To inform", "To entertain", "To confuse"], correct: 1 }
      ]
    },
    {
      id: 4,
      title: { fa: 'مهارت شنیداری پارت ۱', en: 'Listening Practice Part 1' },
      desc: { fa: 'تقویت درک جزئیات مکالمات روزمره و کاری انگلیسی‌زبانان', en: 'Improve comprehension of everyday and business conversations' },
      level: 'A2 - B1',
      category: 'listening',
      questions: [
        { text: "Where did the conversation take place?", options: ["Airport", "Restaurant", "Hospital", "Library"], correct: 0 }
      ]
    }
  ];

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
    quizzes: (dbData && dbData.length > 0) ? dbData : fallbackQuizzes,

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
      pageBadge: { fa: 'ارزیابی هوشمند و هدفمند', en: 'Smart & Targeted Assessment' },
      pageTitle1: { fa: 'بانک آزمون‌ها و', en: 'Online Quiz Bank &' },
      pageTitle2: { fa: 'کوئیزهای آنلاین', en: 'Language Assessment' },
      pageDesc: { fa: 'آزمون مورد نظر خود را انتخاب کنید و سطح دانش زبانی خود را با سؤالات استاندارد بسنجید.', en: 'Select a quiz below and evaluate your language proficiency with standardized questions.' },
      searchPlaceholder: { fa: 'جستجو در عنوان یا توضیحات آزمون...', en: 'Search quizzes by title or keyword...' },
      catAll: { fa: 'همه موضوعات', en: 'All Topics' },
      catGrammar: { fa: 'گرامر', en: 'Grammar' },
      catVocab: { fa: 'واژگان', en: 'Vocabulary' },
      catListening: { fa: 'شنیداری', en: 'Listening' },
      showingCount: { fa: 'نمایش', en: 'Showing' },
      ofTotal: { fa: 'از مجموع', en: 'of' },
      totalItems: { fa: 'آزمون', en: 'quizzes' },
      pageWord: { fa: 'صفحه', en: 'Page' },
      prevPage: { fa: 'قبلی', en: 'Previous' },
      nextPage: { fa: 'بعدی', en: 'Next' },
      startBtn: { fa: 'شروع آزمون', en: 'Start Quiz' },
      backBtn: { fa: 'بازگشت به لیست آزمون‌ها', en: 'Back to Quizzes' },
      nextBtn: { fa: 'ثبت و سوال بعدی', en: 'Submit & Next' },
      finishBtn: { fa: 'پایان و مشاهده نتیجه', en: 'Finish & View Result' },
      resultTitle: { fa: 'آزمون به پایان رسید!', en: 'Quiz Completed!' },
      resultDesc: { fa: 'نمره شما بر اساس پاسخ‌های صحیح محاسبه شد. می‌توانید مجدداً این آزمون را تکرار کنید یا به سراغ کوئیزهای دیگر بروید.', en: 'Your score has been calculated based on correct answers. You can retake this quiz or try others.' },
      tryAgainBtn: { fa: 'بازگشت به بانک آزمون‌ها', en: 'Back to Quiz Bank' },
      noResult: { fa: 'آزمونی مطابق با جستجوی شما یافت نشد.', en: 'No quizzes matched your search query.' }
    }
  }
}
</script>
@endpush