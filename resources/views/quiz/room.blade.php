<x-user-layout>
    <div class="min-h-screen relative sm:flex sm:justify-center sm:items-center">
    <form action="" method="post" class="block max-w-md p-6 bg-white border border-gray-200 rounded-lg shadow" style="min-width: 640px">
        @csrf
{{--
        <div class="flex justify-center mb-3">
            <img src="{{asset('images/logo.png')}}" alt="" style="max-width: 350px">
        </div>
--}}
{{--        <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white text-center">Information Protection Department</h5>--}}
{{--        <h3 class="mb-3 font-bold text-gray-700 dark:text-gray-400 text-center" style="font-size: 22pt">Welcome to the Cyber Maze Challenge</h3>--}}
        <p class="mb-3 text-center font-bold">{{$room_title ?? ''}}</p>
{{--        <p class="text-center font-bold">Don’t forget to be fast!</p>--}}
        <hr class="w-48 h-1 mx-auto my-5 bg-gray-100 border-0 rounded dark:bg-gray-700">

        <div>
            <x-input-label for="secret_code" :value="$title ?? 'NULL'" />
            <x-text-input id="secret_code" class="block mt-1 w-full" type="text" name="secret_code" :value="old('secret_code')" required autofocus />
{{--            <p id="helper-text-explanation" class="mt-2 text-sm text-blue-700 dark:text-gray-400">Your first letter of your secret code is “F”</p>--}}
            <x-input-error :messages="$errors->get('secret_code')" class="mt-2" />
        </div>

        <br>
        <hr />


        <div class="flex items-center justify-center mt-4">
{{--
            <a class="text-left underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('player.register') }}">
                {{ __('Don\'t have Code ?') }}
            </a>
            --}}
            <x-primary-button class="ml-4">
                {{ __('Unlock') }}
            </x-primary-button>
        </div>

    </form>
    </div>
    @if (session()->has('success'))
    <script type="module">
        window.jQuery(function () {
            window.Swal.fire({
                title: "Good job!",
                text: "You Unlocked the Door",
                icon: "success"
            });
        });
    </script>
    @endif

    @if (session()->has('error_code'))
        <script type="module">
            window.jQuery(function () {
                window.Swal.fire({
                    title: "Oops...",
                    text: "Invalid Value",
                    icon: "error"
                });
            });
        </script>
    @endif
</x-user-layout>
