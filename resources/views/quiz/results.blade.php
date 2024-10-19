<x-app-layout>
    <div class="container mt-5">
        <h1 class="text-center">Quiz Results</h1>
        <p class="text-center">You answered {{ $score }} out of {{ $total }} questions correctly.</p>
        <p class="text-center">Your score: {{ number_format($percentage, 2)}}%</p>
    </div>


</x-app-layout>
