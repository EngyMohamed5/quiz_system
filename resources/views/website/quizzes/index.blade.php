<x-app-layout>

    {{-- <style>
        
        .imgcontainer::before {
            content: "";
            position: absolute;
            left: 0;
            top: 0;
            width: 0;
            height:12em;
            background-color: #ededed2e;
            
            transition: 0.3s;
        }
        .card:hover .imgcontainer::before {
            width: 100%;
            
        }  
        
    </style> --}}
    
    <div class="container my-5">
        <h1 class="text-center mb-4">Quizzes on {{ $topic->name }}</h1>

        <div class="row">
            @forelse($quizzes as $quiz)
            <div class="col-md-6 col-lg-4 mb-4" >
                <div class="quiz-card card shadow-sm m-2 {{ $quiz->quiz_type }}" style="height:20em;overflow:hidden">
                    
                    <div class="imgquiz">
                        @if($quiz->image)
                        <img src="{{ asset('upload_images/' . $quiz->image) }}" class="card-img-top" alt="{{ $quiz->title }}">
                        @else
                        <img src="https://images.pexels.com/photos/207756/pexels-photo-207756.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1" class="card-img-top" alt="{{ $quiz->title }}">
                        @endif
                    </div>
                    
                    <div class="card-body">
                        <h5 class="card-title">
                            <a href="{{ route('quiz.show', $quiz->id) }}" class="text-dark text-decoration-none">{{ $quiz->title }}</a>
                        </h5>
                        <p class="card-text">{{ $quiz->description }}</p>

                        <div class="d-flex justify-content-between align-items-center">
                            <a href="{{ route('quiz.show', $quiz->id) }}" class="btn btn-primary">Start Quiz</a>
                            @if ($quiz->time_limit)
                            <div class="btn btn-warning text-dark" title="with time limit">
                                <i class="fa-solid fa-stopwatch"></i>
                            </div>
                            @endif
                           
                        </div>
                        
                    </div>
                </div>
            </div>

            @empty
                <div class="d-flex justify-content-center align-items-center p-4 " style="background-color:rgba(255, 255, 212, 0.389)">
                    No {{ $topic->name }} quizzes 
                </div>
            
            @endforelse
        </div>
    </div>

</x-app-layout>
