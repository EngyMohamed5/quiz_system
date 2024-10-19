<?php

namespace App\Http\Controllers;


use App\Mail\AnswerMail;
use App\Models\Option;
use App\Models\Question;
use App\Models\PerformanceHistory;
use App\Models\Answer;
use App\Models\Quiz;
use App\Models\Topic;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Traits\Uploadimage;
use App\Traits\CheckFile;
use Illuminate\Support\Facades\Mail;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Validation\ValidationException;
use Barryvdh\DomPDF\ServiceProvider as PDF;
use Illuminate\Support\Facades\Log;




class QuizController extends Controller
{
    use Uploadimage, CheckFile;
    public function showQuizzesByTopic($id)
    {
        if($id){
            $topic = Topic::findOrFail($id);
            $quizzes = $topic->quizzes()->paginate(2);
        }else{
            $topic = (object) ['name'=>'All'];
            $quizzes = Quiz::paginate(3);
        }
        return view('website.quizzes.index', compact('topic', 'quizzes'));

    }
    
    public function getMonths()
    {
        $months = array_combine(
            ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
            range(1, 12)
        );
return $months;
    }

    public function showQuiz(Quiz $quiz)
    {
        return view('website.quizzes.show', compact('quiz'));
    }

    public function addQuestions(array $QuestionsData, Quiz $quiz,Request $request=null)
    {
        foreach ( $QuestionsData as $question_to_store) {
            $question_data = [
                "question_text" => $question_to_store['text'],
                "question_type" => $question_to_store['type'],
            ];
            if (array_key_exists('image', $question_to_store)) {
                $question_data['image'] = $this->uploadImage($question_to_store, 'image', 'Questions_images');
            }
            $question = $quiz->questions()->create($question_data);
            foreach ($question_to_store['options'] as $index => $option) {
                $question->options()->create([
                    'option_text' => $option,
                    'is_correct' => ($question_to_store['is_correct_number'] - 1) === $index ? 1 : 0,
                ]);
            }
        }
    }
    public function store(Request $request)
    {
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
                $this->addQuestions($request["questions"],$quiz,$request);

            });
            alert::success("Success!","Quiz Added Successfully");
            return redirect()->route("quiz.index");
        } catch (ValidationException $e) {
            // Get the error messages
            $errorMessages = $e->validator->errors()->all();
            $errorCount = count($errorMessages);
            $errorMessage = "There are {$errorCount} issues with your input.";

            // Display error message (using toast, assuming it's a function you have)
            toast($errorMessage, 'error');

            // Redirect back to the previous page
            return redirect()->back()->withInput(); // Optionally retain the input
        } catch (\Exception $e) {
            // Handle any other exceptions
            toast('An unexpected error occurred. Please try again.', 'error');
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
            'quizzes.quiz_type',
            'performance_histories.score',
            'performance_histories.attempt_number',

        )
            ->join('users', 'performance_histories.user_id', '=', 'users.id')
            ->join('quizzes', 'performance_histories.quiz_id', '=', 'quizzes.id',)
            ->where('performance_histories.user_id', $userId)
            ->get();


        $score = $request->input('score');
        $total = $request->input('total');
        $percentage = $request->input('percentage');

        return view('quiz.results', compact('score', 'total', 'percentage', 'userResults'));
    }


    public function showdata(Request $request)
    {
        // الحصول على معرف المستخدم الحالي
        $userId = auth()->id();
    
        // جلب نتائج الأداء
        $results = PerformanceHistory::select(
            'performance_histories.user_id', 
            'users.name', 
            'performance_histories.score',
            'quizzes.title as quizTitle'
        )
        ->join('users', 'performance_histories.user_id', '=', 'users.id')
        ->join('quizzes', 'performance_histories.quiz_id', '=', 'quizzes.id')
        ->get();
    
        // جمع البيانات للرسم البياني
        $quizTitles = Quiz::pluck('title')->toArray(); // سحب عناوين الاختبارات من قاعدة البيانات
        $userCounts = [];
    
        // احصاء عدد المستخدمين الذين قاموا بالاختبار
        foreach ($quizTitles as $title) {
            $quizId = Quiz::where('title', $title)->value('id'); // الحصول على معرف الاختبار
            $userCounts[] = PerformanceHistory::where('quiz_id', $quizId)->count(); // استخدام quiz_id
        }
    
        // حساب المتوسط ونسبة النجاح
        $averageScore = PerformanceHistory::avg('score') ?? 0; // التأكد من أن المتوسط قابل للاستخدام
        $passPercentage = PerformanceHistory::where('score', '>=', 50)->count() / (PerformanceHistory::count() ?: 1) * 100; // تجنب القسمة على صفر
    
        // إرجاع النتائج إلى العرض
        return view('quiz.showresults', compact('results', 'quizTitles', 'userCounts', 'averageScore', 'passPercentage'));
    }
    
    
    
    // here i show quiz and delete
    public function index()
    {
        $quizzes = Quiz::with(['creator:id,name'])->get();
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
    public function update(Request $request)
    {
        try{
            $rules = [
                "description" => "required",
                "quiz_type" => "required",
                "image" => "nullable|image|mimes:jpeg,png,jpg,gif,svg",
                "time_limit" => "required|integer|min:0",
                "topic_id" => "required",
            ];
            $quiz = Quiz::find($request->id);
            $rules["title"] = ($quiz->title !== $request->title) ? "required|unique:quizzes,title" : "required";
            if(isset($request->questions)){
                $rules["questions"] = "required|array";
                $rules["questions.*.text" ]= "required|string";
                $rules["questions.*.type" ]= "required|string";
                $rules["questions.*.image"] = "nullable|image|mimes:jpeg,png,jpg,gif";
                $rules["questions.*.options"] = "required|array|min:2";
                $rules["questions.*.options.*"] = "required|string";
                $rules["questions.*.is_correct_number" ]= "required|integer|min:1|max:4";
            }
            $validatedData = $request->validate($rules);
            DB::transaction(function () use ($quiz, $validatedData, $request) {
                $quiz->update([
                    'title' => $validatedData['title'],
                    'description' => $validatedData['description'],
                    'quiz_type' => $validatedData['quiz_type'],
                    'time_limit' => $validatedData['time_limit'],
                    'topic_id' => $validatedData['topic_id'],
                ]);
                if ($this->checkFile($request,"image")) {
                    $quiz->image = $this->uploadImage($request, 'image', 'Quizzes_images');
                    $quiz->save();
                }
                if(isset($validatedData['questions'])){
                    $this->addQuestions($validatedData["questions"],$quiz,$request);
                }
            });
            alert::success("Success!","Quiz Updated Successfully");
            return redirect()->back();
        }catch(\Exception $e){
            alert::error("Failed!",$e->getMessage());
            return redirect()->back();
        }
    }
    public function showQuizzesByTopicForAdmin(Topic $topic)
    {
        $quizzes=$topic->quizzes;
        return view('Dashboard.quiz.index', compact( 'quizzes'));

    }
    public function showUsersForQuizForAdmin(Quiz $quiz)
    {
        $months = $this->getMonths();
        $participants = Quiz::with(['performances' => function ($query) {
            $query->select('id', 'user_id', 'quiz_id','created_at');
        }, 'performances.user' => function ($query) {
            $query->select('id', 'name', 'email');
        }])
            ->find($quiz->id)
            ->performances
            ->map(function ($performance) {
                $performance->created_at_edited = Carbon::parse($performance->created_at)->format('M j, Y \a\t H:i');
                $performance->user_name = $performance->user->name;
                return $performance;
            })
            ->sortByDesc('created_at');
        return view("Dashboard.quiz.participants",compact("participants","quiz","months"));
    }
    public function showUsersForQuizForAdminByMonth(Quiz $quiz,$month)
    {
        $months = $this->getMonths();
        $participants = Quiz::with([
            'performances' => function ($query) use ($month) {
            $query->select('id', 'user_id', 'quiz_id','created_at')
                ->whereMonth('created_at', $month);
            },
            'performances.user' => function ($query) {
            $query->select('id', 'name', 'email');
            }
            ])->find($quiz->id)
            ->performances
            ->map(function ($performance) {
                $performance->created_at_edited = Carbon::parse($performance->created_at)->format('M j, Y \a\t H:i');
                $performance->user_name = $performance->user->name;
                return $performance;
            })
            ->sortByDesc('created_at');
        return view("Dashboard.quiz.participants",compact("participants","quiz","months"));
    }


    //reports 
   
    public function generatePdf($quizId)
{
    // Check if the user is authenticated
    if (!auth()->check()) {
        return response()->json(['error' => 'User not authenticated.'], 401);
    }

    // Fetch the quiz title
    $quiz = Quiz::findOrFail($quizId);

    // Fetch the results: User name and score for the quiz
    $results = PerformanceHistory::select('performance_histories.user_id', 'users.name', 'performance_histories.score')
        ->join('users', 'performance_histories.user_id', '=', 'users.id')
        ->where('performance_histories.quiz_id', $quizId) // Filter by the quiz ID
        ->get();

    // Prepare data for the PDF
    $data = [
        'quizTitle' => $quiz->title,
        'results' => $results, // Passing the results to the view
    ];

    // Create a new PDF instance
    $pdf = app('dompdf.wrapper');
    $pdf->loadView('pdf.quiz_report', $data);
    
    // Return the generated PDF for download
    return $pdf->download('quiz_report.pdf');
}

    

    
    
}
