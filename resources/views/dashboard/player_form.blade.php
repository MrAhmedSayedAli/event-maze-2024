<x-app-layout>


    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Add Player') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 content-center">


                    <form action="" method="post" class="block p-6 bg-white border border-gray-200 rounded-lg shadow">
                        @csrf

                        <div>
                            <x-input-label for="name" :value="__('Name')" />
                            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
                            <x-input-error :messages="$errors->get('name')" class="mt-2" />
                        </div>
                        <hr />
                        <br>
                        <div>
                            <x-input-label for="phone" :value="__('Phone')" />
                            <x-text-input id="phone" class="block mt-1 w-full" type="text" name="phone" :value="old('phone')" required autofocus autocomplete="phone" />
                            <x-input-error :messages="$errors->get('phone')" class="mt-2" />
                        </div>
                        <br>
                        <div>
                            <x-input-label for="email" :value="__('Email Address')" />
                            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="email" />
                            <x-input-error :messages="$errors->get('email')" class="mt-2" />
                        </div>
                        <hr class="w-48 h-1 mx-auto my-5 bg-gray-100 border-0 rounded dark:bg-gray-700">
                        <div>
                            <x-input-label for="group_code" :value="__('Join group code')" />
                            <x-text-input id="group_code" class="block mt-1 w-full" type="text" name="group_code" :value="old('group_code')" placeholder="XXXX"/>
                            {{--            <p id="helper-text-explanation" class="mt-2 text-sm text-orange-600 dark:text-gray-400">Enter Code To Join To Group Or Leave Blank For Single Or To Make One</p>--}}
                            <x-input-error :messages="$errors->get('group_code')" class="mt-2" />
                        </div>

                        <hr />
                        <br>

                        <div class="flex items-center justify-center mt-4">
                            <x-primary-button class="ml-4">
                                {{ __('Add') }}
                            </x-primary-button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
