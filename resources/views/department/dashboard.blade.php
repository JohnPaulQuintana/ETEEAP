<x-app-layout>
    <div class="mx-auto max-w-screen-2xl p-4 md:p-6 2xl:p-5">


        <div class="flex justify-between mb-5">
            <div class="flex">
                <h1 class="text-blue-900 mx-2 font-bold text-xl border-l-4 pl-2 dark:text-white">
                    {{ $department->department_name }} Dashboard </h1>

            </div>
            @include('partials.breadcrumb')
        </div>

        <div class="sm:rounded-lg overflow-hidden px-2">
            <!-- Main modal -->
            <div class="relativew-full max-w-full max-h-full">
                <!-- Modal content -->
                <div class="bg-white rounded-lg shadow dark:bg-gray-700">
                    {{-- loop the location of documents --}}
                    @foreach ($documents as $document)
                        {{-- {{ $document }} --}}
                        <!-- Modal header -->
                        <div
                            class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                            <h3 class="text-lg font-semibold text-blue-900 dark:text-white">
                                {{ $document->name }} Application
                            </h3>
                            <button type="button"
                                class="t-close text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm h-8 w-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                                data-modal-toggle="timeline-modal">
                                <i class="fa-sharp fa-solid fa-circle-user text-2xl text-blue-900"></i>
                            </button>
                        </div>
                        <!-- Modal body -->
                        <div class="p-4 md:p-5 max-h-150 overflow-scroll">
                            <ol id="history-card"
                                class="relative border-s border-gray-200 dark:border-gray-600 ms-3.5 mb-4 md:mb-5">


                                <li class="shadow-md p-2 ms-8 grid grid-cols-1 lg:grid-cols-2 gap-2">
                                    {{-- documents --}}
                                    <div>
                                        <span
                                            class="absolute flex items-center justify-center w-6 h-6 bg-gray-100 rounded-full -start-3.5 ring-8 ring-white dark:ring-gray-700 dark:bg-gray-600">
                                            <i class="fa-sharp fa-solid fa-circle w-2.5 h-2.5 text-yellow-400"></i>
                                        </span>
                                        <h3
                                            class="flex items-start mb-1 text-lg font-semibold text-blue-900 dark:text-white">
                                            ETEEAP APPLICATION

                                            <span
                                                class="bg-yellow-400 text-white text-sm font-medium mr-2 px-2.5 py-0.5 rounded dark:bg-blue-900 dark:text-blue-300 ms-3">
                                                {{ $document->documents[0]->status[0]->status }}
                                            </span>
                                            <span
                                                class="bg-blue-500 hover:bg-blue-700 hover:cursor-pointer text-white text-sm font-medium mr-2 px-2.5 py-0.5 rounded dark:bg-blue-900 dark:text-blue-300 ms-3">
                                                Date: {{ \Carbon\Carbon::parse($document->documents[0]->created_at)->format('Y-m-d') }}
                                            </span>
                                            <span
                                                class="bg-blue-500 hover:bg-blue-700 hover:cursor-pointer text-white text-sm font-medium mr-2 px-2.5 py-0.5 rounded dark:bg-blue-900 dark:text-blue-300 ms-3">
                                                Time: {{ \Carbon\Carbon::parse($document->documents[0]->created_at)->format('h:i A') }}
                                            </span>
                                        </h3>
                                        {{-- <time
                                            class="block mb-3 text-sm font-normal leading-none text-blue-900 dark:text-gray-400">
                                            <span class="font-bold">Date :</span>
                                            {{ \Carbon\Carbon::parse($document->documents[0]->created_at)->format('Y-m-d') }}
                                        </time>
                                        <time
                                            class="block mb-3 text-sm font-normal leading-none text-blue-900 dark:text-gray-400">
                                            <span class="font-bold">Time :</span>
                                            {{ \Carbon\Carbon::parse($document->documents[0]->created_at)->format('h:i A') }}
                                        </time> --}}

                                        {{-- {{ $checked }} --}}
                                        <div class="rounded-md p-2">
                                            @php
                                                $count = 0;
                                                $originalName = [
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

                                                $columnKey = [
                                                    'loi',
                                                    'ce',
                                                    'cr',
                                                    'nce',
                                                    'hdt',
                                                    'f137_8',
                                                    'abcb',
                                                    'mc',
                                                    'nbc',
                                                    '2_id',
                                                    'ge',
                                                    'pc',
                                                    'rl',
                                                    'cgmc',
                                                    'cer',
                                                ];
                                            @endphp
                                            @foreach ($originalName as $key => $doc)
                                                @if ($document->documents[0][$columnKey[$key]] !== null)
                                                    {{-- {{ $count++ }} {{ isset($checked[$count++]->action) }} --}}
                                                    @php
                                                        $borderClass = '';
                                                      
                                                        foreach ($checked as $check) {
                                                            if ($columnKey[$key] === $check->sub_name) {
                                                                $borderClass = 'border-green-500';
                                                                if($check->action !== 'accepted'){
                                                                    $borderClass = 'border-red-500';

                                                                }
                                                            }
                                                        }

                                                    @endphp
                                                    <div
                                                        class="p-5 shadow-md border rounded-md mb-2 {{ $borderClass }}">
                                                        <div class="flex items-center gap-2">
                                                            <i
                                                                class="fa-solid fa-file-invoice text-4xl text-blue-900"></i>
                                                            <span
                                                                class="col-span-2 text-blue-900">{{ $doc }}</span>

                                                        </div>
                                                        <div class="w-full flex justify-end gap-2">
                                                            @php
                                                                $isShow = 'hidden';
                                                                $isText = 'Evaluated';
                                                                $icons = 'fa-check';
                                                                $bgColor = 'bg-green-500';
                                                                foreach ($checked as $check) {
                                                                    if ($columnKey[$key] === $check->sub_name) {
                                                                        $isShow = '';
                                                                        if ($check->action !== 'accepted') {
                                                                            $isText = 'Declined';
                                                                            $icons = 'fa-xmark';
                                                                            $bgColor = 'bg-red-500';
                                                                        }
                                                                    }
                                                                }
                                                                // echo $icons;
                                                            @endphp

                                                            <a
                                                                class="border rounded-md {{ $bgColor }} text-white p-1 {{ $isShow }}">
                                                                <i class="fa-solid {{ $icons }}"></i>
                                                                {{ $isText }}</a>

                                                            <a data-user_id="{{ $document->id }}"
                                                                data-doc='{{ $document->documents[0][$columnKey[$key]] }}'
                                                                data-filename='{{ $doc }}'
                                                                data-sub_name='{{ $columnKey[$key] }}'
                                                                class="docx border rounded-md bg-blue-500 hover:bg-blue-700 text-white p-1 hover:cursor-pointer">
                                                                <i class="fa-solid fa-eye"></i> view document</a>
                                                        </div>

                                                    </div>
                                                @endif
                                            @endforeach

                                        </div>

                                    </div>

                                    {{--  comments --}}
                                    <div class="border border-gray-2 rounded-md bg-gray-2 p-2 text-blue-900 w-full">
                                        <span class="font-bold">Comment's
                                            <span
                                                class="bg-blue-500 hover:bg-blue-700 hover:cursor-pointer text-white text-[14px] font-medium mr-2 px-2.5 py-2 rounded dark:bg-blue-900 dark:text-blue-300 ms-3">
                                                Forward to <i class="fa-sharp fa-solid fa-paper-plane-top text-[10px]"></i>
                                            </span>

                                        </span>
                                        <div class="">
                                            {{-- list of resubmit docs --}}
                                            @foreach ($declined as $dec)
                                                <div class="text-wrap w-full mt-3">
                                                    <div class="break-words max-h-60 overflow-auto">

                                                        <span class="block text-left border rounded-md bg-white p-1 mb-2">

                                                            <div class="flex items-start gap-2.5">
                                                                <div class="flex flex-col w-full gap-1">
                                                                    <div
                                                                        class="flex flex-col w-full leading-1.5 p-4 border-gray-200 bg-gray-100 rounded-e-xl rounded-es-xl dark:bg-gray-700">
                                                                        <div
                                                                            class="flex items-center space-x-2 rtl:space-x-reverse">
                                                                            <span
                                                                                class="text-sm font-semibold text-gray-900 p-1 dark:text-white">
                                                                                {{ __("ETEEAP Department") }}    
                                                                            </span>
                                                                            <span
                                                                                class="text-sm font-normal bg-yellow-400 p-[2px] rounded-sm text-white dark:text-gray-400">
                                                                                {{ \Carbon\Carbon::parse($dec->created_at)->format('h:i A') }}
                                                                            </span>
                                                                            <span
                                                                                class="text-sm font-normal bg-red-500 p-[2px] rounded-sm text-white dark:text-gray-400">re-submit</span>
                                                                        </div>
                                                                        <div
                                                                            class="flex justify-between w-full items-start bg-gray-50 dark:bg-gray-600 rounded-xl p-2">
                                                                            <div class="me-2">

                                                                                <span
                                                                                    class="flex items-center gap-2 mb-2 text-md font-medium text-gray-900 capitalize dark:text-white">
                                                                                    <i
                                                                                        class="fa-sharp fa-solid fa-files flex-shrink-0 text-2xl"></i>

                                                                                    {{ $dec->requirements }}
                                                                                </span>
                                                                                <span class="mt-2 text-red-700 mx-10">
                                                                                    <i class="fa-solid fa-circle-info"></i>
                                                                                    {{ $dec->description }}
                                                                                </span>
                                                                            </div>
                                                                            <div
                                                                                class="inline-flex self-center items-center">
                                                                                <button
                                                                                    class="reupload border inline-flex bg-blue-900 self-center items-center p-2 text-sm font-medium text-center text-white bg-gray-50 rounded-lg hover:bg-gray-100 focus:ring-4 focus:outline-none dark:text-white focus:ring-gray-50 dark:bg-gray-600 dark:hover:bg-gray-500 dark:focus:ring-gray-600"
                                                                                    type="button">
                                                                                    <i
                                                                                        class="fa-solid fa-envelope-open-text text-md"></i>
                                                                                </button>
                                                                            </div>
                                                                        </div>

                                                                    </div>
                                                                </div>

                                                            </div>

                                                        </span>

                                                    </div>
                                                </div>
                                            @endforeach
                                            

                                        </div>
                                    </div>

                                </li>



                            </ol>
                            {{-- <button class="text-white inline-flex w-full justify-center bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                            My Downloads
                            </button> --}}


                        </div>
                    @endforeach
                </div>
            </div>
        </div>

    </div>

    @include('department.modal.iframe')
    @section('scripts')
        <script>
            $(document).ready(function() {

                const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                // set the modal menu element
                const $requirement = document.getElementById('iframe-modal');
                const options = {
                    placement: 'right',
                    backdrop: 'static',
                    backdropClasses: 'bg-blue-900/50 dark:bg-blue-900/80 fixed inset-0 z-40',
                    closable: true,
                    onHide: () => {
                        console.log('modal is hidden');
                        $('#fileViewer').attr('src', ``)
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
                    id: 'iframe-modal',
                    override: true
                };
                const rq = new Modal($requirement, options, instanceOptions);

                $('.docx').on('click', function() {

                    let file = $(this).data('doc').replace(/^public\//, 'storage/')
                    let fileName = $(this).data('filename')
                    let subName = $(this).data('sub_name')
                    let user_id = $(this).data('user_id');

                    $('.btn-iframe-accepted').attr('data-user_id', user_id);
                    $('.btn-iframe-declined').attr('data-user_id', user_id);

                    $('#filename').text(fileName)
                    $('#filename-orig').val(fileName)
                    $('#subname').val(subName)
                    // console.log($(this).data('doc'))
                    $('#fileViewer').attr('src', `{{ asset('${file}') }}`)
                    rq.show()
                })
                $('.stClose').on('click', function() {
                    rq.hide()
                })


                //iframe accepted 
                $('#btn-iframe-accepted').click(function() {
                    let user_id = $(this).data('user_id')
                    let filename = $('#filename-orig').val()

                    let subname = $('#subname').val()
                    let description = $('#message').val();


                    var data = {
                        'user_id': user_id,
                        'type': 'accepted',
                        'description': description,
                        'subname': subname,
                        'filename': filename
                    }
                    console.log(data)
                    acceptOrReject('/evaluate', 'post', data)
                        .then(function(data) {
                            console.log(data)
                            if (data.status === 'success') {
                                $('#message').val('')
                                filename = ''
                                subname = ''
                                rq.hide()
                                Swal.fire({
                                    title: "Evaluated!",
                                    text: "Document evaluated successfully!",
                                    icon: "success",
                                    showConfirmButton: false,
                                    timer: 1000
                                });
                                setTimeout(() => {
                                    window.location.reload()
                                }, 1000);
                            } else {
                                rq.hide()
                                Swal.fire({
                                    title: "Evaluated!",
                                    text: `${data.message}`,
                                    icon: "error",
                                    showConfirmButton: false,
                                    timer: 1000
                                });
                            }
                            // Handle the data or perform additional actions if needed
                        })
                        .catch(function(errorMessage) {
                            console.error(errorMessage);
                            // Handle the error as needed
                        });

                })

                //iframe rejected
                $(document).on('click', '.btn-iframe-declined', function() {
                    let user_id = $(this).data('user_id')
                    let filename = $('#filename-orig').val()

                    let subname = $('#subname').val()
                    let description = $('#message').val();
                    var data = {
                        'user_id': user_id,
                        'type': 'declined',
                        'description': description,
                        'subname': subname,
                        'filename': filename
                    }
                    console.log(data)
                    acceptOrReject('/evaluate', 'post', data)
                        .then(function(data) {
                            console.log(data)
                            if (data.status === 'success') {
                                $('#message').val('')
                                filename = ''
                                subname = ''
                                rq.hide()
                                Swal.fire({
                                    title: "Evaluated!",
                                    text: "Document evaluated successfully!",
                                    icon: "success",
                                    showConfirmButton: false,
                                    timer: 1000
                                });
                                setTimeout(() => {
                                    window.location.reload()
                                }, 1000);
                            } else {
                                rq.hide()
                                Swal.fire({
                                    title: "Evaluated!",
                                    text: `${data.message}`,
                                    icon: "error",
                                    showConfirmButton: false,
                                    timer: 1000
                                });
                            }
                            // Handle the data or perform additional actions if needed
                        })
                        .catch(function(errorMessage) {
                            console.error(errorMessage);
                            // Handle the error as needed
                        });
                })

                // Function to fetch data
                function acceptOrReject(endpoint, type, params) {

                    return new Promise(function(resolve, reject) {
                        $.ajax({
                            url: endpoint,
                            type: type,
                            data: params,
                            dataType: 'json',
                            headers: {
                                'X-CSRF-TOKEN': csrfToken
                            },
                            success: function(data) {

                                resolve(data); // Resolve the Promise with the fetched data
                            },
                            error: function(error) {
                                console.error('Error fetching data:', error);
                                reject('Error fetching data: ' + error);
                            }
                        });
                    });
                }

            })
        </script>
    @endsection
</x-app-layout>
