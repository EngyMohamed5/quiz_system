<div id="poll-container" wire:poll.1000ms="tick" class=" sticky-top">
    <div class="alert alert-info text-center">
        Time Left: {{ floor($remainingTime / 60) }}:{{ str_pad($remainingTime % 60, 2, '0', STR_PAD_LEFT) }}
    </div>
</div>

<script>
    document.addEventListener('livewire:load', function () {

  
        Livewire.on('quizTimeEnded', function () {
            document.getElementById('poll-container').removeAttribute('wire:poll.1000ms');
            Swal.fire({
                icon: 'inTime is up!',
                text: 'Time is Up!',
                title: ' quiz has ended.',
                confirmButtonText: 'OK',
                allowOutsideClick: false, 
                allowEscapeKey: false,    
                allowEnterKey: false
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('quizForm').submit();
                }
            });
        });
    });
</script>
