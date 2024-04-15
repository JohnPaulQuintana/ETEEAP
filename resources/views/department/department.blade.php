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

            .add_department {
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
                    {{ $department->department_name }} Dashboard </h1>

            </div>
            {{-- @include('partials.breadcrumb') --}}
        </div>

        <div class="mb-4 border-b border-gray-200 dark:border-gray-700">
            {{-- <span>Outgoing Docum</span> --}}

        </div>

        <div class="sm:rounded-lg overflow-hidden px-2">
            <div class="relativew-full max-w-full max-h-full">
                <div class="bg-white rounded-lg shadow dark:bg-gray-700 px-2">
                    {{-- {{ $department_list }} --}}
                    <table id="department-table"
                        class="department-table table text-left activate-select dt-responsive nowrap w-full text-sm rtl:text-right text-gray-500 dark:text-gray-400">
                    </table>

                </div>
            </div>
        </div>
    </div>

    @include('department.modal.department')
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
            let departmentList = @json($department_list);
            console.log(departmentList)
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
                            buttons: [{
                                    extend: 'csvHtml5',
                                    text: `<i class="fa-solid fa-file-csv text-blue-700 hover:text-blue-800 p-1 text-[22px]"></i>`,
                                    exportOptions: exportFormatter
                                },
                                {
                                    extend: 'excelHtml5',
                                    text: `<i class="fa-solid fa-file-xls text-blue-700 hover:text-blue-800 p-1 text-[22px]"></i>`,
                                    exportOptions: exportFormatter
                                },
                                // { extend: 'pdfHtml5', exportOptions: exportFormatter },
                                {
                                    text: '<i class="fa-solid fa-building-circle-check text-blue-700 hover:text-blue-800 p-1 text-[22px]"></i>',
                                    action: function(e, dt, node, config) {
                                        triggerAddingDept();
                                    }
                                }
                            ]
                        }
                    },
                    data: departmentList,
                    "order": [],
                    "columnDefs": [{
                        "targets": 'no-sort',
                        "orderable": false,
                    }],
                    columns: [{
                            title: 'Department ID',
                            data: null,
                            render: function(type, data, row) {
                                return `<span class="font-bold text-blue-900">${uniqueId(row.id)}</span>`
                            }
                        },
                        {
                            title: 'Department Name',
                            data: null,
                            render: function(type, data, row) {
                                return `<span>${row.department_name}</span>`
                            }
                        },
                        {
                            title: 'Status',
                            data: null,
                            render: function(type, data, row) {
                                if (row.status) {
                                    return `<span class="text-green-500 border p-[2px] rounded-md">active</span>`
                                } else {
                                    return `<span class="text-red-500 border p-[2px] rounded-md">in-active</span>`
                                }
                            }
                        },
                        {
                            title: 'Accounts',
                            data: null,
                            render: function(type, data, row) {
                                var base_url = "{{ route('eteeap.users', '') }}"; // Assuming eteeap.users is your route name
                                return `
                                    <a href="${base_url}/${row.id}" class="inline-flex items-center gap-2 font-bold text-md p-[5px] rounded-md bg-blue-900 text-white hover:bg-blue-700 hover:cursor-pointer"><i class="fa-sharp fa-solid fa-plus"></i>${row.user_count}</a>
                                
                                `
                            }
                        },
                        {
                            title: 'Created',
                            data: null,
                            render: function(type, data, row) {
                                return `<span>${row.created_at}</span>`
                            }
                        },
                        {
                            title: 'Updated',
                            data: null,
                            render: function(type, data, row) {
                                return `<span>${row.updated_at}</span>`
                            }
                        },
                        // {
                        //     title: 'Action',
                        //     data:null,
                        //     render: function(type, data, row){
                        //         return `<a href="#" class="border rounded-md p-[5px] inline-flex hover:text-blue-700"><i class="fa-sharp fa-solid fa-eye text-[20px]"></i></a>`
                        //     }
                        // },

                    ],
                    // visible: true, // Show the column in the table display
                    responsive: true,
                    "initComplete": function(settings, json) {
                        $(this.api().table().container()).addClass('bs4');
                    },
                })


                // $(document).on('click', '.account', function() {
                //     alert($(this).data('id'))
                // })

            })
            const uniqueId = (id) => {
                const randomness = Math.random().toString(36).substr(2);
                const uuid = randomness + id
                return uuid.substr(0, 12).toUpperCase();
            };
            const triggerAddingDept = () => {
                // alert('add a new department here')
                $('.backdrop').removeClass('hidden').addClass('visible').fadeIn('slow')
                $('.add_department').removeClass('hidden').addClass('visible').fadeIn('slow')
            }

            $('.department-close').on('click', function(){
                $('.backdrop').removeClass('visible').addClass('hidden').fadeOut('slow')
                $('.add_department').removeClass('visible').addClass('hidden').fadeOut('slow')
            })
        </script>
    @endsection
</x-app-layout>
