<x-app-layout>
    <div class="mx-auto max-w-screen-2xl p-4 md:p-6 2xl:p-5">

        <div class="mb-2">
            @foreach ($documents as $document)
                
                @foreach ($document->documents as $doc)
                        

                    @foreach ($doc->status as $status)
                        {{-- {{ $status }} --}}
                        @foreach ($status->notes as $note)
                            @include('partials.anouncement', ['data'=>$note])
                        @endforeach
                        
                    @endforeach
                    
                @endforeach

            @endforeach
            
        </div>

        <div class="mt-10">
            <div class="flex justify-between">
                <div class="flex">
                    <h1 class="text-blue-900 mx-2 font-bold border-l-4 pl-2 dark:text-white">My Document's </h1>
                    <span class="sendDocs" data-tooltip-target="tooltip-light" data-tooltip-style="light"><i
                            class="fa-regular fa-file-circle-plus text-xl text-blue-700 hover:text-blue-500 hover:cursor-pointer dark:text-white"></i></span>
                    <div id="tooltip-light" role="tooltip"
                        class="absolute z-10 invisible inline-block px-3 py-2 text-sm font-medium text-gray-900 bg-white border border-blue-200 rounded-lg shadow-sm opacity-0 tooltip">
                        Send Documents
                        <div class="tooltip-arrow" data-popper-arrow></div>
                    </div>
                </div>
                @include('partials.breadcrumb')
            </div>

            <div class="grid grid-cols-1 gap-4 p-2 md:grid-cols-2 md:gap-6 xl:grid-cols-4 2xl:gap-7.5">
                
                @foreach ($documents as $document)
                
                    @foreach ($document->documents as $doc)
                        @foreach ($doc->status as $d)
                            @include('partials.card', ['data'=>$d,])
                        @endforeach
                        
                    @endforeach
                   
                @endforeach

                {{-- create documents --}}

                <!-- Card Item Start -->

                <a
                    class="sendDocs flex flex-col items-center px-5 bg-white border-dotted border-2 rounded-lg shadow md:max-w-xl hover:cursor-pointer hover:bg-slate-100 dark:bg-black">
                    <div class="p-4 leading-normal w-full">
                        <h6
                            class="text-xl font-bold text-blue-900 text-center tracking-tight text-gray-900 dark:text-white">
                            Send Documents</h6>
                        {{-- <p class="mb-3 font-normal text-gray-700 dark:text-gray-400">Here are the biggest enterprise technology acquisitions of 2021 so far, in reverse chronological order.</p> --}}
                    </div>
                    <div class="flex flex-col items-center justify-between gap-1 mb-3">
                        <div class="p-2 border rounded-xl shadow-default">
                            <i class="fa-duotone fa-file-arrow-up text-5xl text-blue-900 dark:text-white"></i>

                        </div>
                        {{-- <img class="object-cover w-full rounded-t-lg h-96 md:h-auto md:w-48 md:rounded-none md:rounded-s-lg" src="/docs/images/blog/image-4.jpg" alt=""> --}}
                        <span>click to proceed</span>


                    </div>


                </a>

                <!-- Card Item End -->


            </div>

        </div>
    </div>

    @include('popup.requirementSend')
    {{-- @include('popup.checkstatus') --}}
   
    @section('scripts')
        <script>
            var response = @json(session('status'));
            console.log(response)
            $(document).ready(function() {

                const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                // set the modal menu element
                const $requirementU = document.getElementById('requirementUpload-modal');
                // const $timeline = document.getElementById('timeline-modal');
                // const $comments = document.getElementById('comments-modal');
                // options with default values
                const options = {
                    placement: 'bottom-right',
                    backdrop: 'static',
                    backdropClasses: 'bg-blue-900/50 dark:bg-blue-900/80 fixed inset-0 z-40',
                    closable: true,
                    onHide: () => {
                        console.log('modal is hidden');

                        $('#loi').val('');
                        $('#ce').val('');
                        $('#cr').val('');
                        $('#nce').val('');
                        $('#hdt').val('');
                        $('#f137_8').val('');
                        $('#abcb').val('');
                        $('#mc').val('');
                        $('#nbc').val('');
                        $('#tvid').val('');
                        $('#ge').val('');
                        $('#pc').val('');
                        $('#rl').val('');
                        $('#cgmc').val('');
                        $('#cer').val('');
                    },
                    onShow: () => {
                        console.log('modal is shown');
                    },
                    onToggle: () => {
                        console.log('modal has been toggled');
                    },
                };
                // options with default values
                // const optionComments = {
                //     placement: 'bottom-right',
                //     backdrop: 'static',
                //     backdropClasses: 'bg-blue-900/50 dark:bg-blue-900/80 fixed inset-0 z-40',
                //     closable: true,
                //     onHide: () => {
                //         console.log('modal is hidden');

                        
                //     },
                //     onShow: () => {
                //         console.log('modal is shown');
                //     },
                //     onToggle: () => {
                //         console.log('modal has been toggled');
                //     },
                // };

                // instance options object
                const instanceOptions = {
                    id: 'requirementUpload-modal',
                    override: true
                };
                // instance options object
                // const instanceOptionsT = {
                //     id: 'timeline-modal',
                //     override: true
                // };
                // // instance options object
                // const instanceOptionsC = {
                //     id: 'comments-modal',
                //     override: true
                // };
                // on load
                const rqu = new Modal($requirementU, options, instanceOptions);
                // const tm = new Modal($timeline, options, instanceOptionsT);
                // const cm = new Modal($comments, optionComments, instanceOptionsC);

                if(response === 'success'){
                    window.location.reload()
                }

                $(document).on('click', '.sendDocs', function() {
                    rqu.show()
                })

                $(document).on('click', '.rs-close', function(){
                    rqu.hide()
                })

                // $(document).on('click', '.reupload', function() {
                //     cm.show()
                // })

                // $(document).on('click', '.checkStatus', function(){
                //     var docId = $(this).data('id')
                //     fetchHistory('/history/'+docId)
                //     tm.show()
                //     // alert(docId)
                // })

                // $(document).on('click', '.t-close', function(){
                //     tm.hide()
                // })
                
                // $(document).on('click', '.c-close', function(){
                //     cm.hide()
                // })


                // Function to make the Ajax request
                function fetchHistory(endpoint) {

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
                            // console.log(data.histories);
                            var lists = ''
                            data.histories.forEach(history => {
                                console.log(history)
                                // Parse the original date using moment.js
                                var parsedDate = moment(history.created_at);

                                // Format the date as per your requirements
                                var formattedDate = parsedDate.format("YYYY-MM-DD");
                                var formattedDay = parsedDate.format("h:mm:ss A");
                                var classNameText = ''
                                var classNameBg = ''
                                switch (history.status) {
                                    case "in-review":
                                        className = 'text-orange-400'
                                        classNameBg = 'bg-orange-400'
                                        break;
                                    case "accepted":
                                        className = 'text-green-400'
                                        classNameBg = 'bg-green-400'
                                        break;
                                    case "rejected":
                                        className = 'text-red-500'
                                        classNameBg = 'bg-red-500'
                                        break;
                                
                                    default:
                                        className = 'text-yellow-400'
                                        classNameBg = 'bg-yellow-400'
                                        break;
                                }
                                lists += `
                                    <li class="shadow-md p-2 mb-10 ms-8 grid grid-cols-1 lg:grid-cols-2 gap-2">            
                                        <div>
                                            <span class="absolute flex items-center justify-center w-6 h-6 bg-gray-100 rounded-full -start-3.5 ring-8 ring-white dark:ring-gray-700 dark:bg-gray-600">
                                                <i class="fa-sharp fa-solid fa-circle w-2.5 h-2.5 ${className}"></i>  
                                            </span>
                                            <h3 class="flex items-start mb-1 text-lg font-semibold text-blue-900 dark:text-white">
                                                ETEEAP APPLICATION 
                                                <span class="${classNameBg} text-white text-sm font-medium mr-2 px-2.5 py-0.5 rounded dark:bg-blue-900 dark:text-blue-300 ms-3">
                                                    ${history.status}
                                                </span>
                                                <span class="bg-red-500 hover:bg-red-700 hover:cursor-pointer text-white text-sm font-medium mr-2 px-2.5 py-0.5 rounded dark:bg-blue-900 dark:text-blue-300 ms-3">
                                                    Notify
                                                </span>
                                            </h3>
                                            <time class="block mb-3 text-sm font-normal leading-none text-blue-900 dark:text-gray-400"><span class="font-bold">Date :</span> ${formattedDate}</time>
                                            <time class="block mb-3 text-sm font-normal leading-none text-blue-900 dark:text-gray-400"><span class="font-bold">Time :</span> ${formattedDay}</time>
                                            <span class="block rounded-md p-2 mb-3 text-blue-900 text-md font-normal leading-none bg-gray-2 dark:text-gray-400">${history.notes}</span>
                                        
                                        </div>

                                        <div class="border border-gray-2 rounded-md bg-gray-2 p-2 text-blue-900 w-full">
                                            <span class="p-1 font-bold">Comment's</span>
                                            <div class="text-wrap w-full">
                                                <div class="break-words max-h-60 overflow-auto">

                                                    <span class="block text-left border rounded-md bg-white p-1 mb-2">
                                                        
                                                        <div class="flex items-start gap-2.5">
                                                            <div class="flex flex-col gap-1">
                                                                <div class="flex flex-col w-full max-w-[326px] leading-1.5 p-4 border-gray-200 bg-gray-100 rounded-e-xl rounded-es-xl dark:bg-gray-700">
                                                                    <div class="flex items-center space-x-2 rtl:space-x-reverse">
                                                                        <span class="text-sm font-semibold text-gray-900 dark:text-white">John Paul Quintana</span>
                                                                        <span class="text-sm font-normal ${classNameBg} rounded-sm text-white dark:text-gray-400">11:46 AM</span>
                                                                    </div>
                                                                    <div class="flex items-start bg-gray-50 dark:bg-gray-600 rounded-xl p-2">
                                                                        <div class="me-2">
                                                                            <span>Kindly resubmit this documents</span>
                                                                        <span class="flex items-center gap-2 text-sm font-medium text-gray-900 dark:text-white">
                                                                            <i class="fa-sharp fa-solid fa-files flex-shrink-0"></i>
                                                                            
                                                                            Flowbite Terms & Conditions
                                                                        </span>
                                                                        
                                                                        </div>
                                                                        <div class="inline-flex self-center items-center">
                                                                        <button class="reupload border inline-flex bg-blue-900 self-center items-center p-2 text-sm font-medium text-center text-white bg-gray-50 rounded-lg hover:bg-gray-100 focus:ring-4 focus:outline-none dark:text-white focus:ring-gray-50 dark:bg-gray-600 dark:hover:bg-gray-500 dark:focus:ring-gray-600" type="button">
                                                                            <i class="fa-sharp fa-solid fa-upload text-md"></i>  
                                                                            
                                                                        </button>
                                                                        </div>
                                                                    </div>
                                                                    
                                                                </div>
                                                            </div>
                                                        
                                                        </div>

                                                    </span>

                                                </div>
                                            </div>    
                                        </div>

                                    </li>
                                `
                            });

                            $('#history-card').html(lists)
                            // var lists = ''
                            // var count = 0;
                            // $('#doc_name').text(data.documents[0].name)

                            // const fileNames = [
                            //     'loi', 'ce', 'cr', 'nce', 'hdt', 'f137_8', 'abcb', 'mc', 'nbc', 'tvid', 'ge', 'pc', 'rl', 'cgmc', 'cer',
                            // ];
                            // const originalNames = [
                            //     'Letter of Intent addressed to: Mr. Philip M. Flores, Director, ETEEAP, Arellano University, 2600 Legarda St., Sampaloc, Manila 1008',
                            //     'CHED - ETEEAP Application form with 3 pieces of 1x1 picture', 
                            //     'Comprehensive Resume (original)', 
                            //     'Notarized Certificate of Employment with job description (with at least 5 years of working experience)', 
                            //     'Honorable Dismissal and TOR (for undergraduate and for vocational courses)', 
                            //     'Form 137–A and Form 138 (for High School Graduate) or PEPT/ALS Certificate', 
                            //     'Authenticated Birth Certificate/Affidavit of Birth (original)', 
                            //     'Marriage Certificate (for female, if married - photocopy)', 
                            //     'NBI or Barangay clearance (original)', 
                            //     '2 valid IDs (photocopy)', 
                            //     'Government eligibility', 
                            //     'Proficiency Certificate', 
                            //     'Recommendation Letter from immediate superior to undergo ETEEAP (original)', 
                            //     'Certificate of Good Moral Character from previous school (original)', 
                            //     'Certificates of Trainings, Seminars and Workshops attended (photocopy)',
                            // ];
                            // data.documents[0].documents.forEach(doc => {
                            //     // console.log(doc)
                            //     const filteredObject = Object.fromEntries(
                            //         Object.entries(doc).filter(([key]) => fileNames.includes(key))
                            //     );
                            //     for (const key in filteredObject) {
                            //         if(doc.hasOwnProperty(key)){
                            //             console.log(filteredObject[key])

                            //             // Create a mapping object
                            //             const mapping = {};
                            //             fileNames.forEach((fileName, index) => {
                            //                 mapping[fileName] = originalNames[index];
                            //             });
                            //             count++;
                            //             lists += `
                            //                 <li class="list-data" data-filename="${mapping[key]}" data-file="${filteredObject[key]}"data-modal-target="select-modal">
                            //                     <input type="radio" id="job-${count}" name="job" value="job-1" class="hidden peer" required />
                            //                     <label for="job-${count}" class="inline-flex items-center justify-between w-full p-5 text-gray-900 bg-white border border-gray-200 rounded-lg cursor-pointer dark:hover:text-gray-300 dark:border-gray-500 dark:peer-checked:text-blue-500 peer-checked:border-blue-600 peer-checked:text-blue-600 hover:text-gray-900 hover:bg-gray-100 dark:text-white dark:bg-gray-600 dark:hover:bg-gray-500">                           
                            //                         <div class="block">
                            //                             <div class="w-full text-lg font-semibold">REQUIREMENT'S - ${count}</div>
                            //                             <div class="w-full text-gray-500 dark:text-gray-400 text-sm">${mapping[key]}</div>
                            //                         </div>
                            //                         <svg class="w-4 h-4 ms-3 rtl:rotate-180 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 10"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 5h12m0 0L9 1m4 4L9 9"/></svg>
                            //                     </label>
                            //                 </li>
                            //             `
                            //         }
                                    
                            //     }
                            // });

                            // $('.doc-list').html(lists)
                            // dqu.show()
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
