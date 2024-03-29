<x-app-layout>
    <div class="mx-auto max-w-screen-2xl p-4 md:p-6 2xl:p-5">
        <div class="flex justify-between mb-5">
            <div class="flex">
                <h1 class="text-blue-900 mx-2 font-bold text-xl border-l-4 pl-2 dark:text-white">
                    {{ $department->department_name }} Dashboard </h1>

            </div>
            @include('partials.breadcrumb')
        </div>

        <div class="mb-4 border-b border-gray-200 dark:border-gray-700">
            {{-- <span>Outgoing Docum</span> --}}
            <ul class="flex flex-wrap -mb-px text-sm font-medium text-center" id="default-tab"
                data-tabs-toggle="#default-tab-content" role="tablist">
                @if (count($documents) > 0)
                    @foreach ($documents as $document)
                        <li class="me-2" role="presentation">
                            <button class="inline-block p-4 border-b-2 rounded-t-lg"
                                id="{{ str_replace(' ', '', $document->owner[0]->name) }}-tab"
                                data-tabs-target="#{{ str_replace(' ', '', $document->owner[0]->name) }}" type="button"
                                role="tab" aria-controls="{{ str_replace(' ', '', $document->owner[0]->name) }}"
                                aria-selected="false">
                                <i class="fa-sharp fa-solid fa-circle-user text-2xl text-blue-900"></i>
                                {{ $document->owner[0]->name }}
                            </button>
                        </li>
                    @endforeach
                @endif
            </ul>
        </div>

        <div class="sm:rounded-lg overflow-hidden px-2">
            <div class="relativew-full max-w-full max-h-full">
                <div class="bg-white rounded-lg shadow dark:bg-gray-700">

                    @if (count($documents) !== 0)
                        <div id="default-tab-content">

                            @foreach ($documents as $forwarded)
                                <div class="hidden p-4 rounded-lg bg-gray-50 dark:bg-gray-800"
                                    id="{{ str_replace(' ', '', $forwarded->owner[0]->name) }}" role="tabpanel"
                                    aria-labelledby="{{ str_replace(' ', '', $forwarded->owner[0]->name) }}-tab">


                                    <div class="p-4 md:p-5">

                                        <ol id="history-card border"
                                            class="relative border-s border-gray-200 dark:border-gray-600 ms-3.5 mb-4 md:mb-5">
                                            <li class="shadow-md p-2 ms-8 grid grid-cols-1 lg:grid-cols-2 gap-2">
                                                <div>
                                                    @php
                                                    $textColor = 'text-yellow-400';
                                                    switch ($forwarded->status[0]->status) {
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
                                                            <div class="p-5 shadow-md rounded-md mb-2 bg-gray">
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
                                                                    {{-- <a data-user_id="{{ $forwarded->user->id }}"
                                                                        data-doc='{{ $path }}'
                                                                        data-filename='{{ $resubDoc->requirements }}'
                                                                        data-sub_name='{{ $resubDoc->sub_name }}'
                                                                        class="docx border rounded-md bg-blue-500 hover:bg-blue-700 text-white p-1 hover:cursor-pointer">
                                                                        <i class="fa-solid fa-eye"></i>
                                                                        view document
                                                                    </a> --}}




                                                                </div>

                                                            </div>
                                                        @endforeach


                                                    </div>
                                                </div>

                                                {{-- comments --}}

                                                <div class="bg-gray p-2">
                                                    <div class="flex justify-between items-center mb-1">
                                                        <span class="font-bold">Comment's
                                                            {{-- <span data-document_id="{{ $forwarded->document_id }}"
                                                                class="ftd bg-blue-500 hover:bg-blue-700 hover:cursor-pointer text-white text-[14px] font-medium mr-2 px-2.5 py-2 rounded dark:bg-blue-900 dark:text-blue-300 ms-3">
                                                                Forward to <i
                                                                    class="fa-sharp fa-solid fa-paper-plane-top text-[10px]"></i>
                                                            </span> --}}

                                                        </span>

                                                    </div>

                                                    @if (count($forwarded->comments) == 0)
                                                        <div
                                                            class=" bg-white rounded-md p-2 flex items-center justify-center mt-4 h-28">
                                                            <h1 class="text-xl">No comment's available</h1>
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

                                                                            <div class="flex items-start gap-2.5">
                                                                                <div class="flex flex-col w-full gap-1">
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
                                                                                            <div class="me-2">

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
                                                                                            {{-- <div
                                                                                class="inline-flex self-center items-center">
                                                                                <button
                                                                                    class="reupload border inline-flex bg-blue-900 self-center items-center p-2 text-sm font-medium text-center text-white bg-gray-50 rounded-lg hover:bg-gray-100 focus:ring-4 focus:outline-none dark:text-white focus:ring-gray-50 dark:bg-gray-600 dark:hover:bg-gray-500 dark:focus:ring-gray-600"
                                                                                    type="button">
                                                                                    <i
                                                                                        class="fa-solid fa-envelope-open-text text-md"></i>
                                                                                </button>
                                                                            </div> --}}
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
                                {{-- <div class="hidden p-4 rounded-lg bg-gray-50 dark:bg-gray-800" id="dashboard" role="tabpanel" aria-labelledby="dashboard-tab">
                                <p class="text-sm text-gray-500 dark:text-gray-400">This is some placeholder content the <strong class="font-medium text-gray-800 dark:text-white">Dashboard tab's associated content</strong>. Clicking another tab will toggle the visibility of this one for the next. The tab JavaScript swaps classes to control the content visibility and styling.</p>
                            </div>
                            <div class="hidden p-4 rounded-lg bg-gray-50 dark:bg-gray-800" id="settings" role="tabpanel" aria-labelledby="settings-tab">
                                <p class="text-sm text-gray-500 dark:text-gray-400">This is some placeholder content the <strong class="font-medium text-gray-800 dark:text-white">Settings tab's associated content</strong>. Clicking another tab will toggle the visibility of this one for the next. The tab JavaScript swaps classes to control the content visibility and styling.</p>
                            </div>
                            <div class="hidden p-4 rounded-lg bg-gray-50 dark:bg-gray-800" id="contacts" role="tabpanel" aria-labelledby="contacts-tab">
                                <p class="text-sm text-gray-500 dark:text-gray-400">This is some placeholder content the <strong class="font-medium text-gray-800 dark:text-white">Contacts tab's associated content</strong>. Clicking another tab will toggle the visibility of this one for the next. The tab JavaScript swaps classes to control the content visibility and styling.</p>
                            </div> --}}
                            @endforeach
                        </div>

                        {{-- <div id="default-tab-content"> --}}

                        {{-- </div> --}}
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
</x-app-layout>
