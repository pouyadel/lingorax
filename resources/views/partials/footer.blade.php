<footer class="glass-card border-t border-white/5 py-10 mb-16 md:mb-0">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6 text-center">
    
    <div class="flex flex-wrap justify-center gap-6 text-xs sm:text-sm text-brand-slate font-semibold">
      <a href="{{ route('home') }}" class="hover:text-brand-gold transition-colors">
        <span x-show="lang === 'fa'">صفحه اصلی</span><span x-show="lang === 'en'">Home</span>
      </a>
      <a href="{{ route('articles') }}" class="hover:text-brand-gold transition-colors">
        <span x-show="lang === 'fa'">مقالات آموزشی</span><span x-show="lang === 'en'">Articles</span>
      </a>
      <a href="{{ route('quizzes') }}" class="hover:text-brand-gold transition-colors">
        <span x-show="lang === 'fa'">بانک آزمون‌ها</span><span x-show="lang === 'en'">Quizzes</span>
      </a>
      <a href="{{ route('about') }}" class="hover:text-brand-gold transition-colors">
        <span x-show="lang === 'fa'">درباره من</span><span x-show="lang === 'en'">About Me</span>
      </a>
    </div>

    <div class="flex justify-center gap-3.5 text-brand-slate">
      <a href="https://instagram.com/Lingorax" target="_blank" class="w-10 h-10 rounded-2xl glass-card flex items-center justify-center hover:text-brand-gold hover:border-brand-gold hover:shadow-glow-gold transition-all">
        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg>
      </a>
      <a href="mailto:yashil.razmiyanzade@gmail.com" class="w-10 h-10 rounded-2xl glass-card flex items-center justify-center hover:text-brand-gold hover:border-brand-gold hover:shadow-glow-gold transition-all">
        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
      </a>
      <a href="tel:09911911683" class="w-10 h-10 rounded-2xl glass-card flex items-center justify-center hover:text-brand-gold hover:border-brand-gold hover:shadow-glow-gold transition-all">
        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
      </a>
    </div>

    <div class="text-xs text-brand-slate/80 border-t border-white/5 pt-4">
      <span x-show="lang === 'fa'">© پایگاه آموزشی و تحلیلی <strong class="text-brand-gold font-bold">LINGORAX</strong></span>
      <span x-show="lang === 'en'">© <strong class="text-brand-gold font-bold">LINGORAX</strong> Educational Hub</span>
    </div>
  </div>
</footer>