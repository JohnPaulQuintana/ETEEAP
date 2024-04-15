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
                    {{ $department_users[0]->department_name }} User's </h1>

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
            let departmentList = @json($department_users);
            let courses = @json($courses);
            console.log(courses)
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
                                    text: '<h1 class="text-red-500"><i class="fa-solid fa-backward"></i></h1>',
                                    action: function(e, dt, node, config) {
                                        triggerBack();
                                    }
                                },
                                {
                                    extend: 'csvHtml5',
                                    text: `<i class="fa-solid fa-file-csv text-blue-700 hover:text-blue-800 text-[19px]"></i>`,
                                    exportOptions: exportFormatter
                                },
                                {
                                    extend: 'excelHtml5',
                                    text: `<i class="fa-solid fa-file-xls text-blue-700 hover:text-blue-800 text-[19px]"></i>`,
                                    exportOptions: exportFormatter
                                },
                                // { extend: 'pdfHtml5', exportOptions: exportFormatter },
                                {
                                    text: '<i class="fa-solid fa-user-plus text-blue-700 hover:text-blue-800 text-[19px]"></i>',
                                    action: function(e, dt, node, config) {
                                        triggerAddingUser();
                                    }
                                },

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
                            title: 'Name',
                            data: null,
                            render: function(type, data, row) {
                                if (row.name !== null) return `<span>${row.name}</span>`;
                                return `<span class="px-2 bg-red-700 text-white rounded-md">no available user's</span>`
                            }
                        },
                        {
                            title: 'Email Verified',
                            data: null,
                            render: function(type, data, row) {
                                if (row.email_verified_at !== null)
                                return `<span>${new Date(row.email_verified_at).toLocaleString()}</span>`;
                                return `<span class="px-2 bg-red-700 text-white rounded-md">not-verified</span>`
                            }
                        },

                        {
                            title: 'Created',
                            data: null,
                            render: function(type, data, row) {
                                return `<span>${new Date(row.created_at).toLocaleString()}</span>`
                            }
                        },
                        {
                            title: 'Updated',
                            data: null,
                            render: function(type, data, row) {
                                return `<span>${new Date(row.updated_at).toLocaleString()}</span>`
                            }
                        },
                        {
                            title: 'Action',
                            data: null,
                            render: function(type, data, row) {
                                return `
                                <a class="action_btn border rounded-md p-[5px] inline-flex text-blue-700 hover:text-blue-800 hover:cursor-pointer" 
                                    data-id="${row.id}" data-department_id="${row.dept_id}" data-type="edit" data-name="${row.name}" data-email="${row.email}" data-password="${row.password}" data-verified="${row.email_verified_at}">
                                    <i class="fa-solid fa-pen-to-square text-[20px]"></i>
                                </a>
                                <a class="action_btn border rounded-md p-[5px] inline-flex text-red-700 hover:text-red-800 hover:cursor-pointer" 
                                data-id="${row.id}" data-department_id="${row.dept_id}" data-type="delete" data-name="${row.name}" data-email="${row.email}" data-password="${row.password}" data-verified="${row.email_verified_at}">
                                    <i class="fa-solid fa-square-minus text-[20px]"></i>
                                </a>
                                `
                            }
                        },

                        {
                            title: 'Course',
                            data: null,
                            render: function(type, data, row) {
                                return `<span class="p-2 font-bold tracking-wider text-[14px] text-blue-950">${row.available_course}</span>`
                            }
                        },

                    ],
                    // visible: true, // Show the column in the table display
                    responsive: true,
                    "initComplete": function(settings, json) {
                        $(this.api().table().container()).addClass('bs4');
                    },


                })


                $(document).on('click', '.action_btn', function() {
                    let id = $(this).data('id')
                    let dept_id = $(this).data('department_id')
                    let name = $(this).data('name')
                    let email = $(this).data('email')
                    switch ($(this).data('type')) {
                        case 'edit':


                            // alert(name)
                            $('#edit_user_id').val(parseInt(id))
                            $('#edit_department_id').val(parseInt(dept_id))
                            $('#edit_name').val(name)
                            $('#edit_email').val(email)

                            $('.backdrop').removeClass('hidden').addClass('visible').fadeIn('slow')
                            $('.edit_user_modal').removeClass('hidden').addClass('visible').fadeIn('slow')
                            break;

                        case 'delete':
                            $('#delete_user_id').val(parseInt(id))
                            $('#delete_department_id').val(parseInt(dept_id))
                            $('#delete_name').val(name)
                            $('#delete_email').val(email)

                            $('.backdrop').removeClass('hidden').addClass('visible').fadeIn('slow')
                            $('.delete_user_modal').removeClass('hidden').addClass('visible').fadeIn('slow')

                        default:
                            break;
                    }

                    $('.edit-close').on('click', function() {
                        $('#edit_name').val('')
                        $('#edit_email').val('')
                        $('#edit_user_id').val('')
                        $('#edit_department_id').val('')
                        $('.backdrop').removeClass('visible').addClass('hidden').fadeOut('slow')
                        $('.edit_user_modal').removeClass('visible').addClass('hidden').fadeOut('slow')
                    })
                    $('.delete-close').on('click', function() {
                        $('#delete_name').val('')
                        $('#delete_email').val('')
                        $('#delete_user_id').val('')
                        $('#delete_department_id').val('')
                        $('.backdrop').removeClass('visible').addClass('hidden').fadeOut('slow')
                        $('.delete_user_modal').removeClass('visible').addClass('hidden').fadeOut('slow')
                    })
                })

            })
            
            const uniqueId = (id) => {
                const randomness = Math.random().toString(36).substr(2);
                const uuid = randomness + id
                return uuid.substr(0, 12).toUpperCase();
            };
            const triggerAddingUser = () => {
                // alert('add a new user here')
                // console.log(departmentList[0].dept_id)
                $('#dept_id').val(parseInt(departmentList[0].dept_id))
                var coursesHtml = '<option value=""></option>'
                courses.forEach(c => {
                    coursesHtml += `<option value="${c.id}">${c.available_course}</option>`
                });
                $('#add_course').html(coursesHtml)
                $('.backdrop').removeClass('hidden').addClass('visible').fadeIn('slow')
                $('.add_user_modal').removeClass('hidden').addClass('visible').fadeIn('slow')
            }
            $('.user-close').on('click', function() {
                $('#name').val('')
                $('#email').val('')
                $('#password').val('')
                $('#dept_id').val('')
                $('.backdrop').removeClass('visible').addClass('hidden').fadeOut('slow')
                $('.add_user_modal').removeClass('visible').addClass('hidden').fadeOut('slow')
            })

            const triggerBack = () => {
                window.location.href = '/eteeap-department'
            }
        </script>
    @endsection
</x-app-layout>
