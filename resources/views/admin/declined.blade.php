<x-app-layout>
    <div class="mx-auto max-w-screen-2xl p-4 md:p-6 2xl:p-5">
        <div class="mb-2">
            @include('partials.anouncement', ['admin' => 'Here is the list of rejected applicants ' . Auth::user()->name])
        </div>

        <div class="flex justify-between mt-5 mb-5">
            <div class="flex">
                <h1 class="text-blue-900 mx-2 font-bold text-xl border-l-4 pl-2 dark:text-white">Rejected Applicant's </h1>
                
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
                            title: 'Application Status',
                            data: null,
                            render: function(data, type, row) {
                                
                                return `
                                <div class="hover:text-blue-700">
                                    <span class="text-red-500">rejected</span>
                                </div>
                            `
                            }
                        },
                        {
                            title: 'Applied Date',
                            data: null,
                            render: function(data, type, row) {
                                
                                return `
                                <div class="hover:text-blue-700">
                                    <i class="fa-sharp fa-solid fa-calendar-days text-md text-blue-500 hover:cursor-pointer"></i>
                                    <span>${formatedDate(row.created_at)}</span>
                                </div>
                            `
                            }
                        },
                        
                        
                        {
                            title: 'Date Rejected: ',
                            data: null,
                            render: function(data, type, row) {
                                return `${formatedDate(row.documents[0].status[0].updated_at)}`
                            }
                        }
                    ],
                    reponsive: true,
                    "initComplete": function(settings, json) {
                        $(this.api().table().container()).addClass('bs4');
                    },
                })

            function formatedDate(dateString){
                // Parse the date string to get the date parts
                var dateParts = dateString.split('T')[0].split('-');
                var timeParts = dateString.split('T')[1].split('.')[0].split(':');

                // Format the date
                return formattedDate = dateParts[0] + '-' + dateParts[1] + '-' + dateParts[2] + ' ' + timeParts[0] + ':' + timeParts[1] + ':' + timeParts[2];


            }
         })
    </script>
    @endsection
</x-app-layout>