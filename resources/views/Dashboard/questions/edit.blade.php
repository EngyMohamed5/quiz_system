<x-dashboard>
    @section('page_title', 'Edit Question')

    <div class="container mt-5">

        <form action="{{ route('questions.update', [$quiz->id, $question->id]) }}" method="POST" enctype="multipart/form-data" class="container-fluid d-flex flex-wrap  justify-content-between mt-5 bg-white p-5 rounded-2">
            @csrf
            @method('PUT')

            <div class="mb-3 col-md-12">
                <label for="question_text" class="form-label fw-bold">Question Text</label>
                <input type="text" name="question_text" class="form-control" value="{{ old('question_text', $question->question_text) }}">
            </div>

            <div class="mb-3 col-md-12">
                <label for="question_type" class="form-label fw-bold">Question Type</label>
                <select name="question_type" class="form-control" disabled>
                    <option value="true_false" {{ old('question_type', $question->question_type) === 'true_false' ? 'selected' : '' }}>True/False</option>
                    <option value="multiple_choice" {{ old('question_type', $question->question_type) === 'multiple_choice' ? 'selected' : '' }}>Multiple Choice</option>
                </select>
            </div>

            <div class="mb-3 col-md-12">
                <div class="mb-3 col-md-7">
                    <label class="form-label fw-bold">Question Picture (optional)</label>
                    <input type="file" class="form-control" name="image">
                </div>
                <div class="col-md-7 mb-3">
                    @if(isset($question->image))
                        <img src="{{ asset('upload_images/' . $question->image) }}" style="max-width: 100px;">
                    @else
                        <p class="text-secondary">No Image Is Set For This Question</p>
                    @endif
                </div>
            </div>

            <!-- Options -->
    <div class="mb-3 col-md-12">
        <label for="options" class="form-label fw-bold">Question Options</label>
        <table class="col-md-12 mx-1">
            <tr>
                <th>Options</th>
                <th class="px-4">Correct</th>
            </tr>
            @foreach($question->options as $key => $option)
             <tr>
                    <td class="col-md-6">
                 <div class="form-group my-2 col-md-11 mx-2">
                        <input type="text" name="options[{{$key}}][option_text]" class="form-control" value="{{$option["option_text"]}}" {{$question->question_type==="true_false"?"readonly":""}}>
                        <input type="hidden" name="options[{{$key}}][id]" class="form-control" value="{{$option["id"]}}">
                 </div>
                    </td>
                 <td class="px-4 py-2 col-md-1">
                     <input type="radio" name="is_correct_number" value="{{$key+1}}" {{ $option['is_correct'] ? 'checked' : '' }}>
                 </td>

             </tr>
            @endforeach
        </table>

    </div>
            <button type="submit" class="btn btn-primary  mt-3 form-control">Update Question</button>
        </form>
    </div>
</x-dashboard>
