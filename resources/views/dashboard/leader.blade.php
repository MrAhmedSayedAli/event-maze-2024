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
            {{ __('Leader Board') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">


                    <div class="relative overflow-x-auto">
                        <table class="w-full text-lg text-center ajax-table">
                            <thead class="text-xs uppercase bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-3">
                                    <button class="hide">#</button>
                                </th>
                                <th scope="col" class="px-6 py-3">Players Names</th>
{{--                                <th scope="col" class="px-6 py-3">Phone</th>--}}
                                <th scope="col" class="px-6 py-3">code</th>
{{--                                <th scope="col" class="px-6 py-3">Score</th>--}}
                                <th scope="col" class="px-6 py-3">Duration</th>
{{--                                <th scope="col" class="px-6 py-3">test</th>--}}
                            </tr>

                            </thead>
                            <tbody>
                            </tbody>
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
                    url:'{{ route('dashboard.leader_ajax') }}',
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
                    // {className:'px-6 py-4 text-gray-500 dark:text-gray-400',data: 'phone', name: 'phone', orderable: false, searchable: false},
                    {className:'px-6 py-4 text-gray-500 dark:text-gray-400',data: 'code', name: 'code', orderable: false, searchable: false},
                    // {className:'px-6 py-4 text-gray-500 dark:text-gray-400',data: 'score', name: 'score', orderable: false, searchable: false},
                    {className:'px-6 py-4 text-gray-500 dark:text-gray-400',data: 'duration', name: 'duration', orderable: false, searchable: false}

                ]
            });



            setInterval(function () {
                table.ajax.reload();
            }, 1000*5);

            window.jQuery('.hide').on('click', function(e) {
                e.preventDefault();
                window.jQuery('nav').toggle();
                window.jQuery('header').toggle();
            });

        });
    </script>

</x-app-layout>
