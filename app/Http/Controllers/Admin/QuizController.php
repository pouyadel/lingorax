<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Quiz;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class QuizController extends Controller
{
    public function index()
    {
        $quizzes = Quiz::withCount('questions')->latest()->paginate(10);
        return view('admin.quizzes.index', compact('quizzes'));
    }

    public function create()
    {
        return view('admin.quizzes.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title_fa' => 'required|string|max:255',
            'title_en' => 'required|string|max:255',
            'level' => 'required|string',
            'category' => 'required|string',
            'description_fa' => 'nullable|string',
            'description_en' => 'nullable|string',
            'questions' => 'required|array|min:1',
            'questions.*.text_en' => 'required|string',
            'questions.*.text_fa' => 'nullable|string',
            'questions.*.options' => 'required|array|min:2',
            'questions.*.options.*.text_en' => 'required|string',
            'questions.*.options.*.text_fa' => 'nullable|string',
            'questions.*.correct' => 'required',
        ], [
            'title_fa.required' => 'وارد کردن عنوان فارسی آزمون الزامی است.',
            'title_en.required' => 'وارد کردن عنوان انگلیسی آزمون الزامی است.',
            'questions.*.text_en.required' => 'متن انگلیسی تمام سوالات الزامی است.',
            'questions.*.options.*.text_en.required' => 'متن انگلیسی تمام گزینه‌ها الزامی است.',
        ]);

        try {
            DB::transaction(function () use ($request) {
                $quiz = Quiz::create([
                    'title_fa' => $request->title_fa,
                    'title_en' => $request->title_en,
                    'slug' => Str::slug($request->title_en) . '-' . time(),
                    'description_fa' => $request->description_fa,
                    'description_en' => $request->description_en,
                    'level' => $request->level,
                    'category' => $request->category,
                    'is_published' => $request->has('is_published'),
                ]);

                foreach ($request->questions as $qIndex => $qData) {
                    $question = $quiz->questions()->create([
                        'text_fa' => $qData['text_fa'] ?? null,
                        'text_en' => $qData['text_en'],
                        'order' => $qIndex,
                    ]);

                    $correctIndex = (int)($qData['correct'] ?? 0);

                    foreach ($qData['options'] as $oIndex => $oData) {
                        $question->options()->create([
                            'text_fa' => $oData['text_fa'] ?? null,
                            'text_en' => $oData['text_en'],
                            'is_correct' => ($correctIndex === (int)$oIndex),
                            'order' => $oIndex,
                        ]);
                    }
                }
            });

            return redirect()->route('admin.quizzes.index')->with('success', 'آزمون دوزبانه با موفقیت ثبت شد.');

        } catch (\Exception $e) {
            return back()->withInput()->with('error', 'خطا در دیتابیس: ' . $e->getMessage());
        }
    }

    public function edit(Quiz $quiz)
    {
        $quiz->load(['questions.options']);
        return view('admin.quizzes.edit', compact('quiz'));
    }

    public function update(Request $request, Quiz $quiz)
    {
        $request->validate([
            'title_fa' => 'required|string|max:255',
            'title_en' => 'required|string|max:255',
            'level' => 'required|string',
            'category' => 'required|string',
            'questions' => 'required|array|min:1',
            'questions.*.text_en' => 'required|string',
            'questions.*.options' => 'required|array|min:2',
            'questions.*.options.*.text_en' => 'required|string',
            'questions.*.correct' => 'required',
        ]);

        try {
            DB::transaction(function () use ($request, $quiz) {
                $quiz->update([
                    'title_fa' => $request->title_fa,
                    'title_en' => $request->title_en,
                    'description_fa' => $request->description_fa,
                    'description_en' => $request->description_en,
                    'level' => $request->level,
                    'category' => $request->category,
                    'is_published' => $request->has('is_published'),
                ]);

                $quiz->questions()->delete();

                foreach ($request->questions as $qIndex => $qData) {
                    $question = $quiz->questions()->create([
                        'text_fa' => $qData['text_fa'] ?? null,
                        'text_en' => $qData['text_en'],
                        'order' => $qIndex,
                    ]);

                    $correctIndex = (int)($qData['correct'] ?? 0);

                    foreach ($qData['options'] as $oIndex => $oData) {
                        $question->options()->create([
                            'text_fa' => $oData['text_fa'] ?? null,
                            'text_en' => $oData['text_en'],
                            'is_correct' => ($correctIndex === (int)$oIndex),
                            'order' => $oIndex,
                        ]);
                    }
                }
            });

            return redirect()->route('admin.quizzes.index')->with('success', 'آزمون به‌روزرسانی شد.');

        } catch (\Exception $e) {
            return back()->withInput()->with('error', 'خطا در ویرایش: ' . $e->getMessage());
        }
    }

    public function destroy(Quiz $quiz)
    {
        $quiz->delete();
        return redirect()->route('admin.quizzes.index')->with('success', 'آزمون حذف شد.');
    }
}