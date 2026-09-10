@extends('admin.layout')

@section('title', 'ویرایش مقاله دوزبانه')
@section('page-title', 'ویرایش مقاله: ' . $article->title_fa)

@push('styles')
<link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
<style>
    .ql-toolbar { background: #0E1A2E; border-color: rgba(255,255,255,0.1) !important; border-radius: 0.75rem 0.75rem 0 0; }
    .ql-container { background: #080F1D; border-color: rgba(255,255,255,0.1) !important; border-radius: 0 0 0.75rem 0.75rem; color: #fff; min-height: 220px; font-family: inherit; }
    .ql-stroke { stroke: #94A3B8 !important; }
    .ql-fill { fill: #94A3B8 !important; }
    .ql-picker-label { color: #94A3B8 !important; }
</style>
@endpush

@section('content')
<form action="{{ route('admin.articles.update', $article) }}" method="POST" enctype="multipart/form-data" class="max-w-5xl space-y-6" id="articleForm">
    @csrf
    @method('PUT')

    <div class="glass-card p-6 rounded-3xl border border-white/5 space-y-6">
        
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div class="space-y-2">
                <label class="text-xs text-brand-slate font-bold">عنوان فارسی (FA)</label>
                <input type="text" name="title_fa" value="{{ $article->title_fa }}" required class="w-full bg-brand-dark border border-white/10 rounded-xl px-4 py-2.5 text-xs text-white focus:outline-none focus:border-brand-gold" />
            </div>

            <div class="space-y-2">
                <label class="text-xs text-brand-slate font-bold">English Title (EN)</label>
                <input type="text" name="title_en" value="{{ $article->title_en }}" dir="ltr" required class="w-full bg-brand-dark border border-white/10 rounded-xl px-4 py-2.5 text-xs text-white focus:outline-none focus:border-brand-gold" />
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-4 gap-4 border-t border-white/5 pt-4">
            <div class="space-y-2">
                <label class="text-xs text-brand-slate font-bold">دسته‌بندی (مهارت)</label>
                <select name="category" class="w-full bg-brand-dark border border-white/10 rounded-xl px-4 py-2.5 text-xs text-white focus:outline-none focus:border-brand-gold">
                    <option value="listening" {{ $article->category === 'listening' ? 'selected' : '' }}>شنیداری (Listening)</option>
                    <option value="grammar" {{ $article->category === 'grammar' ? 'selected' : '' }}>گرامر (Grammar)</option>
                    <option value="vocab" {{ $article->category === 'vocab' ? 'selected' : '' }}>واژگان (Vocabulary)</option>
                    <option value="reading" {{ $article->category === 'reading' ? 'selected' : '' }}>درک مطلب (Reading)</option>
                    <option value="ielts" {{ $article->category === 'ielts' ? 'selected' : '' }}>آیلتس و تافل (IELTS & TOEFL)</option>
                </select>
            </div>

            <div class="space-y-2">
                <label class="text-xs text-brand-slate font-bold">سطح زبان</label>
                <select name="level" class="w-full bg-brand-dark border border-white/10 rounded-xl px-4 py-2.5 text-xs text-white focus:outline-none focus:border-brand-gold">
                    <option value="A1 - A2" {{ $article->level === 'A1 - A2' ? 'selected' : '' }}>A1 - A2</option>
                    <option value="B1 - B2" {{ $article->level === 'B1 - B2' ? 'selected' : '' }}>B1 - B2</option>
                    <option value="C1 - C2" {{ $article->level === 'C1 - C2' ? 'selected' : '' }}>C1 - C2</option>
                </select>
            </div>

            <div class="space-y-2">
                <label class="text-xs text-brand-slate font-bold">مدت زمان مطالعه (دقیقه)</label>
                <input type="number" name="read_time" value="{{ $article->read_time }}" min="1" class="w-full bg-brand-dark border border-white/10 rounded-xl px-4 py-2.5 text-xs text-white focus:outline-none focus:border-brand-gold" />
            </div>

            <div class="space-y-2">
                <label class="text-xs text-brand-slate font-bold">تغییر تصویر شاخص</label>
                <input type="file" name="image" accept="image/*" class="w-full bg-brand-dark border border-white/10 rounded-xl p-2 text-xs text-brand-slate" />
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 border-t border-white/5 pt-4">
            <div class="space-y-2">
                <label class="text-xs text-brand-slate font-bold">چکیده مقاله (فارسی)</label>
                <textarea name="excerpt_fa" rows="2" class="w-full bg-brand-dark border border-white/10 rounded-xl p-3 text-xs text-white focus:outline-none focus:border-brand-gold">{{ $article->excerpt_fa }}</textarea>
            </div>

            <div class="space-y-2">
                <label class="text-xs text-brand-slate font-bold">Short Excerpt (English)</label>
                <textarea name="excerpt_en" dir="ltr" rows="2" class="w-full bg-brand-dark border border-white/10 rounded-xl p-3 text-xs text-white focus:outline-none focus:border-brand-gold">{{ $article->excerpt_en }}</textarea>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 border-t border-white/5 pt-4">
            <div class="space-y-2">
                <label class="text-xs text-brand-gold font-bold">متن کامل مقاله (فارسی)</label>
                <input type="hidden" name="content_fa" id="content_fa">
                <div id="editor_fa">{!! $article->content_fa !!}</div>
            </div>

            <div class="space-y-2">
                <label class="text-xs text-brand-gold font-bold">Full Article Content (English)</label>
                <input type="hidden" name="content_en" id="content_en">
                <div id="editor_en" dir="ltr">{!! $article->content_en !!}</div>
            </div>
        </div>

        <div class="flex items-center gap-2 pt-2">
            <input type="checkbox" name="is_published" id="is_published" value="1" {{ $article->is_published ? 'checked' : '' }} class="rounded border-white/10 text-brand-gold focus:ring-brand-gold">
            <label for="is_published" class="text-xs font-bold text-white cursor-pointer">منتشر شده در وب‌سایت</label>
        </div>
    </div>

    <button type="submit" class="bg-gradient-to-r from-brand-gold to-brand-goldHover text-brand-darkest font-black px-8 py-3 rounded-xl text-xs shadow-glow-gold hover:scale-105 active:scale-95 transition-all">
        ذخیره تغییرات مقاله
    </button>
</form>
@endsection

@push('scripts')
<script src="https://cdn.quilljs.com/1.3.6/quill.min.js"></script>
<script>
    const toolbarOptions = [
        [{ 'header': [1, 2, 3, false] }],
        ['bold', 'italic', 'underline', 'strike'],
        [{ 'list': 'ordered'}, { 'list': 'bullet' }],
        ['link', 'blockquote', 'code-block'],
        ['clean']
    ];

    const quillFa = new Quill('#editor_fa', { theme: 'snow', modules: { toolbar: toolbarOptions } });
    const quillEn = new Quill('#editor_en', { theme: 'snow', modules: { toolbar: toolbarOptions } });

    document.getElementById('articleForm').onsubmit = function() {
        document.getElementById('content_fa').value = quillFa.root.innerHTML;
        document.getElementById('content_en').value = quillEn.root.innerHTML;
    };
</script>
@endpush