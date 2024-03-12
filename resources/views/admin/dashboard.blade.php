<x-app-layout>
    <div class="mx-auto max-w-screen-2xl p-4 md:p-6 2xl:p-5">
        <div class="mb-2">
            @include('partials.anouncement', ['admin' => "Welcome back ".Auth::user()->name])
        </div>

        <div class="shadow-md sm:rounded-lg overflow-hidden">
            <h1 class="font-bold text-blue-900 text-xl mt-5">Pending Document's</h1>
            <table id="rejected-table" class="table activate-select dt-responsive nowrap w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400"></table>

        </div>
    </div>

    @include('popup.documents')
    @include('popup.iframe')

    @section('scripts')
        {{-- datatables --}}
        {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/datatables.net-responsive-bs4/3.0.0/responsive.bootstrap4.min.js"></script> --}}
        <script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/responsive/2.2.9/js/dataTables.responsive.min.js"></script>
        <script>
            // // test data format
            // var dataArray = [
            // { name: 'John Doe', email: 'john@example.com', age: 25 },
            // { name: 'Jane Smith', email: 'jane@example.com', age: 30 },
            // // Add more objects as needed
            // ];

            var dataToRender =  @json($documents);
            $(document).ready(function(){
                const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

                const $requirementU = document.getElementById('select-modal');
                const $requirementI = document.getElementById('static-modal');

                // options with default values
                const options = {
                    placement: 'right',
                    backdrop: 'static',
                    backdropClasses: 'bg-blue-900/10 dark:bg-blue-900/80 fixed inset-0 z-40',
                    closable: true,
                    onHide: () => {
                        console.log('modal is hidden');
                    },
                    onShow: () => {
                        console.log('modal is shown');
                    },
                    onToggle: () => {
                        console.log('modal has been toggled');
                    },
                };
                // instance options object
                const instanceOptions = {
                    id: 'select-modal',
                    override: true
                };
                // instance options object
                const instanceOptionsI = {
                    id: 'static-modal',
                    override: true
                };

                const dqu = new Modal($requirementU, options, instanceOptions);
                const Iqu = new Modal($requirementI, options, instanceOptionsI);


                $('#rejected-table').DataTable({
                    data: dataToRender,
                    "order": [],
                    "columnDefs": [ {
                    "targets"  : 'no-sort',
                    "orderable": false,
                    }],

                    columns: [
                        {title: 'Type', data: null, render(data, type,row) {
                           return `<span class="text-blue-900 font-bold">ETEEAP Application</span>`    
                        }},
                        {title: 'Name', data: 'name'},
                        {title: 'Email', data: 'email'},
                        {title: 'Documents', data: null, render: function(data, type, row){
                            return `
                                <div class="docsbtn hover:cursor-pointer hover:text-blue-700" data-user_id="${row.id}">
                                    <i class="fa-sharp fa-solid fa-folder-open text-md text-blue-500 hover:cursor-pointer"></i>
                                    <span>view document's</span>
                                </div>
                            `
                        }},
                        {title: 'Status', data: null, render: function(data, type, row){
                            console.log(row.documents[0].status[0].status)
                            return `<span class="p-1 rounded-md bg-yellow-300 lowercase text-black text-sm">${row.documents[0].status[0].status}</span>`
                        }},
                        {title: 'Date', data: null, render: function(data, type, row){
                            return `${row.documents[0].created_at}`
                        }}
                    ],
                    reponsive: true,
                    "initComplete": function (settings, json) {
                        $(this.api().table().container()).addClass('bs4');
                    },
                })

                // open documents
                $(document).on('click', '.docsbtn', function(){
                    let user_id = $(this).data('user_id')
                    // alert(user_id)
                    fetchData(`/documents/${user_id}`)
                    updateStatus(`/documents-update/${user_id}`)
                })

                // open file
                $(document).on('click', '.list-data', function(){
                    let file=$(this).data('file').replace(/^public\//, 'storage/')
                    let fileName=$(this).data('filename')
              
                    $('#filename').text(fileName)
                    $('#fileViewer').attr('src', `{{ asset('${file}') }}`)
                    Iqu.show();
                })

                // close modal
                $(document).on('click', '.seClose', function(){
                    dqu.hide();
                })
                $(document).on('click', '.stClose', function(){
                    Iqu.hide();
                })

                // Function to make the Ajax request
                function fetchData(endpoint) {

                    // Include the CSRF token in the headers
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': csrfToken
                        }
                    });

                    $.ajax({
                        url: endpoint,
                        type: 'get', // Change the type if needed
                        dataType: 'json',
                        success: function (data) {
                            // Handle the data as needed
                            console.log(data.documents[0].documents);
                            var lists = ''
                            var count = 0;
                            $('#doc_name').text(data.documents[0].name)

                            const fileNames = [
                                'loi', 'ce', 'cr', 'nce', 'hdt', 'f137_8', 'abcb', 'mc', 'nbc', 'tvid', 'ge', 'pc', 'rl', 'cgmc', 'cer',
                            ];
                            const originalNames = [
                                'Letter of Intent addressed to: Mr. Philip M. Flores, Director, ETEEAP, Arellano University, 2600 Legarda St., Sampaloc, Manila 1008',
                                'CHED - ETEEAP Application form with 3 pieces of 1x1 picture', 
                                'Comprehensive Resume (original)', 
                                'Notarized Certificate of Employment with job description (with at least 5 years of working experience)', 
                                'Honorable Dismissal and TOR (for undergraduate and for vocational courses)', 
                                'Form 137–A and Form 138 (for High School Graduate) or PEPT/ALS Certificate', 
                                'Authenticated Birth Certificate/Affidavit of Birth (original)', 
                                'Marriage Certificate (for female, if married - photocopy)', 
                                'NBI or Barangay clearance (original)', 
                                '2 valid IDs (photocopy)', 
                                'Government eligibility', 
                                'Proficiency Certificate', 
                                'Recommendation Letter from immediate superior to undergo ETEEAP (original)', 
                                'Certificate of Good Moral Character from previous school (original)', 
                                'Certificates of Trainings, Seminars and Workshops attended (photocopy)',
                            ];
                            data.documents[0].documents.forEach(doc => {
                                // console.log(doc)
                                const filteredObject = Object.fromEntries(
                                    Object.entries(doc).filter(([key]) => fileNames.includes(key))
                                );
                                for (const key in filteredObject) {
                                    if(doc.hasOwnProperty(key)){
                                        console.log(filteredObject[key])

                                        // Create a mapping object
                                        const mapping = {};
                                        fileNames.forEach((fileName, index) => {
                                            mapping[fileName] = originalNames[index];
                                        });
                                        count++;
                                        lists += `
                                            <li class="list-data" data-filename="${mapping[key]}" data-file="${filteredObject[key]}"data-modal-target="select-modal">
                                                <input type="radio" id="job-${count}" name="job" value="job-1" class="hidden peer" required />
                                                <label for="job-${count}" class="inline-flex items-center justify-between w-full p-5 text-gray-900 bg-white border border-gray-200 rounded-lg cursor-pointer dark:hover:text-gray-300 dark:border-gray-500 dark:peer-checked:text-blue-500 peer-checked:border-blue-600 peer-checked:text-blue-600 hover:text-gray-900 hover:bg-gray-100 dark:text-white dark:bg-gray-600 dark:hover:bg-gray-500">                           
                                                    <div class="block">
                                                        <div class="w-full text-lg font-semibold">REQUIREMENT'S - ${count}</div>
                                                        <div class="w-full text-gray-500 dark:text-gray-400 text-sm">${mapping[key]}</div>
                                                    </div>
                                                    <svg class="w-4 h-4 ms-3 rtl:rotate-180 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 10"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 5h12m0 0L9 1m4 4L9 9"/></svg>
                                                </label>
                                            </li>
                                        `
                                    }
                                    
                                }
                            });

                            $('.doc-list').html(lists)
                            dqu.show()
                        },
                        error: function (error) {
                            console.error('Error fetching data:', error);
                        }
                    });
                }
                // Function to make the Ajax request for updating status
                function updateStatus(endpoint) {

                    // Include the CSRF token in the headers
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': csrfToken
                        }
                    });

                    $.ajax({
                        url: endpoint,
                        type: 'get', // Change the type if needed
                        dataType: 'json',
                        success: function (data) {
                            // Handle the data as needed
                            console.log(data);
                        },
                        error: function (error) {
                            console.error('Error fetching data:', error);
                        }
                    });
                }
            })
        </script>
    @endsection
</x-app-layout>