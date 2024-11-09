<x-user-layout>
    <div class="min-h-screen relative sm:flex sm:justify-center sm:items-center  ">
        <div class="max-w-lg p-6 bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700 text-center" style="min-width: 350px">

            <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white text-center"><div id="timer">10:00</div></h5>

            <p style="padding-bottom: 15px;" class="text-center">
                @php
                    $names = '';
                    foreach ($maze->Group->Player ?? [] as $player) {
                        $names = $names . Str::words($player->name, 2,'') . ', ';
                    }
                 @endphp
                {{$names}}
            </p>

            <a href="{{route('maze.finish',$maze->hash)}}" class="inline-flex items-center px-3 py-2 text-md font-medium text-center text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                End Session
            </a>
        </div>
    </div>
    <script type="module">
        window.jQuery(function () {
            const duration = 10 * 60;
            let timer = duration, minutes, seconds;
            const countdownInterval = setInterval(function() {
                minutes = Math.floor(timer / 60);
                seconds = timer % 60;
                minutes = minutes.toString().padStart(2, '0');
                seconds = seconds.toString().padStart(2, '0');

                $('#timer').text(`${minutes}:${seconds}`);
                    console.log(timer);
                timer--;

                if (timer < 0) {
                    clearInterval(countdownInterval);
                    window.location.href = "{{route('maze.finish',$maze->hash)}}";
                    {{--window.location.href = "{{route('player.login')}}";--}}
                }
            }, 1000);
        });
    </script>
</x-user-layout>
