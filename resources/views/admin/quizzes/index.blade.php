@extends('admin.layout')

@section('title', 'مدیریت آزمون‌ها')
@section('page-title', 'بانک آزمون‌های آنلاین')

@section('content')
<div class="space-y-5 sm:space-y-6">

    <!-- هدر بالای صفحه و دکمه ایجاد -->
    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-3 bg-brand-card/40 p-4 sm:p-6 rounded-2xl sm:rounded-3xl border border-white/5">
        <div>
            <h2 class="text-sm sm:text-base font-black text-white font-heading">بانک آزمون‌های آنلاین</h2>
            <span class="text-xs text-brand-slate mt-0.5 block">مجموع: {{ $quizzes->total() }} آزمون ثبت‌شده</span>
        </div>
        <a href="{{ route('admin.quizzes.create') }}" class="w-full sm:w-auto inline-flex items-center justify-center gap-1.5 bg-brand-gold hover:bg-brand-goldHover text-brand-darkest text-xs font-black px-5 py-2.5 rounded-xl shadow-glow-gold transition-all active:scale-95">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4" />
            </svg>
            <span>+ ساخت آزمون جدید</span>
        </a>
    </div>

    <!-- ۱. نمای کارت مخصوص موبایل -->
    <div class="grid grid-cols-1 gap-3.5 md:hidden">
        @forelse($quizzes as $quiz)
            <div class="glass-card p-4 rounded-2xl border border-white/5 space-y-3.5 shadow-md">
                <div>
                    <div class="flex items-center gap-1.5 flex-wrap mb-2">
                        <span class="px-2 py-0.5 rounded-md text-[10px] font-bold {{ $quiz->is_published ? 'bg-emerald-500/15 text-emerald-400 border border-emerald-500/20' : 'bg-red-500/15 text-red-400 border border-red-500/20' }}">
                            {{ $quiz->is_published ? 'منتشر شده' : 'پیش‌نویس' }}
                        </span>

                        @if($quiz->is_private)
                            <span class="px-2 py-0.5 rounded-md text-[10px] font-bold bg-purple-500/15 text-purple-300 border border-purple-500/30">
                                اختصاصی (رمز: <span class="font-mono text-white">{{ $quiz->password }}</span>)
                            </span>
                        @else
                            <span class="px-2 py-0.5 rounded-md text-[10px] font-bold bg-blue-500/15 text-blue-300 border border-blue-500/25">
                                عمومی
                            </span>
                        @endif

                        <span class="px-2 py-0.5 rounded-md text-[10px] font-bold bg-white/5 text-brand-gold border border-white/10">
                            {{ $quiz->category }}
                        </span>
                        <span class="px-2 py-0.5 rounded-md text-[10px] text-white bg-brand-cardLight border border-white/10">
                            {{ $quiz->questions_count }} سؤال
                        </span>
                    </div>

                    <h3 class="text-xs font-bold text-white">{{ $quiz->title_fa }}</h3>
                    <p class="text-[11px] text-brand-slate mt-0.5 truncate" dir="ltr">{{ $quiz->title_en }}</p>
                </div>

                <!-- دکمه‌های عملیات مشخص در موبایل -->
                <div class="grid grid-cols-3 gap-2 pt-2 border-t border-white/5">
                    <button 
                        type="button" 
                        onclick="navigator.clipboard.writeText('{{ route('quizzes.show', $quiz) }}'); alert('لینک آزمون کپی شد:\n{{ route('quizzes.show', $quiz) }}');" 
                        class="inline-flex items-center justify-center gap-1 py-2 rounded-xl bg-purple-500/15 text-purple-300 border border-purple-500/30 text-[11px] font-bold active:scale-95"
                    >
                        <span>کپی لینک</span>
                    </button>

                    <a href="{{ route('admin.quizzes.edit', $quiz) }}" class="inline-flex items-center justify-center gap-1 py-2 rounded-xl bg-brand-gold/15 text-brand-gold border border-brand-gold/30 text-[11px] font-bold hover:bg-brand-gold hover:text-brand-darkest transition-all">
                        <span>ویرایش</span>
                    </a>

                    <form action="{{ route('admin.quizzes.destroy', $quiz) }}" method="POST" onsubmit="return confirm('آیا از حذف این آزمون و سوالات آن مطمئن هستید؟');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="w-full inline-flex items-center justify-center gap-1 py-2 rounded-xl bg-red-500/15 text-red-400 border border-red-500/30 text-[11px] font-bold hover:bg-red-500 hover:text-white transition-all">
                            <span>حذف</span>
                        </button>
                    </form>
                </div>
            </div>
        @empty
            <div class="glass-card p-6 rounded-2xl text-center text-xs text-brand-slate border border-white/5">
                هیچ آزمونی یافت نشد.
            </div>
        @endforelse
    </div>

    <!-- ۲. نمای جدول برای تبلت و دسکتاپ -->
    <div class="hidden md:block glass-card rounded-3xl overflow-hidden border border-white/5 shadow-xl">
        <div class="overflow-x-auto">
            <table class="w-full text-right text-xs">
                <thead class="bg-white/5 text-brand-slate font-bold border-b border-white/5 text-[11px]">
                    <tr>
                        <th class="p-4 px-6">عنوان آزمون</th>
                        <th class="p-4 text-center">نوع و رمز</th>
                        <th class="p-4 text-center">دسته‌بندی / سطح</th>
                        <th class="p-4 text-center">تعداد سوالات</th>
                        <th class="p-4 text-center">وضعیت</th>
                        <th class="p-4 px-6 text-center">عملیات</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-white/5">
                    @forelse($quizzes as $quiz)
                        <tr class="hover:bg-white/[0.03] transition-all">
                            <td class="p-4 px-6">
                                <div class="font-bold text-white">{{ $quiz->title_fa }}</div>
                                <div class="text-[11px] text-brand-slate font-normal" dir="ltr">{{ $quiz->title_en }}</div>
                            </td>
                            <td class="p-4 text-center">
                                @if($quiz->is_private)
                                    <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-lg bg-purple-500/15 text-purple-300 font-bold text-[11px] border border-purple-500/30">
                                        🔒 اختصاصی (رمز: <span class="font-mono text-white">{{ $quiz->password }}</span>)
                                    </span>
                                @else
                                    <span class="inline-block px-2.5 py-1 rounded-lg bg-blue-500/15 text-blue-400 font-bold text-[11px] border border-blue-500/25">
                                        🌐 عمومی
                                    </span>
                                @endif
                            </td>
                            <td class="p-4 text-center">
                                <span class="px-2 py-0.5 rounded-lg bg-white/5 text-brand-gold font-bold text-[11px] border border-white/10">
                                    {{ $quiz->category }}
                                </span>
                                <div class="text-[10px] text-brand-slate mt-1">{{ $quiz->level }}</div>
                            </td>
                            <td class="p-4 text-center font-bold text-white">
                                {{ $quiz->questions_count }} سؤال
                            </td>
                            <td class="p-4 text-center">
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[10px] font-bold {{ $quiz->is_published ? 'bg-emerald-500/10 text-emerald-400 border border-emerald-500/20' : 'bg-red-500/10 text-red-400 border border-red-500/20' }}">
                                    <span class="w-1.5 h-1.5 rounded-full {{ $quiz->is_published ? 'bg-emerald-400' : 'bg-red-400' }}"></span>
                                    {{ $quiz->is_published ? 'فعال' : 'غیرفعال' }}
                                </span>
                            </td>
                            <td class="p-4 px-6 text-center">
                                <div class="inline-flex items-center justify-center gap-2">
                                    <!-- دکمه کپی لینک اختصاصی برای ارسال به زبان‌آموز -->
                                    <button 
                                        type="button" 
                                        onclick="navigator.clipboard.writeText('{{ route('quizzes.show', $quiz) }}'); alert('لینک آزمون با موفقیت کپی شد:\n{{ route('quizzes.show', $quiz) }}');" 
                                        class="inline-flex items-center gap-1 px-3 py-1.5 bg-purple-500/15 hover:bg-purple-500 text-purple-300 hover:text-white rounded-xl border border-purple-500/30 text-[11px] font-bold transition-all"
                                        title="کپی لینک اختصاصی برای ارسال به متقاضی"
                                    >
                                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z" />
                                        </svg>
                                        <span>کپی لینک</span>
                                    </button>

                                    <!-- دکمه ویرایش -->
                                    <a href="{{ route('admin.quizzes.edit', $quiz) }}" class="inline-flex items-center gap-1 px-3 py-1.5 bg-brand-gold/15 hover:bg-brand-gold text-brand-gold hover:text-brand-darkest rounded-xl border border-brand-gold/30 text-[11px] font-bold transition-all" title="ویرایش">
                                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/>
                                        </svg>
                                        <span>ویرایش</span>
                                    </a>

                                    <!-- دکمه حذف -->
                                    <form action="{{ route('admin.quizzes.destroy', $quiz) }}" method="POST" onsubmit="return confirm('آیا از حذف این آزمون و تمامی سوالات آن مطمئن هستید؟');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="inline-flex items-center gap-1 px-3 py-1.5 bg-red-500/15 hover:bg-red-500 text-red-400 hover:text-white rounded-xl border border-red-500/30 text-[11px] font-bold transition-all" title="حذف">
                                            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                            </svg>
                                            <span>حذف</span>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="p-6 text-center text-brand-slate">هیچ آزمونی یافت نشد.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- صفحه‌بندی -->
    <div class="pt-2 flex justify-center">
        {{ $quizzes->links() }}
    </div>
</div>
@endsection