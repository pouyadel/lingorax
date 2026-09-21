<!doctype html>
<html lang="fa" class="scroll-smooth">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <title>@yield('title', 'لینگوراکس (LINGORAX) | آموزش و ارزیابی تخصصی زبان انگلیسی - یاشیل رزمیان زاده')</title>

    <!-- متاتگ‌های عمومی و تخصصی سئو -->
    <meta name="description" content="@yield('meta_description', 'پایگاه آموزشی لینگوراکس (LINGORAX) با مدیریت یاشیل رزمیان زاده؛ مرجع تخصصی مقالات تحلیلی، ارزیابی آنلاین، کوئیزهای سطح‌بندی شده و استراتژی‌های جامع آیلتس و تافل.')" />
    <meta name="keywords" content="@yield('meta_keywords', 'یاشیل رزمیان زاده, یاشیل رزمیان‌زاده, لینگوراکس, LINGORAX, Yashil Razmiyanzadeh, آموزش زبان انگلیسی, کوئیز آنلاین زبان, آزمون تعیین سطح, آیلتس, تافل, گرامر زبان انگلیسی')" />
    <meta name="author" content="یاشیل رزمیان زاده | Yashil Razmiyanzadeh" />
    <meta name="robots" content="@yield('meta_robots', 'index, follow, max-image-preview:large, max-snippet:-1, max-video-preview:-1')" />
    <link rel="canonical" href="@yield('canonical', url()->current())" />

    <!-- Open Graph (نمایش پیش‌نمایش در تلگرام، واتساپ، ایتا و فیسبوک) -->
    <meta property="og:type" content="@yield('og_type', 'website')" />
    <meta property="og:locale" content="fa_IR" />
    <meta property="og:site_name" content="لینگوراکس | LINGORAX" />
    <meta property="og:url" content="@yield('canonical', url()->current())" />
    <meta property="og:title" content="@yield('title', 'لینگوراکس (LINGORAX) | آموزش زبان انگلیسی با یاشیل رزمیان زاده')" />
    <meta property="og:description" content="@yield('meta_description', 'پایگاه آموزشی لینگوراکس (LINGORAX) با تدریس یاشیل رزمیان زاده؛ مرجع مقالات تحلیلی و آزمون‌های آنلاین زبان انگلیسی.')" />
    <meta property="og:image" content="@yield('og_image', asset('images/logo.png'))" />

    <!-- Twitter Cards -->
    <meta name="twitter:card" content="summary_large_image" />
    <meta name="twitter:title" content="@yield('title', 'لینگوراکس | یاشیل رزمیان زاده')" />
    <meta name="twitter:description" content="@yield('meta_description', 'پایگاه تخصصی آموزش زبان انگلیسی LINGORAX به مدیریت یاشیل رزمیان زاده.')" />
    <meta name="twitter:image" content="@yield('og_image', asset('images/logo.png'))" />

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('images/favicon.png') }}" />
    <link rel="apple-touch-icon" href="{{ asset('images/favicon.png') }}" />
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

    <!-- اسکیما گراف گوگل برای برند لینگوراکس و هویت یاشیل رزمیان زاده (کاملاً امن در برابر خطای Blade) -->
    @php
      $schemaData = [
        "@context" => "https://schema.org",
        "@graph" => [
          [
            "@type" => "WebSite",
            "@id" => url('/') . "/#website",
            "url" => url('/'),
            "name" => "لینگوراکس | LINGORAX",
            "description" => "پایگاه تخصصی آموزش، مقالات تحلیلی و کوئیزهای آنلاین زبان انگلیسی",
            "publisher" => [
              "@id" => url('/') . "/#person"
            ],
            "inLanguage" => ["fa-IR", "en-US"]
          ],
          [
            "@type" => "EducationalOrganization",
            "@id" => url('/') . "/#organization",
            "name" => "لینگوراکس",
            "alternateName" => ["LINGORAX", "پایگاه آموزشی لینگوراکس"],
            "url" => url('/'),
            "logo" => asset('images/logo.png'),
            "founder" => [
              "@id" => url('/') . "/#person"
            ],
            "description" => "مرجع آموزش تخصصی، کوئیزهای هوشمند و مقالات آمادگی آزمون‌های بین‌المللی زبان انگلیسی"
          ],
          [
            "@type" => "Person",
            "@id" => url('/') . "/#person",
            "name" => "یاشیل رزمیان زاده",
            "alternateName" => ["یاشیل رزمیان‌زاده", "Yashil Razmiyanzadeh"],
            "jobTitle" => "مدرس و مؤلف تخصصی آزمون‌های بین‌المللی زبان انگلیسی، آیلتس و تافل",
            "url" => route('about'),
            "image" => asset('images/image.png'),
            "worksFor" => [
              "@id" => url('/') . "/#organization"
            ],
            "sameAs" => [
              "https://instagram.com/Lingorax"
            ]
          ]
        ]
      ];
    @endphp
    <script type="application/ld+json">
    {!! json_encode($schemaData, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT) !!}
    </script>

    @stack('schema')

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