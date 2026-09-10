@extends('layouts.app')

@section('title', 'LINGORAX | درباره من')

@section('content')
<div x-data="aboutPage()" class="space-y-10 sm:space-y-14 py-8 sm:py-12">
  
  <!-- INSTRUCTOR PROFILE HERO -->
  <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="glass-card rounded-3xl p-6 sm:p-12 border border-brand-gold/20 relative overflow-hidden shadow-xl">
      <!-- Background Decoration -->
      <div class="absolute -top-24 -right-24 w-64 h-64 bg-brand-gold/10 blur-3xl rounded-full pointer-events-none"></div>
      
      <div class="grid grid-cols-1 lg:grid-cols-12 gap-10 items-center relative z-10">
        
        <!-- Image Profile -->
        <div class="lg:col-span-4 flex justify-center lg:justify-start">
          <div class="relative group">
            <div class="w-48 h-48 sm:w-64 sm:h-64 rounded-full bg-gradient-to-tr from-brand-card to-brand-cardLight border-4 border-brand-gold/50 overflow-hidden shadow-glow-gold flex items-center justify-center">
              <img
                src="{{ asset('images/image.png') }}"
                alt="Yashil Razmiyanzadeh"
                class="w-full h-full object-cover object-top transition-transform duration-700 group-hover:scale-110"
              />
            </div>
            <div class="absolute bottom-2 left-1/2 -translate-x-1/2 bg-brand-darkest text-brand-gold border border-brand-gold/30 text-[10px] sm:text-xs font-black px-4 py-1.5 rounded-full shadow-lg whitespace-nowrap tracking-widest" x-text="t.teacherBadge[lang]"></div>
          </div>
        </div>

        <!-- Bio Text -->
        <div class="lg:col-span-8 space-y-5 text-center" :class="lang === 'fa' ? 'lg:text-right' : 'lg:text-left'">
          <div>
            <h1 class="text-3xl sm:text-5xl font-black text-white font-heading leading-tight" x-text="t.teacherName[lang]"></h1>
            <p class="text-base sm:text-lg text-brand-gold font-bold mt-2" x-text="t.teacherRole[lang]"></p>
          </div>
          
          <p class="text-brand-slate text-sm sm:text-base leading-relaxed max-w-3xl" x-text="t.teacherBioFull[lang]"></p>

          <div class="pt-4 flex flex-wrap items-center justify-center lg:justify-start gap-4">
            <a
              href="mailto:yashil.razmiyanzade@gmail.com?subject=Download CV Request"
              class="bg-gradient-to-r from-brand-gold to-brand-goldHover text-brand-darkest px-6 py-3 rounded-xl text-sm font-extrabold shadow-glow-gold transition-all active:scale-95 flex items-center gap-2"
            >
              <span x-text="t.downloadCV[lang]"></span>
              <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
              </svg>
            </a>

            <a
              href="mailto:yashil.razmiyanzade@gmail.com"
              class="glass-card border border-brand-gold/40 text-brand-gold hover:bg-brand-gold hover:text-brand-darkest px-6 py-3 rounded-xl text-sm font-bold transition-all active:scale-95 flex items-center gap-2"
            >
              <span x-text="t.contactMe[lang]"></span>
              <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
              </svg>
            </a>
          </div>
        </div>

      </div>
    </div>
  </section>

  <!-- STATISTICS -->
  <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 sm:gap-6">
      <template x-for="stat in stats" :key="stat.id">
        <div class="glass-card p-6 rounded-3xl text-center space-y-2 border border-white/5 hover:border-brand-gold/30 transition-colors">
          <div class="text-3xl sm:text-4xl font-black text-gold-gradient" x-text="num(stat.value[lang])"></div>
          <div class="text-xs sm:text-sm font-bold text-brand-slate" x-text="stat.label[lang]"></div>
        </div>
      </template>
    </div>
  </section>

  <!-- PHILOSOPHY / METHODOLOGY -->
  <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="glass-card rounded-3xl p-6 sm:p-10 border border-white/5 space-y-6">
      <div class="flex items-center gap-3 border-b border-white/5 pb-4">
        <span class="w-2 h-7 bg-brand-gold rounded-full"></span>
        <h2 class="text-xl sm:text-2xl font-black text-white font-heading" x-text="t.philosophyTitle[lang]"></h2>
      </div>
      
      <div class="space-y-4 text-brand-slate text-sm sm:text-base leading-loose" :class="lang === 'fa' ? 'text-justify' : 'text-left'">
        <p x-text="t.philosophyP1[lang]"></p>
        <p x-text="t.philosophyP2[lang]"></p>
      </div>
    </div>
  </section>

</div>
@endsection

@push('scripts')
<script>
  function aboutPage() {
    return {
      stats: [
        { id: 1, value: { fa: '+8', en: '+8' }, label: { fa: 'سال سابقه تدریس', en: 'Years Experience' } },
        { id: 2, value: { fa: '+1000', en: '+1000' }, label: { fa: 'زبان‌آموز موفق', en: 'Successful Students' } },
        { id: 3, value: { fa: '8.5', en: '8.5' }, label: { fa: 'نمره آیلتس آکادمیک', en: 'IELTS Academic Band' } },
        { id: 4, value: { fa: '+50', en: '+50' }, label: { fa: 'مقاله تخصصی', en: 'Published Articles' } },
      ],
      stats: [
        { 
          id: 1, 
          value: { fa: "{{ $settings['about_stat1_val'] ?? '+8' }}", en: "{{ $settings['about_stat1_val'] ?? '+8' }}" }, 
          label: { fa: "{{ $settings['about_stat1_lbl_fa'] ?? 'سال سابقه تدریس' }}", en: "{{ $settings['about_stat1_lbl_en'] ?? 'Years Experience' }}" } 
        },
        { 
          id: 2, 
          value: { fa: "{{ $settings['about_stat2_val'] ?? '+1000' }}", en: "{{ $settings['about_stat2_val'] ?? '+1000' }}" }, 
          label: { fa: "{{ $settings['about_stat2_lbl_fa'] ?? 'زبان‌آموز موفق' }}", en: "{{ $settings['about_stat2_lbl_en'] ?? 'Successful Students' }}" } 
        },
        { 
          id: 3, 
          value: { fa: "{{ $settings['about_stat3_val'] ?? '8.5' }}", en: "{{ $settings['about_stat3_val'] ?? '8.5' }}" }, 
          label: { fa: "{{ $settings['about_stat3_lbl_fa'] ?? 'نمره آیلتس آکادمیک' }}", en: "{{ $settings['about_stat3_lbl_en'] ?? 'IELTS Academic Band' }}" } 
        },
        { 
          id: 4, 
          value: { fa: "{{ $settings['about_stat4_val'] ?? '+50' }}", en: "{{ $settings['about_stat4_val'] ?? '+50' }}" }, 
          label: { fa: "{{ $settings['about_stat4_lbl_fa'] ?? 'مقاله تخصصی' }}", en: "{{ $settings['about_stat4_lbl_en'] ?? 'Published Articles' }}" } 
        },
      ],
      t: {
        teacherBadge: { 
          fa: "{{ $settings['about_teacher_badge_fa'] ?? 'مؤلف و مدرس زبان' }}", 
          en: "{{ $settings['about_teacher_badge_en'] ?? 'AUTHOR & INSTRUCTOR' }}" 
        },
        teacherName: { 
          fa: "{{ $settings['about_teacher_name_fa'] ?? 'یاشیل رزمیان‌زاده' }}", 
          en: "{{ $settings['about_teacher_name_en'] ?? 'Yashil Razmiyanzadeh' }}" 
        },
        teacherRole: { 
          fa: "{{ $settings['about_teacher_role_fa'] ?? 'مدرس تخصصی آیلتس، تافل و زبان عمومی' }}", 
          en: "{{ $settings['about_teacher_role_en'] ?? 'Specialized IELTS, TOEFL & General English Instructor' }}" 
        },
        teacherBioFull: { 
          fa: "{{ $settings['about_teacher_bio_fa'] ?? 'من یاشیل رزمیان‌زاده هستم. سال‌هاست که مسیر تدریس زبان انگلیسی را با هدف ایجاد تغییرات بنیادین در شیوه یادگیری زبان‌آموزان انتخاب کرده‌ام.' }}", 
          en: "{{ $settings['about_teacher_bio_en'] ?? 'I am Yashil Razmiyanzadeh. For years, I have dedicated myself to transforming how students learn English.' }}" 
        },
        downloadCV: { fa: 'دانلود رزومه کامل (PDF)', en: 'Download Full CV (PDF)' },
        contactMe: { fa: 'ارتباط مستقیم', en: 'Direct Contact' },
        
        philosophyTitle: { 
          fa: "{{ $settings['about_philosophy_title_fa'] ?? 'فلسفه و رویکرد آموزشی من' }}", 
          en: "{{ $settings['about_philosophy_title_en'] ?? 'My Teaching Philosophy' }}" 
        },
        philosophyP1: { 
          fa: "{{ $settings['about_philosophy_p1_fa'] ?? 'یادگیری زبان انگلیسی نباید به حفظ کردن طوطی‌وار گرامر و لغت محدود شود. در کلاس‌ها و مقالات من، زبان به عنوان یک ابزار ارتباطی زنده بررسی می‌شود.' }}", 
          en: "{{ $settings['about_philosophy_p1_en'] ?? 'Learning English should not be limited to rote memorization of grammar and vocabulary. In my classes and articles, language is treated as a living communication tool.' }}" 
        },
        philosophyP2: { 
          fa: "{{ $settings['about_philosophy_p2_fa'] ?? 'ما در LINGORAX با تمرکز بر ارزیابی‌های مستمر و یادگیری خودآموز، تلاش می‌کنیم فرآیند آموزش را شخصی‌سازی کرده و بالاترین بازدهی را برای هر فرد به ارمغان بیاوریم.' }}", 
          en: "{{ $settings['about_philosophy_p2_en'] ?? 'At LINGORAX, by focusing on continuous assessment and self-study, we strive to personalize the learning process and bring about the highest efficiency for each individual.' }}" 
        }
      }
    };
  }
</script>
@endpush