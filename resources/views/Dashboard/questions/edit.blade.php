<x-dashboard>
    @section('page_title', 'Edit Question')

    <div class="container mt-5">
        <h2>Edit Question</h2>

        <form action="{{ route('questions.update', [$quiz->id, $question->id]) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <!-- Question Text -->
            <div class="mb-3">
                <label for="question_text" class="form-label">Question Text</label>
                <input type="text" name="question_text" class="form-control" value="{{ old('question_text', $question->question_text) }}">
            </div>

            <!-- Question Type -->
            <div class="mb-3">
                <label for="question_type" class="form-label">Question Type</label>
                <select name="question_type" class="form-control">
                    <option value="true_false" {{ old('question_type', $question->question_type) === 'true_false' ? 'selected' : '' }}>True/False</option>
                    <option value="multiple_choice" {{ old('question_type', $question->question_type) === 'multiple_choice' ? 'selected' : '' }}>Multiple Choice</option>
                </select>
            </div>


            <!-- Image Upload -->
            <div class="mb-3">
                <label for="image" class="form-label">Upload Image (optional)</label>
                <input type="file" name="image" class="form-control">
                @if($question->image)
                    <img src="{{ asset('storage/' . $question->image) }}" alt="Question Image" style="max-width: 100px;">
                @endif
            </div>

            <!-- Options -->
    <div class="mb-3">
        <label for="options" class="form-label">Options</label>

        @foreach($question->options as $key => $option)
    <div class="option-group">
        <input type="hidden" name="options[{{ $key }}][id]" value="{{ $option->id }}"> <!-- Include the option ID -->
        <input type="text" name="options[{{ $key }}][option_text]" class="form-control" value="{{ old('options.' . $key . '.option_text', $option->option_text) }}">
        <label for="is_correct">Is Correct:</label>
        <input type="hidden" name="options[{{ $key }}][is_correct]" value="0"> <!-- Hidden field for unchecked checkbox -->
        <input type="checkbox" name="options[{{ $key }}][is_correct]" value="1" {{ $option->is_correct ? 'checked' : '' }}>
    </div>
@endforeach

    </div>
            <!-- Submit Button -->
            <button type="submit" class="btn btn-primary">Update Question</button>
        </form>

        @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    </div>
</x-dashboard>
