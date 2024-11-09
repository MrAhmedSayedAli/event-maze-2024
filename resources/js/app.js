import './bootstrap';

import Alpine from 'alpinejs';

import 'laravel-datatables-vite';

import swal from 'sweetalert2';

window.Swal = swal;

window.Alpine = Alpine;

Alpine.start();

import 'flowbite';


//--------------------->
window.jQuery(function () {

    const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000
    });

    window.jQuery(document).on('click', '.del-all', function (e) {
        e.preventDefault();
        var element = $(this);
        var del_id = element.data("id");
        var baseurl = element.data("url");
        var info = 'id=' + del_id;

        window.Swal.fire({
            title: "are you sure you want to Delete Data",
            text: "In case of deletion, data cannot be retrieved again!",
            icon: "warning",
            showCancelButton: true,
            buttonsStyling: false,
            confirmButtonText: "Yes, delete!",
            cancelButtonText: "No, cancel",
            customClass: {

                cancelButton: "text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800",
                confirmButton: "focus:outline-none text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-900"
            }
        }).then(result => {
            if (result.value) {
                $.ajax({
                    type: "DELETE",
                    url: baseurl,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: info,
                    error: function (err) {
                        Toast.fire({
                            icon: 'error',
                            title: "Error cannot delete ! try again later"
                        });
                    },
                    success: function (data) {
                        var jsonObj = {};
                        jsonObj = data;
                        if (jsonObj.success === true) {
                            Toast.fire({
                                icon: 'success',
                                title: "Data has been deleted successfully"
                            });
                            if (del_id == "x") {
                                window.location.reload();
                            } else {
                                element.closest("tr").animate({backgroundColor: "#fbc7c7"}, "fast").animate({opacity: "hide"}, "slow");
                            }
                        } else {
                            var delMsg = "Error cannot delete ! try again later";

                            if (jsonObj.msg) {
                                delMsg = jsonObj.msg;
                            }
                            Toast.fire({
                                icon: 'error',
                                title: delMsg
                            });
                        }
                    }
                });
            }
        });
    });
});
//--------------------->
