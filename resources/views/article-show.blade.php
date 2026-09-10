@extends('layouts.app')

@section('title', $article->title_fa . ' | ' . $article->title_en)

@section('content')
<article class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8 sm:py-12 space-y-8">
  <div class="space-y-4 text-center">
    <div class="flex items-center justify-center gap-2 text-xs font-bold text-brand-gold">
      <span>سطح / Level: {{ $article->level }}</span>
      <span>•</span>
      <span>{{ $article->category }}</span>
      <span>•</span>
      <span>{{ $article->read_time }} min</span>
    </div>
    <h1 class="text-2xl sm:text-4xl font-black text-white leading-snug">
      <span x-show="lang === 'fa'">{{ $article->title_fa }}</span>
      <span x-show="lang === 'en'">{{ $article->title_en }}</span>
    </h1>
  </div>

  @if($article->image)
    <div class="h-64 sm:h-96 rounded-3xl overflow-hidden glass-card border border-white/10">
      <img src="{{ asset('storage/' . $article->image) }}" class="w-full h-full object-cover" />
    </div>
  @endif

  <div class="glass-card p-6 sm:p-10 rounded-3xl border border-white/5 text-brand-slate text-sm sm:text-base leading-loose space-y-4" :dir="lang === 'fa' ? 'rtl' : 'ltr'">
    <div x-show="lang === 'fa'">{!! $article->content_fa !!}</div>
    <div x-show="lang === 'en'">{!! $article->content_en !!}</div>
  </div>

  <div class="text-center">
    <a href="{{ route('articles') }}" class="inline-flex text-xs font-bold text-brand-gold hover:underline">
      <span x-show="lang === 'fa'">← بازگشت به همه مقالات</span>
      <span x-show="lang === 'en'">← Back to all articles</span>
    </a>
  </div>
</article>
@endsection