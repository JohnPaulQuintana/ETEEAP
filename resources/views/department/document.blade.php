<x-app-layout>
    @section('links')
        <style>
            .backdrop {
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background-color: rgba(0, 0, 0, 0.5);
                /* semi-transparent black */
                z-index: 9998;
                /* lower z-index to appear behind the popup */
            }

            .add_user_modal,
            .edit_user_modal,
            .delete_user_modal {
                position: fixed;

                top: 50%;
                left: 50%;
                transform: translate(-50%, -50%);
                background-color: white;
                padding: 20px;
                border: 2px solid #ccc;
                box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
                z-index: 9999;
                transition: 3s ease-in-out;
                /* higher z-index to appear above the backdrop */
            }
        </style>
    @endsection
    <div class="mx-auto max-w-screen-2xl p-4 md:p-6 2xl:p-5">
        <div class="flex justify-between mb-5">
            <div class="flex">
                <h1 class="text-blue-900 mx-2 font-bold text-xl border-l-4 pl-2 dark:text-white">
                    Application </h1>

            </div>
            {{-- @include('partials.breadcrumb') --}}
        </div>

        <div class="mb-4 border-b border-gray-200 dark:border-gray-700">
            {{-- <span>Outgoing Docum</span> --}}

        </div>

        <div class="sm:rounded-lg overflow-hidden px-2">
            <div class="relative w-full max-w-full max-h-full">
                <div class="bg-white rounded-lg shadow dark:bg-gray-700 px-2">
                    <div class="overflow-x-auto"> <!-- Add overflow-x-auto class here -->
                        <table id="department-table"
                            class="department-table table text-left activate-select dt-responsive nowrap text-sm rtl:text-right text-gray-500 dark:text-gray-400">
                        </table>
                    </div>
                </div>
            </div>
        </div>

    </div>
    @include('department.modal.user')
    @include('department.modal.edit')
    @include('department.modal.delete')
    @section('scripts')
        <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
        <script src="https://cdn.datatables.net/2.0.3/js/dataTables.js"></script>

        <script src="https://cdn.datatables.net/2.0.3/js/dataTables.jqueryui.js"></script>
        <script src="https://cdn.datatables.net/responsive/3.0.1/js/dataTables.responsive.js"></script>
        <script src="https://cdn.datatables.net/responsive/3.0.1/js/responsive.dataTables.js"></script>
        <script src="https://cdn.datatables.net/buttons/3.0.1/js/dataTables.buttons.js"></script>
        <script src="https://cdn.datatables.net/buttons/3.0.1/js/buttons.jqueryui.js"></script>
        <script src="https://cdn.datatables.net/buttons/3.0.1/js/buttons.dataTables.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
        <script src="https://cdn.datatables.net/buttons/3.0.1/js/buttons.html5.min.js"></script>
        {{-- <script src="https://cdn.datatables.net/responsive/2.2.9/js/dataTables.responsive.min.js"></script> --}}
        <script>
            let application = @json($application);

            console.log(application)
            $(document).ready(function() {
                const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                var exportFormatter = {
                    format: {
                        body: function(data, row, column, node) {
                            // Strip $ from salary column to make it numeric
                            // return column === 5 ? data.replace(/[$,]/g, '') : data;
                            // Use jQuery to extract text content from HTML
                            return $(data).text();
                        }
                    }
                };

                $('#department-table').DataTable({
                    layout: {
                        top1Start: {
                            buttons: [
                                // {
                                //     text: '<h1 class="text-red-500"><i class="fa-solid fa-backward"></i></h1>',
                                //     action: function(e, dt, node, config) {
                                //         triggerBack();
                                //     }
                                // },
                                {
                                    extend: 'csvHtml5',
                                    exportOptions: exportFormatter
                                },
                                {
                                    extend: 'excelHtml5',
                                    exportOptions: exportFormatter
                                },
                                // { extend: 'pdfHtml5', exportOptions: exportFormatter },
                                // {
                                //     text: 'Add User',
                                //     action: function(e, dt, node, config) {
                                //         triggerAddingUser();
                                //     }
                                // },

                            ]
                        }
                    },
                    data: application,
                    "order": [],
                    "columnDefs": [{
                        "targets": 'no-sort',
                        "orderable": false,
                    }],
                    columns: [{
                            title: 'Applicant No.',
                            data: null,
                            render: function(type, data, row) {
                                return `<span class="font-bold text-blue-900">${uniqueId(row.id)}</span>`
                            }
                        },
                        {
                            title: 'Name',
                            data: null,
                            render: function(type, data, row) {
                                return `<span>${row.user.name}</span>`
                            }
                        },
                        {
                            title: 'Course',
                            data: null,
                            render: function(type, data, row) {
                                return `<span>${row.available_course}</span>`
                            }
                        },
                        {
                            title: 'Date Submitted',
                            data: null,
                            render: function(type, data, row) {
                                return `<span>${new Date(row.created_at).toLocaleString()}</span>`
                            }
                        },
                        {
                            title: 'Status',
                            data: null,
                            render: function(type, data, row) {
                                return `<span class="capitalize">${row.status[0].status}</span>`
                            }
                        },
                        {
                            title: 'Action Required',
                            data: null,
                            render: function(type, data, row) {
                                if(row.action){
                                    return `<span class="text-red-500">${row.action.action_required}</span>`
                                }
                               
                            }
                        },

                        {
                            title: 'Action',
                            data: null,
                            render: function(type, data, row) {
                                var base_url = "{{ route('eteeap.document', '') }}"; // Assuming eteeap.users is your route name
                                // console.log(base_url)
                                return `
                                <a href="${base_url}/${row.id}" class="border rounded-md p-[5px] inline-flex text-blue-700 hover:text-blue-800 hover:cursor-pointer">
                                    <i class="fa-solid fa-chevrons-right text-[20px]"></i>
                                </a>
                                
                                `
                            }
                        },

                    ],
                    // visible: true, // Show the column in the table display
                    responsive: true,
                    "initComplete": function(settings, json) {
                        $(this.api().table().container()).addClass('bs4');
                    },


                })
                

            })

            const uniqueId = (id) => {
                const randomness = Math.random().toString(36).substr(2);
                const uuid = randomness + id
                return uuid.substr(0, 12).toUpperCase();
            };
            
        </script>
    @endsection
</x-app-layout>
