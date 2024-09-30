<x-dashboard>
    @section('page_title', 'Questions for Quiz: ' . $quiz->title)

    <div class="container mt-5">
        <h2>Questions for Quiz: {{ $quiz->title }}</h2>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Question ID</th>
                    <th>Question</th>
                    <th>Image</th>
                    <th>Correct Answer</th>
                    <th>Options</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($quiz->questions as $question)
                    <tr>
                        <td>{{ $question->id }}</td>
                        <td>{{ $question->question_text }}</td>
                        <td>
                            <img src="{{ asset('upload_images/' . $question->image) }}" alt="Question Image" style="max-width: 100px;">
                        </td>

                        <!-- Correct Answer -->
                        <td>
                            @foreach($question->options as $option)
                                @if($option->is_correct)
                                    {{ $option->option_text }}
                                @endif
                            @endforeach
                        </td>

                        <!-- Display all options -->
                        <td>
                            <ul>
                                @foreach($question->options as $option)
                                    <li>{{ $option->option_text }}</li>
                                @endforeach
                            </ul>
                        </td>

                        <!-- Actions: Edit/Delete -->
                        <td>
                            <a href="{{ route('questions.edit', [$quiz->id, $question->id]) }}" class="btn btn-warning">Edit</a>
                            <form action="{{ route('questions.destroy', [$quiz->id, $question->id]) }}" method="POST" style="display:inline-block;" class="delete-form">
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

    @include('sweetalert::alert')
    @if(session('success'))
        <script>
            Swal.fire({
                title: 'Deleted!',
                text: "{{ session('success') }}",
                icon: 'success',
                confirmButtonText: 'OK'
            });
        </script>
    @endif
</x-dashboard>
