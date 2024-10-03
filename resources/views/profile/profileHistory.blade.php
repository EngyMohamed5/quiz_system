<x-app-layout>
    <x-slot name="header">
        <div class="d-flex flex-row justify-content-start gap-3">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Profile-History') }}
            </h2>
        </div>
    </x-slot>

    <div class="container" style="padding-top: 30px;">
        <h1>Your Performance</h1>
        <p>Congratulations! Here are your results:</p>
    
        <!-- Dropdown for filtering attempts -->
        <div class="mb-4">
            <select id="attemptFilter" class="form-select" onchange="filterTable()">
                <option value="all">Show All</option>
                <option value="once">Once Attempt</option>
                <option value="multiple">Multiple Attempts</option>
            </select>
        </div>
    
        @if($userResults->isEmpty())
            <p>No results found for your quizzes.</p>
        @else
            <table class="table table-striped" id="resultsTable">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Quiz Title</th>
                        <th>Score</th>
                        <th>Attempt Number</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($userResults->groupBy('quiz_id') as $quizId => $results)
                        @foreach($results as $result)
                        <tr data-attempt-type="{{ $results->count() == 1 ? 'once' : 'multiple' }}" data-attempt-number="{{ $result->attempt_number }}">
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $result->name }}</td>
                            <td>{{ $result->title }}</td>
                            <td>{{ $result->score }}%</td>
                            <td>{{ $result->attempt_number }}</td>
                        </tr>
                        @endforeach
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>
    

    <script>
        function filterTable() {
            var filter = document.getElementById("attemptFilter").value;
            var rows = document.querySelectorAll("#resultsTable tbody tr");

            rows.forEach(function(row) {
                var attemptNumber = parseInt(row.getAttribute('data-attempt-number'), 10);

                if (filter === 'all') {
                    row.style.display = '';
                } else if (filter === 'once' && attemptNumber === 1) {
                    row.style.display = '';
                } else if (filter === 'multiple' && attemptNumber > 1) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        }
    </script>

</x-app-layout>
