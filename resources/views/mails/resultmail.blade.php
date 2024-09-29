<!DOCTYPE html>
<html>

<head>
    <title>Your Quiz Results</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
        }

        .table th,
        .table td {
            border: 1px solid #ddd;
            padding: 8px;
        }

        .bg-success {
            background-color: #28a745 !important;
            color: white;
        }

        .bg-danger {
            background-color: #dc3545 !important;
            color: white;
        }

        .text-muted {
            color: #6c757d !important;
        }

        p,
        h4 {
            text-align: center;
            padding: 0.5em;
            margin: 0;
            width: 100%;
        }

        h1 {
            text-align: center;
        }
    </style>
</head>

<body>
    <h1>Your Result in {{$quizname}} quiz</h1>

    <p>Hello Mr. {{ auth()->user()->name }}, your answers and the correct answers:</p>

    <table class="table">
        <thead>
            <tr>
                <th>Question</th>
                <th>Options</th>
            </tr>
        </thead>
        <tbody>
            @foreach($questions as $question)
            <tr>
                <td>{{ $question->question_text }}</td>
                <td>
                    @php
                    $selectedAnswer = $useranswer->where('question_id', $question->id)->first();
                    @endphp
                    @foreach($question->options as $option)
                    <p class="
                        @if($option->is_correct)
                            bg-success
                        @elseif($selectedAnswer && $selectedAnswer->option_id == $option->id)
                            bg-danger
                        @else
                            text-muted
                        @endif
                    ">
                        {{ $option->option_text }}
                    </p>
                    @endforeach
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <p>Thank you for taking the quiz!</p>
    <p>Regards,</p>
    <h4>{{ config('app.name') }}</h4>
</body>

</html>