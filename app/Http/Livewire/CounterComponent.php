<?php

namespace App\Http\Livewire;

use App\Models\Quiz;
use Carbon\Carbon;
use Livewire\Component;
use RealRashid\SweetAlert\Facades\Alert;

class CounterComponent extends Component
{
    public $timeLimit;
    public $quizId;
    public $remainingTime; 
    public $endTime ;
    
    
    public function mount($quizId)
    {
        $quiz = Quiz::findOrFail($quizId);
        $this->timeLimit = $quiz->time_limit * 60; 

        $this->remainingTime = $this->timeLimit;
        $this->endTime = Carbon::now()->addSeconds($this->timeLimit);
    }

    public function tick()
    {
        $now = Carbon::now();

        if ($this->remainingTime > 0) {
            $this->remainingTime =  $now->diffInSeconds($this->endTime, false); 
        
        } else {
            $this->emit('quizTimeEnded'); 
        }
       
    }

    // public function submitQuiz(){
    //     // return redirect()->route()-
    // }

    public function render()
    {
        return view('livewire.counter-component');
    }
}
