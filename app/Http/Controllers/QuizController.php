<?php

namespace App\Http\Controllers;

use App\Models\Quiz;
use App\Models\Topic;
use Illuminate\Http\Request;

class QuizController extends Controller
{
    public function showQuizzesByTopic(Topic $topic)
    {
        $quizzes = $topic->quizzes;
        return view('website.quizzes.index', compact('topic', 'quizzes'));
    }

    public function showQuiz(Quiz $quiz)
    {
        return view('website.quizzes.show', compact('quiz'));
    }

}
