
<div id="comments-modal" tabindex="-1" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
    <div class="realtive p-4 w-full max-w-xl max-h-full">
        <div class="relative bg-white  rounded-lg shadow-2xl dark:bg-gray-700">
            <button type="button" class="c-close absolute top-3 end-2.5 text-red-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="comments-modal">
                <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                </svg>
                <span class="sr-only">Close modal</span>
            </button>
            <div class="p-4 md:p-5 text-center">
                <i class="fa-sharp fa-regular fa-circle-check mx-auto mb-2 text-gray-400 w-12 h-12 text-5xl text-blue-900"></i>
               
                <h3 class="text-lg font-normal text-blue-900 dark:text-gray-400 uppercase">Upload your requirements to ETEEAP.</h3>
                <span class="text-blue-900"><i class="fa-solid fa-asterisk text-red-500"></i> REQUIRED TO SUBMIT</span>
                <div class="">
                   {{-- original is reupload route --}}
                    <form class="max-w-lg mx-auto h-fit overflow-auto" enctype="multipart/form-data" action="{{ route('additional') }}" method="post">
                        @csrf
                        <input type="number" name="documentId" id="documentId" value="" class="hidden">
                        <input type="number" name="senderId" id="senderId" value="" class="hidden">
                        <input type="number" name="checkedId" id="checkedId" value="" class="hidden">
                        <input type="text" name="checkedName" id="checkedName" value="" class="hidden">
                        <input type="text" name="checkedSubName" id="checkedSubName" value="" class="hidden">
                        <div class="mb-2 p-1">
                            <label class="block mb-2 text-md text-left font-bold text-bgprimary" for="reuploadDocsName">1.Document's Name: <i class="fa-solid fa-asterisk text-red-500"></i></label>
                            <input name="reuploadDocsName" class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400" type="text" required>
                            {{-- <div class="mt-1 text-sm text-left uppercase text-bgprimary dark:text-gray-300" id="user_avatar_help">addressed to: Mr. Philip M. Flores, Director, ETEEAP, Arellano University, 2600 Legarda St., Sampaloc, Manila 1008</div> --}}
                        </div>
                        <div class="mb-2 p-1">
                            <label class="block mb-2 text-md text-left font-bold text-bgprimary" for="reuploadDocs" id="reuploadLable">2.Document's to upload: <i class="fa-solid fa-asterisk text-red-500"></i></label>
                            <input name="reuploadDocs" id="reuploadDocs" class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400" aria-describedby="user_avatar_help" type="file" accept=".doc, .pdf, .png, .jpeg" required>
                            {{-- <div class="mt-1 text-sm text-left uppercase text-bgprimary dark:text-gray-300" id="user_avatar_help">addressed to: Mr. Philip M. Flores, Director, ETEEAP, Arellano University, 2600 Legarda St., Sampaloc, Manila 1008</div> --}}
                        </div>

                        <div class="mb-2 p-1">
                            <label class="block mb-2 text-md text-left font-bold text-bgprimary" for="comment">Comments:</label>
                            <textarea id="reuploadComment" name="reuploadComment" rows="4" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Add your comments or messages here..."></textarea>
                        </div>
                        
                        
                        
                        
                        <div class="mb-2 p-1">
                            
                            <button type="submit" class="border w-full p-2 border-blue-700 bg-blue-700 text-white hover:bg-blue-800">Submit Documents</button>
                        </div>
                        
                    </form>
  
                </div>
               
            </div>
        </div>
    </div>
</div>