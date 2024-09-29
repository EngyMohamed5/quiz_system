<x-dashboard>
    @section('page_title', 'Manage Quizzes')

    <div class="container mt-5">
        <h2>Quiz List</h2>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Description</th>
                    <th>Time Limit</th>
                    <th>Topic</th>
                    <th>Created By</th>
                    <th>Quiz Type</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($quizzes as $quiz)
                <tr>
                    <td>{{ $quiz->title }}</td>
                    <td>{{ $quiz->description }}</td>
                    <td>{{ $quiz->time_limit }} minutes</td>
                    <td>{{ $quiz->topic->name }}</td>
                    <td>{{ $quiz->created_by }}</td>
                    <td>{{ $quiz->quiz_type }}</td>
                    <td>
                        <a href="{{ route('questions.index', $quiz->id) }}" class="btn btn-primary">View Questions</a>
                        <form action="{{ route('quiz.delete', $quiz->id) }}" method="POST" style="display:inline-block;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Delete</button>
                        </form>
                    </td>

                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</x-dashboard>
