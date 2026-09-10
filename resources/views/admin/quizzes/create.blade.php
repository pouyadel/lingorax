@extends('admin.layout')

@section('title', 'ساخت آزمون دوزبانه')
@section('page-title', 'طراحی آزمون و سوالات (FA / EN)')

@section('content')
<div x-data="quizBuilder()" class="max-w-5xl space-y-6">
    <form action="{{ route('admin.quizzes.store') }}" method="POST" class="space-y-6">
        @csrf

        <!-- مشخصات کلی آزمون -->
        <div class="glass-card p-6 rounded-3xl border border-white/5 space-y-4">
            <h3 class="text-sm font-bold text-brand-gold border-b border-white/5 pb-3">مشخصات آزمون</h3>
            
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div class="space-y-2">
                    <label class="text-xs text-brand-slate font-bold">عنوان فارسی آزمون</label>
                    <input type="text" name="title_fa" value="{{ old('title_fa') }}" required class="w-full bg-brand-dark border border-white/10 rounded-xl px-4 py-2.5 text-xs text-white focus:outline-none focus:border-brand-gold" placeholder="مثال: کوئیز گرامر زمان‌ها" />
                </div>

                <div class="space-y-2">
                    <label class="text-xs text-brand-slate font-bold">English Quiz Title</label>
                    <input type="text" name="title_en" value="{{ old('title_en') }}" dir="ltr" required class="w-full bg-brand-dark border border-white/10 rounded-xl px-4 py-2.5 text-xs text-white focus:outline-none focus:border-brand-gold" placeholder="e.g. English Verb Tenses" />
                </div>

                <div class="space-y-2">
                    <label class="text-xs text-brand-slate font-bold">توضیح کوتاه فارسی</label>
                    <textarea name="description_fa" rows="2" class="w-full bg-brand-dark border border-white/10 rounded-xl p-3 text-xs text-white focus:outline-none focus:border-brand-gold">{{ old('description_fa') }}</textarea>
                </div>

                <div class="space-y-2">
                    <label class="text-xs text-brand-slate font-bold">English Description</label>
                    <textarea name="description_en" dir="ltr" rows="2" class="w-full bg-brand-dark border border-white/10 rounded-xl p-3 text-xs text-white focus:outline-none focus:border-brand-gold">{{ old('description_en') }}</textarea>
                </div>

                <div class="space-y-2">
                    <label class="text-xs text-brand-slate font-bold">دسته‌بندی</label>
                    <select name="category" class="w-full bg-brand-dark border border-white/10 rounded-xl px-4 py-2.5 text-xs text-white focus:outline-none focus:border-brand-gold">
                        <option value="grammar">گرامر (Grammar)</option>
                        <option value="vocab">واژگان (Vocabulary)</option>
                        <option value="listening">شنیداری (Listening)</option>
                        <option value="reading">درک مطلب (Reading)</option>
                    </select>
                </div>

                <div class="space-y-2">
                    <label class="text-xs text-brand-slate font-bold">سطح</label>
                    <select name="level" class="w-full bg-brand-dark border border-white/10 rounded-xl px-4 py-2.5 text-xs text-white focus:outline-none focus:border-brand-gold">
                        <option value="A1 - A2">A1 - A2</option>
                        <option value="B1 - B2">B1 - B2</option>
                        <option value="C1">C1</option>
                        <option value="C1 - C2">C1 - C2</option>
                    </select>
                </div>

                <div class="sm:col-span-2 flex items-center gap-2 pt-2">
                    <input type="checkbox" name="is_published" id="is_published" value="1" checked class="rounded border-white/10 text-brand-gold focus:ring-brand-gold">
                    <label for="is_published" class="text-xs font-bold text-white cursor-pointer">انتشار این آزمون در وب‌سایت</label>
                </div>
            </div>
        </div>

        <!-- بخش سوالات داینامیک -->
        <div class="space-y-4">
            <div class="flex items-center justify-between">
                <h3 class="text-sm font-bold text-white">سوالات آزمون (<span x-text="questions.length"></span> سوال)</h3>
                <button type="button" @click="addQuestion()" class="bg-brand-cardLight border border-brand-gold/40 text-brand-gold hover:bg-brand-gold hover:text-brand-darkest text-xs font-bold px-4 py-2 rounded-xl transition-all">
                    + افزودن سوال جدید
                </button>
            </div>

            <template x-for="(q, qIndex) in questions" :key="qIndex">
                <div class="glass-card p-6 rounded-3xl border border-white/5 space-y-4">
                    <div class="flex items-center justify-between border-b border-white/5 pb-3">
                        <span class="text-xs font-bold text-brand-gold" x-text="'سوال شماره ' + (qIndex + 1)"></span>
                        <button type="button" @click="removeQuestion(qIndex)" x-show="questions.length > 1" class="text-red-400 hover:text-red-300 text-xs font-bold">
                            حذف این سوال
                        </button>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div class="space-y-1">
                            <label class="text-[11px] text-brand-slate font-bold">Question (EN - اجباری)</label>
                            <input type="text" :name="'questions['+qIndex+'][text_en]'" x-model="q.text_en" dir="ltr" required class="w-full bg-brand-dark border border-white/10 rounded-xl px-4 py-2 text-xs text-white focus:outline-none focus:border-brand-gold" placeholder="e.g. She _____ to the cinema yesterday." />
                        </div>
                        <div class="space-y-1">
                            <label class="text-[11px] text-brand-slate font-bold">ترجمه صورت سوال (FA - اختیاری)</label>
                            <input type="text" :name="'questions['+qIndex+'][text_fa]'" x-model="q.text_fa" class="w-full bg-brand-dark border border-white/10 rounded-xl px-4 py-2 text-xs text-white focus:outline-none focus:border-brand-gold" placeholder="راهنما یا ترجمه فارسی..." />
                        </div>
                    </div>

                    <!-- گزینه‌ها -->
                    <div class="space-y-2 pt-2">
                        <label class="text-[11px] text-brand-slate font-bold">گزینه‌ها (تیک دایره‌ای = جواب درست):</label>
                        <div class="space-y-2">
                            <template x-for="(opt, oIndex) in q.options" :key="oIndex">
                                <div class="flex items-center gap-2 bg-brand-dark/60 p-2.5 rounded-xl border border-white/5">
                                    <input type="radio" :name="'questions['+qIndex+'][correct]'" :value="oIndex" :checked="q.correct == oIndex" @change="q.correct = oIndex" required class="text-brand-gold focus:ring-brand-gold">
                                    <span class="text-xs font-bold text-brand-gold w-5" x-text="['A', 'B', 'C', 'D'][oIndex] + '.'"></span>
                                    
                                    <input type="text" :name="'questions['+qIndex+'][options]['+oIndex+'][text_en]'" x-model="opt.text_en" dir="ltr" required class="w-1/2 bg-brand-dark border border-white/5 rounded-lg px-3 py-1.5 text-xs text-white focus:outline-none focus:border-brand-gold" placeholder="Option (EN)..." />
                                    <input type="text" :name="'questions['+qIndex+'][options]['+oIndex+'][text_fa]'" x-model="opt.text_fa" class="w-1/2 bg-brand-dark border border-white/5 rounded-lg px-3 py-1.5 text-xs text-white focus:outline-none focus:border-brand-gold" placeholder="گزینه (FA)..." />
                                </div>
                            </template>
                        </div>
                    </div>
                </div>
            </template>
        </div>

        <button type="submit" class="bg-gradient-to-r from-brand-gold to-brand-goldHover text-brand-darkest font-black px-8 py-3 rounded-xl text-xs shadow-glow-gold hover:scale-105 active:scale-95 transition-all">
            ذخیره آزمون دوزبانه
        </button>
    </form>
</div>
@endsection

@push('scripts')
<script>
function quizBuilder() {
    return {
        questions: [
            {
                text_en: '', text_fa: '', correct: 0,
                options: [
                    { text_en: '', text_fa: '' },
                    { text_en: '', text_fa: '' },
                    { text_en: '', text_fa: '' },
                    { text_en: '', text_fa: '' }
                ]
            }
        ],
        addQuestion() {
            this.questions.push({
                text_en: '', text_fa: '', correct: 0,
                options: [
                    { text_en: '', text_fa: '' },
                    { text_en: '', text_fa: '' },
                    { text_en: '', text_fa: '' },
                    { text_en: '', text_fa: '' }
                ]
            });
        },
        removeQuestion(index) {
            this.questions.splice(index, 1);
        }
    }
}
</script>
@endpushe