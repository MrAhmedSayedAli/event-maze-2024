<x-user-layout>
    <div class="min-h-screen relative sm:flex sm:justify-center sm:items-center  ">
        <div class="max-w-lg p-6 bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700 text-center" style="min-width: 750px">

            <h5 class="mb-2 text-lg font-bold tracking-tight text-gray-900 dark:text-white text-center" style="font-size: 180pt;    margin-bottom: 111px;    padding-top: 90px;"><div id="timer">10:00</div></h5>

            <p style="padding-bottom: 15px;" class="text-center">
                @php
                    $names = '';
                    foreach ($maze->Group->Player ?? [] as $player) {
                        $names = $names . Str::words($player->name, 2,'') . ', ';
                    }
                 @endphp
                {{$names}}
            </p>
{{--
            <a href="{{route('maze.countdown')}}" class="inline-flex items-center px-3 py-2 text-md font-medium text-center text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                Restart
                <svg class="w-3.5 h-3.5 ml-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 10">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 5h12m0 0L9 1m4 4L9 9"/>
                </svg>
            </a>
--}}
        </div>
    </div>
    <script type="module">
        window.jQuery(function () {

            setInterval(function() {
                $.ajax({
                    url: '{{ route('maze.session') }}',
                    type: 'GET',
                    dataType: 'json',

                    success: function(response) {
                        if (response.success) {
                            const players = response.data.players;
                            const datetime = response.data.timer;

                            $('#players').text(players);
                            $('#timer').text(datetime);

                        } else {
                            console.log('No data available or an error occurred.');
                        }
                    },
                    error: function(xhr, status, error) {
                        console.log('AJAX request failed:', error);
                    }
                });
            }, 1000);

            {{--
            const duration = 10 * 60;
            let timer = duration, minutes, seconds;
            const countdownInterval = setInterval(function() {
                minutes = Math.floor(timer / 60);
                seconds = timer % 60;
                minutes = minutes.toString().padStart(2, '0');
                seconds = seconds.toString().padStart(2, '0');

                $('#timer').text(`${minutes}:${seconds}`);
                timer--;

                if (timer < 0) {
                    clearInterval(countdownInterval);
                    $('#timer').text("Time's up!");
                }
            }, 1000);
            --}}
        });
    </script>
</x-user-layout>
