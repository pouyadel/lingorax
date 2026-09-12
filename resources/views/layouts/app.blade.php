<!doctype html>
<html lang="fa" class="scroll-smooth">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <title>@yield('title', 'LINGORAX | English Hub & Online Assessment')</title>

    <link rel="icon" type="image/png" href="{{ asset('images/favicon.png') }}" />
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">

    <!-- اعمال آنی جهت صفحه بدون پرش ظاهری -->
    <script>
      (function() {
        const savedLang = localStorage.getItem('lingorax_lang') || 'fa';
        document.documentElement.setAttribute('dir', savedLang === 'fa' ? 'rtl' : 'ltr');
        document.documentElement.setAttribute('lang', savedLang);
      })();
    </script>

    <!-- Tailwind & Alpine -->
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
                goldLight: "#F2D06B",
                goldHover: "#BA9524",
                slate: "#94A3B8",
                muted: "#64748B",
              },
            },
            boxShadow: {
              'glow-gold': '0 0 25px rgba(212, 175, 55, 0.25)',
              'glow-gold-lg': '0 0 45px rgba(212, 175, 55, 0.35)',
            }
          },
        },
      };
    </script>
    @stack('styles')
  </head>
  <body
    x-data="{
      lang: localStorage.getItem('lingorax_lang') || 'fa',
      setLang(targetLang) {
        this.lang = targetLang;
        localStorage.setItem('lingorax_lang', targetLang);
        document.documentElement.setAttribute('dir', targetLang === 'fa' ? 'rtl' : 'ltr');
        document.documentElement.setAttribute('lang', targetLang);
      },
      init() {
        this.$watch('lang', val => {
          localStorage.setItem('lingorax_lang', val);
          document.documentElement.setAttribute('dir', val === 'fa' ? 'rtl' : 'ltr');
          document.documentElement.setAttribute('lang', val);
        });
      },
      num(val) {
        if (!val && val !== 0) return '';
        const str = String(val);
        if (this.lang === 'fa') return str.replace(/\d/g, d => '۰۱۲۳۴۵۶۷۸۹'[d]);
        return str.replace(/[۰-۹]/g, d => '0123456789'['۰۱۲۳۴۵۶۷۸۹'.indexOf(d)]);
      }
    }"
    :dir="lang === 'fa' ? 'rtl' : 'ltr'"
    class="antialiased min-h-screen flex flex-col justify-between bg-[#080f1d] text-[#f8fafc] pb-24 md:pb-0 bg-radial-glow selection:bg-brand-gold selection:text-brand-darkest transition-all duration-300"
  >

    @include('partials.header')

    <main class="flex-grow">
      @yield('content')
    </main>

    @include('partials.footer')
    @include('partials.mobile-nav')

    @stack('scripts')
  </body>
</html>