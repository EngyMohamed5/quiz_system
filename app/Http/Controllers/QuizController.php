<?php

namespace App\Http\Controllers;

use App\Models\Quiz;
use App\Models\Topic;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Traits\Uploadimage;
use App\Traits\CheckFile;
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

      try{
          $request->validate([
              "title" => "required|string|unique:quizzes",
              "description" => "required|string",
              'image' => 'nullable|image|mimes:jpeg,png,jpg,gif',
              "quize_type" => "required",
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
              $quiz_data=[
                  "title"=>$request->title,
                  "description"=>$request->description,
                  "quize_type"=>$request->quize_type,
                  "time_limit"=>$request->time_limit,
                  "created_by"=>$request->created_by,
                  "topic_id"=>$request->topic_id,
              ];
              if($this->checkFile($request,'image')){
                  $quiz_data['image']=$this->uploadImage($request, 'image', 'Quizzes_images');;
              }

              $quiz= Quiz::create($quiz_data);

              foreach ($request->questions as $question_to_store) {
//                  dd($question_to_store);
                  $question_data=[
                      "question_text"=>$question_to_store['text'],
                      "question_type"=>$question_to_store['type'],
                  ];
                  if(array_key_exists('image',$question_to_store)){
                      $question_data['image']=$this->uploadImage($request, 'image', 'Questions_images');
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
      }catch (\Exception $e){
          return $e->getMessage();
      }



    }



}
