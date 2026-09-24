@extends('admin.layout')

@section('title', 'افزودن مقاله دوزبانه')
@section('page-title', 'افزودن مقاله جدید')

@push('styles')
<style>
    .custom-editor-content { min-height: 220px; outline: none; }
    .custom-editor-content h3 { font-size: 1.35rem; font-weight: bold; margin-bottom: 10px; color: #fbbf24; }
    .custom-editor-content p { margin-bottom: 10px; line-height: 1.8; }
    .custom-editor-content img { max-width: 100%; border-radius: 8px; margin: 10px 0; }
    .custom-editor-content audio { width: 100%; margin: 10px 0; border-radius: 30px; }
    .custom-editor-content iframe { width: 100%; height: 260px; border-radius: 12px; margin: 15px 0; border: none; }
    @media (min-width: 640px) {
        .custom-editor-content iframe { height: 350px; }
    }
    .editor-btn { padding: 5px 9px; font-size: 0.7rem; border-radius: 6px; background: rgba(255,255,255,0.05); color: #fff; transition: 0.2s; white-space: nowrap; }
    .editor-btn:hover { background: rgba(255,255,255,0.15); color: #fbbf24; }
</style>
@endpush

@section('content')
<form action="{{ route('admin.articles.store') }}" method="POST" enctype="multipart/form-data" class="w-full max-w-5xl space-y-5" id="articleForm">
    @csrf

    <div class="glass-card p-4 sm:p-6 md:p-8 rounded-2xl sm:rounded-3xl border border-white/5 space-y-5">
        
        <!-- عناوین دوزبانه -->
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div class="space-y-1.5">
                <label class="text-xs text-brand-slate font-bold">عنوان فارسی (FA)</label>
                <input type="text" name="title_fa" required class="w-full bg-brand-dark border border-white/10 rounded-xl px-3.5 py-2.5 text-xs text-white focus:outline-none focus:border-brand-gold">
            </div>

            <div class="space-y-1.5">
                <label class="text-xs text-brand-slate font-bold">English Title (EN)</label>
                <input type="text" name="title_en" dir="ltr" required class="w-full bg-brand-dark border border-white/10 rounded-xl px-3.5 py-2.5 text-xs text-white focus:outline-none focus:border-brand-gold">
            </div>
        </div>

        <!-- دسته‌بندی و ویژگی‌ها -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 border-t border-white/5 pt-4">
            <div class="space-y-1.5">
                <label class="text-xs text-brand-slate font-bold">دسته‌بندی</label>
                <select name="category" class="w-full bg-brand-dark border border-white/10 rounded-xl px-3.5 py-2.5 text-xs text-white focus:outline-none focus:border-brand-gold">
                    <option value="speaking" {{ old('category') === 'speaking' ? 'selected' : '' }}>اسپیکینگ (Speaking)</option>
                    <option value="listening" {{ old('category') === 'listening' ? 'selected' : '' }}>شنیداری (Listening)</option>
                    <option value="grammar" {{ old('category') === 'grammar' ? 'selected' : '' }}>گرامر (Grammar)</option>
                    <option value="vocab" {{ old('category') === 'vocab' ? 'selected' : '' }}>واژگان (Vocabulary)</option>
                    <option value="reading" {{ old('category') === 'reading' ? 'selected' : '' }}>درک مطلب (Reading)</option>
                    <option value="ielts" {{ old('category') === 'ielts' ? 'selected' : '' }}>آیلتس و تافل (IELTS & TOEFL)</option>
                </select>
            </div>

            <div class="space-y-1.5">
                <label class="text-xs text-brand-slate font-bold">سطح زبان</label>
                <select name="level" class="w-full bg-brand-dark border border-white/10 rounded-xl px-3.5 py-2.5 text-xs text-white focus:outline-none focus:border-brand-gold">
                    <option value="A1 - A2" {{ old('level') === 'A1 - A2' ? 'selected' : '' }}>A1 - A2</option>
                    <option value="B1 - B2" {{ old('level') === 'B1 - B2' ? 'selected' : '' }}>B1 - B2</option>
                    <option value="C1 - C2" {{ old('level') === 'C1 - C2' ? 'selected' : '' }}>C1 - C2</option>
                    <option value="A1 - C2" {{ old('level') === 'A1 - C2' ? 'selected' : '' }}>A1 - C2 (مناسب تمامی سطوح)</option>
                </select>
            </div>

            <div class="space-y-1.5">
                <label class="text-xs text-brand-slate font-bold">زمان مطالعه (دقیقه)</label>
                <input type="number" name="read_time" value="5" min="1" class="w-full bg-brand-dark border border-white/10 rounded-xl px-3.5 py-2.5 text-xs text-white focus:outline-none focus:border-brand-gold">
            </div>

            <div class="space-y-1.5">
                <label class="text-xs text-brand-slate font-bold">تصویر شاخص</label>
                <input type="file" name="image" accept="image/*" class="w-full bg-brand-dark border border-white/10 rounded-xl p-1.5 text-xs text-brand-slate file:mr-0 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-xs file:bg-white/10 file:text-white hover:file:bg-white/20">
            </div>
        </div>

        <!-- چکیده دوزبانه -->
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 border-t border-white/5 pt-4">
            <div class="space-y-2" id="excerpt-fa-container">
                <label class="text-xs text-brand-slate font-bold flex justify-between items-center">
                    <span>چکیده فارسی (لیست)</span>
                    <button type="button" onclick="addExcerpt('fa')" class="px-2 py-0.5 rounded-lg bg-white/5 border border-white/10 text-brand-gold hover:text-white text-xs font-bold transition-colors">+ افزودن مورد</button>
                </label>
                <input type="text" name="excerpt_fa[]" class="w-full bg-brand-dark border border-white/10 rounded-xl px-3.5 py-2 text-xs text-white mb-2" placeholder="مورد اول...">
            </div>

            <div class="space-y-2" id="excerpt-en-container">
                <label class="text-xs text-brand-slate font-bold flex justify-between items-center">
                    <span>English Excerpt (List)</span>
                    <button type="button" onclick="addExcerpt('en')" class="px-2 py-0.5 rounded-lg bg-white/5 border border-white/10 text-brand-gold hover:text-white text-xs font-bold transition-colors">+ Add Item</button>
                </label>
                <input type="text" name="excerpt_en[]" dir="ltr" class="w-full bg-brand-dark border border-white/10 rounded-xl px-3.5 py-2 text-xs text-white mb-2" placeholder="First item...">
            </div>
        </div>

        <!-- ادیتورها -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 border-t border-white/5 pt-4">
            <!-- ادیتور فارسی -->
            <div class="space-y-2">
                <label class="text-xs text-brand-gold font-bold block">متن کامل (فارسی)</label>
                <div class="border border-white/10 rounded-xl overflow-hidden bg-[#080F1D]">
                    <div class="bg-[#0E1A2E] p-2 flex flex-wrap gap-1.5 sm:gap-2 border-b border-white/10">
                        <button type="button" onclick="formatDoc('formatBlock', 'H3', 'editor_fa')" class="editor-btn">تیتر</button>
                        <button type="button" onclick="formatDoc('formatBlock', 'P', 'editor_fa')" class="editor-btn">متن</button>
                        <button type="button" onclick="formatDoc('bold', null, 'editor_fa')" class="editor-btn font-black">B</button>
                        <div class="w-px h-5 bg-white/10 self-center mx-0.5"></div>
                        <button type="button" onclick="formatDoc('justifyRight', null, 'editor_fa')" class="editor-btn">راست</button>
                        <button type="button" onclick="formatDoc('justifyLeft', null, 'editor_fa')" class="editor-btn">چپ</button>
                        <div class="w-px h-5 bg-white/10 self-center mx-0.5"></div>
                        <button type="button" onclick="uploadCustomMedia('image', 'editor_fa')" class="editor-btn !text-blue-400">عکس</button>
                        <button type="button" onclick="uploadCustomMedia('audio', 'editor_fa')" class="editor-btn !text-green-400">صدا</button>
                        <button type="button" onclick="insertAparat('editor_fa')" class="editor-btn !text-red-400">آپارات</button>
                    </div>
                    <div id="editor_fa" contenteditable="true" class="custom-editor-content p-3.5 sm:p-4 text-white text-xs sm:text-sm" dir="rtl"></div>
                </div>
                <input type="hidden" name="content_fa" id="content_fa_input">
            </div>

            <!-- ادیتور انگلیسی -->
            <div class="space-y-2">
                <label class="text-xs text-brand-gold font-bold block">Full Content (English)</label>
                <div class="border border-white/10 rounded-xl overflow-hidden bg-[#080F1D]">
                    <div class="bg-[#0E1A2E] p-2 flex flex-wrap gap-1.5 sm:gap-2 border-b border-white/10" dir="ltr">
                        <button type="button" onclick="formatDoc('formatBlock', 'H3', 'editor_en')" class="editor-btn">H3</button>
                        <button type="button" onclick="formatDoc('formatBlock', 'P', 'editor_en')" class="editor-btn">P</button>
                        <button type="button" onclick="formatDoc('bold', null, 'editor_en')" class="editor-btn font-black">B</button>
                        <div class="w-px h-5 bg-white/10 self-center mx-0.5"></div>
                        <button type="button" onclick="formatDoc('justifyLeft', null, 'editor_en')" class="editor-btn">Left</button>
                        <button type="button" onclick="formatDoc('justifyRight', null, 'editor_en')" class="editor-btn">Right</button>
                        <div class="w-px h-5 bg-white/10 self-center mx-0.5"></div>
                        <button type="button" onclick="uploadCustomMedia('image', 'editor_en')" class="editor-btn !text-blue-400">Img</button>
                        <button type="button" onclick="uploadCustomMedia('audio', 'editor_en')" class="editor-btn !text-green-400">Audio</button>
                        <button type="button" onclick="insertAparat('editor_en')" class="editor-btn !text-red-400">Video</button>
                    </div>
                    <div id="editor_en" contenteditable="true" class="custom-editor-content p-3.5 sm:p-4 text-white text-xs sm:text-sm" dir="ltr"></div>
                </div>
                <input type="hidden" name="content_en" id="content_en_input">
            </div>
        </div>

        <div class="flex items-center gap-2 pt-2">
            <input type="checkbox" name="is_published" id="is_published" value="1" checked class="rounded border-white/10 text-brand-gold focus:ring-brand-gold h-4 w-4 bg-brand-dark">
            <label for="is_published" class="text-xs font-bold text-white cursor-pointer select-none">انتشار این مقاله در سایت</label>
        </div>
    </div>

    <div class="pt-1">
        <button type="submit" class="w-full sm:w-auto bg-gradient-to-r from-brand-gold to-brand-goldHover text-brand-darkest font-black px-8 py-3 rounded-xl text-xs shadow-glow-gold transition-all active:scale-95">
            ذخیره و انتشار مقاله
        </button>
    </div>
</form>
@endsection

@push('scripts')
<script>
    function addExcerpt(lang) {
        const container = document.getElementById('excerpt-' + lang + '-container');
        const input = document.createElement('input');
        input.type = 'text';
        input.name = lang === 'fa' ? 'excerpt_fa[]' : 'excerpt_en[]';
        input.dir = lang === 'fa' ? 'rtl' : 'ltr';
        input.placeholder = lang === 'fa' ? 'مورد بعدی...' : 'Next item...';
        input.className = 'w-full bg-brand-dark border border-white/10 rounded-xl px-3.5 py-2 text-xs text-white mb-2 mt-2';
        container.appendChild(input);
    }

    function formatDoc(cmd, value = null, editorId) {
        document.getElementById(editorId).focus();
        document.execCommand(cmd, false, value);
    }

    function insertAparat(editorId) {
        document.getElementById(editorId).focus();
        let url = prompt('لینک آپارات را وارد کنید (مثال: https://www.aparat.com/v/XYZ):');
        if (!url) return;
        
        let hash = url.match(/v\/([a-zA-Z0-9]+)/)?.[1] || url.match(/videohash\/([a-zA-Z0-9]+)/)?.[1] || url.trim();
        
        if (hash) {
            let html = `<br><iframe src="https://www.aparat.com/video/video/embed/videohash/${hash}/vt/frame" allowFullScreen="true"></iframe><br><p>&#8203;</p>`;
            document.execCommand('insertHTML', false, html);
        }
    }

    function uploadCustomMedia(type, editorId) {
        const editor = document.getElementById(editorId);
        editor.focus();
        
        let selection = window.getSelection();
        let range = selection.rangeCount > 0 ? selection.getRangeAt(0) : null;

        let input = document.createElement('input');
        input.type = 'file';
        input.accept = type === 'image' ? 'image/*' : 'audio/*';
        
        input.onchange = function() {
            let file = this.files[0];
            let formData = new FormData();
            formData.append('file', file);

            if (range) { selection.removeAllRanges(); selection.addRange(range); }
            document.execCommand('insertHTML', false, `<span id="loading-media" style="color:#fbbf24;">[در حال آپلود...]</span>`);

            fetch('{{ route("admin.editor.upload") }}', {
                method: 'POST',
                headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                body: formData
            })
            .then(res => res.json())
            .then(data => {
                editor.innerHTML = editor.innerHTML.replace('<span id="loading-media" style="color:#fbbf24;">[در حال آپلود...]</span>', '');
                
                if (data.location) {
                    let html = type === 'image' 
                        ? `<br><img src="${data.location}" /><br><p>&#8203;</p>` 
                        : `<br><audio controls src="${data.location}" dir="ltr"></audio><br><p>&#8203;</p>`;
                    
                    editor.focus();
                    document.execCommand('insertHTML', false, html);
                } else {
                    alert('خطا در آپلود فایل');
                }
            }).catch(() => {
                editor.innerHTML = editor.innerHTML.replace('<span id="loading-media" style="color:#fbbf24;">[در حال آپلود...]</span>', '');
                alert('خطا در برقراری ارتباط با سرور');
            });
        };
        input.click();
    }

    document.getElementById('articleForm').onsubmit = function() {
        document.getElementById('content_fa_input').value = document.getElementById('editor_fa').innerHTML;
        document.getElementById('content_en_input').value = document.getElementById('editor_en').innerHTML;
    };
</script>
@endpush