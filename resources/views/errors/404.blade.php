@extends('layouts.app')

@section('title', '۴۰۴ - صفحه مورد نظر پیدا نشد | LINGORAX')

@section('content')
<div class="min-h-[60vh] flex items-center justify-center px-4 py-16">
  <div class="glass-card max-w-lg w-full p-8 sm:p-12 rounded-3xl border border-white/10 text-center space-y-6 shadow-2xl relative overflow-hidden">
    <div class="absolute -top-24 -left-24 w-48 h-48 bg-brand-gold/10 rounded-full blur-3xl pointer-events-none"></div>
    <div class="absolute -bottom-24 -right-24 w-48 h-48 bg-brand-gold/10 rounded-full blur-3xl pointer-events-none"></div>

    <div class="w-20 h-20 mx-auto rounded-2xl bg-brand-gold/10 border border-brand-gold/30 text-brand-gold flex items-center justify-center text-3xl font-black font-heading shadow-glow-gold">
      ۴۰۴
    </div>

    <div class="space-y-2">
      <h1 class="text-2xl sm:text-3xl font-black text-white font-heading">صفحه مورد نظر یافت نشد!</h1>
      <p class="text-xs sm:text-sm text-brand-slate leading-relaxed">
        صفحه‌ای که به دنبال آن بودید تغییر مکان داده، حذف شده یا آدرس آن را اشتباه وارد کرده‌اید.
      </p>
    </div>

    <div class="pt-2 flex flex-col sm:flex-row items-center justify-center gap-3">
      <a href="{{ route('home') }}" class="w-full sm:w-auto bg-gradient-to-r from-brand-gold to-brand-goldHover text-brand-darkest font-extrabold px-6 py-2.5 rounded-xl text-xs shadow-glow-gold hover:scale-105 active:scale-95 transition-all">
        بازگشت به صفحه اصلی
      </a>
      <a href="{{ route('articles') }}" class="w-full sm:w-auto border border-white/10 hover:border-brand-gold/50 text-white font-bold px-6 py-2.5 rounded-xl text-xs transition-all">
        مشاهده مقالات
      </a>
    </div>
  </div>
</div>
@endsection