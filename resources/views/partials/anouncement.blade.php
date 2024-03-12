<div id="informational-banner" tabindex="-1"
    class="md:start-10 z-50 flex flex-col justify-center items-center w-fit p-4 border border-blue-200 md:flex-row bg-gray-50 dark:bg-gray-700 dark:border-gray-600">
    <div class="pr-2 text-blue-700">

        <i class="fa-duotone {{ isset($data) ? 'fa-file-check' : 'fa-volume' }} text-5xl"></i>
    </div>
    <div class="mb-4 md:mb-0 md:me-4">
        {{-- {{ $data }} --}}
        <h2 class="mb-1 text-base font-semibold text-blue-900 dark:text-white">{{ isset($data) ? $data->notes : $admin }}</h2>
        <p class="flex items-center text-sm font-normal text-gray-500 dark:text-gray-400">{{ isset($data) ? $data->created_at : '' }}</p>
    </div>
    <div class="flex items-center flex-shrink-0">
        @if (isset($data))
            <a href="#"
            class="inline-flex items-center justify-center px-3 py-2 me-2 text-xs font-medium text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">
            check it out <svg class="w-3 h-3 ms-2 rtl:rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                fill="none" viewBox="0 0 14 10">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M1 5h12m0 0L9 1m4 4L9 9" />
            </svg></a>
        @endif
        <button data-dismiss-target="#informational-banner" type="button"
            class="flex-shrink-0 inline-flex justify-center w-7 h-7 items-center text-gray-400 hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 dark:hover:bg-gray-600 dark:hover:text-white">
            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                viewBox="0 0 14 14">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
            </svg>
            <span class="sr-only">Close banner</span>
        </button>
    </div>
</div>
