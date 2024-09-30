<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TopicController;
use App\Http\Controllers\QuizController;

use App\Mail\AnswerMail;
use Illuminate\Support\Facades\Mail;

use App\Http\Controllers\QuestionController;
use Illuminate\Support\Facades\Route;
use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('dashboard');
});


Route::get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');


Route::resource('topics', TopicController::class)->middleware('admin');

Route::get('/admin', [DashboardController::class, 'index'])
    ->name('admin.dashboard')
    ->middleware('admin');

Route::post('users/search', [AdminController::class, 'SearchForUser'])
    ->name('users.search');

Route::get('admins/showall', [AdminController::class, 'alladmins'])
    ->name('admins.showall')->middleware('admin');

Route::get('users', [AdminController::class, 'getusers'])
    ->name('users.showall')->middleware('admin');

Route::get('users/showall', [AdminController::class, 'allusers'])
    ->name('allusers.showall')->middleware('admin');

Route::resource('admins', AdminController::class)->middleware('admin');
Route::resource('admins', AdminController::class)->only(['create', 'store'])->middleware('super_admin');



//Create Quiz
Route::get('admin/createQuiz', [AdminController::class, 'createQuizPage'])
    ->name('admin.CreateQuiz')->middleware('admin');
Route::post("admin/storeQuiz", [QuizController::class, 'store'])->name('quiz.store')->middleware('admin');



/*....................................................................... */
//quiz admin update  delete
Route::get('admin/quizzes', [QuizController::class, 'index'])->name('quiz.index');
Route::delete('admin/quizzes/{quiz}', [QuizController::class, 'destroy'])->name('quiz.delete');
Route::get('admin/quizzes/{quiz}/questions', [QuestionController::class, 'index'])->name('questions.index');
Route::resource('admin.quizzes.questions', QuestionController::class)->parameters([
    'questions' => 'question'
]);
Route::get('admin/quizzes/{quiz}/questions/{question}', [QuestionController::class, 'show'])->name('questions.show'); // Show a specific question
Route::get('admin/quizzes/{quiz}/questions/{question}/edit', [QuestionController::class, 'edit'])->name('questions.edit');
Route::put('admin/quizzes/{quiz}/questions/{question}', [QuestionController::class, 'update'])->name('questions.update');
Route::delete('quizzes/{quiz}/questions/{question}', [QuestionController::class, 'destroy'])->name('questions.destroy');

/*....................................................................... */


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


Route::get('/topics/{topic}', [QuizController::class, 'showQuizzesByTopic'])->name('quizzes.by_topic');
Route::get('/quiz/{quiz}', [QuizController::class, 'showQuiz'])->name('quiz.show')->middleware(['auth','check.quiz.attempt']);


// score routes
Route::get('/score', [QuizController::class, 'showResults'])->name('score.view');
Route::post('/submit-quiz', [QuizController::class, 'submitQuiz'])->name('quiz.submit');
//results
Route::get('/quiz/results', [QuizController::class, 'showResults'])->name('quiz.results')->middleware('auth');
//results-error-dashboard
Route::get('/quiz/showresults', [QuizController::class, 'showdata'])
    ->name('quiz.showresults');



require __DIR__ . '/auth.php';
