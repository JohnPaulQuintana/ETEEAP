
  
  <!-- Main modal -->
  <div id="forward-modal" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
    <div class="relative  z-99999 p-4 w-full max-w-xl max-h-full">
        <!-- Modal content -->
        <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
            <!-- Modal header -->
            <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                <h3 id="filename" class="text-xl font-semibold text-gray-900 dark:text-white">
                    Forward Document's
                </h3>
                <button type="button" class="frClose text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="forward-modal">
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                    </svg>
                    <span class="sr-only">Close modal</span>
                </button>
            </div>
            <!-- Modal body -->
            <div class="p-4 md:p-5 space-y-4">
                <form class="w-full mx-auto" action="{{ route('outgoing') }}" method="POST">
                    @csrf
                    <div class="mb-4 border border-red-500 p-2 rounded-md">
                        <p class="text-red-500">Note: You need to evaluate all the documents before sending them to another department.</p>
                    </div>
                    <label for="countries" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Select an option</label>
                    <select id="countries" name="user_id" class="user_lists bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required>
                      
                    </select>
                    <input type="text" name="document_id" id="forwarded_document_id" class="hidden">
                
                    <div class="mt-2">
                        <label for="message" class="block mb-2 text-sm dark:text-white">Description</label>
                        <textarea id="message" name="message" rows="4" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Write your thoughts here..."></textarea>
                    </div>
                    {{-- <input type="text" name="department_name" id="forwarded_department_name" class="hidden"> --}}
                    <button data-modal-hide="static-modal" type="submit" id="btn-iframe-accepted" class="btn-iframe-accepted text-white mt-5 bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Forward Document's</button>
                  </form>
                <!-- Iframe to display the file -->
                  {{-- <iframe id="fileViewer" class="block mx-auto" src="" width="100%" height="450px" frameborder="0"></iframe>
                  
                  <div>   
                      <label for="message" class="block mb-2 text-sm font-bold text-blue-900 dark:text-white">Description</label>
                      <textarea id="message" rows="4" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Write your thoughts here..."></textarea>
                      <input type="text" name="" id="filename-orig" class="hidden">
                      <input type="text" name="" id="subname" class="hidden">
                  </div> --}}
            </div>
            <!-- Modal footer -->
            {{-- <div class="flex items-center p-4 md:p-5 border-t border-gray-200 rounded-b dark:border-gray-600">
                
                <button data-modal-hide="static-modal" type="button" id="btn-iframe-declined" class="btn-iframe-declined py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">Decline</button>
            </div> --}}
        </div>
    </div>
</div>
