<x-quiz-layout>

    <iframe class="w-full min-h-screen" src="{{route('template.id',[$answer->Question->id])}}"></iframe>
    <div class="fixed bottom-0 left-0 z-50 w-full h-16 bg-white border-t border-gray-200 dark:bg-gray-700 dark:border-gray-600 " style="background: rgb(9,159,198);background: linear-gradient(90deg, rgba(9,159,198,1) 0%, rgba(150,84,237,1) 100%);">

        <div class="grid h-full w-full grid-cols-4 mx-auto font-medium">



            <div class="inline-flex flex-col items-center justify-center px-5 dark:hover:bg-gray-800 group  mt-1" style="margin-bottom: 10px">
                <div class="min-w-full flex content-center justify-center items-center" style="font-size: 18pt;">
                    <img style="max-width: 50px" src="{{asset('images/logo.png')}}">
                   <p class="ml-3 text-white"> Cybersecurity challenge</p>

                </div>
            </div>

            <div class="inline-flex flex-col items-center justify-center px-5  dark:hover:bg-gray-800 group  mt-4">
                <p class="text-right pb-2 text-white" style="font-size: 18pt;">Question: <span>{{$answer->inc}} / 5</span></p>
            </div>
            <div class="inline-flex flex-col items-center justify-center px-5  dark:hover:bg-gray-800 group">
                <div id="timer" class="inline-flex flex-col items-center justify-center px-5 rounded-l-full mt-3 font-bold group text-white" style="font-size: 18pt;"></div>
            </div>


            <div class="inline-flex flex-col items-center justify-center px-5  dark:hover:bg-gray-800 group  mt-2">
                <button style="font-size: 18pt;background-color: #deba0d;" data-modal-target="defaultModal" data-modal-toggle="defaultModal" class="block text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800" type="button">
                    Answer
                </button>


                <div id="defaultModal" tabindex="-1" aria-hidden="true" class="fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">

                    <div class="relative max-h-full max-w-7xl ">
                        <!-- Modal content -->
                        <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                            <form action="" method="post">
                                @csrf
                                <div class="flex items-start justify-between p-4 border-b rounded-t dark:border-gray-600">
                                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white">What is the observation ?
                                        {{--{{$answer->Question->question}}--}}
                                    </h3>
                                    <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ml-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="defaultModal">
                                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                                        </svg>
                                        <span class="sr-only">Close</span>
                                    </button>
                                </div>
                                <!-- Modal body -->
                                <div class="p-6 space-y-6">

                                    {{--
                                                                            <p class="text-left font-medium text-lg leading-loose">{{$answer->Question->title}}</p>
                                                                            <hr class="w-48 h-1 mx-auto my-4 bg-gray-100 border-0 rounded md:my-10 dark:bg-gray-700"/>
                                    --}}
                                    <div class="grid grid-cols-1 my-5 space-y-2 place-content-center">


                                        @foreach([1,2,3,4] as $row)

                                            <div
                                                class="flex items-center border border-gray-200 rounded dark:border-gray-700 mb-3 p-1 pl-3">
                                                <input id="radio-{{$row}}" type="radio" value="{{$row}}" name="answer"
                                                       class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                                <label for="radio-{{$row}}"
                                                       class="w-full py-4 ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">{{$answer->Question->{'answer_' . $row} }}</label>
                                            </div>

                                        @endforeach


                                    </div>


                                    <div class="flex justify-center pt-4">
                                        @if($answer->inc > 0 && $answer->inc < 5)
                                            <button type="submit"
                                                    class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">
                                                Submit Answer
                                            </button>
                                        @else
                                            <button type="submit"
                                                    class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">
                                                Finish
                                            </button>
                                        @endif

                                    </div>



                                </div>
                            </form>
                        </div>
                    </div>
                </div>



            </div>
        </div>
    </div>


    <script type="text/javascript">

        T = {} ;
        T.timerDiv = document.getElementById('timer');



        function displayTimer() {

            var hours='00', minutes='00',
                miliseconds=0, seconds='00',
                time = '',
                timeNow = new Date(new Date().toUTCString().slice(0, -3)).getTime();

            T.difference = timeNow - T.timerStarted;

            // milliseconds
            // if(T.difference > 10) {
            //     miliseconds = Math.floor((T.difference % 1000) / 10);
            //     if(miliseconds < 10) {
            //         miliseconds = '0'+String(miliseconds);
            //     }
            // }

            // seconds
            if(T.difference > 1000) {
                seconds = Math.floor(T.difference / 1000);
                if (seconds > 60) {
                    seconds = seconds % 60;
                }
                if(seconds < 10) {
                    seconds = '0'+String(seconds);
                }
            }

            // minutes
            if(T.difference > 60000) {
                minutes = Math.floor(T.difference/60000);
                if (minutes > 60) {
                    minutes = minutes % 60;
                }
                if(minutes < 10) {
                    minutes = '0'+String(minutes);
                }
            }

            // hours
            if(T.difference > 3600000) {
                hours = Math.floor(T.difference/3600000);
                // if (hours > 24) {
                // 	hours = hours % 24;
                // }
                if(hours < 10) {
                    hours = '0'+String(hours);
                }
            }

            time  =  hours   + ':'
            time += minutes + ':'
            time += seconds
            //time += miliseconds;

            T.timerDiv.innerHTML = time;
        }


        function startTimer() {

            T.timerStarted = new Date('{{$answer->start_datetime->toDateTimeString()}}').getTime();

            if (T.difference > 0) {
                T.timerStarted = T.timerStarted - T.difference
            }

            T.timerInterval = setInterval(function() {
                displayTimer()
            }, 1000);
        }

        //displayTimer();
        startTimer();
    </script>


</x-quiz-layout>
