<x-app-layout>
    <h1>{{ $quiz->title }}</h1>
    <p>{{ $quiz->description }}</p>

    <div id="timer">
        Time left: <span id="time">{{ $quiz->time_limit * 60 }}</span> seconds
    </div>

    <form action="/submit-quiz" method="POST">
        @csrf

        @foreach($quiz->questions as $question)
            <div class="question">
                <p>{{ $question->question_text }}</p>
                
                @foreach($question->options as $option)
                    <div>
                        <input type="radio" name="question_{{ $question->id }}" value="{{ $option->id }}">
                        <label>{{ $option->option_text }}</label>
                    </div>
                @endforeach
            </div>
        @endforeach

        <button type="submit">Submit Quiz</button>
    </form>

    
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            let timeLeft = {{ $quiz->time_limit * 60 }};
    
            const timerElement = document.getElementById('time');
    
            const timer = setInterval(function() {
                if (timeLeft <= 0) {
                    clearInterval(timer);
                    alert("Time's up!");

                    document.querySelector('form').submit();
                }
                timerElement.textContent = timeLeft;
                timeLeft--;
            }, 1000);
        });
    </script>


</x-app-layout>