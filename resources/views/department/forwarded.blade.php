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
            <div class="relativew-full max-w-full max-h-full">
                <div class="bg-white rounded-lg shadow dark:bg-gray-700">
                    {{-- {{ $forwardedDocuments }} --}}
                    @if (isset($forwardedDocuments) && !empty($forwardedDocuments))
                        @foreach ($forwardedDocuments as $forwarded)
                            <div
                                class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                                <h3 class="text-lg font-semibold text-blue-900 dark:text-white">
                                    {{ $forwarded->user->name }} Application
                                </h3>
                                <button type="button"
                                    class="t-close text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm h-8 w-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                                    data-modal-toggle="timeline-modal">
                                    <i class="fa-sharp fa-solid fa-circle-user text-2xl text-blue-900"></i>
                                </button>
                            </div>

                            <div class="p-4 md:p-5 max-h-150 overflow-scroll">
                                <ol id="history-card"
                                    class="relative border-s border-gray-200 dark:border-gray-600 ms-3.5 mb-4 md:mb-5">
                                    <li class="shadow-md p-2 ms-8 grid grid-cols-1 lg:grid-cols-2 gap-2">
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
                                                    {{ $forwarded->status[0]->status }}
                                                </span>
                                                <span
                                                    class="bg-blue-500 hover:bg-blue-700 hover:cursor-pointer text-white text-sm font-medium mr-2 px-2.5 py-0.5 rounded dark:bg-blue-900 dark:text-blue-300 ms-3">
                                                    Date:
                                                    {{ \Carbon\Carbon::parse($forwarded->date)->format('Y-m-d') }}
                                                </span>
                                                <span
                                                    class="bg-blue-500 hover:bg-blue-700 hover:cursor-pointer text-white text-sm font-medium mr-2 px-2.5 py-0.5 rounded dark:bg-blue-900 dark:text-blue-300 ms-3">
                                                    Time:
                                                    {{ \Carbon\Carbon::parse($forwarded->date)->format('h:i A') }}
                                                </span>
                                            </h3>

                                            {{-- {{ $checked }} --}}
                                            <div class="rounded-md p-2">
                                                {{-- {{ $forwarded->checked }} --}}
                                                {{-- {{ $resubmitted }} --}}
                                                @foreach ($forwarded->checked as $resubDoc)
                                                    <div class="p-5 shadow-md border rounded-md mb-2 border-green-500">
                                                        <div class="flex items-center gap-2">
                                                            <i class="fa-solid fa-file-invoice text-4xl text-blue-900"></i>
                                                            <span
                                                                class="col-span-2 text-blue-900">{{ $resubDoc->requirements }}</span>

                                                        </div>
                                                        <div class="w-full flex justify-end gap-2">

                                                            <a class="border rounded-md bg-green-500 text-white p-1">
                                                                <i class="fa-solid fa-check"></i>
                                                                <span>Evaluated</span>
                                                            </a>
                                                            @php
                                                                $subname = $resubDoc->sub_name;
                                                                $path = $forwarded->$subname;
                                                                // echo $subname;
                                                            @endphp

                                                            @foreach ($resubmitted as $resubmit)
                                                                {{-- {{ $resubmit->reupload }} --}}
                                                                @if ($resubmit->sub_name === $subname)
                                                                    
                                                                    @foreach ($resubmit->reupload as $rr)
                                                                        @php
                                                                            $path = $rr->path;
                                                                        @endphp
                                                                    @endforeach
                                                                @endif
                                                            @endforeach
                                                            <a data-user_id="{{ $forwarded->user->id }}"
                                                                data-doc='{{ $path }}'
                                                                data-filename='{{ $resubDoc->requirements }}'
                                                                data-sub_name='{{ $resubDoc->sub_name }}'
                                                                class="docx border rounded-md bg-blue-500 hover:bg-blue-700 text-white p-1 hover:cursor-pointer">
                                                                <i class="fa-solid fa-eye"></i>
                                                                view document
                                                            </a>




                                                        </div>

                                                    </div>
                                                @endforeach




                                                {{-- @php
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
                                                    
                                                        @php
                                                            $borderClass = '';

                                                            foreach ($checked as $check) {
                                                                if ($columnKey[$key] === $check->sub_name) {
                                                                    $borderClass = 'border-green-500';
                                                                    if ($check->action !== 'accepted') {
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
                                                @endforeach --}}

                                            </div>
                                        </div>
                                    </li>
                                </ol>
                            </div>
                        @endforeach

                    @else
                        <div
                            class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                            <h3 class="text-lg font-semibold text-blue-900 dark:text-white">
                                There's no Application to review right now!
                            </h3>
                            <button type="button"
                                class="t-close text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm h-8 w-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                                data-modal-toggle="timeline-modal">
                                <i class="fa-sharp fa-solid fa-circle-user text-2xl text-blue-900"></i>
                            </button>
                        </div>
                    @endif
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
                // open the docx
                $('.docx').on('click', function() {

                    let file = $(this).data('doc').replace(/^public\//, 'storage/')
                    let fileName = $(this).data('filename')
                    let subName = $(this).data('sub_name')
                    let user_id = $(this).data('user_id');

                    // updateStatus(`/update-status/${user_id}`)

                    // $('.btn-iframe-accepted').attr('data-user_id', user_id);
                    // $('.btn-iframe-declined').attr('data-user_id', user_id);

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
            })
        </script>
    @endsection
</x-app-layout>
