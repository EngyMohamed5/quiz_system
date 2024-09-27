<?php

namespace App\Http\Middleware;

use App\Models\PerformanceHistory;
use Closure;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class CheckQuizAttempt
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $quiz = $request->route('quiz');

        if ($quiz->quiz_type == 'once_attempt') {
            $attempt_status = PerformanceHistory::where('quiz_id', $quiz->id)
                                                ->where('user_id', auth()->id())
                                                ->exists();
    
            if ($attempt_status) {
                Alert::error('Oops!', 'You have already attempted this quiz.');
                return redirect()->back();
            }
        }
    
        return $next($request);
    }
}
