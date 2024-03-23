<x-app-layout>
    <div class="mx-auto max-w-screen-2xl p-4 md:p-6 2xl:p-5">

        <div class="mt-10">
            <div class="flex justify-between">
                <div class="flex">
                    <a href="{{ route('user-dashboard') }}" class="text-red-500 mx-2 font-bold pl-2 dark:text-white"><i class="fa-regular fa-arrow-left"></i> Back</a>
                    <h1 class="text-blue-900 mx-2 font-bold border-l-4 pl-2 dark:text-white">Application Status </h1>

                </div>
                @include('partials.breadcrumb')
            </div>

            <div class="shadow-xl rounded-md mt-4 relative z-0">

                <!--content -->
                <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                    
                    <!--body -->
                    <div class="p-4 md:p-5">
                        <ol id="history-card"
                            class="relative border-s border-gray-200 dark:border-gray-600 ms-3.5 mb-4 md:mb-5">

                            @foreach ($histories as $history)
                                @php
                                    $classNameBg = '';
                                @endphp
                                @switch($history->status)
                                    @case('rejected')
                                       @php
                                            $classNameBg = 'bg-red-500';
                                       @endphp
                                        @break
                                    @case('in-review')
                                       @php
                                            $classNameBg = 'bg-orange-400';
                                       @endphp
                                        @break
                                    @case('accepted')
                                       @php
                                            $classNameBg = 'bg-green-400';
                                       @endphp
                                        @break
                                
                                    @default
                                        @php
                                            $classNameBg = 'bg-yellow-400';
                                        @endphp
                                        @break
                                        
                                @endswitch
                                <li class="shadow-md p-2 mb-10 ms-8 grid grid-cols-1 lg:grid-cols-2 gap-2">
                                    <div>
                                        <span
                                            class="absolute flex items-center justify-center w-6 h-6 bg-gray-100 rounded-full -start-3.5 ring-8 ring-white dark:ring-gray-700 dark:bg-gray-600">
                                            <i class="fa-sharp fa-solid fa-circle w-2.5 h-2.5 text-red-500"></i>
                                        </span>
                                        <h3
                                            class="flex items-start mb-1 text-lg font-semibold text-blue-900 dark:text-white">
                                            ETEEAP APPLICATION
                                            <span
                                                class="{{ $classNameBg }} text-white text-sm font-medium mr-2 px-2.5 py-0.5 rounded dark:bg-blue-900 dark:text-blue-300 ms-3">
                                               {{ $history->status }}
                                            </span>
                                            <span
                                                class="bg-red-500 hover:bg-red-700 hover:cursor-pointer text-white text-sm font-medium mr-2 px-2.5 py-0.5 rounded dark:bg-blue-900 dark:text-blue-300 ms-3">
                                                Notify
                                            </span>
                                        </h3>
                                        <time
                                            class="block mb-3 text-sm font-normal leading-none text-blue-900 dark:text-gray-400"><span
                                                class="font-bold">Date :</span> {{ \Carbon\Carbon::parse($history->created_at)->format('Y-m-d') }}</time>
                                        <time
                                            class="block mb-3 text-sm font-normal leading-none text-blue-900 dark:text-gray-400"><span
                                                class="font-bold">Time :</span> {{ \Carbon\Carbon::parse($history->created_at)->format('h:i A') }}</time>
                                        <span
                                            class="block rounded-md p-2 mb-3 text-blue-900 text-md font-normal leading-none bg-gray-2 dark:text-gray-400">{{ $history->notes }}</span>
    
                                    </div>
    
                                    {{--  comments --}}
                                    <div class="border border-gray-2 rounded-md bg-gray-2 p-2 text-blue-900 w-full">
                                        <span class="font-bold">Comment's</span>
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
                                                                                    data-id="{{ $dec->id }}" data-document_id="{{ $dec->document_id }}" data-subname="{{ $dec->sub_name }}" data-document_name="{{ $dec->requirements }}"
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

                                                            {{-- reupload record --}}
                                                            {{-- {{ $dec->reupload }} --}}
                                                            @if (isset($dec->reupload))
                                                                @foreach ($dec->reupload as $reupload_doc)
                                                                    {{-- {{ $reupload_doc }} --}}
                                                                    <div class="bg-gray p-2 capitalize text-green-700 mb-2">
                                                                        <div class="flex justify-between">
                                                                            <span class="border rounded-md p-[5px] bg-gray text-green-500">re-uploaded</span>
                                                                            <span class="border rounded-md p-[5px] bg-gray text-green-500">{{ \Carbon\Carbon::parse($reupload_doc->created_at)->format('h:i A') }}</span>
                                                                        </div>
                                                                        <div class="flex items-center gap-2 my-2">
                                                                            <i class="fa-solid fa-file-check fa-xl"></i>
                                                                            <span class="text-blue-900">{{ $dec->requirements }}</span>
                                                                        </div>
                                                                        <div class="flex items-center gap-2 mx-15">
                                                                            <i class="fa-solid fa-circle-info"></i>
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
                            @endforeach
                            


                        </ol>
                        {{-- <button class="text-white inline-flex w-full justify-center bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                        My Downloads
                        </button> --}}


                    </div>
                </div>


            </div>

        </div>

    </div>
    @include('popup.comments')
    @section('scripts')
        <script>
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            $(document).ready(function(){
                const $comments = document.getElementById('comments-modal');

                // options with default values
                const optionComments = {
                    placement: 'bottom-right',
                    backdrop: 'static',
                    backdropClasses: 'bg-blue-900/50 dark:bg-blue-900/80 fixed inset-0 z-40',
                    closable: true,
                    onHide: () => {
                        console.log('modal is hidden');
                        $('#reuploadDocs').val('')
                        $('#reuploadComment').val('')
                        
                    },
                    onShow: () => {
                        console.log('modal is shown');
                    },
                    onToggle: () => {
                        console.log('modal has been toggled');
                    },
                };
                const instanceOptionsC = {
                    id: 'comments-modal',
                    override: true
                };

                const cm = new Modal($comments, optionComments, instanceOptionsC);

                $(document).on('click', '.reupload', function() {
                    let checkedId = $(this).data('id')
                    let documentId = $(this).data('document_id')
                    let checkedName = $(this).data('document_name')
                    let checkedSubName = $(this).data('subname')
                   
                    $('#reuploadLable').text('1. '+checkedName)
                    $('#checkedId').val(parseInt(checkedId))
                    $('#documentId').val(parseInt(documentId))
                    $('#checkedName').val(checkedName)
                    $('#checkedSubName').val(checkedSubName)
                    cm.show()
                })

                $(document).on('click', '.c-close', function(){
                    $('#reuploadLable').text('')
                    $('#reuploadDocs').text('')
                    $('#checkedId').val('')
                    $('#documentId').val('')
                    $('#checkedName').val('')
                    $('#checkedSubName').val('')
                    cm.hide()
                })
            })
        </script>
    @endsection
</x-app-layout>
