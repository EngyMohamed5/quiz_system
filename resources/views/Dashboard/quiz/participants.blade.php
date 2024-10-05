<x-dashboard>
    @section('page_title', 'Participants For : '.$quiz->title)
    <div class="container mt-5">
        <div class="d-flex justify-content-between">
            <h2>Participants List</h2>
            <x-dropdown align="right" width="48">
                <x-slot name="trigger">
                    <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 dark:text-gray-400 bg-white dark:bg-gray-800 hover:text-gray-700 dark:hover:text-gray-300 focus:outline-none transition ease-in-out duration-150">
                        Filter By Month
                    </button>
                </x-slot>
                <x-slot name="content">
                    <x-dropdown-link  href="{{ route('quizzes.participants',$quiz->id) }}">
                        All
                    </x-dropdown-link>
                    @foreach($months as $month =>$key)
                        <x-dropdown-link  href="{{ route('quizzes.participants.month',[$quiz->id, $key]) }}">
                            {{ $month}}
                        </x-dropdown-link>
                    @endforeach
                </x-slot>
            </x-dropdown>
        </div>
       @if(count($participants)!=0)
            <table class="table table-bordered">
                <thead>
                <tr>
                    <th>No.</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Taken At</th>
                </tr>
                </thead>
                <tbody>
                @php
                    $ParticipantsCounter=0;
                @endphp
                @foreach($participants as $participant)
                    <tr>
                        <td>{{++$ParticipantsCounter}}</td>
                        <td>{{$participant->user->name}}</td>
                        <td>{{$participant->user->email}}</td>
                        <td>{{$participant->created_at_edited}}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        @else
        <div class="alert alert-warning mt-5 text-center" role="alert">
            No Previous Participants !
        </div>
        @endif


    </div>
</x-dashboard>
