<x-app-layout>
    <div class="container mt-5">
        <h1 class="text-center">Quiz Results</h1>
        <p class="text-center">You answered {{ $score }} out of {{ $total }} questions correctly.</p>
        <p class="text-center">Your score: {{ $percentage }}%</p>
    </div>
        
    <div class="container">
        <h1>Your Performance</h1>
        <p>Congratulations! Here are your results:</p>

        @if($userResults->isEmpty())
            <p>No results found for your quizzes.</p>
        @else
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>User ID</th>
                        <th>Name</th>
                        <th>Quiz Title </th>
                        <th>Score</th>
                        <th>Attempt Number</th>
                    </tr>
                </thead>
                <tbody>
                    {{-- @php $counter = 1; @endphp --}}
                    @foreach($userResults as $result)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $result->user_id }}</td>
                            <td>{{ $result->name }}</td>
                            <td>{{ $result->title }}</td>
                            <td>{{ $result->score }}%</td>
                            <td>{{ $result->attempt_number }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>
</x-app-layout>
