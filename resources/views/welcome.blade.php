<!doctype html>
<html lang="fa" class="scroll-smooth">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <title>@yield('title', 'LINGORAX | English Hub & Online Assessment')</title>

    <link rel="icon" type="image/png" href="{{ asset('images/favicon.png') }}" />
    <link rel="apple-touch-icon" href="{{ asset('images/favicon.png') }}" />

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@500;700;800;900&family=Plus+Jakarta+Sans:ital,wght@0,400;0,600;0,700;0,800;1,400&display=swap" rel="stylesheet">

    <!-- CSS -->
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">

    <!-- Tailwind CSS & Alpine.js -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

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
      lang: 'fa',
      num(val) {
        if (!val && val !== 0) return '';
        const str = String(val);
        if (this.lang === 'fa') return str.replace(/\d/g, d => '۰۱۲۳۴۵۶۷۸۹'[d]);
        return str.replace(/[۰-۹]/g, d => '0123456789'['۰۱۲۳۴۵۶۷۸۹'.indexOf(d)]);
      }
    }"
    :dir="lang === 'fa' ? 'rtl' : 'ltr'"
    class="antialiased min-h-screen flex flex-col justify-between pb-24 md:pb-0 bg-radial-glow selection:bg-brand-gold selection:text-brand-darkest transition-all duration-300"
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