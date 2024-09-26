<?php

namespace App\Http\Livewire;

use App\Models\Quiz;
use Livewire\Component;
use RealRashid\SweetAlert\Facades\Alert;

class CounterComponent extends Component
{
    public $timeLimit;
    public $quizId;
    public $remainingTime; 
    public function mount($quizId)
    {
        $quiz = Quiz::findOrFail($quizId);
        $this->timeLimit = $quiz->time_limit * 60; 
        $this->remainingTime = $this->timeLimit;
    }

    public function tick()
    {
        if ($this->remainingTime > 0) {
            $this->remainingTime--;
            
        } else {
            
            // return Redirect::route('quiz.completed', ['quizId' => $this->quizId]);
            $this->emit('quizTimeEnded'); 
        }
    }

    public function submitQuiz(){
       // submit logic
    }

    public function render()
    {
        return view('livewire.counter-component');
    }
}
