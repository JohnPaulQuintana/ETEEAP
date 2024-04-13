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
            .endorse_user_modal {
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
                                <span id="d_id" class="font-bold">XXXX2202020</span>
                            </div>
                            <div class="mt-2 px-2">
                                <span>Name : </span>
                                <span id="d_name" class="font-bold capitalize">Jaypee Quintana</span>
                            </div>
                            <div class="mt-2 px-2">
                                <span>Email : </span>
                                <span id="d_email" class="font-bold capitalize">Jaypee Quintana</span>
                            </div>
                            <div class="mt-2 px-2">
                                <span>Course Applied : </span>
                                <span id="d_course_applied" class="font-bold capitalize">Jaypee Quintana</span>
                            </div>
                            <div class="mt-2 px-2">
                                <span>Application Status : </span>
                                <span id="d_status" class="font-bold capitalize">Jaypee Quintana</span>
                            </div>

                            {{-- comment --}}
                            <div class="border rounded-sm p-2 mt-2">

                                <div class="mb-1 border-b border-gray-200 dark:border-gray-700">
                                    <ul class="flex flex-wrap -mb-px text-sm font-medium text-center" id="message-tab"
                                        data-tabs-toggle="#message-tab-content" role="tablist">
                                        <li class="me-2" role="presentation">
                                            <button class="inline-block p-4 border-b-2 rounded-t-lg" id="internal-tab"
                                                data-tabs-target="#internal" type="button" role="tab"
                                                aria-controls="internal" aria-selected="false">Internal Message</button>
                                        </li>
                                        <li class="me-2" role="presentation">
                                            <button
                                                class="inline-block p-4 border-b-2 rounded-t-lg hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300"
                                                id="external-tab" data-tabs-target="#external" type="button"
                                                role="tab" aria-controls="external" aria-selected="false">External
                                                Message</button>
                                        </li>

                                    </ul>
                                </div>

                                <div id="message-tab-content">
                                    {{-- internal --}}
                                    <div class="hidden p-2 rounded-lg bg-gray-50 dark:bg-gray-800" id="internal"
                                        role="tabpanel" aria-labelledby="internal-tab">
                                        <div
                                            class="border border-dashed mt-2 p-2 flex flex-col gap-3 w-full h-[150px] overflow-y-auto">

                                            <div class="internal-messages flex flex-col justify-start items-start gap-4">
                                                
                                            </div>

                                        </div>
                                        <div class="">
                                            <form action="{{ route('eteeap.internal') }}" method="post">
                                                @csrf
                                                <input type="text" name="message_type" value="internal" class="hidden">
                                                <input type="number" name="user_document_id" id="u_d_id" value="" class="hidden">
                                                <input type="number" name="user_id" id="u_id" value="" class="hidden">
                                                <div class="flex justify-between items-center mt-2">
                                                    <span class="text-blue-700">Action Required : </span>
                                                    <span>
                                                        <select name="action_required" id="action_required"
                                                            class="w-[100%] h-8 text-[12px] py-0 rounded-md">
                                                            <option value="">Select action</option>
                                                            <option value="Additional Documents Required">Additional Documents Required</option>
                                                            <option value="Applicant Response Needed">Applicant Response Needed</option>
                                                        </select>
                                                    </span>
                                                </div>

                                                <div class="mt-2">
                                                    <label for="default-search" class="mb-2 text-sm font-medium text-gray-900 sr-only dark:text-white">message</label>
                                                    <div class="relative">
                                                        <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                                                            
                                                            <i class="fa-solid fa-envelope-circle-check w-4 h-4 text-gray-500 dark:text-gray-400 text-[20px]"></i>
                                                        </div>
                                                        <input type="text" id="message" name="message" class="block w-full p-4 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Send a message to applicant..." required />
                                                        <button type="submit" class="text-white absolute end-2.5 bottom-2.5 bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-4 py-2 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                                                            <i class="fa-solid fa-paper-plane-top text-[16px]"></i>
                                                        </button>
                                                    </div>
                                                    {{-- <input type="text" name="message" id="message" class="col-span-2 rounded-md" placeholder="Send a message to applicant">
                                                    <button type="submit" class="col-start-3"><i class="fa-solid fa-paper-plane-top text-xl border p-2 rounded-md text-blue-700 hover:text-blue-800 hover:cursor-pointer"></i></button> --}}
                                                </div>
                                                
                                            </form>

                                        </div>
                                    </div>

                                    {{-- external --}}
                                    <div class="hidden p-4 rounded-lg bg-gray-50 dark:bg-gray-800" id="external"
                                        role="tabpanel" aria-labelledby="external-tab">
                                        <div
                                            class="border border-dashed mt-2 p-2 flex flex-col gap-3 w-full h-[150px] overflow-y-auto">

                                            <div class="incoming flex justify-start items-start">
                                                <div class="bg-slate-100 rounded-md px-2">
                                                    <span class="text-[12px] font-bold text-blue-900">Jaypee
                                                        Quintana</span>
                                                    <span
                                                        class="block mt-[-5px] tracking-wider text-[14px] text-slate-800 pl-2">dwadwadwadwad
                                                        dwadwad dwadwadwa dwadwad</span>
                                                </div>
                                            </div>

                                            <div class="outgoing flex justify-end items-end">
                                                <div class="bg-slate-50 rounded-md px-2">
                                                    <span
                                                        class="text-[12px] font-bold text-blue-900 flex justify-end items-end">user2
                                                        Quintana</span>
                                                    <span
                                                        class="mt-[-5px] tracking-wider text-[14px] text-slate-800 pl-2 flex justify-end items-end">dwadwadwadwad
                                                        dwadwad dwadwadwa dwadwad</span>
                                                </div>
                                            </div>

                                            <div class="text-center text-[12px] text-blue-900 border-dotted border-t-2">
                                                2024-09-03 12:00 AM</div>
                                        </div>
                                        <div class="">
                                            <form action="" method="post"
                                                class="grid grid-cols-3 gap-1 mt-2 justify-center items-center">
                                                @csrf
                                                <input type="text" name="message" id="message"
                                                    class="col-span-2 rounded-md"
                                                    placeholder="Send a message to applicant">
                                                <button type="submit" class="w-fit"><i
                                                        class="fa-solid fa-paper-plane-top text-xl border p-2 rounded-md text-blue-700 hover:text-blue-800 hover:cursor-pointer"></i></button>
                                            </form>

                                        </div>
                                    </div>

                                </div>

                                <div>
                                    <form action="#" method="post">
                                        @csrf
                                        <input type="submit" value="Endorse" class="border w-full p-2 rounded-md bg-blue-700 hover:bg-blue-800 hover:cursor-pointer text-white">
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
            let application = @json($documentsArray);

            // console.log(application)
            $(document).ready(function() {
                const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                // Get only the document fields
                var documentFields = filterDocuments(application);
                var keys = Object.keys(documentFields);
                var currentIndex = 0;
                var maxIndex = keys.length;
                // Initial load
                loadIframe(currentIndex, keys, documentFields[keys[currentIndex]], maxIndex, application);


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
                const originalNames = [
                                {loi : 'Letter of Intent addressed to: Mr. Philip M. Flores, Director, ETEEAP, Arellano University, 2600 Legarda St., Sampaloc, Manila 1008'},
                                {ce : 'CHED - ETEEAP Application form with 3 pieces of 1x1 picture'},
                                {cr: 'Comprehensive Resume (original)'},
                                {nce: 'Notarized Certificate of Employment with job description (with at least 5 years of working experience)'},
                                {hdt: 'Honorable Dismissal and TOR (for undergraduate and for vocational courses)'},
                                {f137_8: 'Form 137–A and Form 138 (for High School Graduate) or PEPT/ALS Certificate'},
                                {abcb: 'Authenticated Birth Certificate/Affidavit of Birth (original)'},
                                {mc: 'Marriage Certificate (for female, if married - photocopy)'},
                                {nbc: 'NBI or Barangay clearance (original)'},
                                // {'2 valid IDs (photocopy)'},
                                {ge: 'Government eligibility'},
                                {pc: 'Proficiency Certificate'},
                                {rl: 'Recommendation Letter from immediate superior to undergo ETEEAP (original)'},
                                {cgmc: 'Certificate of Good Moral Character from previous school (original)'},
                                {cer: 'Certificates of Trainings, Seminars and Workshops attended (photocopy)'},
                            ];
                
                let file = url.replace(/^public\//, 'storage/')
                // console.log(applicant)
                $('.max-index').text(index)
                let isMatched = false;
                originalNames.forEach((obj) => {
                   
                    const keys = Object.keys(obj);
                    console.log(keys[0], key[currentIndex])
                   
                        if (keys[0] === key[currentIndex]) {
                            $('#d_title').text(obj[keys[0]]);
                            isMatched = true;
                            return;
                        }
                    
                       
                });
               
                // If no match is found, set the new value
                if (!isMatched) {
                    $('#d_title').text(key[currentIndex]);
                }
                $('#d_id').text(uniqueId(applicant.user_id))
                $('#u_id').val(parseInt(applicant.user_id))
                $('#u_d_id').val(parseInt(applicant.id))
                $('#d_name').text(applicant.user.name)
                $('#d_email').text(applicant.user.email)
                $('#d_course_applied').text(applicant.applied_for)
                $('#d_status').text(applicant.status[0].status)

                if (Array.isArray(applicant.internal) && applicant.internal.length === 0) {
                    console.log('no message')
                    messages += `<div class="bg-slate-100 rounded-md px-2 w-full py-13">
                                        <span class="flex justify-center items-center text-[12px] font-bold text-blue-900">
                                            No internal message available
                                        </span>
                                </div>
                                `
                }else{
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
        </script>
    @endsection
</x-app-layout>
