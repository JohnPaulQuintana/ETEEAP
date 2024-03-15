

<!-- Modal toggle -->
{{-- <button data-modal-target="timeline-modal" data-modal-toggle="timeline-modal" class="block text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800" type="button">
    Toggle modal
  </button> --}}
  
  <!-- Main modal -->
  <div id="timeline-modal" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
      <div class="relative p-4 w-full max-w-5xl max-h-full">
          <!-- Modal content -->
          <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                  <!-- Modal header -->
                  <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                      <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                          Application Status
                      </h3>
                      <button type="button" class="t-close text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm h-8 w-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-toggle="timeline-modal">
                          <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                              <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                          </svg>
                          <span class="sr-only">Close modal</span>
                      </button>
                  </div>
                  <!-- Modal body -->
                  <div class="p-4 md:p-5 max-h-150 overflow-scroll">
                      <ol id="history-card" class="relative border-s border-gray-200 dark:border-gray-600 ms-3.5 mb-4 md:mb-5">      
                        
                        {{-- loop the location of documents --}}
                        {{-- <li class="mb-10 ms-8">            
                            <span class="absolute flex items-center justify-center w-6 h-6 bg-gray-100 rounded-full -start-3.5 ring-8 ring-white dark:ring-gray-700 dark:bg-gray-600">
                                 <i class="fa-sharp fa-solid fa-circle w-2.5 h-2.5 ${className}"></i>  
                            </span>
                            <h3 class="flex items-start mb-1 text-lg font-semibold text-gray-900 dark:text-white">
                                ETEEAP APPLICATION 
                                <span class="${classNameBg} text-black text-sm font-medium mr-2 px-2.5 py-0.5 rounded dark:bg-blue-900 dark:text-blue-300 ms-3">
                                    ${history.status}...
                                </span>
                            </h3>
                            <time class="block mb-3 text-sm font-normal leading-none text-gray-500 dark:text-gray-400">Date : ${formattedDate}</time>
                            <time class="block mb-3 text-sm font-normal leading-none text-gray-500 dark:text-gray-400">Time : ${formattedDay}</time>
                            <button data-note="${history.notes}" type="button" class="py-2 px-3 inline-flex items-center text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">
                                <i class="fa-sharp fa-solid fa-paper-plane w-3 h-3 me-1.5"></i>  
                                Notes
                            </button>
                        </li> --}}
                          
                        
                      </ol>
                      {{-- <button class="text-white inline-flex w-full justify-center bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                      My Downloads
                      </button> --}}

                      
                  </div>
              </div>
      </div>
  </div> 
  