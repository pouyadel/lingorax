@extends('layouts.app')

@php
    $mainTitle = $article->title_fa ?: $article->title_en;
    $pageTitle = $mainTitle . ' | آموزش زبان انگلیسی لینگوراکس - یاشیل رزمیان زاده';
    $rawExcerpt = is_array($article->excerpt_fa) ? implode(' ', array_filter($article->excerpt_fa)) : $article->excerpt_fa;
    $metaDescription = $rawExcerpt ?: (mb_substr(strip_tags($article->content_fa ?: $article->content_en), 0, 155) . '...');
    $articleImage = $article->image ? asset('storage/' . $article->image) : asset('images/logo.png');

    $articleSchema = [
      "@context" => "https://schema.org",
      "@graph" => [
        [
          "@type" => "BreadcrumbList",
          "itemListElement" => [
            [
              "@type" => "ListItem",
              "position" => 1,
              "name" => "صفحه اصلی لینگوراکس",
              "item" => route('home')
            ],
            [
              "@type" => "ListItem",
              "position" => 2,
              "name" => "بانک مقالات آموزشی",
              "item" => route('articles')
            ],
            [
              "@type" => "ListItem",
              "position" => 3,
              "name" => $mainTitle,
              "item" => route('articles.show', $article->slug)
            ]
          ]
        ],
        [
          "@type" => "BlogPosting",
          "mainEntityOfPage" => [
            "@type" => "WebPage",
            "@id" => route('articles.show', $article->slug)
          ],
          "headline" => $mainTitle,
          "alternativeHeadline" => $article->title_en,
          "description" => $metaDescription,
          "image" => $articleImage,
          "inLanguage" => "fa-IR",
          "articleSection" => ucfirst($article->category),
          "keywords" => "یاشیل رزمیان زاده, لینگوراکس, LINGORAX, {$article->category}, آموزش زبان انگلیسی",
          "author" => [
            "@type" => "Person",
            "name" => "یاشیل رزمیان زاده",
            "url" => route('about')
          ],
          "publisher" => [
            "@type" => "Organization",
            "name" => "لینگوراکس | LINGORAX",
            "logo" => [
              "@type" => "ImageObject",
              "url" => asset('images/logo.png')
            ]
          ],
          "datePublished" => $article->created_at ? $article->created_at->toIso8601String() : now()->toIso8601String(),
          "dateModified" => $article->updated_at ? $article->updated_at->toIso8601String() : now()->toIso8601String()
        ]
      ]
    ];
@endphp

@section('title', $pageTitle)
@section('meta_description', $metaDescription)
@section('meta_keywords', ($article->title_fa ? $article->title_fa . ', ' : '') . 'یاشیل رزمیان زاده, لینگوراکس, LINGORAX, آموزش زبان انگلیسی, ' . $article->category . ', سطح ' . $article->level)
@section('canonical', route('articles.show', $article->slug))
@section('og_type', 'article')
@section('og_image', $articleImage)

@push('schema')
<script type="application/ld+json">
{!! json_encode($articleSchema, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT) !!}
</script>
@endpush

@push('styles')
<style>
    .article-body h2 {
        color: #ffffff;
        font-size: 1.5rem;
        font-weight: 800;
        margin-top: 2.25rem;
        margin-bottom: 1rem;
        padding-bottom: 0.5rem;
        border-bottom: 1px solid rgba(212, 175, 55, 0.25);
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
    .article-body h2::before {
        content: "";
        display: inline-block;
        width: 6px;
        height: 1.25rem;
        background: #D4AF37;
        border-radius: 9999px;
    }
    .article-body h3 {
        color: #F2D06B;
        font-size: 1.2rem;
        font-weight: 700;
        margin-top: 1.75rem;
        margin-bottom: 0.75rem;
    }
    .article-body p {
        color: #94A3B8;
        font-size: 0.95rem;
        line-height: 2.1;
        margin-bottom: 1.25rem;
    }
    .article-body blockquote {
        background: linear-gradient(135deg, rgba(212, 175, 55, 0.08) 0%, rgba(14, 26, 46, 0.6) 100%);
        border-right: 4px solid #D4AF37;
        border-radius: 0.75rem;
        padding: 1rem 1.5rem;
        margin: 1.5rem 0;
        color: #f8fafc;
        font-weight: 600;
        font-style: italic;
    }
    body[dir="ltr"] .article-body blockquote {
        border-right: none;
        border-left: 4px solid #D4AF37;
    }
    .article-body img {
        border-radius: 1.25rem;
        border: 1px solid rgba(255, 255, 255, 0.1);
        box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.5);
        margin: 1.75rem auto;
        max-width: 100%;
        height: auto;
    }
    .article-body iframe {
        width: 100% !important;
        aspect-ratio: 16 / 9;
        height: auto !important;
        border-radius: 1.25rem;
        border: 1px solid rgba(212, 175, 55, 0.3);
        box-shadow: 0 0 30px rgba(212, 175, 55, 0.15);
        margin: 2rem 0;
    }
    .article-body ul, .article-body ol {
        color: #94A3B8;
        font-size: 0.95rem;
        line-height: 2;
        margin: 1rem 0 1.5rem 1.5rem;
        list-style-position: inside;
    }
    .article-body ul { list-style-type: disc; }
    .article-body ol { list-style-type: decimal; }
    .article-body a {
        color: #D4AF37;
        text-decoration: underline;
        font-weight: 600;
        transition: color 0.2s;
    }
    .article-body a:hover { color: #F2D06B; }
    .article-body pre {
        background: #050A14;
        border: 1px solid rgba(255, 255, 255, 0.1);
        border-radius: 0.75rem;
        padding: 1rem;
        overflow-x: auto;
        color: #38BDF8;
        margin: 1.25rem 0;
        direction: ltr;
        text-align: left;
    }
</style>
@endpush

@section('content')
<div x-data="articleShow()" class="space-y-8 sm:space-y-10 py-6 sm:py-10">

  <!-- نوار پیشرفت مطالعه مقاله -->
  <div class="fixed top-0 inset-x-0 h-1 bg-brand-darkest/50 z-50">
    <div class="bg-gradient-to-r from-brand-gold to-brand-goldLight h-full transition-all duration-150" :style="'width: ' + progress + '%'"></div>
  </div>

  <article class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6 sm:space-y-8">
    
    <!-- مسیر راهنما (Breadcrumbs) -->
    <nav aria-label="Breadcrumb" class="flex items-center gap-2 text-xs font-semibold text-brand-slate/70">
      <a href="{{ route('home') }}" class="hover:text-brand-gold transition-colors">
        <span x-show="lang === 'fa'">خانه</span><span x-show="lang === 'en'">Home</span>
      </a>
      <span>/</span>
      <a href="{{ route('articles') }}" class="hover:text-brand-gold transition-colors">
        <span x-show="lang === 'fa'">مقالات آموزشی لینگوراکس</span><span x-show="lang === 'en'">Articles</span>
      </a>
      <span>/</span>
      <span class="text-brand-gold truncate max-w-xs">
        <span x-show="lang === 'fa'">{{ $article->title_fa }}</span>
        <span x-show="lang === 'en'">{{ $article->title_en }}</span>
      </span>
    </nav>

    <!-- سرتیتر و جزئیات مقاله -->
    <div class="space-y-4 text-center">
      <div class="inline-flex items-center gap-2.5 flex-wrap justify-center text-xs font-bold">
        <span class="bg-brand-gold text-brand-darkest px-3 py-1 rounded-lg shadow">
          <span x-show="lang === 'fa'">سطح {{ $article->level }}</span>
          <span x-show="lang === 'en'">Level {{ $article->level }}</span>
        </span>
        <span class="glass-card text-brand-goldLight border border-brand-gold/30 px-3 py-1 rounded-lg">
          {{ ucfirst($article->category) }}
        </span>
        <span class="glass-card text-brand-slate px-3 py-1 rounded-lg border border-white/5 flex items-center gap-1.5">
          <svg class="w-3.5 h-3.5 text-brand-gold" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
          </svg>
          <span>{{ $article->read_time }}</span>
          <span x-show="lang === 'fa'">دقیقه مطالعه</span>
          <span x-show="lang === 'en'">min read</span>
        </span>
      </div>

      <h1 class="text-2xl sm:text-4xl lg:text-5xl font-black text-white leading-tight font-heading">
        <span x-show="lang === 'fa'">{{ $article->title_fa }}</span>
        <span x-show="lang === 'en'">{{ $article->title_en }}</span>
      </h1>

      @php
        $excerptFa = is_array($article->excerpt_fa) ? implode(' - ', array_filter($article->excerpt_fa)) : $article->excerpt_fa;
        $excerptEn = is_array($article->excerpt_en) ? implode(' - ', array_filter($article->excerpt_en)) : $article->excerpt_en;
      @endphp

      @if($excerptFa || $excerptEn)
        <p class="text-brand-slate text-xs sm:text-base max-w-2xl mx-auto leading-relaxed">
          <span x-show="lang === 'fa'">{{ $excerptFa }}</span>
          <span x-show="lang === 'en'">{{ $excerptEn }}</span>
        </p>
      @endif
    </div>

    <!-- تصویر شاخص -->
    @if($article->image)
      <div class="relative rounded-3xl overflow-hidden glass-card border border-white/10 shadow-2xl group">
        <img 
          src="{{ asset('storage/' . $article->image) }}" 
          alt="{{ ($article->title_fa ?: $article->title_en) . ' - آموزش زبان انگلیسی لینگوراکس با یاشیل رزمیان زاده' }}" 
          class="w-full h-60 sm:h-[420px] object-cover object-center group-hover:scale-105 transition-transform duration-700" 
        />
        <div class="absolute inset-0 bg-gradient-to-t from-brand-darkest/80 via-transparent to-transparent"></div>
      </div>
    @endif

    <!-- محتوای اصلی مقاله -->
    <div class="glass-card p-5 sm:p-12 rounded-3xl border border-white/5 shadow-2xl relative">
      <div 
        class="article-body font-normal" 
        :dir="lang === 'fa' ? 'rtl' : 'ltr'"
      >
        <div x-show="lang === 'fa'">
          {!! $article->content_fa !!}
        </div>
        <div x-show="lang === 'en'">
          {!! $article->content_en !!}
        </div>
      </div>

      <!-- اشتراک‌گذاری -->
      <div class="border-t border-white/10 pt-6 mt-10 flex flex-wrap items-center justify-between gap-4">
        <div class="flex items-center gap-2">
          <span class="text-xs font-bold text-brand-slate">
            <span x-show="lang === 'fa'">اشتراک‌گذاری مقاله:</span>
            <span x-show="lang === 'en'">Share:</span>
          </span>
          <button @click="copyShareLink()" class="glass-card hover:border-brand-gold text-brand-slate hover:text-white p-2 rounded-xl text-xs font-bold transition-all flex items-center gap-1.5">
            <svg class="w-4 h-4 text-brand-gold" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"/></svg>
            <span x-text="copied ? (lang === 'fa' ? 'کپی شد!' : 'Copied!') : (lang === 'fa' ? 'کپی لینک' : 'Copy')"></span>
          </button>
        </div>

        <a href="{{ route('articles') }}" class="inline-flex items-center gap-2 border border-brand-gold/40 text-brand-gold hover:bg-brand-gold hover:text-brand-darkest px-4 py-2 rounded-xl text-xs font-bold transition-all">
          <span x-show="lang === 'fa'">← مشاهده همه مقالات لینگوراکس</span>
          <span x-show="lang === 'en'">← All Articles</span>
        </a>
      </div>
    </div>

    <!-- جعبه بیوگرافی نویسنده با سئوی اختصاصی نام یاشیل رزمیان زاده و برند لینگوراکس -->
    <div class="glass-card p-5 sm:p-8 rounded-3xl border border-brand-gold/25 flex flex-col sm:flex-row items-center gap-5 sm:gap-6 text-center sm:text-right">
      <div class="w-20 h-20 rounded-2xl overflow-hidden border-2 border-brand-gold/50 flex-shrink-0 shadow-glow-gold">
        <img src="{{ asset('images/image.png') }}" class="w-full h-full object-cover" alt="یاشیل رزمیان زاده | مدرس ارشد آیلتس و زبان انگلیسی">
      </div>
      <div class="space-y-1.5 flex-1">
        <h4 class="text-base font-bold text-white font-heading">
          <span x-show="lang === 'fa'">{{ $settings['about_teacher_name_fa'] ?? 'یاشیل رزمیان زاده' }}</span>
          <span x-show="lang === 'en'">{{ $settings['about_teacher_name_en'] ?? 'Yashil Razmiyanzadeh' }}</span>
        </h4>
        <p class="text-xs text-brand-gold font-semibold">
          <span x-show="lang === 'fa'">{{ $settings['about_teacher_role_fa'] ?? 'مدرس تخصصی آیلتس، تافل و زبان انگلیسی' }}</span>
          <span x-show="lang === 'en'">{{ $settings['about_teacher_role_en'] ?? 'Specialized IELTS, TOEFL & General English Instructor' }}</span>
        </p>
        <p class="text-xs text-brand-slate leading-relaxed">
          <span x-show="lang === 'fa'">مؤلف و مدرس در پایگاه تخصصی لینگوراکس (LINGORAX). ارائه جدیدترین تحلیل‌ها، متدهای نوین واژگان و آماده‌سازی برای آزمون‌های بین‌المللی با هدایت یاشیل رزمیان زاده.</span>
          <span x-show="lang === 'en'">Published on LINGORAX English platform by Yashil Razmiyanzadeh.</span>
        </p>
      </div>
      <a href="{{ route('about') }}" class="whitespace-nowrap bg-brand-cardLight border border-white/10 hover:border-brand-gold text-white text-xs font-bold px-4 py-2.5 rounded-xl transition-all">
        <span x-show="lang === 'fa'">درباره یاشیل رزمیان زاده</span>
        <span x-show="lang === 'en'">View Profile</span>
      </a>
    </div>

  </article>
</div>
@endsection

@push('scripts')
<script>
function articleShow() {
  return {
    progress: 0,
    copied: false,
    init() {
      window.addEventListener('scroll', () => {
        const winScroll = document.documentElement.scrollTop || document.body.scrollTop;
        const height = document.documentElement.scrollHeight - document.documentElement.clientHeight;
        this.progress = height > 0 ? (winScroll / height) * 100 : 0;
      });
    },
    copyShareLink() {
      navigator.clipboard.writeText(window.location.href);
      this.copied = true;
      setTimeout(() => this.copied = false, 2500);
    }
  }
}
</script>
@endpush