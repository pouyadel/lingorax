<!doctype html>
<html lang="fa" dir="rtl" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>آزمون: {{ $quiz->title_fa }}</title>

    <link rel="icon" type="image/png" href="{{ asset('images/favicon.png') }}" />
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">

    <script src="{{ asset('js/tailwindcss.js') }}"></script>
    <script defer src="{{ asset('js/alpine.min.js') }}"></script>

    <style>
      @font-face {
        font-family: 'Modam';
        src: url("{{ asset('fonts/ModamVF.ttf') }}") format('truetype');
        font-weight: 100 900;
        font-style: normal;
        font-display: swap;
      }
      *, *::before, *::after, html, body, input, button {
        font-family: 'Modam', system-ui, -apple-system, sans-serif !important;
      }
    </style>

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
            },
            boxShadow: {
              'glow-gold': '0 0 25px rgba(212, 175, 55, 0.25)',
            }
          }
        }
      }
    </script>
</head>
<body class="bg-[#080F1D] text-[#f8fafc] min-h-screen py-8 px-4 antialiased selection:bg-brand-gold selection:text-brand-darkest">

<div x-data="quizPlayer()" class="max-w-3xl mx-auto space-y-6">

    <!-- هدر آزمون -->
    <div class="bg-[#0E1A2E] p-4 sm:p-6 rounded-3xl border border-white/10 flex items-center justify-between gap-4">
        <div>
            <span class="text-[10px] font-bold px-2.5 py-1 rounded-md bg-brand-gold/15 text-brand-gold border border-brand-gold/25">
                {{ $quiz->category }} - سطح {{ $quiz->level }}
            </span>
            <h1 class="text-base sm:text-lg font-black text-white mt-2">
                {{ $quiz->title_fa }}
            </h1>
        </div>
        <div class="text-left" x-show="!finished">
            <span class="text-xs text-brand-slate font-bold block">پیشرفت:</span>
            <span class="text-sm sm:text-base font-black text-brand-gold font-mono" x-text="(currentIndex + 1) + ' / ' + total"></span>
        </div>
    </div>

    <!-- بدنه سوالات آزمون -->
    <div x-show="!finished" class="bg-[#0E1A2E] p-6 sm:p-8 rounded-3xl border border-white/10 space-y-6 shadow-2xl">
        <div class="space-y-2 border-b border-white/5 pb-4">
            <h2 class="text-base sm:text-lg font-bold text-white leading-relaxed" dir="ltr" x-text="currentQuestion.text_en"></h2>
            <p class="text-xs text-brand-slate" x-show="currentQuestion.text_fa" x-text="currentQuestion.text_fa"></p>
        </div>

        <div class="space-y-3">
            <template x-for="(opt, idx) in currentQuestion.options" :key="idx">
                <button 
                    type="button" 
                    @click="selectOption(idx)"
                    class="w-full text-right p-4 rounded-2xl border transition-all flex items-center justify-between gap-3"
                    :class="selectedAnswers[currentIndex] === idx 
                        ? 'bg-brand-gold/15 border-brand-gold text-white shadow-glow-gold' 
                        : 'bg-[#080F1D] border-white/5 text-brand-slate hover:border-white/20 hover:text-white'"
                >
                    <div class="flex items-center gap-3">
                        <span class="w-7 h-7 rounded-xl flex items-center justify-center font-bold text-xs"
                            :class="selectedAnswers[currentIndex] === idx ? 'bg-brand-gold text-brand-darkest' : 'bg-white/5 text-brand-slate'"
                            x-text="['A', 'B', 'C', 'D'][idx]">
                        </span>
                        <span class="text-xs sm:text-sm font-semibold" dir="ltr" x-text="opt.text_en"></span>
                    </div>
                    <span class="text-xs text-brand-slate/70" x-text="opt.text_fa"></span>
                </button>
            </template>
        </div>

        <div class="flex items-center justify-between pt-4 border-t border-white/5">
            <button 
                type="button" 
                @click="prevQuestion()" 
                x-show="currentIndex > 0"
                class="px-5 py-2.5 rounded-xl bg-white/5 hover:bg-white/10 text-white text-xs font-bold transition-all"
            >
                ← سوال قبلی
            </button>
            <div x-show="currentIndex === 0"></div>

            <button 
                type="button" 
                @click="nextQuestion()" 
                x-show="currentIndex < total - 1"
                class="px-6 py-2.5 rounded-xl bg-brand-gold hover:bg-brand-goldHover text-brand-darkest text-xs font-black shadow-glow-gold transition-all"
            >
                سوال بعدی →
            </button>

            <button 
                type="button" 
                @click="finishQuiz()" 
                x-show="currentIndex === total - 1"
                class="px-6 py-2.5 rounded-xl bg-gradient-to-r from-emerald-500 to-teal-600 text-white text-xs font-black shadow-lg transition-all"
            >
                پایان آزمون و مشاهده نتیجه ✓
            </button>
        </div>
    </div>

    <!-- کارنامه نتیجه نهایی -->
    <div x-show="finished" x-transition class="bg-[#0E1A2E] p-6 sm:p-10 rounded-3xl border border-brand-gold/30 text-center space-y-6 shadow-2xl">
        <div class="w-20 h-20 mx-auto rounded-3xl bg-brand-gold/15 border border-brand-gold/30 flex items-center justify-center text-brand-gold text-3xl font-black shadow-glow-gold">
            <span x-text="Math.round((score / total) * 100) + '%'"></span>
        </div>

        <div class="space-y-2">
            <h2 class="text-xl font-black text-white">نتیجه آزمون شما</h2>
            <p class="text-xs sm:text-sm text-brand-slate leading-relaxed">
                شما به <span class="text-brand-gold font-bold font-mono" x-text="score"></span> سوال از مجموع <span class="text-white font-bold font-mono" x-text="total"></span> سوال پاسخ صحیح دادید.
            </p>
        </div>

        <div class="pt-4 flex justify-center gap-3">
            <button 
                type="button" 
                @click="restartQuiz()" 
                class="px-6 py-2.5 rounded-xl bg-brand-gold hover:bg-brand-goldHover text-brand-darkest text-xs font-black transition-all"
            >
                تلاش مجدد
            </button>
            <a 
                href="{{ route('home') }}" 
                class="px-6 py-2.5 rounded-xl bg-white/5 hover:bg-white/10 text-white text-xs font-bold transition-all"
            >
                بازگشت به صفحه اصلی
            </a>
        </div>
    </div>

</div>

<script>
function quizPlayer() {
    const rawQuestions = @json($quiz->questions);
    return {
        questions: rawQuestions,
        total: rawQuestions.length,
        currentIndex: 0,
        selectedAnswers: {},
        finished: false,
        score: 0,

        get currentQuestion() {
            return this.questions[this.currentIndex] || { options: [] };
        },
        selectOption(idx) {
            this.selectedAnswers[this.currentIndex] = idx;
        },
        nextQuestion() {
            if (this.selectedAnswers[this.currentIndex] === undefined) {
                alert('لطفاً ابتدا یکی از گزینه‌ها را انتخاب کنید.');
                return;
            }
            if (this.currentIndex < this.total - 1) {
                this.currentIndex++;
            }
        },
        prevQuestion() {
            if (this.currentIndex > 0) {
                this.currentIndex--;
            }
        },
        finishQuiz() {
            if (this.selectedAnswers[this.currentIndex] === undefined) {
                alert('لطفاً به سوال آخر پاسخ دهید.');
                return;
            }
            let correctCount = 0;
            this.questions.forEach((q, qIdx) => {
                const userChoice = this.selectedAnswers[qIdx];
                if (userChoice !== undefined && q.options[userChoice] && q.options[userChoice].is_correct) {
                    correctCount++;
                }
            });
            this.score = correctCount;
            this.finished = true;
        },
        restartQuiz() {
            this.selectedAnswers = {};
            this.currentIndex = 0;
            this.score = 0;
            this.finished = false;
        }
    }
}
</script>

</body>
</html>