<x-app-layout>

    <style>
        .pagination {
            display: flex;
            margin-top: 10px;
        }
        .paginate_button{
            padding: 0 10px 0 10px;
        }

    </style>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Players List') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">

                    <div class="relative overflow-x-auto">

                        <div class="flex items-center justify-between pb-4 bg-white dark:bg-gray-900">

    <div>
        <a href="{{route('dashboard.player.register')}}" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">
            Add New Player
        </a>

        <a href="{{route('dashboard.players.export')}}" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">
            Export
        </a>

        <a href="javascript:void(0)" data-id="x" data-url="{{route('dashboard.administrator.delete_all')}}" class="del-all text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 dark:bg-red-600 dark:hover:bg-red-700 focus:outline-none dark:focus:ring-red-800">
            Delete Data
        </a>

    </div>

                            <div class="pb-5 bg-white dark:bg-gray-900" style="padding-bottom: 30px">
                                <label for="table-search" class="sr-only">Search</label>
                                <div class="relative mt-1">
                                    <input type="text" id="table-search" class="block p-2 pl-10 text-sm text-gray-900 border border-gray-300 rounded-lg w-80 bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 w-6/12" placeholder="Search for items">
                                </div>
                            </div>
                        </div>


                        <table class="w-full text-lg text-center ajax-table">
                            <thead class="text-xs uppercase bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-3">
                                    <button class="hide">#</button>
                                </th>
                                <th scope="col" class="px-6 py-3">Player Name</th>
                                <th scope="col" class="px-6 py-3">Phone</th>
                                <th scope="col" class="px-6 py-3">Email</th>
                                <th scope="col" class="px-6 py-3">Mazes Count</th>
                                <th scope="col" class="px-6 py-3">Duration</th>
                                <th scope="col" class="px-6 py-3">Group Code</th>
{{--                                <th scope="col" class="px-6 py-3">Rating</th>--}}
                            </tr>

                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>


                </div>
            </div>
        </div>
    </div>


    <script type="module">
        window.jQuery(function () {

            var table = window.jQuery('.ajax-table').DataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                autoWidth: false,
                ajax:{
                    url:'{{ route('dashboard.players_ajax') }}',
                    type: 'POST',
                    headers: {
                        'X-CSRF-TOKEN' : '{{ csrf_token() }}'
                    }
                },
                dom: 'lrt<"flex items-center justify-center"p>',
                "createdRow": function( row, data, dataIndex ) {
                    $(row).addClass( 'bg-white border-b dark:bg-gray-800 dark:border-gray-700' );
                },
                columns: [
                    {className:'px-6 py-4 text-gray-500 dark:text-gray-400',data: 'DT_RowIndex' , name: 'DT_RowIndex', orderable: false, searchable: false},
                    {className:'px-6 py-4 text-gray-500 dark:text-gray-400',data: 'name', name: 'name', orderable: false, searchable: false},
                    {className:'px-6 py-4 text-gray-500 dark:text-gray-400',data: 'phone', name: 'phone', orderable: false, searchable: false},
                    {className:'px-6 py-4 text-gray-500 dark:text-gray-400',data: 'email', name: 'email', orderable: false, searchable: false},
                    {className:'px-6 py-4 text-gray-500 dark:text-gray-400',data: 'quiz_count', name: 'quiz_count', orderable: false, searchable: false},
                    {className:'px-6 py-4 text-gray-500 dark:text-gray-400',data: 'max_score', name: 'max_score', orderable: false, searchable: false},
                    {className:'px-6 py-4 text-gray-500 dark:text-gray-400',data: 'action', name: 'action', orderable: false, searchable: false}
                ]
            });



            function delay(callback, ms) {
                var timer = 0;
                return function () {
                    var context = this,
                        args = arguments;
                    clearTimeout(timer);
                    timer = setTimeout(function () {
                        callback.apply(context, args);
                    }, ms || 0);
                };
            }

            $('#table-search').on('keyup', delay(function () {
                table.search(this.value).draw();
            }, 500));

            // setInterval(function () {
            //     table.ajax.reload();
            // }, 1000*5);
            //
            window.jQuery(document).on('click','.show-code', function(e) {
                e.preventDefault();
                alert(window.jQuery(this).data('code'));
            });

        });
    </script>

</x-app-layout>
