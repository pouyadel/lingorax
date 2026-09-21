<!doctype html>
<html lang="fa" dir="rtl" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ورود به آزمون اختصاصی | {{ $quiz->title_fa }}</title>

    <link rel="icon" type="image/png" href="{{ asset('images/favicon.png') }}" />
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">

    <!-- Tailwind & Alpine محلی -->
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
                gold: "#D4AF37",
                goldHover: "#BA9524",
                slate: "#94A3B8",
              }
            },
            boxShadow: {
              'glow-gold': '0 0 30px rgba(212, 175, 55, 0.2)',
            }
          }
        }
      }
    </script>
</head>
<body class="bg-[#080F1D] text-[#f8fafc] min-h-screen flex items-center justify-center p-4 antialiased selection:bg-brand-gold selection:text-brand-darkest">

    <div class="max-w-md w-full bg-[#0E1A2E]/90 backdrop-blur-xl p-6 sm:p-8 rounded-3xl border border-white/10 shadow-2xl space-y-6 text-center">
        
        <!-- آیکون قفل طلایی -->
        <div class="w-16 h-16 mx-auto rounded-2xl bg-brand-gold/10 border border-brand-gold/30 flex items-center justify-center text-brand-gold shadow-glow-gold">
            <svg class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
            </svg>
        </div>

        <div class="space-y-2">
            <span class="inline-block text-[11px] font-bold px-3 py-1 rounded-full bg-purple-500/15 text-purple-400 border border-purple-500/25">
                🔒 آزمون ارزیابی اختصاصی
            </span>
            <h1 class="text-lg sm:text-xl font-black text-white">
                {{ $quiz->title_fa }}
            </h1>
            <p class="text-xs text-brand-slate leading-relaxed">
                این آزمون به صورت خصوصی برگزار می‌شود. برای دسترسی، لطفاً رمز عبور دریافتی از استاد را وارد کنید.
            </p>
        </div>

        @if($errors->has('password'))
            <div class="bg-rose-500/10 border border-rose-500/30 text-rose-400 p-3 rounded-xl text-xs font-bold">
                {{ $errors->first('password') }}
            </div>
        @endif

        <form action="{{ route('quizzes.unlock', $quiz) }}" method="POST" class="space-y-4">
            @csrf
            <div class="space-y-1">
                <input 
                    type="password" 
                    name="password" 
                    required 
                    autofocus
                    placeholder="رمز ورود آزمون..." 
                    class="w-full bg-[#080F1D] border border-white/10 focus:border-brand-gold text-white text-center tracking-widest text-sm rounded-xl px-4 py-3 focus:outline-none transition-colors"
                />
            </div>

            <button 
                type="submit" 
                class="w-full bg-gradient-to-r from-brand-gold to-brand-goldHover text-brand-darkest font-black py-3 rounded-xl text-xs shadow-glow-gold hover:scale-[1.02] active:scale-95 transition-all"
            >
                تأیید رمز و ورود به آزمون
            </button>
        </form>

        <div class="pt-3 border-t border-white/5 text-[11px] text-brand-slate flex justify-center items-center gap-3">
            <span>تعداد سوالات: {{ $quiz->questions()->count() }}</span>
            <span>•</span>
            <span>سطح: {{ $quiz->level }}</span>
            <span>•</span>
            <a href="{{ route('home') }}" class="text-brand-gold hover:underline">بازگشت به سایت</a>
        </div>
    </div>

</body>
</html>