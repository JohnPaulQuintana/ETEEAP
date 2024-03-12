
<div id="requirement-modal" tabindex="-1" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
    <div class="relative p-4 w-full max-w-4xl max-h-full">
        <div class="relative bg-bgprimary rounded-lg shadow dark:bg-gray-700">
            <button type="button" class="absolute top-3 end-2.5 text-red-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="requirement-modal">
                <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                </svg>
                <span class="sr-only">Close modal</span>
            </button>
            <div class="p-4 md:p-5 text-center">
                <i class="fa-sharp fa-regular fa-circle-check mx-auto mb-2 text-gray-400 w-12 h-12 text-5xl text-textprimary"></i>
               
                <h3 class="mb-5 text-lg font-normal text-textprimary dark:text-gray-400">You need to know about the requirements.</h3>
                <div class="border border-gray p-2 rounded">
                   <iframe src="{{ asset('requirement/Qualification-and-Requirements.pdf') }}" frameborder="0" width="100%" height="750"></iframe>
                </div>
               
            </div>
        </div>
    </div>
</div>