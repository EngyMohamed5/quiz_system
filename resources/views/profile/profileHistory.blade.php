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
            <!-- Smaller Performance Trends Chart -->
            <div class="mb-4">
                <canvas id="performanceChart" width="300" height="150"></canvas> <!-- Reduced size -->
            </div>

            <!-- Table of Results -->
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

    <!-- Include Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    
    <!-- Script to Render Smaller Performance Trends -->
    <script>
        // Get the results from PHP and format them for the chart
        var quizTitles = @json($userResults->pluck('title'));
        var quizScores = @json($userResults->pluck('score'));

        // Create the performance trend chart
        var ctx = document.getElementById('performanceChart').getContext('2d');
        var performanceChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: quizTitles, // X-axis labels (Quiz Titles)
                datasets: [{
                    label: 'Quiz Scores',
                    data: quizScores, // Y-axis data (Scores)
                    borderColor: 'rgba(75, 192, 192, 1)',
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    borderWidth: 2, // Thinner line
                    pointBackgroundColor: 'rgba(54, 162, 235, 1)', // Custom point colors
                    pointRadius: 3 // Smaller points
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false, // To allow for custom sizing
                scales: {
                    y: {
                        beginAtZero: true,
                        max: 100 // Assuming max score is 100%
                    }
                },
                plugins: {
                    legend: {
                        display: false // Hide the legend for a cleaner look
                    }
                },
                elements: {
                    line: {
                        tension: 0.4 // Make the line smoother (curve)
                    }
                }
            }
        });

        // Function to filter the table based on attempt type
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
