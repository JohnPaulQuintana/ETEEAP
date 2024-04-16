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
            .delete_user_modal,
            .filter_modal,
            .notification_modal {
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
    @include('department.modal.filter')
    @include('department.modal.newnotification')
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
            let latestMessages = @json($latestMessages);

           
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

               
                var dataTable = $('#department-table').DataTable({
                    
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
                                    text: `
                                        <i class="fa-solid fa-filter-list text-blue-700 hover:text-blue-800 p-1 text-[22px]"></i>
                                        `,
                                    action: function(e, dt, node, config) {
                                        triggerFilter();
                                    }
                                },
                                {
                                    text: `
                                            
                                            <button type="button" class="relative inline-flex items-center text-sm p-1 font-medium text-center text-blue-700 rounded-lg hover:text-blue-800">
                                                <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 16">
                                                <path d="m10.036 8.278 9.258-7.79A1.979 1.979 0 0 0 18 0H2A1.987 1.987 0 0 0 .641.541l9.395 7.737Z"/>
                                                <path d="M11.241 9.817c-.36.275-.801.425-1.255.427-.428 0-.845-.138-1.187-.395L0 2.6V14a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V2.5l-8.759 7.317Z"/>
                                                </svg>
                            
                                                <span class="message-pop absolute inline-flex items-center justify-center w-6 h-6 text-xs font-bold text-white bg-red-500 border-2 border-white rounded-full -top-2 -end-4 dark:border-gray-900">20</span>
                                            </button>

                                        `,
                                    action: function(e, dt, node, config) {
                                        triggerAlert();
                                    }
                                },

                            ]
                        }
                    },
                    data: application,
                    "order": [],
                    "columnDefs": [{
                        "targets": 'no-sort',
                        "orderable": false,
                    }],
                    columns: [
                        {
                            title: 'Applicant No.',
                            data: null,
                            render: function(type, data, row) {
                                return `<span class="font-bold text-blue-900">${uniqueId(row.id)}</span>`
                            }
                        },
                        {
                            title: 'Status',
                            data: null,
                            render: function(type, data, row) {
                                let span = ''
                                switch (row.status[0].status) {
                                    // 'pending', 'accepted', 'in-review', 'forwarded', rejected
                                    case 'under-review':
                                        span = `<span class="capitalize font-bold text-orange-400 bg-slate-100 p-[4px] rounded-md">Under Review</span>`
                                        break;
                                    case 'pending':
                                        span = `<span class="capitalize font-bold text-yellow-400 bg-slate-100 p-[4px] rounded-md">Pending</span>`
                                        break;
                                    case 'accepted':
                                        span = `<span class="capitalize font-bold text-green-400 bg-slate-100 p-[4px] rounded-md">Approved</span>`
                                        break;
                                    case 'rejected':
                                        span = `<span class="capitalize font-bold text-red-500 bg-slate-100 p-[4px] rounded-md">Rejected</span>`
                                        break;
                                
                                    default:
                                        span = `<span class="capitalize font-bold text-red-500 bg-slate-100 p-[4px] rounded-md">On Hold</span>`
                                        break;
                                }
                                return span;
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
                                return `<span>${new Date(row.date_submitted).toLocaleString()}</span>`
                            }
                        },
                        
                        {
                            title: 'Action Required',
                            data: null,
                            render: function(type, data, row) {
                                console.log(row.action)
                                if(row.action !== null && row.action.action_required !== null ){
                                    return `<span class="text-red-500">${row.action.action_required}</span>`
                                }else{
                                    return `<span class="text-red-500"></span>`
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
                

                //render the notification service
                notificationPop(latestMessages)
                
                

                const triggerFilter = () => {

                    $('.backdrop').removeClass('hidden')
                    $('.filter_modal').removeClass('hidden')
                    // alert('lets filter')
                    // Apply default filter
                    var defaultFilterValue = 'Approved'; // Set your default filter value here
                    dataTable.search(defaultFilterValue).draw();
                }

                const triggerAlert = () => {
                    let ntRender = ''
                    // Iterate over each notification
                    for (const notificationId in latestMessages) {
                        if (Object.hasOwnProperty.call(latestMessages, notificationId)) {
                            const notification = latestMessages[notificationId];
                            // console.log(notification);
                            // Access individual properties of the notification object
                            // console.log("Notification ID:", notification.id);
                            // console.log("Receiver ID:", notification.reciever_id);
                            // console.log("Sender ID:", notification.sender_id);
                            // console.log("Notification:", notification.notification);
                            // console.log("Created At:", notification.created_at);
                            // console.log("Updated At:", notification.updated_at);

                            ntRender += `
                            <div id="toast-simple"
                                class="flex items-center w-full  p-4 space-x-4 rtl:space-x-reverse text-gray-500 bg-white divide-x rtl:divide-x-reverse divide-gray-200 rounded-lg shadow dark:text-gray-400 dark:divide-gray-700 space-x dark:bg-gray-800"
                                role="alert">
                                <i class="fa-solid fa-paper-plane-top text-blue-600 dark:text-blue-500 text-[25px]"></i>

                                <div class="ps-4 text-sm font-normal flex flex-col">
                                    <input type="number" name="${notification.name}" value="${notification.id}" class="hidden">
                                    <span class="font-bold text-blue-900">${notification.name}</span>

                                    <span class="">${notification.notification}</span>
                                    <span class="text-blue-700">${formatDate(notification.created_at)}</span>

                                </div>

                            </div>
                            `

                        }
                    }

                    $('.alert-container').html(ntRender)

                    $('.backdrop').removeClass('hidden')
                    $('.notification_modal').removeClass('hidden')
                    
                }

                $('.filterBtn').click(function(){
                    // alert($(this).data('name'))
                    let filterValue = $(this).data('name')
                    $('.backdrop').addClass('hidden')
                    $('.filter_modal').addClass('hidden')
                    // var defaultFilterValue = 'Approved'; // Set your default filter value here
                    dataTable.search(filterValue).draw();

                })

                $('.f-close').click(function(){
                    $('.backdrop').addClass('hidden')
                    $('.filter_modal').addClass('hidden')
                })

                $('.n-close').click(function(){
                    $('.backdrop').addClass('hidden')
                    $('.notification_modal').addClass('hidden')
                })
                
            })

            const uniqueId = (id) => {
                const randomness = Math.random().toString(36).substr(2);
                const uuid = randomness + id
                return uuid.substr(0, 12).toUpperCase();
            };

            const notificationPop = (message) => {
                console.log(message)
                const count = Object.keys(message).length;
                    $('.message-pop').text(count)
                }
            
            // Function to format the date string
            const formatDate = (dateString) => {
                const date = new Date(dateString);
                // Options for formatting the date
                const options = { year: 'numeric', month: 'short', day: 'numeric', hour: '2-digit', minute: '2-digit' };
                // Format the date using the options
                const formattedDate = date.toLocaleDateString('en-US', options);
                return formattedDate;
            }
            
        </script>
    @endsection
</x-app-layout>
