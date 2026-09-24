@extends('admin.layout')

@section('title', 'ویرایش آزمون دوزبانه')
@section('page-title', 'ویرایش آزمون: ' . $quiz->title_fa)

@section('content')
<div x-data="quizBuilder()" class="w-full max-w-5xl space-y-5 sm:space-y-6">

    @if ($errors->any())
        <div class="p-4 rounded-2xl bg-red-500/10 border border-red-500/30 text-red-400 text-xs font-bold space-y-1">
            @foreach ($errors->all() as $error)
                <p>• {{ $error }}</p>
            @endforeach
        </div>
    @endif

    <form action="{{ route('admin.quizzes.update', $quiz) }}" method="POST" class="space-y-5 sm:space-y-6">
        @csrf
        @method('PUT')

        <div class="glass-card p-4 sm:p-6 md:p-8 rounded-2xl sm:rounded-3xl border border-white/5 space-y-4">
            <h3 class="text-xs sm:text-sm font-bold text-brand-gold border-b border-white/5 pb-3">مشخصات آزمون</h3>
            
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div class="space-y-1.5">
                    <label class="text-xs text-brand-slate font-bold">عنوان فارسی آزمون</label>
                    <input type="text" name="title_fa" value="{{ $quiz->title_fa }}" required class="w-full bg-brand-dark border border-white/10 rounded-xl px-3.5 py-2.5 text-xs text-white focus:outline-none focus:border-brand-gold" />
                </div>

                <div class="space-y-1.5">
                    <label class="text-xs text-brand-slate font-bold">English Quiz Title</label>
                    <input type="text" name="title_en" value="{{ $quiz->title_en }}" dir="ltr" required class="w-full bg-brand-dark border border-white/10 rounded-xl px-3.5 py-2.5 text-xs text-white focus:outline-none focus:border-brand-gold" />
                </div>

                <div class="space-y-1.5">
                    <label class="text-xs text-brand-slate font-bold">توضیح کوتاه فارسی</label>
                    <textarea name="description_fa" rows="2" class="w-full bg-brand-dark border border-white/10 rounded-xl p-3 text-xs text-white focus:outline-none focus:border-brand-gold">{{ $quiz->description_fa }}</textarea>
                </div>

                <div class="space-y-1.5">
                    <label class="text-xs text-brand-slate font-bold">English Description</label>
                    <textarea name="description_en" dir="ltr" rows="2" class="w-full bg-brand-dark border border-white/10 rounded-xl p-3 text-xs text-white focus:outline-none focus:border-brand-gold">{{ $quiz->description_en }}</textarea>
                </div>

                <div class="space-y-1.5">
                    <label class="text-xs text-brand-slate font-bold">دسته‌بندی</label>
                    <select name="category" class="w-full bg-brand-dark border border-white/10 rounded-xl px-3.5 py-2.5 text-xs text-white focus:outline-none focus:border-brand-gold">
                        <option value="grammar" {{ old('category', $quiz->category) === 'grammar' ? 'selected' : '' }}>گرامر (Grammar)</option>
                        <option value="vocab" {{ old('category', $quiz->category) === 'vocab' ? 'selected' : '' }}>واژگان (Vocabulary)</option>
                        <option value="reading" {{ old('category', $quiz->category) === 'reading' ? 'selected' : '' }}>درک مطلب (Reading)</option>
                    </select>
                </div>

                <div class="space-y-1.5">
                    <label class="text-xs text-brand-slate font-bold">سطح</label>
                    <select name="level" class="w-full bg-brand-dark border border-white/10 rounded-xl px-3.5 py-2.5 text-xs text-white focus:outline-none focus:border-brand-gold">
                        <option value="A1 - A2" {{ old('level', $quiz->level) === 'A1 - A2' ? 'selected' : '' }}>A1 - A2</option>
                        <option value="B1 - B2" {{ old('level', $quiz->level) === 'B1 - B2' ? 'selected' : '' }}>B1 - B2</option>
                        <option value="C1 - C2" {{ old('level', $quiz->level) === 'C1 - C2' ? 'selected' : '' }}>C1 - C2</option>
                        <option value="A1 - C2" {{ old('level', $quiz->level) === 'A1 - C2' ? 'selected' : '' }}>A1 - C2 (تمامی سطوح)</option>
                    </select>
                </div>

                <div class="sm:col-span-2 flex items-center gap-2 pt-2">
                    <input type="checkbox" name="is_published" id="is_published" value="1" {{ $quiz->is_published ? 'checked' : '' }} class="rounded border-white/10 text-brand-gold focus:ring-brand-gold h-4 w-4 bg-brand-dark">
                    <label for="is_published" class="text-xs font-bold text-white cursor-pointer select-none">انتشار فعال آزمون</label>
                </div>

                <!-- ویرایش وضعیت اختصاصی بودن و رمز عبور -->
                <div class="sm:col-span-2 space-y-3 pt-3 border-t border-white/5" x-data="{ isPrivate: {{ old('is_private', $quiz->is_private) ? 'true' : 'false' }} }">
                    <div class="flex items-center gap-2">
                        <input type="checkbox" name="is_private" id="is_private" value="1" x-model="isPrivate" class="rounded border-white/10 text-brand-gold focus:ring-brand-gold h-4 w-4 bg-brand-dark">
                        <label for="is_private" class="text-xs font-bold text-brand-gold cursor-pointer select-none">
                            این آزمون خصوصی (Private) است و ورود به آن نیازمند رمز عبور است
                        </label>
                    </div>

                    <div x-show="isPrivate" x-transition class="space-y-1.5 max-w-sm bg-brand-dark/50 p-4 rounded-2xl border border-brand-gold/30">
                        <label class="text-xs text-brand-slate font-bold block">رمز ورود به آزمون (Password)</label>
                        <input 
                            type="text" 
                            name="password" 
                            value="{{ old('password', $quiz->password) }}" 
                            :required="isPrivate" 
                            class="w-full bg-brand-dark border border-brand-gold/40 rounded-xl px-3.5 py-2.5 text-xs text-brand-gold font-mono tracking-wider focus:outline-none focus:border-brand-gold" 
                            placeholder="رمز ورود را وارد کنید..." 
                        />
                        <p class="text-[10px] text-brand-slate leading-relaxed">
                            این آزمون در آرشیو عمومی سایت مخفی خواهد ماند و تنها با ارسال لینک و این رمز قابل دسترس خواهد بود.
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <div class="space-y-4">
            <div class="flex flex-wrap items-center justify-between gap-2">
                <h3 class="text-xs sm:text-sm font-bold text-white">سوالات آزمون (<span x-text="questions.length"></span> سوال)</h3>
                <button type="button" @click="addQuestion()" class="bg-brand-cardLight border border-brand-gold/40 text-brand-gold hover:bg-brand-gold hover:text-brand-darkest text-xs font-bold px-3.5 py-2 rounded-xl transition-all">
                    + افزودن سوال جدید
                </button>
            </div>

            <template x-for="(q, qIndex) in questions" :key="qIndex">
                <div class="glass-card p-4 sm:p-6 rounded-2xl sm:rounded-3xl border border-white/5 space-y-4 shadow-lg">
                    <div class="flex items-center justify-between border-b border-white/5 pb-2.5">
                        <span class="text-xs font-bold text-brand-gold" x-text="'سوال شماره ' + (qIndex + 1)"></span>
                        <button type="button" @click="removeQuestion(qIndex)" x-show="questions.length > 1" class="text-red-400 hover:text-red-300 text-xs font-bold">
                            حذف این سوال
                        </button>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3.5">
                        <div class="space-y-1">
                            <label class="text-[11px] text-brand-slate font-bold">Question Prompt (EN - اجباری)</label>
                            <input type="text" :name="'questions['+qIndex+'][text_en]'" x-model="q.text_en" dir="ltr" required class="w-full bg-brand-dark border border-white/10 rounded-xl px-3.5 py-2 text-xs text-white focus:outline-none focus:border-brand-gold" />
                        </div>
                        <div class="space-y-1">
                            <label class="text-[11px] text-brand-slate font-bold">صورت سوال به فارسی (اختیاری)</label>
                            <input type="text" :name="'questions['+qIndex+'][text_fa]'" x-model="q.text_fa" class="w-full bg-brand-dark border border-white/10 rounded-xl px-3.5 py-2 text-xs text-white focus:outline-none focus:border-brand-gold" />
                        </div>
                    </div>

                    <div class="space-y-2 pt-2">
                        <label class="text-[11px] text-brand-slate font-bold block">گزینه‌ها (پاسخ صحیح را مشخص کنید):</label>
                        <div class="space-y-2">
                            <template x-for="(opt, oIndex) in q.options" :key="oIndex">
                                <div class="flex flex-col sm:flex-row sm:items-center gap-2 bg-brand-dark/60 p-3 sm:p-2.5 rounded-xl border border-white/5">
                                    <div class="flex items-center gap-2 flex-shrink-0">
                                        <input type="radio" :name="'questions['+qIndex+'][correct]'" :value="oIndex" :checked="q.correct == oIndex" @change="q.correct = oIndex" required class="text-brand-gold focus:ring-brand-gold h-4 w-4 bg-brand-dark border-white/10">
                                        <span class="text-xs font-bold text-brand-gold w-5" x-text="['A', 'B', 'C', 'D'][oIndex] + '.'"></span>
                                        <span class="text-[10px] text-brand-slate sm:hidden">(پاسخ صحیح)</span>
                                    </div>
                                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-2 flex-1 w-full">
                                        <input type="text" :name="'questions['+qIndex+'][options]['+oIndex+'][text_en]'" x-model="opt.text_en" dir="ltr" required class="w-full bg-brand-dark border border-white/10 rounded-lg px-3 py-1.5 text-xs text-white focus:outline-none focus:border-brand-gold" />
                                        <input type="text" :name="'questions['+qIndex+'][options]['+oIndex+'][text_fa]'" x-model="opt.text_fa" class="w-full bg-brand-dark border border-white/10 rounded-lg px-3 py-1.5 text-xs text-white focus:outline-none focus:border-brand-gold" />
                                    </div>
                                </div>
                            </template>
                        </div>
                    </div>
                </div>
            </template>
        </div>

        <div class="pt-1">
            <button type="submit" class="w-full sm:w-auto bg-gradient-to-r from-brand-gold to-brand-goldHover text-brand-darkest font-black px-8 py-3 rounded-xl text-xs shadow-glow-gold transition-all active:scale-95">
                ذخیره تغییرات آزمون
            </button>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script>
function quizBuilder() {
    const dbQuestions = @json($quiz->questions);
    const initialQuestions = dbQuestions.map(q => {
        let correctIdx = 0;
        const options = (q.options || []).map((opt, idx) => {
            if (opt.is_correct) correctIdx = idx;
            return { text_en: opt.text_en || '', text_fa: opt.text_fa || '' };
        });
        return {
            text_en: q.text_en || '',
            text_fa: q.text_fa || '',
            correct: correctIdx,
            options: options
        };
    });

    return {
        questions: initialQuestions.length ? initialQuestions : [
            { text_en: '', text_fa: '', correct: 0, options: [{ text_en: '', text_fa: '' }, { text_en: '', text_fa: '' }, { text_en: '', text_fa: '' }, { text_en: '', text_fa: '' }] }
        ],
        addQuestion() {
            this.questions.push({
                text_en: '', text_fa: '', correct: 0,
                options: [{ text_en: '', text_fa: '' }, { text_en: '', text_fa: '' }, { text_en: '', text_fa: '' }, { text_en: '', text_fa: '' }]
            });
        },
        removeQuestion(index) {
            this.questions.splice(index, 1);
        }
    }
}
</script>
@endpush