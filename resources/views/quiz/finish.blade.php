<x-quiz-layout>

    <div class="max-w-sm bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700"
         style="max-width: 75rem !important;">
        <div class="p-5">


            <p class="text-left font-medium text-2xl lg:text-3xl leading-loose">Information Protection Department</p>
            <hr style="margin: 15px 0 15px 0;"/>
            <p class="text-left font-medium ">Congratulations on completing the challenge<br />Please proceed to the exit.</p>
            <br />

            <p class="font-medium text-center">Hope we see you again </p>
            <br />
            <h3 class="text-2xl font-medium leading-loose text-center">SCORE : {{$quiz->score}} </h3>
            <div class="flex justify-start pt-4">
                <ul>
                    @foreach($quiz->QuizAnswer as $ans)
                        <li>
{{--                            Question {{ $loop->iteration}}  {{$ans->is_correct ? 'Is Correct Answer Duration ( '. $ans->end_datetime->diff($ans->start_datetime)->format('%H:%I:%S') .' )' : 'Not Correct'}}</li>--}}
                            Question {{ $loop->iteration}}  {{$ans->is_correct ? 'Is Correct Answer' : 'Not Correct'}}</li>
                    @endforeach
                </ul>

                <hr/>


            </div>

            <div class="flex justify-center pt-4">
                <a class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150"
                   href="{{ route('player.login') }}">
                    {{ __('Back To Home') }}
                </a>
            </div>
        </div>
    </div>

</x-quiz-layout>
