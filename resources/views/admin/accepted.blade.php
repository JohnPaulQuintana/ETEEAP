<x-app-layout>
    <div class="mx-auto max-w-screen-2xl p-4 md:p-6 2xl:p-5">
        <div class="flex justify-between mt-5 mb-5">
            <div class="flex">
                <h1 class="text-blue-900 mx-2 font-bold text-xl border-l-4 pl-2 dark:text-white">Applicants</h1>
            </div>
            @include('partials.breadcrumb')
            <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                Export
            </button>
        </div>
        <div class="shadow-md sm:rounded-lg overflow-hidden">
            <table id="users-table"
                class="table activate-select dt-responsive nowrap w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
            </table>
        </div>
    </div>
    @section('scripts')
    <script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.2.9/js/dataTables.responsive.min.js"></script>
    <script>
    var dataToRender = @json($documents);
    console.log(dataToRender); // Log the data to verify that 'date_submitted' is present

    $(document).ready(function(){
        $('#users-table').DataTable({
            data: dataToRender,
            "order": [],
            "columnDefs": [{
                "targets": 'no-sort',
                "orderable": false,
            }],
            columns: [
                {
                    title: 'Applicant ID',
                    data: 'id'
                },
                {
                    title: 'Name',
                    data: 'name'
                },
                {
                    title: 'Course',
                    data: 'course'
                },
                {
                    title: 'Date Submitted',
                    data: 'date_submitted'
                },
                {
                    title: 'Status',
                    data: 'status'
                },
                {
                    title: 'Action Required',
                    data: 'action_required',
                    render: function(data, type, row) {
                        if (data === 'Additional Documents Required' || data === 'Applicant Response Needed') {
                            return `<span class="text-red-500">${data}</span>`;
                        } else {
                            return data;
                        }
                    }
                },
                {
                    title: 'Details',
                    data: null,
                    render: function(data, type, row) {
                        return `<button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">View Details</button>`;
                    }
                }
            ],
            responsive: true,
            "initComplete": function(settings, json) {
                $(this.api().table().container()).addClass('bs4');
            },
        });
    });
</script>


    @endsection
</x-app-layout>
