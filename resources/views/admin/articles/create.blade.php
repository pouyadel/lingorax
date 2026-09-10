@extends('admin.layout')

@section('title', 'افزودن مقاله دوزبانه')
@section('page-title', 'افزودن مقاله جدید (فارسی / انگلیسی)')

@push('styles')
<style>
    /* استایل‌های اختصاصی محیط ادیتور دست‌ساز شما */
    .custom-editor-content { min-height: 250px; outline: none; }
    .custom-editor-content h3 { font-size: 1.5rem; font-weight: bold; margin-bottom: 10px; color: #fbbf24; }
    .custom-editor-content p { margin-bottom: 10px; line-height: 1.8; }
    .custom-editor-content img { max-width: 100%; border-radius: 8px; margin: 10px 0; }
    .custom-editor-content audio { width: 100%; margin: 10px 0; border-radius: 30px; }
    .custom-editor-content iframe { width: 100%; height: 350px; border-radius: 12px; margin: 15px 0; border: none; }
    .editor-btn { padding: 4px 10px; font-size: 0.75rem; border-radius: 6px; background: rgba(255,255,255,0.05); color: #fff; transition: 0.2s; }
    .editor-btn:hover { background: rgba(255,255,255,0.15); color: #fbbf24; }
</style>
@endpush

@section('content')
<form action="{{ route('admin.articles.store') }}" method="POST" enctype="multipart/form-data" class="max-w-5xl space-y-6" id="articleForm">
    @csrf

    <div class="glass-card p-6 rounded-3xl border border-white/5 space-y-6">
        
        <!-- عناوین دوزبانه -->
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div class="space-y-2">
                <label class="text-xs text-brand-slate font-bold">عنوان فارسی (FA)</label>
                <input type="text" name="title_fa" required class="w-full bg-brand-dark border border-white/10 rounded-xl px-4 py-2.5 text-xs text-white focus:outline-none focus:border-brand-gold">
            </div>

            <div class="space-y-2">
                <label class="text-xs text-brand-slate font-bold">English Title (EN)</label>
                <input type="text" name="title_en" dir="ltr" required class="w-full bg-brand-dark border border-white/10 rounded-xl px-4 py-2.5 text-xs text-white focus:outline-none focus:border-brand-gold">
            </div>
        </div>

        <!-- دسته‌بندی و سطح -->
        <div class="grid grid-cols-1 sm:grid-cols-4 gap-4 border-t border-white/5 pt-4">
            <div class="space-y-2">
                <label class="text-xs text-brand-slate font-bold">دسته‌بندی</label>
                <select name="category" class="w-full bg-brand-dark border border-white/10 rounded-xl px-4 py-2.5 text-xs text-white">
                    <option value="listening">شنیداری</option>
                    <option value="grammar">گرامر</option>
                    <option value="vocab">واژگان</option>
                    <option value="reading">درک مطلب</option>
                    <option value="ielts">آیلتس و تافل</option>
                </select>
            </div>

            <div class="space-y-2">
                <label class="text-xs text-brand-slate font-bold">سطح زبان</label>
                <select name="level" class="w-full bg-brand-dark border border-white/10 rounded-xl px-4 py-2.5 text-xs text-white">
                    <option value="A1 - A2">A1 - A2</option>
                    <option value="B1 - B2">B1 - B2</option>
                    <option value="C1 - C2">C1 - C2</option>
                </select>
            </div>

            <div class="space-y-2">
                <label class="text-xs text-brand-slate font-bold">زمان مطالعه (دقیقه)</label>
                <input type="number" name="read_time" value="5" min="1" class="w-full bg-brand-dark border border-white/10 rounded-xl px-4 py-2.5 text-xs text-white">
            </div>

            <div class="space-y-2">
                <label class="text-xs text-brand-slate font-bold">تصویر شاخص</label>
                <input type="file" name="image" accept="image/*" class="w-full bg-brand-dark border border-white/10 rounded-xl p-2 text-xs text-brand-slate">
            </div>
        </div>

        <!-- چکیده دوزبانه (آرایه‌ای) -->
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 border-t border-white/5 pt-4">
            <div class="space-y-2" id="excerpt-fa-container">
                <label class="text-xs text-brand-slate font-bold flex justify-between">
                    <span>چکیده فارسی (لیست)</span>
                    <button type="button" onclick="addExcerpt('fa')" class="text-brand-gold hover:text-white">+</button>
                </label>
                <input type="text" name="excerpt_fa[]" class="w-full bg-brand-dark border border-white/10 rounded-xl px-4 py-2 text-xs text-white mb-2" placeholder="مورد اول...">
            </div>

            <div class="space-y-2" id="excerpt-en-container">
                <label class="text-xs text-brand-slate font-bold flex justify-between">
                    <span>English Excerpt (List)</span>
                    <button type="button" onclick="addExcerpt('en')" class="text-brand-gold hover:text-white">+</button>
                </label>
                <input type="text" name="excerpt_en[]" dir="ltr" class="w-full bg-brand-dark border border-white/10 rounded-xl px-4 py-2 text-xs text-white mb-2" placeholder="First item...">
            </div>
        </div>

        <!-- ادیتورهای دست‌ساز اختصاصی -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 border-t border-white/5 pt-4">
            <!-- ادیتور فارسی -->
            <div class="space-y-2">
                <label class="text-xs text-brand-gold font-bold">متن کامل (فارسی)</label>
                <div class="border border-white/10 rounded-xl overflow-hidden bg-[#080F1D]">
                    <div class="bg-[#0E1A2E] p-2 flex flex-wrap gap-2 border-b border-white/10">
                        <button type="button" onclick="formatDoc('formatBlock', 'H3', 'editor_fa')" class="editor-btn">تیتر</button>
                        <button type="button" onclick="formatDoc('formatBlock', 'P', 'editor_fa')" class="editor-btn">متن عادی</button>
                        <button type="button" onclick="formatDoc('bold', null, 'editor_fa')" class="editor-btn font-bold">B</button>
                        <div class="w-px h-5 bg-white/10 mx-1"></div>
                        <button type="button" onclick="formatDoc('justifyRight', null, 'editor_fa')" class="editor-btn">راست‌چین</button>
                        <button type="button" onclick="formatDoc('justifyLeft', null, 'editor_fa')" class="editor-btn">چپ‌چین</button>
                        <div class="w-px h-5 bg-white/10 mx-1"></div>
                        <button type="button" onclick="uploadCustomMedia('image', 'editor_fa')" class="editor-btn !text-blue-400">عکس</button>
                        <button type="button" onclick="uploadCustomMedia('audio', 'editor_fa')" class="editor-btn !text-green-400">ویس</button>
                        <button type="button" onclick="insertAparat('editor_fa')" class="editor-btn !text-red-400">آپارات</button>
                    </div>
                    <div id="editor_fa" contenteditable="true" class="custom-editor-content p-4 text-white text-sm" dir="rtl"></div>
                </div>
                <input type="hidden" name="content_fa" id="content_fa_input">
            </div>

            <!-- ادیتور انگلیسی -->
            <div class="space-y-2">
                <label class="text-xs text-brand-gold font-bold">Full Content (English)</label>
                <div class="border border-white/10 rounded-xl overflow-hidden bg-[#080F1D]">
                    <div class="bg-[#0E1A2E] p-2 flex flex-wrap gap-2 border-b border-white/10" dir="ltr">
                        <button type="button" onclick="formatDoc('formatBlock', 'H3', 'editor_en')" class="editor-btn">Heading</button>
                        <button type="button" onclick="formatDoc('formatBlock', 'P', 'editor_en')" class="editor-btn">Normal</button>
                        <button type="button" onclick="formatDoc('bold', null, 'editor_en')" class="editor-btn font-bold">B</button>
                        <div class="w-px h-5 bg-white/10 mx-1"></div>
                        <button type="button" onclick="formatDoc('justifyLeft', null, 'editor_en')" class="editor-btn">Left</button>
                        <button type="button" onclick="formatDoc('justifyRight', null, 'editor_en')" class="editor-btn">Right</button>
                        <div class="w-px h-5 bg-white/10 mx-1"></div>
                        <button type="button" onclick="uploadCustomMedia('image', 'editor_en')" class="editor-btn !text-blue-400">Image</button>
                        <button type="button" onclick="uploadCustomMedia('audio', 'editor_en')" class="editor-btn !text-green-400">Audio</button>
                        <button type="button" onclick="insertAparat('editor_en')" class="editor-btn !text-red-400">Aparat</button>
                    </div>
                    <div id="editor_en" contenteditable="true" class="custom-editor-content p-4 text-white text-sm" dir="ltr"></div>
                </div>
                <input type="hidden" name="content_en" id="content_en_input">
            </div>
        </div>

        <div class="flex items-center gap-2 pt-2">
            <input type="checkbox" name="is_published" id="is_published" value="1" checked class="rounded border-white/10 text-brand-gold focus:ring-brand-gold">
            <label for="is_published" class="text-xs font-bold text-white cursor-pointer">انتشار این مقاله</label>
        </div>
    </div>

    <button type="submit" class="bg-gradient-to-r from-brand-gold to-brand-goldHover text-brand-darkest font-black px-8 py-3 rounded-xl text-xs shadow-glow-gold hover:scale-105 transition-all">
        ذخیره و انتشار
    </button>
</form>
@endsection

@push('scripts')
<script>
    // اسکریپت افزودن چکیده آرایه ای
    function addExcerpt(lang) {
        const container = document.getElementById('excerpt-' + lang + '-container');
        const input = document.createElement('input');
        input.type = 'text';
        input.name = lang === 'fa' ? 'excerpt_fa[]' : 'excerpt_en[]';
        input.dir = lang === 'fa' ? 'rtl' : 'ltr';
        input.className = 'w-full bg-brand-dark border border-white/10 rounded-xl px-4 py-2 text-xs text-white mb-2 mt-2';
        container.appendChild(input);
    }

    // توابع ادیتور اختصاصی
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
        
        // ذخیره موقعیت نشانگر
        let selection = window.getSelection();
        let range = selection.rangeCount > 0 ? selection.getRangeAt(0) : null;

        let input = document.createElement('input');
        input.type = 'file';
        input.accept = type === 'image' ? 'image/*' : 'audio/*';
        
        input.onchange = function() {
            let file = this.files[0];
            let formData = new FormData();
            formData.append('file', file);

            // بازگرداندن نشانگر و درج متن لودینگ
            if (range) { selection.removeAllRanges(); selection.addRange(range); }
            document.execCommand('insertHTML', false, `<span id="loading-media" style="color:#fbbf24;">[در حال آپلود...]</span>`);

            fetch('{{ route("admin.editor.upload") }}', {
                method: 'POST',
                headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                body: formData
            })
            .then(res => res.json())
            .then(data => {
                // حذف متن لودینگ
                editor.innerHTML = editor.innerHTML.replace('<span id="loading-media" style="color:#fbbf24;">[در حال آپلود...]</span>', '');
                
                if (data.location) {
                    let html = type === 'image' 
                        ? `<br><img src="${data.location}" /><br><p>&#8203;</p>` 
                        : `<br><audio controls src="${data.location}" dir="ltr"></audio><br><p>&#8203;</p>`;
                    
                    editor.focus();
                    document.execCommand('insertHTML', false, html);
                } else {
                    alert('خطا در آپلود');
                }
            }).catch(() => {
                editor.innerHTML = editor.innerHTML.replace('<span id="loading-media" style="color:#fbbf24;">[در حال آپلود...]</span>', '');
                alert('خطا در ارتباط با سرور');
            });
        };
        input.click();
    }

    // کپی کردن محتوای ادیتورها به اینپوت‌های مخفی هنگام ارسال فرم
    document.getElementById('articleForm').onsubmit = function() {
        document.getElementById('content_fa_input').value = document.getElementById('editor_fa').innerHTML;
        document.getElementById('content_en_input').value = document.getElementById('editor_en').innerHTML;
    };
</script>
@endpush