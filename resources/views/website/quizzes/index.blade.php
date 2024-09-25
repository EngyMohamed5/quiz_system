<x-app-layout>

    <div class="container my-5">
        <h1 class="text-center mb-4">Quizzes on {{ $topic->name }}</h1>

        <div class="row">
            @foreach($quizzes as $quiz)
            <div class="col-md-6 col-lg-4 mb-4">
                <div class="card shadow-sm">
                    @if($quiz->image)
                    <img src="{{ $quiz->image }}" class="card-img-top" alt="{{ $quiz->title }}">
                    @else
                    <img src="https://images.pexels.com/photos/207756/pexels-photo-207756.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1" class="card-img-top" alt="{{ $quiz->title }}">
                    @endif
                    <div class="card-body">
                        <h5 class="card-title">
                            <a href="{{ route('quiz.show', $quiz->id) }}" class="text-dark text-decoration-none">{{ $quiz->title }}</a>
                        </h5>
                        <p class="card-text">{{ $quiz->description }}</p>
                        <a href="{{ route('quiz.show', $quiz->id) }}" class="btn btn-primary">Start Quiz</a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>

</x-app-layout>
