<?php

namespace App\Http\Controllers;

use App\Models\Topic;
use Illuminate\Http\Request;

class QuizController extends Controller
{
    public function showQuizzesByTopic(Topic $topic)
    {
        $quizzes = $topic->quizzes;
        return view('website.quizzes.index', compact('topic', 'quizzes'));
    }

}
