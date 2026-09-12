<!doctype html>
<html lang="fa" dir="rtl" class="h-full overflow-x-hidden">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <title>به زودی | LINGORAX - پایگاه مقالات و کوئیزهای آنلاین زبان</title>

    <!-- FAVICON -->
    <link rel="icon" type="image/png" href="{{ asset('images/favicon.png') }}?v=2" />
    <link rel="apple-touch-icon" href="{{ asset('images/favicon.png') }}?v=2" />

        <script src="{{ asset('js/tailwindcss.js') }}"></script>
        <script defer src="{{ asset('js/alpine.min.js') }}"></script>
    <style>
      @font-face {
        font-family: "Modam VF";
        src: url("{{ asset('fonts/ModamVF.woff') }}") format("woff"),
             url("{{ asset('fonts/ModamVF.ttf') }}") format("truetype");
        font-weight: 100 900;
        font-display: swap;
      }
      @font-face {
        font-family: "Modam Static";
        src: url("{{ asset('fonts/staticfonts/ModamWeb-Regular.woff') }}") format("woff");
        font-weight: 400;
        font-display: swap;
      }
      @font-face {
        font-family: "Modam Static";
        src: url("{{ asset('fonts/staticfonts/ModamWeb-Bold.woff') }}") format("woff");
        font-weight: 700;
        font-display: swap;
      }

      html, body {
        overflow-x: hidden;
        max-width: 100%;
      }

      body {
        font-family: "Modam VF", "Modam Static", system-ui, -apple-system, sans-serif;
        background-color: #080f1d;
        color: #f8fafc;
        -webkit-tap-highlight-color: transparent;
      }

      .bg-radial-glow {
        background-image: 
          radial-gradient(circle at 50% 15%, rgba(212, 175, 55, 0.08) 0%, transparent 45%),
          radial-gradient(circle at 10% 85%, rgba(56, 189, 248, 0.05) 0%, transparent 40%),
          radial-gradient(circle at 90% 85%, rgba(212, 175, 55, 0.06) 0%, transparent 45%);
      }

      .text-gold-gradient {
        background: linear-gradient(135deg, #FFF0B8 0%, #D4AF37 50%, #AA820A 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
      }

      .glass-card {
        background: linear-gradient(135deg, rgba(27, 42, 74, 0.5) 0%, rgba(14, 26, 46, 0.75) 100%);
        backdrop-filter: blur(16px);
        -webkit-backdrop-filter: blur(16px);
        border: 1px solid rgba(255, 255, 255, 0.08);
      }

      .glass-card-glow {
        border-color: rgba(212, 175, 55, 0.25);
        box-shadow: 0 10px 30px -10px rgba(0, 0, 0, 0.5), 0 0 25px 0 rgba(212, 175, 55, 0.08);
      }
    </style>

    <script>
      tailwind.config = {
        theme: {
          extend: {
            fontFamily: {
              sans: ["Modam VF", "Modam Static", "sans-serif"],
            },
            colors: {
              brand: {
                darkest: "#080F1D",
                dark: "#0E1A2E",
                card: "#16253F",
                cardLight: "#203456",
                gold: "#D4AF37",
                goldLight: "#F2D06B",
                goldHover: "#BA9524",
                slate: "#94A3B8",
                muted: "#64748B",
              },
            },
            boxShadow: {
              'glow-gold': '0 0 25px rgba(212, 175, 55, 0.25)',
            }
          },
        },
      };
    </script>
  </head>

  <body
    x-data="{
      targetDate: new Date('2026-10-12T00:00:00+03:30').getTime(),
      days: '۰۰',
      hours: '۰۰',
      minutes: '۰۰',
      seconds: '۰۰',
      phone: '',
      toast: false,
      toastMsg: '',
      toFa(num) {
        return String(num).padStart(2, '0').replace(/\d/g, d => '۰۱۲۳۴۵۶۷۸۹'[d]);
      },
      init() {
        this.updateTimer();
        setInterval(() => this.updateTimer(), 1000);
      },
      updateTimer() {
        const now = new Date().getTime();
        const diff = Math.max(0, this.targetDate - now);
        this.days = this.toFa(Math.floor(diff / (1000 * 60 * 60 * 24)));
        this.hours = this.toFa(Math.floor((diff % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60)));
        this.minutes = this.toFa(Math.floor((diff % (1000 * 60 * 60)) / (1000 * 60)));
        this.seconds = this.toFa(Math.floor((diff % (1000 * 60)) / 1000));
      },
      submitNotify() {
        if (this.phone.length >= 10) {
          this.toastMsg = 'شماره شما ثبت شد؛ به محض انتشار سایت مطلع می‌شوید.';
          this.toast = true;
          this.phone = '';
          setTimeout(() => this.toast = false, 4000);
        } else {
          this.toastMsg = 'لطفاً شماره موبایل معتبر وارد کنید.';
          this.toast = true;
          setTimeout(() => this.toast = false, 3000);
        }
      }
    }"
    class="min-h-full flex flex-col justify-between relative bg-radial-glow selection:bg-brand-gold selection:text-brand-darkest"
  >
    <!-- AMBIENT GLOW EFFECTS -->
    <div class="fixed top-0 right-1/2 translate-x-1/2 w-72 sm:w-[28rem] h-72 sm:h-[28rem] bg-brand-gold/10 rounded-full blur-[100px] pointer-events-none -z-10"></div>
    <div class="fixed bottom-0 left-0 w-64 sm:w-80 h-64 sm:h-80 bg-sky-500/10 rounded-full blur-[90px] pointer-events-none -z-10"></div>

    <!-- TOAST NOTIFICATION -->
    <div
      x-show="toast"
      x-transition:enter="transition ease-out duration-300 transform"
      x-transition:enter-start="-translate-y-6 opacity-0"
      x-transition:enter-end="translate-y-0 opacity-100"
      x-transition:leave="transition ease-in duration-200 transform"
      x-transition:leave-start="translate-y-0 opacity-100"
      x-transition:leave-end="-translate-y-6 opacity-0"
      class="fixed top-4 left-4 right-4 sm:left-1/2 sm:right-auto sm:-translate-x-1/2 z-50 glass-card bg-brand-dark/95 text-white px-4 py-3 rounded-2xl shadow-glow-gold border border-brand-gold/40 flex items-center justify-center gap-2.5 text-xs sm:text-sm font-bold text-center"
      style="display: none;"
    >
      <div class="w-5 h-5 rounded-full bg-brand-gold/20 flex items-center justify-center text-brand-gold flex-shrink-0">
        <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20">
          <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
        </svg>
      </div>
      <span x-text="toastMsg"></span>
    </div>

    <!-- HEADER (فقط لوگوی اصلی بدون متن) -->
    <header class="py-5 px-4 sm:px-8 max-w-7xl mx-auto w-full flex items-center justify-between z-10">
      
      <!-- Full Brand Logo Only -->
      <a href="#" class="flex items-center group">
        <img
          src="{{ asset('images/logo.png') }}"
          alt="LINGORAX Logo"
          class="h-9 sm:h-12 w-auto object-contain transition-transform duration-300 group-hover:scale-105"
        />
      </a>

      <!-- Launch Badge -->
      <div class="flex items-center gap-2 glass-card border border-white/10 px-3 sm:px-4 py-1.5 rounded-full text-[11px] sm:text-xs font-semibold text-brand-slate">
        <span class="relative flex h-2 w-2 flex-shrink-0">
          <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-brand-gold opacity-75"></span>
          <span class="relative inline-flex rounded-full h-2 w-2 bg-brand-gold"></span>
        </span>
        <span class="text-white/90 whitespace-nowrap">رونمایی: <strong class="text-brand-gold">۲۰ مهر</strong></span>
      </div>

    </header>

    <!-- HERO CONTENT & COUNTDOWN -->
    <main class="flex-grow flex items-center justify-center py-6 sm:py-10 px-4 z-10">
      <div class="max-w-3xl w-full text-center space-y-6 sm:space-y-10">
        
        <!-- BADGE & HEADLINE -->
        <div class="space-y-3 sm:space-y-4">
          <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full glass-card border-brand-gold/25 text-[11px] sm:text-sm text-brand-goldLight font-medium">
            <span>✨ پایگاه اختصاصی آموزش و کوئیزهای آنلاین زبان</span>
          </div>

          <h1 class="text-2xl sm:text-5xl lg:text-6xl font-black text-white leading-tight">
            مرجع تحلیلی و کوئیزهای آنلاین <br/>
            <span class="text-gold-gradient relative inline-block mt-1">
              به‌زودی در دسترس شماست
              <svg class="absolute -bottom-1.5 sm:-bottom-2 right-0 w-full text-brand-gold/40" viewBox="0 0 100 10" preserveAspectRatio="none" height="6">
                <path d="M0,5 Q50,10 100,5" stroke="currentColor" stroke-width="4" fill="transparent"/>
              </svg>
            </span>
          </h1>

          <p class="text-brand-slate text-xs sm:text-base lg:text-lg max-w-xl mx-auto leading-relaxed px-2">
            در حال بارگذاری مقالات تحلیلی، نکات مهارت‌های زبانی و آماده‌سازی سیستم خودکار ارزیابی آزمون‌ها هستیم.
          </p>
        </div>

        <!-- COUNTDOWN TIMER (DAYS -> HOURS -> MINUTES -> SECONDS) -->
        <div dir="ltr" class="grid grid-cols-4 gap-2 sm:gap-4 max-w-lg mx-auto w-full">
          
          <!-- Days (Leftmost) -->
          <div class="glass-card glass-card-glow rounded-2xl p-2.5 sm:p-5 space-y-1 relative overflow-hidden flex flex-col justify-center items-center">
            <div class="text-xl sm:text-4xl lg:text-5xl font-black text-gold-gradient tracking-tight" x-text="days">۰۰</div>
            <div class="text-[10px] sm:text-xs text-brand-slate font-medium">روز</div>
            <div class="absolute inset-x-0 bottom-0 h-0.5 bg-gradient-to-r from-transparent via-brand-gold/40 to-transparent"></div>
          </div>

          <!-- Hours -->
          <div class="glass-card glass-card-glow rounded-2xl p-2.5 sm:p-5 space-y-1 relative overflow-hidden flex flex-col justify-center items-center">
            <div class="text-xl sm:text-4xl lg:text-5xl font-black text-gold-gradient tracking-tight" x-text="hours">۰۰</div>
            <div class="text-[10px] sm:text-xs text-brand-slate font-medium">ساعت</div>
            <div class="absolute inset-x-0 bottom-0 h-0.5 bg-gradient-to-r from-transparent via-brand-gold/40 to-transparent"></div>
          </div>

          <!-- Minutes -->
          <div class="glass-card glass-card-glow rounded-2xl p-2.5 sm:p-5 space-y-1 relative overflow-hidden flex flex-col justify-center items-center">
            <div class="text-xl sm:text-4xl lg:text-5xl font-black text-gold-gradient tracking-tight" x-text="minutes">۰۰</div>
            <div class="text-[10px] sm:text-xs text-brand-slate font-medium">دقیقه</div>
            <div class="absolute inset-x-0 bottom-0 h-0.5 bg-gradient-to-r from-transparent via-brand-gold/40 to-transparent"></div>
          </div>

          <!-- Seconds (Rightmost) -->
          <div class="glass-card glass-card-glow rounded-2xl p-2.5 sm:p-5 space-y-1 relative overflow-hidden flex flex-col justify-center items-center">
            <div class="text-xl sm:text-4xl lg:text-5xl font-black text-gold-gradient tracking-tight" x-text="seconds">۰۰</div>
            <div class="text-[10px] sm:text-xs text-brand-slate font-medium">ثانیه</div>
            <div class="absolute inset-x-0 bottom-0 h-0.5 bg-gradient-to-r from-transparent via-brand-gold/40 to-transparent"></div>
          </div>

        </div>

        <!-- NOTIFICATION FORM -->
        <div class="max-w-md mx-auto space-y-2.5 w-full px-2">
          <form @submit.prevent="submitNotify" class="glass-card p-1.5 rounded-2xl flex items-center gap-1.5 focus-within:border-brand-gold/60 focus-within:ring-1 focus-within:ring-brand-gold/40 transition-all w-full">
            <input
              type="tel"
              x-model="phone"
              dir="ltr"
              placeholder="۰۹۱۲..."
              class="bg-transparent px-3 py-2 w-full min-w-0 text-sm text-white placeholder-brand-muted/70 text-left focus:outline-none"
            />
            <button
              type="submit"
              class="bg-gradient-to-r from-brand-gold to-brand-goldHover text-brand-darkest hover:shadow-glow-gold active:scale-95 text-xs sm:text-sm font-black px-4 sm:px-6 py-2.5 rounded-xl transition-all whitespace-nowrap flex-shrink-0"
            >
              به من خبر بده
            </button>
          </form>
          <p class="text-[11px] text-brand-slate">با ثبت شماره، اولین نفری باشید که از انتشار مقالات و کوئیزها مطلع می‌شود.</p>
        </div>

        <!-- KEY FEATURES TEASER -->
        <div class="flex flex-wrap justify-center gap-2 sm:gap-3 pt-1">
          <span class="glass-card text-brand-slate text-[11px] sm:text-xs px-3.5 py-1.5 rounded-xl border-white/5 flex items-center gap-1.5">
            <span class="text-brand-gold">⚡</span>
            <span>کوئیزهای تحلیلی آنلاین</span>
          </span>
          <span class="glass-card text-brand-slate text-[11px] sm:text-xs px-3.5 py-1.5 rounded-xl border-white/5 flex items-center gap-1.5">
            <span class="text-brand-gold">📚</span>
            <span>مقالات و نکات آموزشی</span>
          </span>
          <span class="glass-card text-brand-slate text-[11px] sm:text-xs px-3.5 py-1.5 rounded-xl border-white/5 flex items-center gap-1.5">
            <span class="text-brand-gold">🎯</span>
            <span>نکات کاربردی مکالمه و آزمون‌ها</span>
          </span>
        </div>

      </div>
    </main>

    <!-- FOOTER WITH SOCIAL & CONTACT LINKS -->
    <footer class="py-5 px-4 sm:px-8 max-w-7xl mx-auto w-full flex flex-col sm:flex-row items-center justify-between gap-4 border-t border-white/5 text-[11px] sm:text-xs text-brand-slate z-10 text-center sm:text-right">
      <div>© پایگاه آموزشی <span class="text-brand-gold font-bold">LINGORAX</span> | یاشیل رزمیان‌زاده</div>
      
      <div class="flex flex-wrap items-center justify-center gap-5">
        <a href="https://instagram.com/Lingorax" target="_blank" rel="noopener noreferrer" class="hover:text-brand-gold transition-colors flex items-center gap-1">
          <span>اینستاگرام</span>
        </a>
        <a href="https://wa.me/989911911683" target="_blank" rel="noopener noreferrer" class="hover:text-brand-gold transition-colors flex items-center gap-1">
          <span>واتساپ</span>
        </a>
        <a href="tel:09911911683" class="hover:text-brand-gold transition-colors flex items-center gap-1">
          <span>تماس مستقیم</span>
        </a>
        <a href="mailto:yashil.razmiyanzade@gmail.com" class="hover:text-brand-gold transition-colors flex items-center gap-1">
          <span>ایمیل</span>
        </a>
      </div>
    </footer>
  </body>
</html>