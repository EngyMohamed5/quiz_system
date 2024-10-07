<x-dashboard>
    @section('page_title', 'Quiz Results')

    <body>

        <div class="container mt-5">
           

            <!-- Performance Summary -->
            <div class="mb-4 text-center">
                <h3>Performance Summary</h3>
                <p><strong>Pass Percentage for all users:</strong> {{ $passPercentage }}%</p>
            </div>

            <!-- Search Bar -->
            <div class="mb-3">
                <input type="text" id="search" class="form-control" placeholder="Search by Username or User ID" onkeyup="filterResults()">
            </div>

            <!-- Results Table -->
            <div class="table-responsive">
                <table class="table table-bordered table-striped table-hover">
                    <thead class="table-blue">
                        <tr>
                            <th onclick="sortTable(0)">User ID &#x25B2;&#x25BC;</th>
                            <th onclick="sortTable(0)">quizTitle &#x25B2;&#x25BC;</th>
                            <th onclick="sortTable(1)">Username &#x25B2;&#x25BC;</th>
                            <th onclick="sortTable(2)">Score &#x25B2;&#x25BC;</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($results as $result)
                            <tr>
                                <td>{{ $result->user_id }}</td>
                                <td>{{ $result->quizTitle }}</td> <!-- Now this works! -->
                                <td>{{ $result->name }}</td>
                                <td style="background-color: 
                                    @if ($result->score >= 80) lightgreen 
                                    @elseif ($result->score >= 50) lightyellow 
                                    @else lightcoral @endif;">
                                    {{ $result->score }}%
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                    
                </table>
            </div>

            <!-- Canvas for Chart -->
            <h2 class="mt-5">Users Quiz Attempts</h2>
            <canvas id="quizChart" width="400" height="200"></canvas>

            <!-- Chart.js Script -->
            <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
            <script>
                var quizLabels = @json($quizTitles);
                var userCounts = @json($userCounts);

                var ctx = document.getElementById('quizChart').getContext('2d');
                var quizChart = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: quizLabels,
                        datasets: [{
                            label: 'Number of Users Attempting this Quiz',
                            data: userCounts,
                            backgroundColor: [
                                'rgba(255, 99, 132, 0.2)',
                                'rgba(54, 162, 235, 0.2)',
                                'rgba(255, 206, 86, 0.2)',
                                'rgba(75, 192, 192, 0.2)',
                                'rgba(153, 102, 255, 0.2)',
                                'rgba(255, 159, 64, 0.2)'
                            ],
                            borderColor: [
                                'rgba(255, 99, 132, 1)',
                                'rgba(54, 162, 235, 1)',
                                'rgba(255, 206, 86, 1)',
                                'rgba(75, 192, 192, 1)',
                                'rgba(153, 102, 255, 1)',
                                'rgba(255, 159, 64, 1)'
                            ],
                            borderWidth: 1
                        }]
                    },
                    options: {
                        scales: {
                            y: {
                                beginAtZero: true
                            }
                        }
                    }
                });

                // Search Function
                function filterResults() {
                    var input, filter, table, tr, td, i, txtValue;
                    input = document.getElementById("search");
                    filter = input.value.toUpperCase();
                    table = document.querySelector("table");
                    tr = table.getElementsByTagName("tr");

                    for (i = 1; i < tr.length; i++) {
                        tr[i].style.display = "none";
                        td = tr[i].getElementsByTagName("td");
                        for (var j = 0; j < td.length; j++) {
                            if (td[j]) {
                                txtValue = td[j].textContent || td[j].innerText;
                                if (txtValue.toUpperCase().indexOf(filter) > -1) {
                                    tr[i].style.display = "";
                                    break;
                                }
                            }
                        }
                    }
                }

                // Sort Function
                function sortTable(n) {
                    var table, rows, switching, i, x, y, shouldSwitch, dir, switchcount = 0;
                    table = document.querySelector("table");
                    switching = true;
                    dir = "asc"; // Set the sorting direction to ascending initially

                    while (switching) {
                        switching = false;
                        rows = table.rows;

                        for (i = 1; i < (rows.length - 1); i++) {
                            shouldSwitch = false;
                            x = rows[i].getElementsByTagName("TD")[n];
                            y = rows[i + 1].getElementsByTagName("TD")[n];

                            // Parse the scores as integers for comparison
                            let xValue = n === 2 ? parseInt(x.innerHTML) : x.innerHTML; // Change for score column
                            let yValue = n === 2 ? parseInt(y.innerHTML) : y.innerHTML; // Change for score column

                            if (dir == "asc") {
                                if (xValue > yValue) {
                                    shouldSwitch = true;
                                    break;
                                }
                            } else if (dir == "desc") {
                                if (xValue < yValue) {
                                    shouldSwitch = true;
                                    break;
                                }
                            }
                        }

                        if (shouldSwitch) {
                            rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
                            switching = true;
                            switchcount++;
                        } else {
                            if (switchcount == 0 && dir == "asc") {
                                dir = "desc";
                                switching = true;
                            }
                        }
                    }
                }
            </script>
        </div>
    </body>
</x-dashboard>
