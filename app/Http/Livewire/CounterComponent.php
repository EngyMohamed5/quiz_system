<?php

namespace App\Http\Livewire;

use App\Models\Quiz;
use Livewire\Component;
use RealRashid\SweetAlert\Facades\Alert;

class CounterComponent extends Component
{
    public $timeLimit; // Time limit in seconds
    public $quizId;
    public $remainingTime; // Remaining time in seconds

    public function mount($quizId)
    {
        $quiz = Quiz::findOrFail($quizId);
        $this->timeLimit = $quiz->time_limit * 60; // Convert minutes to seconds
        $this->remainingTime = $this->timeLimit; // Initialize remaining time
    }

    public function tick()
    {
        if ($this->remainingTime > 0) {
            $this->remainingTime--;
            
        } else {
            
            // return Redirect::route('quiz.completed', ['quizId' => $this->quizId]);
            $this->emit('quizTimeEnded'); // Emit Livewire event when time is up
        }
    }

    public function render()
    {
        return view('livewire.counter-component');
    }
}
