<x-app-layout>
    <div class="mx-auto max-w-screen-2xl p-4 md:p-6 2xl:p-5">
       

        <div class="flex justify-between mt-5 mb-5">
            <div class="flex">
                <h1 class="text-blue-900 mx-2 font-bold text-xl border-l-4 pl-2 dark:text-white">{{ $department->department_name }} Dashboard </h1>
                
            </div>
            @include('partials.breadcrumb')
        </div>

        <div class="sm:rounded-lg overflow-hidden px-2">
             <!-- Main modal -->
             <div class="relativew-full max-w-full max-h-full">
                <!-- Modal content -->
                <div class="bg-white rounded-lg shadow dark:bg-gray-700">
                        <!-- Modal header -->
                        <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                                Applicant name
                            </h3>
                            <button type="button" class="t-close text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm h-8 w-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-toggle="timeline-modal">
                                <i class="fa-sharp fa-solid fa-circle-user text-2xl text-blue-900"></i>
                            </button>
                        </div>
                        <!-- Modal body -->
                        <div class="p-4 md:p-5 max-h-150 overflow-scroll">
                            <ol id="history-card" class="relative border-s border-gray-200 dark:border-gray-600 ms-3.5 mb-4 md:mb-5">      
                              
                              {{-- loop the location of documents --}}
                              <li class="shadow-md p-2 mb-10 ms-8 grid grid-cols-1 lg:grid-cols-2 gap-2">            
                                <div>
                                    <span class="absolute flex items-center justify-center w-6 h-6 bg-gray-100 rounded-full -start-3.5 ring-8 ring-white dark:ring-gray-700 dark:bg-gray-600">
                                        <i class="fa-sharp fa-solid fa-circle w-2.5 h-2.5 text-yellow-400"></i>  
                                    </span>
                                    <h3 class="flex items-start mb-1 text-lg font-semibold text-blue-900 dark:text-white">
                                        ETEEAP APPLICATION 
                                        <span class="bg-yellow-400 text-white text-sm font-medium mr-2 px-2.5 py-0.5 rounded dark:bg-blue-900 dark:text-blue-300 ms-3">
                                            pending
                                        </span>
                                        <span class="bg-blue-500 hover:bg-blue-700 hover:cursor-pointer text-white text-sm font-medium mr-2 px-2.5 py-0.5 rounded dark:bg-blue-900 dark:text-blue-300 ms-3">
                                            Forwarded
                                        </span>
                                    </h3>
                                    <time class="block mb-3 text-sm font-normal leading-none text-blue-900 dark:text-gray-400"><span class="font-bold">Date :</span> 2024-03-09</time>
                                    <time class="block mb-3 text-sm font-normal leading-none text-blue-900 dark:text-gray-400"><span class="font-bold">Time :</span> 12:00 AM</time>
                                    <span class="block rounded-md p-2 mb-3 text-blue-900 text-md font-normal leading-none bg-gray-2 dark:text-gray-400">This document is in pending state, and need to be reviewed.</span>
                                
                                </div>

                                <div class="border border-gray-2 rounded-md bg-gray-2 p-2 text-blue-900 w-full">
                                    <span class="font-bold">Document's
                                        <span class="bg-blue-500 hover:bg-blue-700 hover:cursor-pointer text-white text-[14px] font-medium mr-2 px-2.5 py-2 rounded dark:bg-blue-900 dark:text-blue-300 ms-3">
                                            send to <i class="fa-sharp fa-solid fa-paper-plane-top text-[10px]"></i>
                                        </span>

                                    </span>
                                    <div class="h-40 overflow-y-auto">
                                        {{-- list of resubmit docs --}}
                                        <div class="text-wrap w-full mt-3">
                                            <div class="break-words max-h-60 overflow-auto">

                                                <span class="block text-left border rounded-md bg-white p-1 mb-2">
                                                    
                                                    <div class="flex items-start gap-2.5">
                                                        <div class="flex flex-col w-full gap-1">
                                                            <div class="flex flex-col w-full leading-1.5 p-4 border-gray-200 bg-gray-100 rounded-e-xl rounded-es-xl dark:bg-gray-700">
                                                                <div class="flex items-center space-x-2 rtl:space-x-reverse">
                                                                    <span class="text-sm font-semibold text-gray-900 p-1 dark:text-white">Resubmitted document by user name here</span>
                                                                    <span class="text-sm font-normal bg-yellow-400 p-[2px] rounded-sm text-white dark:text-gray-400">11:46 AM</span>
                                                                    <span class="text-sm font-normal bg-red-500 p-[2px] rounded-sm text-white dark:text-gray-400">re-submited</span>
                                                                </div>
                                                                <div class="flex justify-between w-full items-start bg-gray-50 dark:bg-gray-600 rounded-xl p-2">
                                                                    <div class="me-2">
                                                                    
                                                                        <span class="flex items-center gap-2 mb-2 text-md font-medium text-gray-900 capitalize dark:text-white">
                                                                            <i class="fa-sharp fa-solid fa-files flex-shrink-0 text-2xl"></i>
                                                                            
                                                                            document's title here
                                                                        </span>
                                                                        <span class="mt-2">Hello, this is the document that you requested on me.</span>
                                                                    </div>
                                                                    <div class="inline-flex self-center items-center">
                                                                        <button class="reupload border inline-flex bg-blue-900 self-center items-center p-2 text-sm font-medium text-center text-white bg-gray-50 rounded-lg hover:bg-gray-100 focus:ring-4 focus:outline-none dark:text-white focus:ring-gray-50 dark:bg-gray-600 dark:hover:bg-gray-500 dark:focus:ring-gray-600" type="button">
                                                                            <i class="fa-solid fa-envelope-open-text text-md"></i>
                                                                        </button>
                                                                    </div>
                                                                </div>
                                                                
                                                            </div>
                                                        </div>
                                                    
                                                    </div>

                                                </span>

                                            </div>
                                        </div> 

                                        {{-- original doc --}}
                                        <div class="text-wrap w-full mt-3">
                                            <div class="break-words max-h-60 overflow-auto">

                                                <span class="block text-left border rounded-md bg-white p-1 mb-2">
                                                    
                                                    <div class="flex items-start gap-2.5">
                                                        <div class="flex flex-col w-full gap-1">
                                                            <div class="flex flex-col w-full leading-1.5 p-4 border-gray-200 bg-gray-100 rounded-e-xl rounded-es-xl dark:bg-gray-700">
                                                                <div class="flex items-center space-x-2 rtl:space-x-reverse">
                                                                    <span class="text-sm font-semibold text-gray-900 dark:text-white">Forwarded by user name here</span>
                                                                    <span class="text-sm font-normal bg-yellow-400 rounded-sm text-white dark:text-gray-400">11:46 AM</span>
                                                                </div>
                                                                <div class="flex justify-between w-full items-start bg-gray-50 dark:bg-gray-600 rounded-xl p-2">
                                                                    <div class="me-2">
                                                                    
                                                                        <span class="flex items-center gap-2 text-md font-medium text-gray-900 capitalize dark:text-white">
                                                                            <i class="fa-sharp fa-solid fa-files flex-shrink-0 text-2xl"></i>
                                                                            
                                                                            document's title here
                                                                        </span>
                                                                    
                                                                    </div>
                                                                    <div class="inline-flex self-center items-center">
                                                                        <button class="reupload border inline-flex bg-blue-900 self-center items-center p-2 text-sm font-medium text-center text-white bg-gray-50 rounded-lg hover:bg-gray-100 focus:ring-4 focus:outline-none dark:text-white focus:ring-gray-50 dark:bg-gray-600 dark:hover:bg-gray-500 dark:focus:ring-gray-600" type="button">
                                                                            <i class="fa-solid fa-envelope-open-text text-md"></i>
                                                                        </button>
                                                                    </div>
                                                                </div>
                                                                
                                                            </div>
                                                        </div>
                                                    
                                                    </div>

                                                </span>

                                            </div>
                                        </div>    

                                        <div class="text-wrap w-full mt-3">
                                            <div class="break-words max-h-60 overflow-auto">

                                                <span class="block text-left border rounded-md bg-white p-1 mb-2">
                                                    
                                                    <div class="flex items-start gap-2.5">
                                                        <div class="flex flex-col w-full gap-1">
                                                            <div class="flex flex-col w-full leading-1.5 p-4 border-gray-200 bg-gray-100 rounded-e-xl rounded-es-xl dark:bg-gray-700">
                                                                <div class="flex items-center space-x-2 rtl:space-x-reverse">
                                                                    <span class="text-sm font-semibold text-gray-900 dark:text-white">Forwarded by user name here</span>
                                                                    <span class="text-sm font-normal bg-yellow-400 rounded-sm text-white dark:text-gray-400">11:46 AM</span>
                                                                </div>
                                                                <div class="flex justify-between w-full items-start bg-gray-50 dark:bg-gray-600 rounded-xl p-2">
                                                                    <div class="me-2">
                                                                    
                                                                        <span class="flex items-center gap-2 text-md font-medium text-gray-900 capitalize dark:text-white">
                                                                            <i class="fa-sharp fa-solid fa-files flex-shrink-0 text-2xl"></i>
                                                                            
                                                                            document's title here
                                                                        </span>
                                                                    
                                                                    </div>
                                                                    <div class="inline-flex self-center items-center">
                                                                        <button class="reupload border inline-flex bg-blue-900 self-center items-center p-2 text-sm font-medium text-center text-white bg-gray-50 rounded-lg hover:bg-gray-100 focus:ring-4 focus:outline-none dark:text-white focus:ring-gray-50 dark:bg-gray-600 dark:hover:bg-gray-500 dark:focus:ring-gray-600" type="button">
                                                                            <i class="fa-solid fa-envelope-open-text text-md"></i>
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
                                </div>

                            </li>
                                
                              
                            </ol>
                            {{-- <button class="text-white inline-flex w-full justify-center bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                            My Downloads
                            </button> --}}
        
                            
                        </div>
                    </div>
            </div>
        </div>

    </div>
</x-app-layout>