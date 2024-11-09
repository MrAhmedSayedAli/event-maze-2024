<x-user-layout>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">

                    <div class="flex text-center content-center">
                        <img class="h-auto max-w-full rounded-lg" style="margin: 0 auto;" src="{{asset('images/lead.jpg')}}">
                    </div>
                    <hr class="w-48 h-1 mx-auto my-5 bg-gray-100 border-0 rounded dark:bg-gray-700">
<div class="" style="margin-top: 20px;margin-bottom: 10px">

    <h5 class="w-full text-xl font-bold tracking-tight text-gray-900 dark:text-white text-center" style="font-size: 50px;margin-bottom: 5px"><div id="timer">10:00</div></h5>
    <p id="players" class="w-full  font-bold tracking-tight text-gray-900 dark:text-white text-center " style="font-size: 25px">No Player</p>

</div>
                    <hr class="w-48 h-1 mx-auto my-5 bg-gray-100 border-0 rounded dark:bg-gray-700">

                    <div class="relative overflow-x-auto">
                        <table class="w-full text-lg text-center ajax-table">
                            <thead class="text-xs uppercase bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-3">RANK</th>
                                <th scope="col" class="px-6 py-3">Player Name</th>
                                <th scope="col" class="px-6 py-3">Duration (Minutes)</th>
{{--                                <th scope="col" class="px-6 py-3">Duration</th>--}}
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


        //---------------------------->
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
        //---------------------------->
            var table = window.jQuery('.ajax-table').DataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                autoWidth: false,
                pageLength: 15,
                ajax:{
                    url:'{{ route('player.leaderboard_ajax') }}',
                    type: 'POST',
                    headers: {
                        'X-CSRF-TOKEN' : '{{ csrf_token() }}'
                    },
                    error: function (xhr, error, code) {
                        setInterval(function () {
                            location.reload();

                            }, 1000*5);
                    }
                },
                dom: 'srt',
                "createdRow": function( row, data, dataIndex ) {
                    $(row).addClass( 'bg-white border-b dark:bg-gray-800 dark:border-gray-700' );
                },
                columns: [
                    {className:'px-6 py-4 text-gray-500 dark:text-gray-400',data: 'DT_RowIndex' , name: 'DT_RowIndex', orderable: false, searchable: false},
                    {className:'px-6 py-4 text-gray-500 dark:text-gray-400',data: 'name', name: 'name', orderable: false, searchable: false},
                    {className:'px-6 py-4 text-gray-500 dark:text-gray-400',data: 'duration', name: 'duration', orderable: false, searchable: false},
                    // {className:'px-6 py-4 text-gray-500 dark:text-gray-400',data: 'duration', name: 'duration', orderable: false, searchable: false}

                ]
            });

            setInterval(function () {table.ajax.reload();}, 1000*5);



        });
    </script>

</x-user-layout>
