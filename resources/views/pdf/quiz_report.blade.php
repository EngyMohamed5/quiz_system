<!DOCTYPE html>
<html>
<head>
    <title>Quiz Report</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        .title {
            text-align: center;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <h1 class="title">Quiz Report</h1>
    <h2>Quiz Title: {{ $quizTitle }}</h2> <!-- Display the quiz title -->

    <h3>Results:Table</h3>
    <table>
        <thead>
            <tr>
                <th>User ID</th>
                <th>User Name</th>
                <th>Score</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($results as $result)
                <tr>
                    <td>{{ $result->user_id }}</td>
                    <td>{{ $result->name }}</td>
                    <td>{{ $result->score }}%</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
