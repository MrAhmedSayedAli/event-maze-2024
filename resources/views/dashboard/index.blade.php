<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    <div class="items-center justify-center space-y-4 sm:flex sm:space-y-0 sm:space-x-4">

                        <div class="m-2 block max-w-sm p-6 bg-white border border-gray-200 rounded-lg shadow hover:bg-gray-100 dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-700" style="margin: 15px;">
                            <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">Mazes</h5>
                            <p class="font-normal text-gray-700 dark:text-gray-400 text-center text-xl">{{\App\Models\Maze::count()}}</p>
                        </div>

                        <div class="m-2 block max-w-sm p-6 bg-white border border-gray-200 rounded-lg shadow hover:bg-gray-100 dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-700" style="margin: 15px;">
                            <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">Finished Mazes</h5>
                            <p class="font-normal text-gray-700 dark:text-gray-400 text-center text-xl">{{\App\Models\Maze::where('status',true)->count()}}</p>
                        </div>

                        <div class="m-2 block max-w-sm p-6 bg-white border border-gray-200 rounded-lg shadow hover:bg-gray-100 dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-700" style="margin: 15px;">
                            <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">Players</h5>
                            <p class="font-normal text-gray-700 dark:text-gray-400 text-center text-xl">{{\App\Models\Player::count()}}</p>
                        </div>

                        <div class="m-2 block max-w-sm p-6 bg-white border border-gray-200 rounded-lg shadow hover:bg-gray-100 dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-700" style="margin: 15px;">
                            <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">Groups</h5>
                            <p class="font-normal text-gray-700 dark:text-gray-400 text-center text-xl">{{\App\Models\Group::count()}}</p>
                        </div>





                </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
