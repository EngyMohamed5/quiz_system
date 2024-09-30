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
        $request->validate([
            'question_text' => 'required|string',
            'question_type' => 'required|string|in:true_false,multiple_choice',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'options' => 'required|array|min:2',
            'options.*.option_text' => 'required|string',
            'options.*.is_correct' => 'required|boolean',
        ]);

        // get question here
        $question = Question::findOrFail($questionId);
        $question->question_text = $request->input('question_text');
        $question->question_type = $request->input('question_type');

        // image update

            $quiz_data['image']=$this->uploadImage($request, 'image', 'Quizzes_images');

    if ($this->checkFile($request,'image')) {
        $question->image = $this->uploadimage($request, 'image', 'Questions_images');
    }
        $question->save();
        foreach ($request->options as $optionData) {
            $option = Option::findOrFail($optionData['id']);
            $option->option_text = $optionData['option_text'];
            $option->is_correct = $optionData['is_correct'];
            $option->save();
        }

        return redirect()->route('questions.index', $quizId)->with('success', 'Question and options updated successfully');
    }

    public function destroy(Quiz $quiz, Question $question)
    {
        $question->delete();

        return redirect()->route('questions.index', $quiz->id)->with('success', 'Question deleted successfully.');
    }

}
