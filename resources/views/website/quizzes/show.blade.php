{{-- <x-app-layout>

    <div class="container mt-5">
        <h1 class="text-center mb-4">{{ $quiz->title }}</h1>
        {{-- <p class="lead text-center">{{ $quiz->description }}</p> --}}

        {{-- @if ($quiz->time_limit) --}}
        {{-- <div class="alert alert-info text-center" id="timer">
            Time left: <span id="time">{{ $quiz->time_limit * 60 }}</span> seconds
        </div>
        @endif --}}
{{-- 
        <livewire:counter-component :quizId="$quiz->id" />
        @endif

       


        <form action="/submit-quiz" method="POST">
            @csrf

            <div class="row">
                @foreach($quiz->questions as $question)
                <div class="col-md-12 mb-4">
                    <div class="card shadow-sm">
                        <div class="card-body">
                                   
                            @if(!empty($question->image))
                            <div class="mb-3" style="height: 20em;">
                                <img src="{{ asset('upload_images/' . $question->image) }}" class="img-fluid mt-3 h-100 " alt="Question Image" >
                            </div>
                            @endif
                            <p class="card-text font-weight-bold">{{ $loop->iteration }}. {{ $question->question_text }}</p>

                            @foreach($question->options as $option)
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="question_{{ $question->id }}" id="option_{{ $option->id }}" value="{{ $option->id }}">
                                <label class="form-check-label" for="option_{{ $option->id }}">
                                    {{ $option->option_text }}
                                </label>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            <div class="text-center pb-4">
                <button type="submit" class="btn btn-primary btn-lg mt-4">Submit Quiz</button>
            </div>
        </form> 
    </div>
    
</x-app-layout> --}} 
<x-app-layout>

    <div class="container mt-5">
        <h1 class="text-center mb-4">{{ $quiz->title }}</h1>
        {{-- <p class="lead text-center">{{ $quiz->description }}</p> --}}

        @if ($quiz->time_limit)
        <livewire:counter-component :quizId="$quiz->id" />
        @endif

        <form action="/submit-quiz" method="POST">
            <input type="hidden" name="quiz_id" value="{{ $quiz->id }}">
            @csrf


            <div class="row">
                @foreach($quiz->questions as $question)
                <div class="col-md-12 mb-4">
                    <div class="card shadow-sm">
                        <div class="card-body">
                                   
                            @if(!empty($question->image))
                            <div class="mb-3" style="height: 20em;">
                                <img src="{{ asset('upload_images/' . $question->image) }}" class="img-fluid mt-3 h-100 " alt="Question Image" >
                            </div>
                            @endif
                            <p class="card-text font-weight-bold">{{ $loop->iteration }}. {{ $question->question_text }}</p>

                            @foreach($question->options as $option)
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="question_{{ $question->id }}" id="option_{{ $option->id }}" value="{{ $option->id }}">
                                <label class="form-check-label" for="option_{{ $option->id }}">
                                    {{ $option->option_text }}
                                </label>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            <div class="text-center pb-4">
                <button type="submit" class="btn btn-primary btn-lg mt-4">Submit Quiz</button>
            </div>
        </form> 
    </div>
    
</x-app-layout>