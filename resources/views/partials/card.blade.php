
    <!-- Card Item Start -->
    
<div class="flex flex-col items-center px-5 bg-white border border-gray-200 rounded-lg shadow md:max-w-xl hover:bg-gray-100 dark:bg-black">
    <div class="p-4 leading-normal w-full">
        <h6 class="text-xl font-bold text-blue-900 text-center tracking-tight text-gray-900 dark:text-white">Enrollment Application</h6>
        {{-- <p class="mb-3 font-normal text-gray-700 dark:text-gray-400">Here are the biggest enterprise technology acquisitions of 2021 so far, in reverse chronological order.</p> --}}
    </div>
    <div class="flex items-center justify-between gap-5 mb-3">
        <div class="checkStatus p-2 border rounded-xl shadow-default hover:bg-blue-100" data-id="{{ $d->id }}">
            <i class="fa-duotone fa-file-doc text-5xl text-blue-900 dark:text-white hover:cursor-pointer"></i>
        </div>
        {{-- <img class="object-cover w-full rounded-t-lg h-96 md:h-auto md:w-48 md:rounded-none md:rounded-s-lg" src="/docs/images/blog/image-4.jpg" alt=""> --}}
        
        <div class="flex flex-row gap-1">
            <div class="text-white">
                <span class="text-blue-900 dark:text-white">Status:</span>
                <h1 class="text-[13px] bg-yellow-400 rounded-lg text-center p-[2px]">
                    {{ $d->status }}
                    <i class="fa-solid fa-circle text-[6px]"></i>
                    <i class="fa-solid fa-circle text-[6px]"></i>
                    <i class="fa-solid fa-circle text-[6px]"></i>
                    
                </h1>
            </div>
            <div class="text-white">
                <span class="text-blue-900 dark:text-white">Date:</span>
                <h1 class="text-[13px] bg-blue-900 rounded-lg text-center p-[2px]">
                    {{ $d->created_at->format('Y-m-d') }}
                </h1>
            </div>
        </div>
        
    </div>

    
</div>

    <!-- Card Item End -->

