<x-app-layout>
    <div class="mx-auto max-w-screen-2xl p-4 md:p-6 2xl:p-5">
        <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-2 mb-2">
            {{-- {{ count($forwardedDocuments) }} --}}
            @include('partials.header-card', ['ra'=> count($forwardedDocuments), 'acc'=>$accepted, 'dc'=>$declined, 'dept'=>$department])
        </div>
        

        <div class="flex justify-between mt-5 mb-5">
            <div class="flex">
                <h1 class="text-blue-900 mx-2 font-bold text-xl border-l-4 pl-2 dark:text-white">Applications </h1>
            </div>
            @include('partials.breadcrumb')
        </div>

        <div class="shadow-md sm:rounded-lg overflow-hidden">
            {{-- <table id="rejected-table"
                class="table activate-select dt-responsive nowrap w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
            </table> --}}

            <div class="sm:rounded-lg overflow-hidden px-2">
                <div class="relativew-full max-w-full max-h-full">
                    <div class="bg-white rounded-lg shadow dark:bg-gray-700">

                        @if (count($forwardedDocuments) !== 0)

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

                                <div class="p-4 md:p-5">
                                    <ol id="history-card"
                                        class="relative border-s border-gray-200 dark:border-gray-600 ms-3.5 mb-4 md:mb-5">
                                        <li class="shadow-md p-2 ms-8 grid grid-cols-1 lg:grid-cols-2 gap-2">
                                            <div>

                                                @php
                                                        $textColor = 'text-yellow-500';
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
                                                <div class="flex items-center mb-1">
                                                    <span data-document_id="{{ $forwarded->document_id }}"
                                                        class="ftd bg-blue-500 hover:bg-blue-700 hover:cursor-pointer text-white text-[14px] font-medium mr-2 px-2.5 py-2 rounded dark:bg-blue-900 dark:text-blue-300 ms-3">
                                                        Forward to <i
                                                            class="fa-sharp fa-solid fa-paper-plane-top text-[10px]"></i>
                                                    </span>
                                                    {{-- {{ $forwarded->user_id }} --}}
                                                    <span 
                                                        data-document_id="{{ $forwarded->document_id }}"
                                                        data-user_id="{{ $forwarded->user_id }}"
                                                        class="forInterview bg-blue-500 hover:bg-blue-700 hover:cursor-pointer text-white text-[14px] font-medium mr-2 px-2.5 py-2 rounded dark:bg-blue-900 dark:text-blue-300 ms-3">
                                                        For Interview <i
                                                            class="fa-sharp fa-solid fa-paper-plane-top text-[10px]"></i>
                                                    </span>
                                                    <span 
                                                        data-document_id="{{ $forwarded->document_id }}"
                                                        data-user_id="{{ $forwarded->user_id }}"
                                                        class="btn-reject bg-red-500 hover:bg-red-700 hover:cursor-pointer text-white text-[14px] font-medium mr-2 px-2.5 py-2 rounded dark:bg-blue-900 dark:text-blue-300 ms-3">
                                                        Reject Application <i
                                                            class="fa-sharp fa-solid fa-paper-plane-top text-[10px]"></i>
                                                    </span>
                                                    

                                                </div>
                                                <span class="font-bold">Comments</span>
                                                @if (count($comments) == 0)
                                                    <div class=" bg-white rounded-md p-2 flex items-center justify-center mt-4 h-28">
                                                        <h1 class="text-xl">No comments available.</h1>
                                                    </div>
                                                @endif
                                                @foreach ($comments as $comment)
                                                    {{-- {{ $comment }} --}}
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
                                                                                            <span class="mt-2 mx-10">
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
                                                                                    <div class="flex justify-between">
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
                            @endforeach
                        @else
                            <div
                                class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                                <h3 class="text-lg font-semibold text-blue-900 dark:text-white">
                                There are no applications to review at the moment.
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
    </div>

    @include('popup.documents')
    {{-- @include('popup.iframe') --}}
    @include('department.modal.iframe')
    @include('admin.modal.forward')
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

           
            $(document).ready(function() {
                const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

                const $requirementU = document.getElementById('select-modal');
                const $requirementI = document.getElementById('static-modal');
                const $requirement = document.getElementById('iframe-modal');
                const $forward = document.getElementById('forward-modal');

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
                // options with default values
                const optionsI = {
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

                const options2 = {
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
                    id: 'select-modal',
                    override: true
                };
                // instance options object
                const instanceOptionsI = {
                    id: 'static-modal',
                    override: true
                };
                const instanceOptions2 = {
                    id: 'iframe-modal',
                    override: true
                };
                // instance options object
                const instanceOptionsForward = {
                    id: 'forward-modal',
                    override: true
                };

                const dqu = new Modal($requirementU, options, instanceOptions);
                const Iqu = new Modal($requirementI, optionsI, instanceOptionsI);
                const rq = new Modal($requirement, options2, instanceOptions2);
                const fr = new Modal($forward, optionsFoward, instanceOptionsForward);
                // new open
                 // open the docx
                 $('.docx').on('click', function() {
                    // alert('dawdwa')
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

                    updateStatus(`/admin-update-status/${user_id}`)

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
                $('.stClose').on('click', function() {
                    rq.hide()
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
                        url: '/admin-forward',
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


                // open documents
                $(document).on('click', '.docsbtn', function() {
                    let user_id = $(this).data('user_id')

                    $('.btn-accept').attr('data-user_id', user_id)
                    $('.btn-reject').attr('data-user_id', user_id)
                    // alert(user_id)
                    fetchData(`/documents/${user_id}`)
                    updateStatus(`/documents-update/${user_id}`)
                })

                // open file
                $(document).on('click', '.list-data', function() {
                    let file = $(this).data('file').replace(/^public\//, 'storage/')
                    let fileName = $(this).data('filename')
                    let subName = $(this).data('sub_name')
                    let user_id = $(this).data('user_id');
                    // console.log(fileName, subName)
                    $('.btn-iframe-accepted').attr('data-user_id', user_id);
                    // $('.btn-iframe-accepted').attr('data-filename', fileName);
                    // $('.btn-iframe-accepted').attr('data-subname', subName);

                    $('.btn-iframe-declined').attr('data-user_id', user_id);
                    // $('.btn-iframe-declined').attr('data-filename', fileName);
                    // $('.btn-iframe-declined').attr('data-subname', subName);

                    $('#filename').text(fileName)
                    $('#filename-orig').val(fileName)
                    $('#subname').val(subName)

                    $('#fileViewer').attr('src', `{{ asset('${file}') }}`)
                    Iqu.show();
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
                    acceptOrReject('/checkedDocument', 'post', data)
                        .then(function(data) {
                            console.log(data)
                            if (data.status === 'success') {
                                $('#message').val('')
                                filename = ''
                                subname = ''
                                Iqu.hide()
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
                    acceptOrReject('/checkedDocument', 'post', data)
                        .then(function(data) {
                            console.log(data)
                            if (data.status === 'success') {
                                $('#message').val('')
                                Iqu.hide()
                            }
                            // Handle the data or perform additional actions if needed
                        })
                        .catch(function(errorMessage) {
                            console.error(errorMessage);
                            // Handle the error as needed
                        });
                })

                // btn for interview
                $(document).on('click', '.forInterview', function() {
                    var user_id = $(this).data('user_id');
                    var document_id = $(this).data('document_id');
                    var data = {
                        'user_id': user_id,
                        'type': 'accepted'
                    }
                    acceptOrReject('/accept', 'post', data)
                        .then(function(data) {
                            console.log(data)
                            if(data.status === 'success'){
                                setInterview(data.user_id, document_id)
                            }
                            // Handle the data or perform additional actions if needed
                        })
                        .catch(function(errorMessage) {
                            console.error(errorMessage);
                            // Handle the error as needed
                        });
                })

                // btn reject
                $(document).on('click', '.btn-reject', function() {
                    var user_id = $(this).data('user_id');
                    var data = {
                        'user_id': user_id,
                        'type': 'rejected'
                    }
                    acceptOrReject('/accept', 'post', data)
                        .then(function(data) {
                            console.log(data)
                            if(data.status === 'success'){
                                setTimeout(() => {
                                // if(result.value.refresh){
                                    window.location.reload()
                                // }
                                }, 1000);
                            }
                            // Handle the data or perform additional actions if needed
                        })
                        .catch(function(errorMessage) {
                            console.error(errorMessage);
                            // Handle the error as needed
                        });
                })

                // close modal
                $(document).on('click', '.seClose', function() {
                    dqu.hide();
                })
                $(document).on('click', '.stClose', function() {
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
                        success: function(data) {
                            // Handle the data as needed
                            console.log(data.documents[0].documents);
                            var lists = ''
                            var count = 0;
                            $('#doc_name').text(data.documents[0].name)

                            const fileNames = [
                                'loi', 'ce', 'cr', 'nce', 'hdt', 'f137_8', 'abcb', 'mc', 'nbc', 'tvid',
                                'ge', 'pc', 'rl', 'cgmc', 'cer',
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
                                    Object.entries(doc).filter(([key]) => fileNames.includes(
                                        key) && doc[key] !== null)
                                );
                                for (const key in filteredObject) {
                                    if (doc.hasOwnProperty(key)) {
                                        // console.log(key)

                                        // Create a mapping object
                                        const mapping = {};
                                        fileNames.forEach((fileName, index) => {
                                            mapping[fileName] = originalNames[index];
                                        });
                                        count++;
                                        lists += `
                                            <li class="list-data" data-user_id="${doc.user_id}" data-sub_name="${key}" data-filename="${mapping[key]}" data-file="${filteredObject[key]}" data-modal-target="select-modal">
                                                <input type="radio" id="job-${count}" name="job" value="job-1" class="hidden peer" required />
                                                <label for="job-${count}" class="inline-flex items-center justify-between w-full p-5 text-gray-900 bg-white border border-gray-200 rounded-lg cursor-pointer dark:hover:text-gray-300 dark:border-gray-500 dark:peer-checked:text-blue-500 peer-checked:border-blue-600 peer-checked:text-blue-600 hover:text-gray-900 hover:bg-gray-100 dark:text-white dark:bg-gray-600 dark:hover:bg-gray-500">                           
                                                    <div class="block">
                                                        <div class="w-full text-lg font-semibold">REQUIREMENTS - ${count}</div>
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
                        error: function(error) {
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
                        success: function(data) {
                            // Handle the data as needed
                            console.log(data);
                        },
                        error: function(error) {
                            console.error('Error fetching data:', error);
                        }
                    });
                }

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
                // setInterview()
                function setInterview(id, document_id) {
                    Swal.fire({
                        title: "Setup the interview",
                        html:
                            `<div class="border rounded-md p-3">
                                <div class="mb-2 hidden">
                                    <label for="user_id" class="text-left block mb-2 text-md font-bold text-gray-900 dark:text-white">Interviewer Name</label>
                                    <input type="text" id="documentID" value="${document_id}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" />
                                </div>
                                <div class="mb-2 hidden">
                                    <label for="user_id" class="text-left block mb-2 text-md font-bold text-gray-900 dark:text-white">Interviewer Name</label>
                                    <input type="text" id="user_id" value="${id}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" />
                                </div>
                               
                                <div class="mb-2 flex w-full gap-2">
                                    <div class="w-full">
                                        <label for="date" class="block text-left mb-2 text-md font-bold text-gray-900 dark:text-white">Date Interview</label>
                                        <input type="date" id="date" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" />
                                    </div>
                                    <div class="w-full">
                                        <label for="time" class="block text-left mb-2 text-md font-bold text-gray-900 dark:text-white">Time Interview</label>
                                        <input type="time" id="time" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" />    
                                    </div>
                                </div>
                                <div class="mb-2">
                                    <label for="address" class="block text-left mb-2 text-md font-bold text-gray-900 dark:text-white">Location:</label>
                                    <textarea id="address" rows="4" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Write details here..."></textarea>
                                </div>
                               
                            </div>`,
                        inputAttributes: {
                            autocapitalize: "off"
                        },
                        showCancelButton: true,
                        confirmButtonText: "Setup interview",
                        showLoaderOnConfirm: true,
                        allowOutsideClick: false,
                        preConfirm: async () => {
                            // var interviewer = $('#interviewer').val()
                            var date = $('#date').val()
                            var time = $('#time').val()
                            var address = $('#address').val()
                            // var details = $('#details').val()
                            var user_id = $('#user_id').val()
                            var document_id = $('#documentID').val()
                            // console.log(interviewer, date, time, address, details, user_id)
                            if(date == '' || time == '' || address == ''){
                                return Swal.showValidationMessage(`All field is required to fill`)
                            }

                            try {
                                // let data = {'user_id': user_id, 'interviewer': interviewer, 'date':date, 'time':time, 'address':address, 'message':message}
                                const response = await fetch(`{{ route('interview') }}`, {
                                    method: 'POST',
                                    headers: {
                                        'Content-Type': 'application/json',
                                        'X-CSRF-TOKEN': csrfToken
                                    },
                                    body: JSON.stringify({'document_id':document_id,'user_id': user_id, 'date':date, 'time':time, 'address':address}),
                                });

                                if (!response.ok) {
                                return Swal.showValidationMessage(`
                                    ${JSON.stringify(await response.json())}
                                    `);
                                }
                                return response.json();
                             
                            } catch (error) {
                                Swal.showValidationMessage(`
                                    Request failed: ${error}
                                `);
                            }
                        },
                        // allowOutsideClick: () => !Swal.isLoading()
                    }).then((result) => {
                        if (result.isConfirmed) {
                            console.log(result)
                            Swal.fire({
                                title: "Interview is successfully created!",
                                text: `${result.value.message}`,
                                icon: "success"
                            });

                            setTimeout(() => {
                                // if(result.value.refresh){
                                    window.location.reload()
                                // }
                            }, 3000);
                        }
                    });
                }
            })
        </script>
    @endsection
</x-app-layout>
