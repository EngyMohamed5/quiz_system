<x-dashboard>
    @section('page_title','Add Admin')
    <body>

        <h1>Quiz Results</h1>
    
        <table>
            <thead>
                <tr>
                    <th>User ID</th>
                    <th>Username</th>
                    <th>Score</th>
                    
                </tr>
            </thead>
            <tbody>
                @foreach ($results as $result)
                    <tr>
                        <td>{{ $result->user_id }}</td>
                        <td>{{ $result->name }}</td>
                        <td>{{ $result->score }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    
    </body>

</x-dashboard>
