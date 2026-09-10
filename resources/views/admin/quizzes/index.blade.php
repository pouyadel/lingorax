@extends('admin.layout')

@section('title', 'مدیریت آزمون‌ها')
@section('page-title', 'بانک آزمون‌های آنلاین')

@section('content')
<div class="space-y-6">
    <div class="flex justify-between items-center">
        <span class="text-xs text-brand-slate">مجموع: {{ $quizzes->total() }} آزمون</span>
        <a href="{{ route('admin.quizzes.create') }}" class="bg-brand-gold hover:bg-brand-goldHover text-brand-darkest text-xs font-black px-5 py-2.5 rounded-xl shadow-glow-gold transition-all">
            + ساخت آزمون جدید
        </a>
    </div>

    <div class="glass-card rounded-3xl overflow-hidden border border-white/5">
        <table class="w-full text-right text-xs">
            <thead class="bg-white/5 text-brand-slate font-bold border-b border-white/5">
                <tr>
                    <th class="p-4">عنوان آزمون</th>
                    <th class="p-4">دسته‌بندی</th>
                    <th class="p-4">سطح</th>
                    <th class="p-4">تعداد سوالات</th>
                    <th class="p-4">وضعیت</th>
                    <th class="p-4 text-center">عملیات</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-white/5">
                @forelse($quizzes as $quiz)
                    <tr class="hover:bg-white/5 transition-all">
                        <td class="p-4 font-bold text-white">
                            <div>{{ $quiz->title_fa }}</div>
                            <div class="text-[11px] text-brand-slate font-normal" dir="ltr">{{ $quiz->title_en }}</div>
                        </td>
                        <td class="p-4 text-brand-gold font-bold">{{ $quiz->category }}</td>
                        <td class="p-4 text-brand-slate">{{ $quiz->level }}</td>
                        <td class="p-4 font-bold text-white">{{ $quiz->questions_count }} سوال</td>
                        <td class="p-4">
                            <span class="px-2.5 py-1 rounded-full text-[10px] font-bold {{ $quiz->is_published ? 'bg-emerald-500/10 text-emerald-400 border border-emerald-500/20' : 'bg-red-500/10 text-red-400 border border-red-500/20' }}">
                                {{ $quiz->is_published ? 'منتشر شده' : 'پیش‌نویس' }}
                            </span>
                        </td>
                        <td class="p-4 text-center">
                            <div class="flex items-center justify-center gap-2">
                                <a href="{{ route('admin.quizzes.edit', $quiz) }}" class="p-2 text-brand-gold hover:bg-white/10 rounded-lg transition-all" title="ویرایش">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/></svg>
                                </a>
                                <form action="{{ route('admin.quizzes.destroy', $quiz) }}" method="POST" onsubmit="return confirm('آیا این آزمون و سوالاتش حذف شوند؟');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="p-2 text-red-400 hover:bg-white/10 rounded-lg transition-all" title="حذف">
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
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

    <div>{{ $quizzes->links() }}</div>
</div>
@endsection