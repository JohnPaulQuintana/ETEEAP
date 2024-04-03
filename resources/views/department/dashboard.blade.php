<x-app-layout>
    <div class="mx-auto max-w-screen-2xl p-4 md:p-6 2xl:p-5">
        <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-2 mb-2">
            {{-- {{ $forwardedDocuments }} --}}

            @include('partials.header-card', [
                'ra' =>
                    (isset($documents) ? count($documents) : 0) +
                    (isset($forwardedDocuments) ? count($forwardedDocuments) : 0),
                'acc' => $acceptedCount,
                'dc' => $declinedCount,
                'dept' => $departmentCount,
            ])
        </div>

        <div class="flex justify-between mb-5">
            <div class="flex">
                <h1 class="text-blue-900 mx-2 font-bold text-xl border-l-4 pl-2 dark:text-white">
                    {{ $department->department_name }} Dashboard </h1>

            </div>
            {{-- @include('partials.breadcrumb') --}}
        </div>

        <div class="mb-4 border-b border-gray-200 dark:border-gray-700">
            <ul class="flex flex-wrap -mb-px text-sm font-medium text-center" id="default-tab"
                data-tabs-toggle="#default-tab-content" role="tablist">

                <li class="me-2" role="presentation">
                    <button class="inline-block p-4 border-b-2 rounded-t-lg" id="applicant-tab"
                        data-tabs-target="#applicant" type="button" role="tab" aria-controls="applicant"
                        aria-selected="false">

                        {{ __('New Application') }} <span
                            class="text-red-500">{{ isset($documents) ? count($documents) : 0 }}</span>
                    </button>
                </li>
                <li class="me-2" role="presentation">
                    <button class="inline-block p-4 border-b-2 rounded-t-lg" id="returned-tab"
                        data-tabs-target="#returned" type="button" role="tab" aria-controls="returned"
                        aria-selected="false">

                        {{ __('Pending Application') }} <span
                            class="text-red-500">{{ isset($forwardedDocuments) ? count($forwardedDocuments) : '' }}</span>
                    </button>
                </li>
            </ul>
        </div>

        <div class="sm:rounded-lg overflow-hidden px-2">
            <div class="relativew-full max-w-full max-h-full">
                <div class="bg-white rounded-lg shadow dark:bg-gray-700">
                    <div id="default-tab-content">
                        {{-- applicant tab --}}
                        <div class="hidden p-4 rounded-lg bg-gray-50 dark:bg-gray-800" id="applicant" role="tabpanel"
                            aria-labelledby="applicant-tab">

                            <div class="mb-1  border-gray-200 dark:border-gray-700">
                                
                                <ul class="flex flex-wrap -mb-px text-sm font-medium text-center" id="applicant-tab"
                                    data-tabs-toggle="#applicant-tab-content" role="tablist">
                                    @if (isset($documents) && count($documents) > 0)
                                    
                                        @foreach ($documents as $document)
                                            <li class="me-2" role="presentation">
                                                <button data-tabname="{{ str_replace(' ', '', $document->name) }}"
                                                    class="inline-block p-4 rounded-t-lg tab-btn tab-{{ str_replace(' ', '', $document->name) }}"
                                                    id="{{ str_replace(' ', '', $document->name) }}-tab"
                                                    data-tabs-target="#{{ str_replace(' ', '', $document->name) }}"
                                                    type="button" role="tab"
                                                    aria-controls="{{ str_replace(' ', '', $document->name) }}"
                                                    aria-selected="false">
                                                    <i
                                                        class="fa-sharp fa-solid fa-circle-user text-2xl text-blue-900"></i>
                                                    {{ $document->name }}
                                                </button>
                                            </li>
                                        @endforeach
                                    @endif
                                </ul>
                            </div>

                            <div class="sm:rounded-lg overflow-hidden">
                                <!-- Main modal -->
                                <span class="mx-5"><span class="text-red-500">Note:</span> click the active name tab to change the selected application for evaluation</span>
                                @if (isset($documents) && count($documents) > 0)
                                    <div id="applicant-tab-content">
                                        @foreach ($documents as $document)
                                            {{-- {{ $document->documents[0] }} --}}
                                            <div data-card="{{ str_replace(' ', '', $document->name) }}"
                                                class="hidden p-2 rounded-lg bg-gray-50 dark:bg-gray-800 tabcard tabcard-{{ str_replace(' ', '', $document->name) }}"
                                                id="{{ str_replace(' ', '', $document->name) }}" role="tabpanel"
                                                aria-labelledby="{{ str_replace(' ', '', $document->name) }}-tab">

                                                <div class="p-1 md:p-2">
                                                    <ol id="history-card"
                                                        class="relative border-s border-gray-200 dark:border-gray-600 ms-3.5 mb-4 md:mb-5">


                                                        <li
                                                            class="shadow-md p-2 ms-8 grid grid-cols-1 lg:grid-cols-2 gap-2">


                                                            {{-- documents --}}
                                                            <div>
                                                                @php
                                                                    $textColor = 'text-yellow-500';
                                                                    switch (
                                                                        $document->documents[0]->status[0]->status
                                                                    ) {
                                                                        case 'rejected':
                                                                            $textColor = 'text-red-500';
                                                                            break;
                                                                        case 'accepted':
                                                                            $textColor = 'text-green-500';
                                                                            break;
                                                                        case 'pending':
                                                                            $textColor = 'text-red-500';
                                                                            break;

                                                                        default:
                                                                            # code...
                                                                            break;
                                                                    }
                                                                @endphp

                                                                <span
                                                                    class="absolute flex items-center justify-center w-6 h-6 bg-gray-100 rounded-full -start-3.5 ring-8 ring-white dark:ring-gray-700 dark:bg-gray-600">
                                                                    <i
                                                                        class="fa-sharp fa-solid fa-circle w-2.5 h-2.5 {{ $textColor }}"></i>
                                                                </span>
                                                                <h3
                                                                    class="flex items-start mb-1 text-lg font-semibold text-blue-900 dark:text-white">
                                                                    ETEEAP APPLICATION



                                                                    <span
                                                                        class="bg-gray {{ $textColor }} text-sm font-medium mr-2 px-2.5 py-0.5 rounded dark:bg-blue-900 dark:text-blue-300 ms-3">
                                                                        {{ $document->documents[0]->status[0]->status }}
                                                                    </span>
                                                                    <span
                                                                        class="bg-gray text-blue-900 text-sm font-medium mr-2 px-2.5 py-0.5 rounded dark:bg-blue-900 dark:text-blue-300 ms-3">
                                                                        Date:
                                                                        {{ \Carbon\Carbon::parse($document->documents[0]->created_at)->format('Y-m-d') }}
                                                                    </span>
                                                                    <span
                                                                        class="bg-gray text-blue-900 text-sm font-medium mr-2 px-2.5 py-0.5 rounded dark:bg-blue-900 dark:text-blue-300 ms-3">
                                                                        Time:
                                                                        {{ \Carbon\Carbon::parse($document->documents[0]->created_at)->format('h:i A') }}
                                                                    </span>
                                                                </h3>



                                                                {{-- {{ $checked }} --}}
                                                                <div class="rounded-md p-2">
                                                                    {{-- resubmited documents display first to view --}}
                                                                    {{-- {{ $document->resubmittedDocument }} --}}
                                                                    @if (isset($document->resubmittedDocument))
                                                                        @foreach ($document->resubmittedDocument as $resubDoc)
                                                                            <div
                                                                                class="p-5 shadow-md rounded-md mb-2 bg-slate-100">
                                                                                <div class="flex items-center gap-2">
                                                                                    <i
                                                                                        class="fa-solid fa-file-invoice text-4xl text-blue-900"></i>
                                                                                    <span
                                                                                        class="col-span-2 text-blue-900">{{ $resubDoc->requirements }}</span>

                                                                                </div>
                                                                                <div
                                                                                    class="w-full flex justify-end gap-2 mt-2">

                                                                                    <a class="rounded-md bg-white p-1">
                                                                                        <i
                                                                                            class="fa-solid fa-check text-green-500"></i>
                                                                                        <span>Evaluated</span>
                                                                                    </a>
                                                                                    <a class="rounded-md bg-white p-1">
                                                                                        <i
                                                                                            class="fa-solid fa-check text-green-500"></i>
                                                                                        <span>re-submitted</span>
                                                                                    </a>


                                                                                </div>

                                                                            </div>
                                                                        @endforeach
                                                                    @endif




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
                                                                    {{-- {{ $document->checked }} --}}
                                                                    @foreach ($originalName as $key => $doc)
                                                                        @if ($document->documents[0][$columnKey[$key]] !== null)
                                                                            {{-- {{ $count++ }} {{ isset($checked[$count++]->action) }} --}}
                                                                            @php
                                                                                $borderClass = '';

                                                                                foreach ($document->checked as $check) {
                                                                                    if (
                                                                                        $columnKey[$key] ===
                                                                                        $check->sub_name
                                                                                    ) {
                                                                                        $borderClass =
                                                                                            'border-green-500';
                                                                                        if (
                                                                                            $check->action !==
                                                                                            'accepted'
                                                                                        ) {
                                                                                            $borderClass =
                                                                                                'border-red-500';
                                                                                        }
                                                                                    }
                                                                                }

                                                                            @endphp
                                                                            <div
                                                                                class="p-5 shadow-md bg-slate-100 rounded-md mb-2">
                                                                                <div class="flex items-center gap-2">
                                                                                    <i
                                                                                        class="fa-solid fa-file-invoice text-4xl text-blue-900"></i>
                                                                                    <span
                                                                                        class="col-span-2 text-blue-900">{{ $doc }}</span>

                                                                                </div>
                                                                                <div
                                                                                    class="w-full flex justify-end gap-2">
                                                                                    @php
                                                                                        $isShow = 'hidden';
                                                                                        $isText = 'Evaluated';
                                                                                        $icons = 'fa-check';
                                                                                        $bgColor = 'bg-green-500';
                                                                                        foreach (
                                                                                            $document->checked
                                                                                            as $check
                                                                                        ) {
                                                                                            if (
                                                                                                $columnKey[$key] ===
                                                                                                $check->sub_name
                                                                                            ) {
                                                                                                $isShow = '';
                                                                                                if (
                                                                                                    $check->action !==
                                                                                                    'accepted'
                                                                                                ) {
                                                                                                    $isText =
                                                                                                        'Declined';
                                                                                                    $icons = 'fa-xmark';
                                                                                                    $bgColor =
                                                                                                        'bg-red-500';
                                                                                                }
                                                                                            }
                                                                                        }
                                                                                        // echo $icons;
                                                                                    @endphp

                                                                                    <a
                                                                                        class="rounded-md bg-white p-1 {{ $isShow }}">
                                                                                        <i
                                                                                            class="fa-solid {{ $icons }} {{ $icons === 'fa-xmark' ? 'text-red-500' : 'text-green-500' }}"></i>
                                                                                        {{ $isText }}</a>

                                                                                    <a data-user_id="{{ $document->id }}"
                                                                                        data-doc='{{ $document->documents[0][$columnKey[$key]] }}'
                                                                                        data-filename='{{ $doc }}'
                                                                                        data-sub_name='{{ $columnKey[$key] }}'
                                                                                        class="docx border rounded-md bg-white hover:text-blue-700 text-blue-500 p-1 hover:cursor-pointer">
                                                                                        <i class="fa-solid fa-eye"></i>
                                                                                        view
                                                                                        document</a>
                                                                                </div>

                                                                            </div>
                                                                        @endif
                                                                    @endforeach

                                                                </div>

                                                            </div>

                                                            {{--  comments --}}
                                                            {{-- {{ $document->documents[0] }} --}}
                                                            <div
                                                                class="border border-gray-2 rounded-md bg-gray-2 p-2 text-blue-900 w-full">
                                                                <span class="font-bold">Comments
                                                                    <span
                                                                        data-document_id={{ $document->documents[0]->id }}
                                                                        class="ftd bg-blue-500 hover:bg-blue-700 hover:cursor-pointer text-white text-[14px] font-medium mr-2 px-2.5 py-2 rounded dark:bg-blue-900 dark:text-blue-300 ms-3">
                                                                        Forward to <i
                                                                            class="fa-sharp fa-solid fa-paper-plane-top text-[10px]"></i>
                                                                    </span>

                                                                </span>
                                                                <div class="">
                                                                    {{-- list of resubmit docs --}}
                                                                    @foreach ($document->declined as $dec)
                                                                        <div class="text-wrap w-full mt-3">
                                                                            <div class="break-words">
                                                                                {{-- {{ $dec }} --}}
                                                                                <span
                                                                                    class="block text-left border rounded-md bg-white p-1 mb-2">

                                                                                    <div
                                                                                        class="flex items-start gap-2.5">
                                                                                        <div
                                                                                            class="flex flex-col w-full gap-1">
                                                                                            <div
                                                                                                class="flex flex-col w-full leading-1.5 p-4 border-gray-200 bg-gray-100 rounded-e-xl rounded-es-xl dark:bg-gray-700">
                                                                                                <div
                                                                                                    class="flex items-center space-x-2 rtl:space-x-reverse">
                                                                                                    <span
                                                                                                        class="text-sm font-semibold text-gray-900 p-1 dark:text-white">
                                                                                                        {{ __('ETEEAP Department') }}
                                                                                                    </span>
                                                                                                    <span
                                                                                                        class="text-sm font-normal bg-gray p-[2px] rounded-sm dark:text-gray-400">
                                                                                                        {{ \Carbon\Carbon::parse($dec->created_at)->format('h:i A') }}
                                                                                                    </span>
                                                                                                    <span
                                                                                                        class="text-sm font-normal bg-gray p-[2px] rounded-sm text-red-500 dark:text-gray-400">re-submit</span>
                                                                                                </div>
                                                                                                <div
                                                                                                    class="flex justify-between w-full items-start bg-gray-50 dark:bg-gray-600 rounded-xl p-2">
                                                                                                    <div
                                                                                                        class="me-2">

                                                                                                        <span
                                                                                                            class="flex items-center gap-2 mb-2 text-md font-medium text-gray-900 capitalize dark:text-white">
                                                                                                            <i
                                                                                                                class="fa-sharp fa-solid fa-files flex-shrink-0 text-2xl"></i>

                                                                                                            {{ $dec->requirements }}
                                                                                                        </span>
                                                                                                        <span
                                                                                                            class="mt-2 text-red-700 mx-10">
                                                                                                            <i
                                                                                                                class="fa-solid fa-circle-info"></i>
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

                                                                                    {{-- comments --}}
                                                                                    @if (isset($dec->reupload))
                                                                                        @foreach ($dec->reupload as $reupload_doc)
                                                                                            {{-- {{ $document }} --}}
                                                                                            <div
                                                                                                class="bg-gray p-2 capitalize mb-2">
                                                                                                <div
                                                                                                    class="flex justify-between">
                                                                                                    <span
                                                                                                        class="rounded-md p-[5px] bg-white">re-uploaded</span>
                                                                                                    <span
                                                                                                        class="rounded-md p-[5px] bg-white">{{ \Carbon\Carbon::parse($reupload_doc->created_at)->format('h:i A') }}</span>
                                                                                                </div>
                                                                                                <div
                                                                                                    class="flex items-center gap-2 my-2">
                                                                                                    <i
                                                                                                        class="fa-solid fa-file-check fa-xl"></i>
                                                                                                    {{-- let file = $(this).data('doc').replace(/^public\//, 'storage/')
                                                                                                   let fileName = $(this).data('filename')
                                                                                                   let subName = $(this).data('sub_name')
                                                                                                   let user_id = $(this).data('user_id'); --}}
                                                                                                    <span
                                                                                                        data-filename="{{ $dec->requirements }}"
                                                                                                        data-path="{{ $reupload_doc->path }}"
                                                                                                        data-sub_name="{{ $dec->sub_name }}"
                                                                                                        data-user_id="{{ $document->id }}"
                                                                                                        class="reuploadView text-blue-900 hover:cursor-pointer hover:text-blue-700">{{ $dec->requirements }}</span>
                                                                                                </div>
                                                                                                <div
                                                                                                    class="flex items-center gap-2 mx-15">
                                                                                                    <i
                                                                                                        class="fa-solid fa-circle-info text-red-700"></i>
                                                                                                    <span>{{ $reupload_doc->reupload_description }}</span>
                                                                                                </div>
                                                                                            </div>
                                                                                        @endforeach
                                                                                    @endif
                                                                                </span>

                                                                            </div>
                                                                        </div>
                                                                    @endforeach


                                                                </div>
                                                            </div>

                                                        </li>



                                                    </ol>



                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                @elseif (isset($forwardedDocuments) && count($forwardedDocuments) === 0 && isset($documents) && count($documents) === 0)
                                    <div id="default-tab-content">
                                        <div class="p-5">
                                            <h1 class="text-md">There are no pending applications today.</h1>
                                        </div>
                                    </div>
                                @else
                                    <div
                                        class="flex items-center justify-between p-4 md:p-5 rounded-t dark:border-gray-600">
                                        <h3 class="text-lg font-semibold dark:text-white">
                                            There are no applications to review at the moment.
                                        </h3>

                                    </div>
                                @endif
                            </div>

                        </div>

                        {{-- returned tab --}}
                        <div class="hidden p-4 rounded-lg bg-gray-50 dark:bg-gray-800" id="returned" role="tabpanel"
                            aria-labelledby="returned-tab">

                            <div class="mb-1 border-gray-200 dark:border-gray-700">
                                <ul class="flex flex-wrap -mb-px text-sm font-medium text-center" id="returned-tab"
                                    data-tabs-toggle="#returned-tab-content" role="tablist">

                                    @foreach ($forwardedDocuments as $fdName)
                                        <li class="me-2" role="presentation">
                                            <button 
                                                data-tabname="{{ str_replace(' ', '', $fdName->user->name) }}"
                                                class="inline-block p-4 rounded-t-lg tab-btn tab-{{ str_replace(' ', '', $fdName->user->name) }}"
                                                id="{{ str_replace(' ', '', $fdName->user->name) }}-tab"
                                                data-tabs-target="#{{ str_replace(' ', '', $fdName->user->name) }}"
                                                type="button" role="tab"
                                                aria-controls="{{ str_replace(' ', '', $fdName->user->name) }}"
                                                aria-selected="false">
                                                <i class="fa-sharp fa-solid fa-circle-user text-2xl text-blue-900"></i>
                                                {{ $fdName->user->name }}
                                            </button>

                                            
                                        </li>
                                    @endforeach
                                </ul>
                            </div>

                            <div class="sm:rounded-lg overflow-hidden">
                                @if (count($forwardedDocuments) !== 0)
                                    <div id="returned-tab-content">

                                        @foreach ($forwardedDocuments as $forwarded)
                                            <div class="hidden p-4 rounded-lg bg-gray-50 dark:bg-gray-800 tabcard tabcard-{{ str_replace(' ', '', $forwarded->user->name) }}"
                                                data-card="{{ str_replace(' ', '', $forwarded->user->name) }}"
                                                id="{{ str_replace(' ', '', $forwarded->user->name) }}"
                                                role="tabpanel"
                                                aria-labelledby="{{ str_replace(' ', '', $forwarded->user->name) }}-tab">


                                                <div class="p-4 md:p-5">

                                                    <ol id="history-card border"
                                                        class="relative border-s border-gray-200 dark:border-gray-600 ms-3.5 mb-4 md:mb-5">
                                                        <li
                                                            class="shadow-md p-2 ms-8 grid grid-cols-1 lg:grid-cols-2 gap-2">
                                                            <div>

                                                                <span
                                                                    class="absolute flex items-center justify-center w-6 h-6 bg-gray-100 rounded-full -start-3.5 ring-8 ring-white dark:ring-gray-700 dark:bg-gray-600">
                                                                    <i
                                                                        class="fa-sharp fa-solid fa-circle w-2.5 h-2.5 text-yellow-400"></i>
                                                                </span>

                                                                <h3
                                                                    class="flex items-start mb-1 text-lg font-semibold text-blue-900 dark:text-white">
                                                                    ETEEAP APPLICATION

                                                                    <span
                                                                        class="bg-gray text-yellow-400 text-sm font-medium mr-2 px-2.5 py-0.5 rounded dark:bg-blue-900 dark:text-blue-300 ms-3">
                                                                        {{ $forwarded->status[0]->status }}
                                                                    </span>
                                                                    <span
                                                                        class="bg-gray text-blue-900 text-sm font-medium mr-2 px-2.5 py-0.5 rounded dark:bg-blue-900 dark:text-blue-300 ms-3">
                                                                        Date:
                                                                        {{ \Carbon\Carbon::parse($forwarded->date)->format('Y-m-d') }}
                                                                    </span>
                                                                    <span
                                                                        class="bg-gray  text-blue-900 text-sm font-medium mr-2 px-2.5 py-0.5 rounded dark:bg-blue-900 dark:text-blue-300 ms-3">
                                                                        Time:
                                                                        {{ \Carbon\Carbon::parse($forwarded->date)->format('h:i A') }}
                                                                    </span>
                                                                </h3>

                                                                {{-- {{ $checked }} --}}
                                                                <div class="rounded-md p-2">
                                                                    {{-- {{ $forwarded->checked }} --}}
                                                                    {{-- {{ $resubmitted }} --}}
                                                                    @foreach ($forwarded->checked as $resubDoc)
                                                                        <div
                                                                            class="p-5 shadow-md rounded-md mb-2 bg-gray">
                                                                            <div class="flex items-center gap-2">
                                                                                <i
                                                                                    class="fa-solid fa-file-invoice text-4xl text-blue-900"></i>
                                                                                <span
                                                                                    class="col-span-2 text-blue-900">{{ $resubDoc->requirements }}</span>

                                                                            </div>
                                                                            <div class="w-full flex justify-end gap-2">

                                                                                <a
                                                                                    class="border rounded-md bg-white text-green-500 p-1">
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


                                                                </div>
                                                            </div>

                                                            {{-- comments --}}

                                                            <div class="bg-gray p-2">
                                                                <div class="flex justify-between items-center mb-1">
                                                                    <span class="font-bold">Comments
                                                                        <span
                                                                            data-document_id="{{ $forwarded->document_id }}"
                                                                            class="ftd bg-blue-500 hover:bg-blue-700 hover:cursor-pointer text-white text-[14px] font-medium mr-2 px-2.5 py-2 rounded dark:bg-blue-900 dark:text-blue-300 ms-3">
                                                                            Forward to <i
                                                                                class="fa-sharp fa-solid fa-paper-plane-top text-[10px]"></i>
                                                                        </span>

                                                                    </span>

                                                                </div>

                                                                @if (count($forwarded->comments) == 0)
                                                                    <div
                                                                        class=" bg-white rounded-md p-2 flex items-center justify-center mt-4 h-28">
                                                                        <h1 class="text-xl">No comments available</h1>
                                                                    </div>
                                                                @endif
                                                                @foreach ($forwarded->comments as $comment)
                                                                    {{-- {{ $forwarded->comments }} --}}
                                                                    <div class="rounded-md w-full">

                                                                        <div class="">
                                                                            <div class="text-wrap w-full mt-3">
                                                                                <div class="break-words">

                                                                                    <span
                                                                                        class="block text-left rounded-md bg-white p-1 mb-2">

                                                                                        <div
                                                                                            class="flex items-start gap-2.5">
                                                                                            <div
                                                                                                class="flex flex-col w-full gap-1">
                                                                                                <div
                                                                                                    class="flex flex-col w-full leading-1.5 p-4 border-gray-200 bg-gray-100 rounded-e-xl rounded-es-xl dark:bg-gray-700">
                                                                                                    <div
                                                                                                        class="flex items-center space-x-2 rtl:space-x-reverse">
                                                                                                        <span
                                                                                                            class="text-sm font-semibold text-gray-900 p-1 text-blue-900 dark:text-white">
                                                                                                            <i
                                                                                                                class="fa-sharp fa-solid fa-user flex-shrink-0 text-xl text-blue-900"></i>
                                                                                                            {{ $comment->name }}
                                                                                                        </span>
                                                                                                        <span
                                                                                                            class="text-sm font-normal bg-gray p-[2px] rounded-sm dark:text-gray-400">
                                                                                                            {{ \Carbon\Carbon::parse($comment->created_at)->format('Y-m-d') }}
                                                                                                        </span>
                                                                                                        <span
                                                                                                            class="text-sm font-normal bg-gray p-[2px] rounded-sm dark:text-gray-400">
                                                                                                            {{ \Carbon\Carbon::parse($comment->created_at)->format('h:i A') }}
                                                                                                        </span>

                                                                                                    </div>
                                                                                                    <div
                                                                                                        class="flex justify-between w-full items-start bg-gray-50 dark:bg-gray-600 rounded-xl p-2">
                                                                                                        <div
                                                                                                            class="me-2">

                                                                                                            @if ($comment->document_name !== null)
                                                                                                                <span
                                                                                                                    class="flex items-center gap-2 mb-2 text-md font-medium text-gray-900 capitalize dark:text-white">
                                                                                                                    <i
                                                                                                                        class="fa-sharp fa-solid fa-files flex-shrink-0 text-xl text-blue-900"></i>

                                                                                                                    {{ $comment->document_name }}
                                                                                                                </span>
                                                                                                            @endif
                                                                                                            <span
                                                                                                                class="mt-2 mx-10">
                                                                                                                <i
                                                                                                                    class="fa-solid fa-circle-info text-red-500"></i>
                                                                                                                {{ $comment->department_comment }}
                                                                                                            </span>
                                                                                                        </div>

                                                                                                    </div>

                                                                                                </div>
                                                                                            </div>

                                                                                        </div>

                                                                                        {{-- comments --}}
                                                                                        @if (isset($dec->reupload))
                                                                                            @foreach ($dec->reupload as $reupload_doc)
                                                                                                {{-- {{ $document }} --}}
                                                                                                <div
                                                                                                    class="bg-gray p-2 capitalize text-green-700 mb-2">
                                                                                                    <div
                                                                                                        class="flex justify-between">
                                                                                                        <span
                                                                                                            class="border rounded-md p-[5px] bg-gray text-green-500">re-uploaded</span>
                                                                                                        <span
                                                                                                            class="border rounded-md p-[5px] bg-gray text-green-500">{{ \Carbon\Carbon::parse($reupload_doc->created_at)->format('h:i A') }}</span>
                                                                                                    </div>
                                                                                                    <div
                                                                                                        class="flex items-center gap-2 my-2">
                                                                                                        <i
                                                                                                            class="fa-solid fa-file-check fa-xl"></i>
                                                                                                        {{-- let file = $(this).data('doc').replace(/^public\//, 'storage/')
                                                                    let fileName = $(this).data('filename')
                                                                    let subName = $(this).data('sub_name')
                                                                    let user_id = $(this).data('user_id'); --}}
                                                                                                        <span
                                                                                                            data-filename="{{ $dec->requirements }}"
                                                                                                            data-path="{{ $reupload_doc->path }}"
                                                                                                            data-sub_name="{{ $dec->sub_name }}"
                                                                                                            data-user_id="{{ $document->id }}"
                                                                                                            class="reuploadView text-blue-900 hover:cursor-pointer hover:text-blue-700">{{ $dec->requirements }}</span>
                                                                                                    </div>
                                                                                                    <div
                                                                                                        class="flex items-center gap-2 mx-15">
                                                                                                        <i
                                                                                                            class="fa-solid fa-circle-info"></i>
                                                                                                        <span>{{ $reupload_doc->reupload_description }}</span>
                                                                                                    </div>
                                                                                                </div>
                                                                                            @endforeach
                                                                                        @endif
                                                                                    </span>

                                                                                </div>
                                                                            </div>


                                                                        </div>
                                                                    </div>
                                                                @endforeach
                                                            </div>
                                                        </li>
                                                    </ol>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                @else
                                    <div
                                        class="flex items-center justify-between p-4 md:p-5 rounded-t dark:border-gray-600">
                                        <h3 class="text-lg font-semibold dark:text-white">
                                            No documents have been returned.
                                        </h3>

                                    </div>
                                @endif
                            </div>

                        </div>


                    </div>
                </div>
            </div>
        </div>


        {{-- {{ $documents }} --}}



    </div>

    @include('department.modal.iframe')
    @include('department.modal.forward')
    @section('scripts')
        <script>
            var message = @json(session('pop-message'));
            $(document).ready(function() {

                var activeTabs = localStorage.getItem('active-tabs')
                // alert(activeTabs)
               
                $(`.tabcard`).each(function() {
                    var ca = $(this).data('card')
                    console.log(ca, activeTabs)
                    if ($(this).hasClass(`tabcard-${activeTabs}`)) {
                        $(this).removeClass('hidden')
                    }else{
                        $(this).addClass('hidden')
                    }
                })

                $(`.tab-btn`).each(function() {
                    if ($(this).hasClass(`tab-${activeTabs}`)) {
                        // alert('yes')
                        $(this)
                            .removeClass(
                                `inline-block p-4 rounded-t-lg tab-btn tab-${activeTabs} dark:border-transparent text-gray-500 hover:text-gray-600 dark:text-gray-400 border-gray-100 hover:border-gray-300 dark:border-gray-700 dark:hover:text-gray-300`
                                )
                            .addClass(
                                `inline-block p-4 rounded-t-lg tab-btn tab-${activeTabs} text-blue-600 hover:text-blue-600 dark:text-blue-500 dark:hover:text-blue-500 border-blue-600 dark:border-blue-500`
                                )
                        $(this).attr('aria-selected', true);


                    } else {
                        // $(`.tabcard-${activeTabs}`).addClass('hidden')
                        // $(`.tabcard-${activeTabs}`).removeClass('hidden')
                        $(this).attr('aria-selected', false).removeClass('text-blue-600').addClass(
                            'text-gray-500');
                    }
                });
                if (message !== null) {
                    flashAlert(message)
                }



                const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                // set the modal menu element
                const $requirement = document.getElementById('iframe-modal');
                const $forward = document.getElementById('forward-modal');
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
                // forward
                const optionsFoward = {
                    placement: 'right',
                    backdrop: 'static',
                    backdropClasses: 'bg-blue-900/50 dark:bg-blue-900/80 fixed inset-0 z-40',
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
                    id: 'iframe-modal',
                    override: true
                };
                // instance options object
                const instanceOptionsForward = {
                    id: 'forward-modal',
                    override: true
                };
                const rq = new Modal($requirement, options, instanceOptions);
                const fr = new Modal($forward, optionsFoward, instanceOptionsForward);

                // open documents


                // open the docx
                $('.docx').on('click', function() {
                    let isReturning = $(this).attr('data-return_docs');
                    if (isReturning !== undefined && isReturning !== null) {
                        console.log(isReturning);

                    } else {
                        isReturning = false;
                        // Handle case when data-return_docs is undefined
                    }

                    let file = $(this).data('doc').replace(/^public\//, 'storage/')
                    let fileName = $(this).data('filename')
                    let subName = $(this).data('sub_name')
                    let user_id = $(this).data('user_id');

                    updateStatus(`/update-status/${user_id}`)

                    $('.btn-iframe-accepted').attr('data-user_id', user_id);
                    $('.btn-iframe-declined').attr('data-user_id', user_id);

                    $('#filename').text(fileName)
                    $('#filename-orig').val(fileName)
                    $('#subname').val(subName)
                    $('#isReturned').val(isReturning)
                    // console.log($(this).data('doc'))
                    $('#fileViewer').attr('src', `{{ asset('${file}') }}`)
                    rq.show()


                })

                // open the reupload docs
                $('.reuploadView').on('click', function() {
                    let reuploadfile = $(this).data('path').replace(/^public\//, 'storage/')
                    let reuploadfileName = $(this).data('filename')
                    let reuploadsubName = $(this).data('sub_name')
                    let reuploaduser_id = $(this).data('user_id');

                    $('.btn-iframe-accepted').attr('data-user_id', reuploaduser_id);
                    $('.btn-iframe-declined').attr('data-user_id', reuploaduser_id);

                    $('#filename').text(reuploadfileName)
                    $('#filename-orig').val(reuploadfileName)
                    $('#subname').val(reuploadsubName)
                    console.log(reuploaduser_id, reuploadfileName, reuploadsubName, reuploadfile)
                    $('#fileViewer').attr('src', `{{ asset('${reuploadfile}') }}`)
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
                    let isReturned = $('#isReturned').val();
                    var data = {
                        'isReturned': isReturned,
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

                // forward docs
                $(document).on('click', '.ftd', function() {
                    var di = $(this).data('document_id')
                    // alert(di)
                    // Include the CSRF token in the headers
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': csrfToken
                        }
                    });

                    $.ajax({
                        url: '/forward',
                        type: 'get', // Change the type if needed
                        dataType: 'json',
                        success: function(data) {
                            // Handle the data as needed
                            // console.log(data.departmentUsers);
                            var renderUsers =
                                `<option value="">Choose a department with associated user's</option>`
                            data.departmentUsers.forEach(users => {
                                console.log(users)
                                if (users.role === 1) {
                                    renderUsers += `
                                        <option class="p-2" value="${users.id}|ETEEAP Director">ETEEAP Director - ${users.name}</option>
                                    `
                                } else {
                                    renderUsers += `
                                        <option class="p-2" value="${users.id}|${users.department.department_name}">${users.department.department_name} - ${users.name}</option>
                                    `
                                }

                            });
                            $('.user_lists').html(renderUsers)
                            $('#forwarded_document_id').val(di)
                            // $('#forwarded_department_name').val(users.department.department_name)
                            fr.show();
                        },
                        error: function(error) {
                            console.error('Error fetching data:', error);
                        }
                    });
                })

                $('.frClose').on('click', function() {
                    $('#forwarded_document_id').val('')
                    fr.hide();
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
                        success: function(data) {
                            // Handle the data as needed
                            console.log(data);
                        },
                        error: function(error) {
                            console.error('Error fetching data:', error);
                        }
                    });
                }

                function flashAlert(message) {
                    Swal.fire({
                        title: "Application Forwarded Successfully!",
                        text: message,
                        icon: "success"
                    });
                }

                $(document).on('click', '.tab-btn', function() {
                    // alert($(this).data('tabname'))
                    localStorage.setItem('active-tabs', $(this).data('tabname'))
                    window.location.reload();
                })

            })
        </script>

        {{-- @if (Session::has('message')) --}}
        <script></script>
        {{-- @endif --}}
    @endsection
</x-app-layout>
