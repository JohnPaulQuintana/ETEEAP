<x-app-layout>
    @section('links')
        <style>
            .backdrop {
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background-color: rgba(0, 0, 0, 0.5);
                /* semi-transparent black */
                z-index: 9998;
                /* lower z-index to appear behind the popup */
            }

            .add_user_modal,
            .edit_user_modal,
            .delete_user_modal,
            .endorse_user_modal{
                position: fixed;

                top: 50%;
                left: 50%;
                transform: translate(-50%, -50%);
                background-color: white;
                padding: 20px;
                border: 2px solid #ccc;
                box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
                z-index: 9999;
                transition: 3s ease-in-out;
                /* higher z-index to appear above the backdrop */
            }
        </style>
    @endsection
    <div class="mx-auto max-w-screen-2xl p-4 md:p-6 2xl:p-5">
        <div class="flex justify-between mb-5">
            <div class="flex items-center">
                <span class="d_back border px-2 py-1 hover:cursor-pointer hover:bg-slate-200">
                    <i class="fa-solid fa-chevrons-left text-red-700 font-bold"></i>
                </span>
                <h1 class="text-blue-900 mx-2 font-bold text-xl border-l-4 pl-2 dark:text-white">
                    Application Details</h1>

            </div>
        </div>

        <div class="mb-4 border-b border-gray-200 dark:border-gray-700">

        </div>

        <div class="sm:rounded-lg overflow-hidden px-2">
            <div class="relative w-full max-w-full max-h-full">
                <div class="bg-white rounded-lg shadow dark:bg-gray-700 px-2 p-5">

                    <div class="grid grid-cols-2 gap-1"> <!-- Add overflow-x-auto class here -->

                        <div class="border border-dotted p-2 relative">
                            <span class="absolute top-[-12px] bg-white font-bold">Applicant Information</span>
                            <div class="mt-2 px-2">
                                <span>Applicant ID/No. : </span>
                                <span id="d_id" class="text-blue-900">XXXX2202020</span>
                            </div>
                            <div class="mt-2 px-2">
                                <span>Name : </span>
                                <span id="d_name" class="text-blue-900 capitalize"></span>
                            </div>
                            <div class="mt-2 px-2">
                                <span>Email : </span>
                                <span id="d_email" class="text-blue-900 capitalize" style="text-transform: lowercase;"></span>
                            </div>
                            <div class="mt-2 px-2">
                                <span>Course Applied : </span>
                                <span id="d_course_applied" class="text-blue-900 capitalize"></span>
                            </div>
                            <div class="mt-2 px-2">
                                <span>Application Status : </span>
                                <span id="d_status" class="text-blue-900 capitalize"></span>
                            </div>

                            {{-- comment --}}
                            <div class="border rounded-sm p-2 mt-2">

                                <div class="mb-1 border-b border-gray-200 dark:border-gray-700">
                                    <ul class="flex flex-wrap -mb-px text-sm font-medium text-center" id="message-tab"
                                        data-tabs-toggle="#message-tab-content" role="tablist">
                                        @if (Auth::user()->isReceiver)
                                            <li class="me-2" role="presentation">
                                                <button class="inline-block p-2 border-b-2 rounded-t-lg"
                                                    id="internal-tab" data-tabs-target="#internal" type="button"
                                                    role="tab" aria-controls="internal"
                                                    aria-selected="false">Appicant Message</button>
                                            </li>
                                        @endif


                                        <li class="me-2" role="presentation">
                                            <button
                                                class="inline-block p-2 border-b-2 rounded-t-lg hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300"
                                                id="external-tab" data-tabs-target="#external" type="button"
                                                role="tab" aria-controls="external" aria-selected="false">Internal Message</button>
                                        </li>

                                        <li class="me-2">
                                            <button data-type="under-review"
                                                class="under-review-tabs tabs-btn inline-block p-2 border rounded-t-lg text-orange-400 hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300"
                                                type="button">Under Review</button>
                                        </li>

                                        <li class="me-2 rejected-tabs">
                                            <button data-type="rejected"
                                                class="rejected-tabs tabs-btn inline-block p-2 border rounded-t-lg text-red-500 hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300"
                                                type="button">Rejected</button>
                                        </li>

                                        <li class="me-2 on-hold-tabs">
                                            <button data-type="on-hold"
                                                class="on-hold-tabs tabs-btn inline-block p-2 border rounded-t-lg text-red-500 hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300"
                                                type="button">On Hold</button>
                                        </li>
                                        {{-- {{ Auth::user()->end_user }} --}}
                                        @if (Auth::user()->end_user)
                                            <li class="me-2 approved-tabs">
                                                <button data-type="accepted"
                                                    class="approved-tabs tabs-btn inline-block p-2 border rounded-t-lg text-blue-700 hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300"
                                                    type="button">Approved</button>
                                            </li>
                                        @endif
                                        

                                    </ul>
                                </div>

                                <div id="message-tab-content">
                                    {{-- internal --}}
                                    @if (Auth::user()->isReceiver)
                                        <div class="hidden p-2 rounded-lg bg-gray-50 dark:bg-gray-800" id="internal"
                                            role="tabpanel" aria-labelledby="internal-tab">
                                            <div
                                                class="border border-dashed mt-2 p-2 flex flex-col gap-3 w-full h-[150px] overflow-y-auto">

                                                <div
                                                    class="internal-messages flex flex-col justify-start items-start gap-4">

                                                </div>

                                            </div>
                                            <div class="">
                                                <form action="{{ route('eteeap.internal') }}" method="post">
                                                    @csrf
                                                    <input type="text" name="message_type" value="internal"
                                                        class="hidden">
                                                    <input type="number" name="user_document_id" id="u_d_id"
                                                        value="" class="hidden">
                                                    <input type="number" name="user_id" id="u_id" value=""
                                                        class="hidden">
                                                    <div class="flex justify-between items-center mt-2">
                                                        <span class="text-blue-700">Action Required : </span>
                                                        <span>
                                                            <select name="action_required" id="action_required"
                                                                class="w-[100%] h-8 text-[12px] py-0 rounded-md">
                                                                <option value="">Select action</option>
                                                                <option value="Additional Documents Required">Additional
                                                                    Documents Required</option>
                                                                <option value="Applicant Response Needed">Applicant
                                                                    Response Needed</option>
                                                            </select>
                                                        </span>
                                                    </div>

                                                    <div class="mt-2">
                                                        <label for="default-search"
                                                            class="mb-2 text-sm font-medium text-gray-900 sr-only dark:text-white">message</label>
                                                        <div class="relative">
                                                            <div
                                                                class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">

                                                                <i
                                                                    class="fa-solid fa-envelope-circle-check w-4 h-4 text-gray-500 dark:text-gray-400 text-[20px]"></i>
                                                            </div>
                                                            <input type="text" id="message" name="message"
                                                                class="block w-full p-4 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                                                placeholder="Type your message here"
                                                                required />
                                                            <button type="submit"
                                                                class="text-white absolute end-2.5 bottom-2.5 bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-4 py-2 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                                                                <i class="fa-solid fa-paper-plane-top text-[16px]"></i>
                                                            </button>
                                                        </div>
                                                        {{-- <input type="text" name="message" id="message" class="col-span-2 rounded-md" placeholder="Type your message here">
                                                        <button type="submit" class="col-start-3"><i class="fa-solid fa-paper-plane-top text-xl border p-2 rounded-md text-blue-700 hover:text-blue-800 hover:cursor-pointer"></i></button> --}}
                                                    </div>

                                                </form>

                                            </div>
                                        </div>
                                    @endif
                                    {{-- external --}}
                                    <div class="p-4 rounded-lg bg-gray-50 dark:bg-gray-800" id="external"
                                        role="tabpanel" aria-labelledby="external-tab">
                                        <div
                                            class="border border-dashed mt-2 p-2 flex flex-col gap-3 w-full h-[150px] overflow-y-auto">

                                            <div
                                                class="external-messages flex flex-col justify-start items-start gap-4">

                                                <div class="bg-slate-100 rounded-md px-2 w-full">
                                                    <span
                                                        class="flex justify-between items-center text-[12px] font-bold text-blue-900">
                                                        ETEEAP Department
                                                        <span class="text-[12px] text-blue-900">
                                                            2024-09-03 12:30 AM
                                                        </span>
                                                    </span>
                                                    <span
                                                        class="block mt-[-2px] tracking-wider text-[15px] text-slate-800">
                                                        <i class="fa-solid fa-chevrons-right text-[10px]"></i>
                                                        hello there this is the default message
                                                    </span>
                                                    <span
                                                        class="block mt-[-2px] tracking-wider text-[15px]  text-red-700">
                                                        <i
                                                            class="${msg.action_required != null ? 'fa-solid fa-chevrons-right text-[10px]' : ''} "></i>
                                                        no action required

                                                    </span>
                                                </div>

                                            </div>

                                        </div>
                                        <div class="">
                                            <form action="{{ route('eteeap.internal') }}" method="post">
                                                @csrf
                                                <input type="text" name="message_type" value="external"
                                                    class="hidden">
                                                <input type="number" name="user_document_id" id="e_u_d_id"
                                                    value="" class="hidden">
                                                <input type="number" name="user_id" id="e_u_id" value=""
                                                    class="hidden">
                                                <div class="flex justify-between items-center mt-2">
                                                    <span class="text-blue-700">Action Required : </span>
                                                    <span>
                                                        <select name="action_required" id="e_action_required"
                                                            class="w-[100%] h-8 text-[12px] py-0 rounded-md">
                                                            <option value="">Select action</option>
                                                            <option value="Additional Documents Required">Additional
                                                                Documents Required</option>
                                                            <option value="Applicant Response Needed">Applicant
                                                                Response Needed</option>
                                                        </select>
                                                    </span>
                                                </div>

                                                <div class="mt-2">
                                                    <label for="default-search"
                                                        class="mb-2 text-sm font-medium text-gray-900 sr-only dark:text-white">message</label>
                                                    <div class="relative">
                                                        <div
                                                            class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">

                                                            <i
                                                                class="fa-solid fa-envelope-circle-check w-4 h-4 text-gray-500 dark:text-gray-400 text-[20px]"></i>
                                                        </div>
                                                        <input type="text" id="e_message" name="message"
                                                            class="block w-full p-4 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                                            placeholder="Type your message here" required />
                                                        <button type="submit"
                                                            class="text-white absolute end-2.5 bottom-2.5 bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-4 py-2 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                                                            <i class="fa-solid fa-paper-plane-top text-[16px]"></i>
                                                        </button>
                                                    </div>
                                                    {{-- <input type="text" name="message" id="message" class="col-span-2 rounded-md" placeholder="Type your message here">
                                                        <button type="submit" class="col-start-3"><i class="fa-solid fa-paper-plane-top text-xl border p-2 rounded-md text-blue-700 hover:text-blue-800 hover:cursor-pointer"></i></button> --}}
                                                </div>

                                            </form>

                                        </div>
                                    </div>

                                </div>

                                <div>
                                    <form action="#" method="post">
                                        @csrf
                                        <input type="button" id="endorse_btn" data-id="{{ $id }}"
                                            value="Endorse"
                                            class="border w-full p-2 rounded-md bg-blue-700 hover:bg-blue-800 hover:cursor-pointer text-white">
                                    </form>
                                </div>
                            </div>
                        </div>

                        <div class="border p-2 relative">
                            <span class="absolute top-[-12px] bg-white font-bold">Applicant Document's</span>
                            <div class="mt-2">
                                <iframe id="fileOpener" class="flex justify-center items-center" src=""
                                    width="100%" height="500px" frameborder="0">

                                </iframe>
                                <div class="flex justify-between items-center">
                                    <span id="d_title" class="w-[60%] text-[12px]">Document Name</span>
                                    <div>
                                        <button id="prevButton"
                                            class="bg-blue-900 text-white rounded-md px-2 hover:bg-blue-800 hover:cursor-pointer"
                                            type="button">
                                            <i class="fa-solid fa-chevrons-left"></i>
                                            Back
                                        </button>
                                        <span
                                            class="font-bold px-2 border rounded-md border-dotted text-blue-900 max-index">8</span>
                                        <button id="nextButton"
                                            class="bg-blue-900 text-white rounded-md px-2 hover:bg-blue-800 hover:cursor-pointer"
                                            type="button">
                                            <i class="fa-solid fa-chevrons-right"></i>
                                            Next
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
    @include('department.modal.endorse')
    @section('scripts')
        <script>
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            let application = @json($documentsArray);
            let myID = @json($myID);
            // let users = @json(Auth::user());
            // console.log(application)
            let externalMsg = @json($externalMessages);
            // console.log(externalMsg)
            $(document).ready(function() {
                // if forwarded to another dept
                // console.log(application.forwarded_to[0].receiver_id)
                
                
                if (myID !== application.forwarded_to[0].receiver_id || application.status[0].status === 'rejected' || application.status[0].status === 'accepted') {
                    $('#endorse_btn').attr('hidden', true);
                    $('.tabs-btn').addClass('hidden');
                    
                } else {
                    $('#endorse_btn').removeAttr('hidden');
                    $('.tabs-btn').removeClass('hidden');
                    $('.approved-tabs').removeClass('hidden')
                }

                switch (application.status[0].status) {
                    case 'on-hold':
                        $('.approved-tabs').addClass('hidden')
                        $('.on-hold-tabs').addClass('hidden')
                        break;
                    case 'under-review':
                        $('.under-review-tabs').addClass('hidden')
                        break;
                
                    default:
                        break;
                }
                

                $('#d_id').text(uniqueId(application.user_id))

                // Get only the document fields
                var documentFields = filterDocuments(application);
                var keys = Object.keys(documentFields);
                var currentIndex = 0;
                var maxIndex = keys.length;
                // Initial load
                loadIframe(currentIndex, keys, documentFields[keys[currentIndex]], maxIndex, application);

                //init external
                externalMessages(externalMsg)
                // Next button click event
                $('#nextButton').click(function() {

                    if (currentIndex < keys.length - 1) {
                        currentIndex++;
                        maxIndex--;
                    }
                    loadIframe(currentIndex, keys, documentFields[keys[currentIndex]], maxIndex, application);
                });

                // Previous button click event
                $('#prevButton').click(function() {


                    if (currentIndex > 0 && maxIndex < keys.length) {
                        currentIndex--;
                        // currentIndex = 0;
                        maxIndex++;

                    }
                    loadIframe(currentIndex, keys, documentFields[keys[currentIndex]], maxIndex, application);
                });

                $('.d_back').click(function() {
                    window.location.href = "/eteeap-dashboard"
                })


                // endorse
                $('#endorse_btn').click(function() {
                    // alert($(this).data('id'))
                    let id = $(this).data('id');
                    let departmentRender = `
                            <option data-role="default" value="">Available department</option>
                            
                        `
                    // <option data-role="director" value="0">ETEEAP Director</option>
                    let departmentUserRender = `
                        <option data-role="default" value="">Available user</option>
                        
                    `
                    // <option data-role="director" value="1">Director</option>
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': csrfToken
                        }
                    });

                    $.ajax({
                        url: `/eteeap-endorse/${id}`,
                        type: 'get', // Change the type if needed
                        success: function(data) {
                            // Handle the data as needed
                            console.log(data.departmentWithUsers);
                            data.departmentWithUsers.forEach(dept => {
                                // console.log(dept.user.length)
                                departmentRender += `
                                    <option data-role="${dept.department_name}" value="${dept.id}">${dept.department_name}</option>
                                `
                                if (dept.user.length > 0) {
                                    dept.user.forEach(user => {
                                        departmentUserRender += `
                                            <option data-role="${dept.department_name}" value="${user.id}">${user.name}</option>
                                        `
                                    });

                                } else {
                                    departmentUserRender += `
                                            <option value="">There is no users available</option>
                                        `
                                }
                            });



                            $('#endorse_department').html(departmentRender)
                            $('#endorse_users').html(departmentUserRender)
                            $('#endorse_department_id').val(parseInt(id))

                            $('#endorse_users option:not([data-role="default"])').hide();
                        },
                        error: function(error) {
                            console.error('Error fetching data:', error);
                        }
                    });

                    $('.endorse_user_modal').removeClass('hidden')
                    $('.backdrop').removeClass('hidden')
                })

                //on chnage for select
                $('#endorse_department').on('change', function() {
                    var selectedOption = $(this).find('option:selected');
                    var selectedValue = selectedOption.data('role');
                    // Do something with the selected value
                    console.log("Selected value:", selectedValue);
                    // Filter the options based on the selected role
                    // if (selectedValue === 'director') {
                    //     $('#endorse_users option[data-role="director"]').show();
                    //     $('#endorse_users option:not([data-role="director"])').hide();
                    // } else
                    if (selectedValue === 'default') {
                        $('#endorse_users option[data-role="default"]').show();
                        $('#endorse_users option:not([data-role="default"])').hide();
                    } else {
                        // Remove the selected attribute from all options
                        // Show all options and remove the selected attribute from all options
                        $('#endorse_users option').show();
                        $(`#endorse_users option:not([data-role="${selectedValue}"])`).hide();
                    }

                });

                $('.tabs-btn').click(function() {
                    // alert($(this).data('id'))
                    // var user_id = $(this).data('user_id');
                    var user_id = $(this).data('user_id');
                    var document_id = $(this).data('id');
                    var type = $(this).data('type')
                    var data = {
                        'user_id': user_id,
                        'document_id': document_id,
                        'type': type
                    }
                    acceptOrReject('/eteeap-director-action', 'post', data)
                        .then(function(data) {
                            console.log(data)
                            if (data.status === 'success' && data.type !== 'accepted') {
                                // setInterview(data.user_id, document_id)
                                setTimeout(() => {
                                    // if(result.value.refresh){
                                    window.location.reload()
                                    // }
                                }, 1000);
                            }else{
                                 setInterview(data.user_id, document_id)
                            }
                            // Handle the data or perform additional actions if needed
                        })
                        .catch(function(errorMessage) {
                            console.error(errorMessage);
                            // Handle the error as needed
                        });
                    var data = {
                        'type': type
                    }

                })
            })

            const uniqueId = (id) => {
                const randomness = Math.random().toString(36).substr(2);
                const uuid = randomness + id
                return uuid.substr(0, 12).toUpperCase();
            };

            // Function to filter out only the document fields
            const filterDocuments = (obj) => {
                var documents = {};
                // Extract keys of the object and reverse the array
                var keys = Object.keys(obj).reverse();
                for (var i = 0; i < keys.length; i++) {
                    var key = keys[i];
                    if (obj[key] !== null && typeof obj[key] === 'string' && obj[key].startsWith('public/documents')) {
                        documents[key] = obj[key];
                    }
                }
                return documents;
            };


            const loadIframe = (currentIndex, key, url, index, applicant) => {
                let messages = ''
                const originalNames = [{
                        loi: 'Letter of Intent addressed to: Mr. Philip M. Flores, Director, ETEEAP, Arellano University, 2600 Legarda St., Sampaloc, Manila 1008'
                    },
                    {
                        ce: 'CHED - ETEEAP Application form with 3 pieces of 1x1 picture'
                    },
                    {
                        cr: 'Comprehensive Resume (original)'
                    },
                    {
                        nce: 'Notarized Certificate of Employment with job description (with at least 5 years of working experience)'
                    },
                    {
                        hdt: 'Honorable Dismissal and TOR (for undergraduate and for vocational courses)'
                    },
                    {
                        f137_8: 'Form 137–A and Form 138 (for High School Graduate) or PEPT/ALS Certificate'
                    },
                    {
                        abcb: 'Authenticated Birth Certificate/Affidavit of Birth (original)'
                    },
                    {
                        mc: 'Marriage Certificate (for female, if married - photocopy)'
                    },
                    {
                        nbc: 'NBI or Barangay clearance (original)'
                    },
                    // {'2 valid IDs (photocopy)'},
                    {
                        ge: 'Government eligibility'
                    },
                    {
                        pc: 'Proficiency Certificate'
                    },
                    {
                        rl: 'Recommendation Letter from immediate superior to undergo ETEEAP (original)'
                    },
                    {
                        cgmc: 'Certificate of Good Moral Character from previous school (original)'
                    },
                    {
                        cer: 'Certificates of Trainings, Seminars and Workshops attended (photocopy)'
                    },
                ];

                let file = url.replace(/^public\//, 'storage/')
                // console.log(applicant)
                $('.max-index').text(index)
                let isMatched = false;
                originalNames.forEach((obj) => {

                    const keys = Object.keys(obj);
                    // console.log(keys[0], key[currentIndex])

                    if (keys[0] === key[currentIndex]) {
                        $('#d_title').text(obj[keys[0]]);
                        isMatched = true;
                        return;
                    }


                });
                // myID !== application.forwarded_to[0].receiver_id
                // If no match is found, set the new value
                console.log(application.user_id)
                if (!isMatched) {
                    $('#d_title').text(key[currentIndex]);
                }
               
                // internal
                $('#u_id').val(parseInt(applicant.user_id))
                // external
                $('#e_u_id').val(parseInt(application.forwarded_to[0].receiver_id))
                // internal
                $('#u_d_id').val(parseInt(applicant.id))
                // external
                $('#e_u_d_id').val(parseInt(applicant.id))

                $('#d_name').text(applicant.user.name)
                $('#d_email').text(applicant.user.email)
                $('#d_course_applied').text(applicant.applied_for)

                //add document id on tbs rejected and approved
                $('.tabs-btn').attr('data-id', applicant.id)
                $('.tabs-btn').attr('data-user_id', application.user_id)
                let span = ''
                switch (applicant.status[0].status) {
                    // 'pending', 'accepted', 'under-review', 'forwarded', rejected
                    case 'under-review':
                        span =
                            `<span class="capitalize font-bold text-orange-400 bg-slate-100 p-[4px] rounded-md">Under Review</span>`
                        break;
                    case 'pending':
                        span =
                            `<span class="capitalize font-bold text-yellow-400 bg-slate-100 p-[4px] rounded-md">Pending</span>`
                        break;
                    case 'accepted':
                        span =
                            `<span class="capitalize font-bold text-green-400 bg-slate-100 p-[4px] rounded-md">Approved</span>`
                        break;
                    case 'rejected':
                        span =
                            `<span class="capitalize font-bold text-red-500 bg-slate-100 p-[4px] rounded-md">Rejected</span>`
                        break;

                    default:
                        span =
                            `<span class="capitalize font-bold text-red-500 bg-slate-100 p-[4px] rounded-md">On Hold</span>`
                        break;
                }
                $('#d_status').html(span)

                if (Array.isArray(applicant.internal) && applicant.internal.length === 0) {
                    console.log('no message')
                    messages += `<div class="bg-slate-100 rounded-md px-2 w-full py-13">
                                        <span class="flex justify-center items-center text-[12px] font-bold text-blue-900">
                                            Message thread
                                        </span>
                                </div>
                                `
                } else {
                    applicant.internal.forEach(msg => {
                        switch (msg.message_type) {
                            case 'internal':
                                messages += `<div class="bg-slate-100 rounded-md px-2 w-full">
                                        <span class="flex justify-between items-center text-[12px] font-bold text-blue-900">
                                            ${msg.name}
                                            <span class="text-[12px] text-blue-900">${new Date(msg.created_at).toLocaleString()}</span>
                                        </span>
                                        <span class="block mt-[-2px] tracking-wider text-[15px] text-slate-800">
                                            <i class="fa-solid fa-chevrons-right text-[10px]"></i>
                                            ${msg.message}
                                        </span>
                                        <span class="block mt-[-2px] tracking-wider text-[15px]  text-red-700">
                                            <i class="${msg.action_required != null ? 'fa-solid fa-chevrons-right text-[10px]' : ''} "></i>
                                            ${msg.action_required != null ? msg.action_required : '' }
                                            
                                        </span>
                                    </div>`
                                break;

                            default:
                                break;
                        }

                    });
                }
                $('.internal-messages').html(messages)

                // console.log(file)
                $('#fileOpener').attr('src', `{{ asset('${file}') }}`)
            }

            // close modal
            $('.endorse-close').click(function() {
                $('.endorse_user_modal').addClass('hidden')
                $('.backdrop').addClass('hidden')
            })

            // populate External message
            const externalMessages = (message) => {
                console.log(message.length)
                let emsg = ''
                // for
                if (message.length > 0) {
                    message.forEach(msg => {
                        emsg += `<div class="bg-slate-100 rounded-md px-2 w-full">
                                        <span class="flex justify-between items-center text-[12px] font-bold text-blue-900">
                                            ${msg.name}
                                            <span class="text-[12px] text-blue-900">${new Date(msg.created_at).toLocaleString()}</span>
                                        </span>
                                        <span class="block mt-[-2px] tracking-wider text-[15px] text-slate-800">
                                            <i class="fa-solid fa-chevrons-right text-[10px]"></i>
                                            ${msg.message}
                                        </span>
                                        <span class="block mt-[-2px] tracking-wider text-[15px]  text-red-700">
                                            <i class="${msg.action_required != null ? 'fa-solid fa-chevrons-right text-[10px]' : ''} "></i>
                                            ${msg.action_required != null ? msg.action_required : '' }
                                            
                                        </span>
                                    </div>`
                    });
                } else {
                    emsg = `
                    <div class="bg-slate-100 rounded-md px-2 w-full py-13">
                        <span class="flex justify-center items-center text-[12px] font-bold text-blue-900">
                            Message thread
                        </span>
                    </div>
                    `
                }

                $('.external-messages').html(emsg)
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

            function setInterview(id, document_id) {
                    Swal.fire({
                        title: "Setup the interview",
                        html: `<div class="border rounded-md p-3">
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
                            if (date == '' || time == '' || address == '') {
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
                                    body: JSON.stringify({
                                        'document_id': document_id,
                                        'user_id': user_id,
                                        'date': date,
                                        'time': time,
                                        'address': address
                                    }),
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
        </script>
    @endsection
</x-app-layout>
