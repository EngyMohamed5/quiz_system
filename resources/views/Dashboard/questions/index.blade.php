<x-dashboard>
    @section('page_title', 'Questions for Quiz: ' . $quiz->title)

    <form method="POST" enctype="multipart/form-data" action="{{route("quiz.update")}}" class="container-fluid d-flex flex-wrap  justify-content-between mt-5 bg-white p-5 rounded-2">
        @csrf

        <div class="my-3 d-flex flex-column text-center border-bottom pb-2 col-md-12">
            <label class="form-label mx-5">Quiz Type</label>

            <div>
                <div class="form-check form-check-inline my-2">
                    <input class="form-check-input" type="radio" name="quiz_type" id="inlineRadio2" value="once_attempt" {{ $quiz->quiz_type == 'once_attempt' ? 'checked' : '' }}>
                    <label class="form-check-label" for="inlineRadio2">one attempt</label>
                </div>
                <div class="form-check form-check-inline me-5 my-2">
                    <input class="form-check-input" type="radio" name="quiz_type" id="inlineRadio1" value="multiple_attempts" {{ $quiz->quiz_type== 'multiple_attempts' ? 'checked' : '' }}>
                    <label class="form-check-label" for="inlineRadio1">multiple attempts</label>
                </div>
            </div>
        </div>

        <div class="mb-3 col-md-5">
            <label class="form-label">Name</label>
            <input type="text" class="form-control" name="title" placeholder="Enter Quiz Title"
                   value="{{$quiz->title}}" autofocus>
        </div>
        <div class="mb-3 col-md-5">
            <label class="form-label">Quiz Picture</label>
            <input type="file" class="form-control" name="image">
        </div>
        <div class="mb-3 col-md-5">
            <label class="form-label">Topic</label>
            <select type="text" class="form-control" name="topic_id">
                @if(count($topics))
                    @foreach($topics as $topic)
                        <option value="{{$topic["id"]}}" class="topic" {{ $quiz->topic_id == $topic['id'] ? 'selected' : '' }}>{{$topic["name"]}}</option>
                    @endforeach
                @endif

            </select>
        </div>
        <div class="mb-3 col-md-5">
            <label class="form-label">Time Limit</label>
            <input type="number" class="form-control" name="time_limit" min="0" value="{{$quiz->time_limit}}">
        </div>
        <div class="mb-3 col-md-12">
            <label class="form-label">Description</label>
            <textarea name="description" rows="3" placeholder="Enter Quiz Description" class="form-control">{{$quiz->description}}</textarea>
        </div>


        <input type="hidden" value="{{$quiz->id}}" name="id">

        <div class="container border-top" >
            <label class=" fs-3 text-primary mt-3 ">Add Questions</label>

        </div>
        <div id="questions-container" class="col-md-12">

        </div>
        <div class="col-md-12">
            <button type="button" id="add-question-btn" class="btn btn-primary my-1">Add Question</button>

        </div>

        <button type="submit" class="btn btn-primary mt-3 form-control" id="create_quiz">Update</button>
    </form>



    <div class="container mt-5">
        <h2>Questions List</h2>
        <table class="table table-bordered">
            @php
                $NumberOfQuestions=0
            @endphp
            <thead>
                <tr>
                    <th>Question No.</th>
                    <th>Question Text</th>
                    <th>Image</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($quiz->questions as $question)
                    <tr>
                        <td>{{ ++$NumberOfQuestions }}</td>
                        <td>{{ $question->question_text }}</td>
                        <td>
                          @if(isset($question->image))
                                <img src="{{ asset('upload_images/' . $question->image) }}" alt="Question Image" style="max-width: 100px;">
                            @else
                              <p class="m-auto text-secondary">No Image For This Question</p>
                          @endif
                        </td>

{{--                        <!-- Correct Answer -->--}}
{{--                        <td>--}}
{{--                            @foreach($question->options as $option)--}}
{{--                                @if($option->is_correct)--}}
{{--                                    {{ $option->option_text }}--}}
{{--                                @endif--}}
{{--                            @endforeach--}}
{{--                        </td>--}}

{{--                        <!-- Display all options -->--}}
{{--                        <td>--}}
{{--                            <ul>--}}
{{--                                @foreach($question->options as $option)--}}
{{--                                    <li>{{ $option->option_text }}</li>--}}
{{--                                @endforeach--}}
{{--                            </ul>--}}
{{--                        </td>--}}

                        <!-- Actions: Edit/Delete -->
                        <td class="d-flex justify-content-evenly align-items-center">
                            @if(auth()->check() && auth()->user()->role=="super_admin"||auth()->user()->id==$quiz->created_by)

                            <a href="{{ route('questions.edit', [$quiz->id, $question->id]) }}"><i class="fa-regular fa-pen-to-square"></i></a>
                            <form action="{{ route('questions.destroy', [$quiz->id, $question->id]) }}" method="POST" style="display:inline-block;" class="delete-form">
                                @csrf
                                @method('DELETE')
                                <button type="submit"><i class=" fa-regular fa-trash-can  text-danger "></i></button>
                            </form>
                            @else
                                <p class="text-secondary">No Action Can Be Took</p>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@include("layouts.questions")
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
    @section("js_files")
        <script src="{{asset("assets/js/add_questions.js")}}"></script>
    @endsection
</x-dashboard>
