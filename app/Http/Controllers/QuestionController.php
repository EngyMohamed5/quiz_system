<?php

namespace App\Http\Controllers;
use App\Models\Answer;
use App\Models\Option;
use App\Models\PerformanceHistory;
use App\Models\Question;
use App\Models\Quiz;
use App\Models\Topic;
use Illuminate\Http\Request;
use App\Traits\Uploadimage;
use App\Traits\CheckFile;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use RealRashid\SweetAlert\Facades\Alert;

class QuestionController extends Controller
{
    use Uploadimage, CheckFile;

    public function index($quizId)
{

    $quiz = Quiz::with(['questions' => function($query) {
        $query->with('options');
    }])->findOrFail($quizId);

    return view('Dashboard.questions.index', compact('quiz'));
}

    // edit  question by (question , quiz) id
    public function edit($quizId, $questionId)
    {
        $quiz = Quiz::findOrFail($quizId);
        $question = Question::findOrFail($questionId);
        return view('Dashboard.questions.edit', compact('quiz', 'question'));
    }




  //update question so we need (question , quiz) id

    public function update(Request $request, $quizId, $questionId)
    {
//        return $request;
//        dd ($request);
        try{
            $request->validate([
                'question_text' => 'required|string',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif',
                'options' => 'required|array|min:2',
                'options.*.option_text' => 'required|string',
                'is_correct_number' => 'integer',
            ]);
            DB::transaction(function () use ($request,$questionId,$quizId) {
                $question = Question::findOrFail($questionId);
                $question->question_text = $request->question_text;
                if ($this->checkFile($request,'image')) {
                    $question->image = $this->uploadimage($request, 'image', 'Questions_images');
                }
                $question->save();
                foreach ($request->options as $index => $option_to_edit) {
                    $option = Option::findOrFail($option_to_edit['id']);
                    $option->option_text = $option_to_edit['option_text'];
                    $option->is_correct = ($request->is_correct_number - 1) === $index ? 1 : 0;
                    $option->save();
                }
            });

            alert::success("Success!",'Question Updated Successfully');
            return redirect()->back();
        }
     catch (\Exception $e){
         alert()->error('Question Could Not Be Updated!');
         return redirect()->back();
     }
    }

    public function destroy(Quiz $quiz, Question $question)
    {
        $question->delete();
        return redirect()->route('questions.index', $quiz->id)->with('success', 'Question deleted successfully.');
    }

}
