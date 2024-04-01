<x-app-layout>
    <div class="mx-auto max-w-screen-2xl p-4 md:p-6 2xl:p-5">
        <div class="mb-2">
            @include('partials.anouncement', ['admin' => 'Here is the list of accepted applicants ' . Auth::user()->name])
        </div>

        <div class="flex justify-between mt-5 mb-5">
            <div class="flex">
                <h1 class="text-blue-900 mx-2 font-bold text-xl border-l-4 pl-2 dark:text-white">Accepted Applicants </h1>
                
            </div>
            @include('partials.breadcrumb')
        </div>

        <div class="shadow-md sm:rounded-lg overflow-hidden">
            <table id="accepted-table"
                class="table activate-select dt-responsive nowrap w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
            </table>

        </div>
    </div>

    @section('scripts')
    <script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.2.9/js/dataTables.responsive.min.js"></script>
    <script>
         var dataToRender = @json($documents);
         console.log(dataToRender)
         $(document).ready(function(){
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            $('#accepted-table').DataTable({
                    data: dataToRender,
                    "order": [],
                    "columnDefs": [{
                        "targets": 'no-sort',
                        "orderable": false,
                    }],

                    columns: [{
                            title: 'Type',
                            data: null,
                            render(data, type, row) {
                                return `<span class="text-blue-900 font-bold">ETEEAP Application</span>`
                            }
                        },
                        {
                            title: 'Name',
                            data: 'name'
                        },
                        {
                            title: 'Email',
                            data: 'email'
                        },
                        {
                            title: 'Scheduled',
                            data: null,
                            render: function(data, type, row) {
                                
                                return `
                                <div class="hover:text-blue-700">
                                    <i class="fa-sharp fa-solid fa-calendar-days text-md text-blue-500 hover:cursor-pointer"></i>
                                    <span>${row.interview[0].date}</span>
                                </div>
                            `
                            }
                        },
                        // {
                        //     title: 'Interviewer',
                        //     data: null,
                        //     render: function(data, type, row) {
                            
                        //         return `<span class="p-1 rounded-md lowercase text-black text-sm">${row.interview[0].interviewer}</span>`
                        //     }
                        // },
                        {
                            title: 'Time',
                            data: null,
                            render: function(data, type, row) {
                            
                                return `<span class="p-1 rounded-md lowercase text-black text-sm">${row.interview[0].time}</span>`
                            }
                        },
                        {
                            title: 'Location',
                            data: null,
                            render: function(data, type, row) {
                            
                                return `<span class="p-1 rounded-md lowercase text-black text-sm">${row.interview[0].location}</span>`
                            }
                        },
                        // {
                        //     title: 'What to bring?',
                        //     data: null,
                        //     render: function(data, type, row) {
                            
                        //         return `<span class="p-1 rounded-md lowercase text-black text-sm">${row.interview[0].what_to_bring}</span>`
                        //     }
                        // },
                        {
                            title: 'Date Created: ',
                            data: null,
                            render: function(data, type, row) {
                                return `${row.interview[0].created_at}`
                            }
                        }
                    ],
                    reponsive: true,
                    "initComplete": function(settings, json) {
                        $(this.api().table().container()).addClass('bs4');
                    },
                })
         })
    </script>
    @endsection
</x-app-layout>