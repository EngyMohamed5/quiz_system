<x-app-layout>
    
    <h1>Quizzes on {{ $topic->name }}</h1>
    

    <ul>
        @foreach($quizzes as $quiz)
            <li>
                <a href="{{ route('quiz.show', $quiz->id) }}">{{ $quiz->title }}</a>
                <p>{{ $quiz->description }}</p>
            </li>
        @endforeach
    </ul>
</x-app-layout>