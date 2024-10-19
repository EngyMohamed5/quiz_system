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


use App\Http\Controllers\Auth\VerifyEmailController;
use App\Http\Controllers\Auth\ResendVerificationEmailController;
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
})->name('dashboard')->middleware( 'verified');

// Group routes that share the 'admin' middleware
Route::middleware(['admin'])->group(function () {
    // Resource routes for topics
    Route::resource('topics', TopicController::class);

    // Admin dashboard route
    Route::get('/admin', [DashboardController::class, 'index'])
        ->name('admin.dashboard');

    // Admin-related routes
    Route::get('admins/showall', [AdminController::class, 'alladmins'])
        ->name('admins.showall');

    Route::resource('admins', AdminController::class);

    // User-related routes for admin
    Route::get('users', [AdminController::class, 'getusers'])
        ->name('users.showall');

    Route::get('users/showall', [AdminController::class, 'allusers'])
        ->name('allusers.showall');

    //results
    Route::get('/quiz/results', [QuizController::class, 'showResults'])->name('quiz.results');

    // display quiz 
    Route::get('/quiz/{quiz}', [QuizController::class, 'showQuiz'])->name('quiz.show')->middleware('check.quiz.attempt');
});



Route::resource('admins', AdminController::class)->only(['create', 'store'])->middleware('super_admin');

/*....................................................................... */
Route::middleware(['admin'])->group(function () {
    // Quiz Creation
    Route::get('admin/createQuiz', [AdminController::class, 'createQuizPage'])
        ->name('admin.CreateQuiz');
    Route::post("admin/storeQuiz", [QuizController::class, 'store'])
        ->name('quiz.store');

    // Quizzes & Questions Management
    Route::get('admin/quizzes', [QuizController::class, 'index'])
        ->name('quiz.index');
    Route::post('admin/quizzes/update', [QuizController::class, 'update'])
        ->name('quiz.update');
    Route::delete('admin/quizzes/{quiz}', [QuizController::class, 'destroy'])
        ->name('quiz.delete');
    Route::get('admin/quizzes/{quiz}/questions', [QuestionController::class, 'index'])
        ->name('questions.index');
    Route::resource('admin.quizzes.questions', QuestionController::class)->parameters([
        'questions' => 'question'
    ]);
    Route::get('admin/quizzes/{quiz}/questions/{question}', [QuestionController::class, 'show'])
        ->name('questions.show');
    Route::get('admin/quizzes/{quiz}/questions/{question}/edit', [QuestionController::class, 'edit'])
        ->name('questions.edit');
    Route::put('admin/quizzes/{quiz}/questions/{question}', [QuestionController::class, 'update'])
        ->name('questions.update');
    Route::delete('quizzes/{quiz}/questions/{question}', [QuestionController::class, 'destroy'])
        ->name('questions.destroy');

    Route::get('admin/quizzes/topics/{topic}', [QuizController::class, 'showQuizzesByTopicForAdmin'])
        ->name('quizzes.by_topic.admin');

    Route::get("/admin/quizzes/{quiz}/participants", [QuizController::class, 'showUsersForQuizForAdmin'])
        ->name('quizzes.participants');
    Route::get("/admin/quizzes/{quiz}/participants/{month}", [QuizController::class, 'showUsersForQuizForAdminByMonth'])
        ->name('quizzes.participants.month');
    //results-error-dashboard
    Route::get('/quiz/showresults', [QuizController::class, 'showdata'])
        ->name('quiz.showresults');
    //reports 
    Route::get('/quiz/{quizId}/pdf', [QuizController::class, 'generatePdf'])->name('quiz.pdf');



    // Route::post('report/export/pdf', [QuizController::class, 'exportPDF'])->name('report.export.pdf');

});
/*....................................................................... */


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::get('/profile/history', [ProfileController::class, 'showResults'])->name('profile.History');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::patch('/profile/image', [ProfileController::class, 'update_image'])->name('profile.update_image');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


Route::get('/topics/{topic}', [QuizController::class, 'showQuizzesByTopic'])->name('quizzes.by_topic');


// score routes
Route::get('/score', [QuizController::class, 'showResults'])->name('score.view');
Route::post('/submit-quiz', [QuizController::class, 'submitQuiz'])->name('quiz.submit');





Route::get('/email/verify', function () {
    return view('auth.verify-email');
})->middleware('auth')->name('verification.notice');

Route::get('/email/verify/{id}/{hash}', [VerifyEmailController::class, '__invoke'])
    ->middleware(['auth', 'signed'])->name('verification.verify');

require __DIR__ . '/auth.php';
