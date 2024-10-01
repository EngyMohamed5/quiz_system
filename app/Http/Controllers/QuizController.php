<?php

namespace App\Http\Controllers;

use App\Mail\AnswerMail;
use App\Models\Option;
use App\Models\Question;
use App\Models\PerformanceHistory;
use App\Models\Answer;
use App\Models\Quiz;
use App\Models\Topic;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Traits\Uploadimage;
use App\Traits\CheckFile;
use Illuminate\Support\Facades\Mail;
use RealRashid\SweetAlert\Facades\Alert;

class QuizController extends Controller
{
    use Uploadimage, CheckFile;
    public function showQuizzesByTopic(Topic $topic)
    {
        $quizzes = $topic->quizzes;
        return view('website.quizzes.index', compact('topic', 'quizzes'));
    }

    public function showQuiz(Quiz $quiz)
    {
        return view('website.quizzes.show', compact('quiz'));
    }

    public function store(Request $request)
    {
//        dd($request->questions);

        try {
            $request->validate([
                "title" => "required|string|unique:quizzes",
                "description" => "required|string",
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif',
                "quiz_type" => "required",
                "time_limit" => "required|integer",
                "topic_id" => "required|integer",
                "questions" => "required|array|min:1",
                "questions.*.text" => "required|string",
                "questions.*.type" => "required|string",
                "questions.*.image" => "nullable|image|mimes:jpeg,png,jpg,gif",
                "questions.*.options" => "required|array|min:2",
                "questions.*.options.*" => "required|string",
                "questions.*.is_correct_number" => "required|integer|min:1|max:4",
                "created_by" => "required|integer",
            ]);
            DB::transaction(function () use ($request) {
                $quiz_data = [
                    "title" => $request->title,
                    "description" => $request->description,
                    "quiz_type" => $request->quiz_type,
                    "time_limit" => $request->time_limit,
                    "created_by" => $request->created_by,
                    "topic_id" => $request->topic_id,
                ];
                if ($this->checkFile($request, 'image')) {
                    $quiz_data['image'] = $this->uploadImage($request, 'image', 'Quizzes_images');;
                }

                $quiz = Quiz::create($quiz_data);

                foreach ($request->questions as $question_to_store) {
                    $question_data = [
                        "question_text" => $question_to_store['text'],
                        "question_type" => $question_to_store['type'],
                    ];
                    if (array_key_exists('image', $question_to_store)) {
                        $question_data['image'] = $this->uploadImage($request, 'image', 'Questions_images');
                    }
                    $question = $quiz->questions()->create($question_data);
                    foreach ($question_to_store['options'] as $index => $option) {
                        $question->options()->create([
                            'option_text' => $option,
                            'is_correct' => ($question_to_store['is_correct_number'] - 1) === $index ? 1 : 0,
                        ]);
                    }
                }
            });
            alert::success("Success!","Quiz Added Successfully");
            return redirect()->route("quiz.index");
        } catch (\Exception $e) {
            $errorCount = count($e->validator->errors()->all());
            $errorMessage = "There are {$errorCount} issues with your input.";
            toast($errorMessage, 'error');
            return redirect()->back();
        }
    }

    public function submitQuiz(Request $request)
    {
        $submittedAnswers = $request->except('_token');
        $userId = auth()->id();
        $quizId = $request->input('quiz_id');
        $score = 0;
        $totalQuestions = 0;



        $questions = Question::where('quiz_id', $quizId)->get();
        $totalQuestions = $questions->count();

        foreach ($submittedAnswers as $questionKey => $selectedOptionId) {
            $questionId = str_replace('question_', '', $questionKey);


            $correctOption = Option::where('question_id', $questionId)
                ->where('is_correct', 1)
                ->first();


            if (!$correctOption) {
                continue;
            }


            if ($correctOption->id == $selectedOptionId) {
                $score++;
            }


            Answer::create([
                'user_id' => $userId,
                'quiz_id' => $quizId,
                'question_id' => $questionId,
                'option_id' => $selectedOptionId,
                'is_correct' => $correctOption->id == $selectedOptionId ? 1 : 0,
                'attempt_number' => 1,
            ]);
        }


        $percentageScore = ($totalQuestions > 0) ? ($score / $totalQuestions) * 100 : 0;

        $latestAttempt = PerformanceHistory::where('user_id', auth()->id())
            ->where('quiz_id', $quizId)
            ->max('attempt_number');
        $newAttemptNumber = $latestAttempt ? $latestAttempt + 1 : 1;

        PerformanceHistory::create([
            'user_id' => $userId,
            'quiz_id' => $quizId,
            'score' =>  $percentageScore,
            'attempt_number' => $newAttemptNumber,
        ]);

        $quiz = Quiz::select('title', 'quiz_type')->find($quizId);

        if ($quiz->quiz_type == "once_attempt") {
            $useranswer = Answer::where('user_id', auth()->id())
                ->where('quiz_id', $quizId)
                ->get();
            Mail::to(auth()->user()->email)->send(new AnswerMail($questions, $useranswer, $quiz->title));
        }

        return redirect()->route('score.view', [
            'score' => $score,
            'total' => $totalQuestions,
            'percentage' => $percentageScore
        ]);
    }

    public function showResults(Request $request)
    {

        $userId = auth()->id();


        $userResults = PerformanceHistory::select(
            'performance_histories.user_id',
            'users.name',
            'quizzes.title',
            'performance_histories.score',
            'performance_histories.attempt_number',

        )
            ->join('users', 'performance_histories.user_id', '=', 'users.id')
            ->join('quizzes', 'performance_histories.quiz_id', '=', 'quizzes.id')
            ->where('performance_histories.user_id', $userId)
            ->get();


        $score = $request->input('score');
        $total = $request->input('total');
        $percentage = $request->input('percentage');

        return view('quiz.results', compact('score', 'total', 'percentage', 'userResults'));
    }



    public function showdata(Request $request)
    {
        $userId = auth()->id();


        $results = PerformanceHistory::select('performance_histories.user_id', 'users.name', 'performance_histories.score')
            ->join('users', 'performance_histories.user_id', '=', 'users.id')
            ->get();


        $score = $request->input('score');
        $total = $request->input('total');
        $percentage = $request->input('percentage');

        return view('quiz.showresults', compact('score', 'total', 'percentage', 'results', 'userId'));
    }

    // here i show quiz and delete
    public function index()
    {
        $quizzes = Quiz::all();
        return view('dashboard.quiz.index', compact('quizzes'));
    }
    public function show(Quiz $quiz)
    {
        $quiz->load('questions.options');
        return view('dashboard.quiz.show', compact('quiz'));
    }
    public function destroy(Quiz $quiz)
    {
        $quiz->delete();
        return redirect()->route('quiz.index')->with('success', 'Quiz deleted successfully.');
    }
}
