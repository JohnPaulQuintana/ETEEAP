
    <!-- Card Item Start -->
    
    <div class="flex flex-col items-center px-5 bg-white border border-gray-200 rounded-lg shadow md:max-w-xl hover:bg-gray-100 dark:bg-black">
        <div class="p-4 leading-normal w-full">
            <h6 class="text-xl font-bold text-blue-900 text-center tracking-tight text-gray-900 dark:text-white">Reviewing Applicant's</h6>
            {{-- <p class="mb-3 font-normal text-gray-700 dark:text-gray-400">Here are the biggest enterprise technology acquisitions of 2021 so far, in reverse chronological order.</p> --}}
        </div>
        <div class="flex items-center justify-between gap-5 mb-3">
           
            <div class="flex flex-row gap-1">
                <div class="text-white">
                    <span class="text-4xl font-bold {{ $ra===0 ? 'text-red-500' : 'text-blue-900' }}  dark:text-white">{{ $ra }}</span>
                    
                       
                    </h1>
                </div>
                
            </div>
            
        </div>
    
        
    </div>
    
    {{-- @if (Auth::user()->role === 1)
        
    @endif --}}
    <div class="flex flex-col items-center px-5 bg-white border border-gray-200 rounded-lg shadow md:max-w-xl hover:bg-gray-100 dark:bg-black">
        <div class="p-4 leading-normal w-full">
            <h6 class="text-xl font-bold text-blue-900 text-center tracking-tight text-gray-900 dark:text-white">Accepted Applicant's</h6>
            {{-- <p class="mb-3 font-normal text-gray-700 dark:text-gray-400">Here are the biggest enterprise technology acquisitions of 2021 so far, in reverse chronological order.</p> --}}
        </div>
        <div class="flex items-center justify-between gap-5 mb-3">
           
            <div class="flex flex-row gap-1">
                <div class="text-white">
                    <span class="text-4xl font-bold {{ $acc===0 ? 'text-red-500' : 'text-blue-900' }} dark:text-white">{{ $acc }}</span>
                    
                       
                    </h1>
                </div>
                
            </div>
            
        </div>
    
        
    </div>
    
    <div class="flex flex-col items-center px-5 bg-white border border-gray-200 rounded-lg shadow md:max-w-xl hover:bg-gray-100 dark:bg-black">
        <div class="p-4 leading-normal w-full">
            <h6 class="text-xl font-bold text-blue-900 text-center tracking-tight text-gray-900 dark:text-white">Declined Applicant's</h6>
            {{-- <p class="mb-3 font-normal text-gray-700 dark:text-gray-400">Here are the biggest enterprise technology acquisitions of 2021 so far, in reverse chronological order.</p> --}}
        </div>
        <div class="flex items-center justify-between gap-5 mb-3">
           
            <div class="flex flex-row gap-1">
                <div class="text-white">
                    <span class="text-4xl font-bold {{ $dc===0 ? 'text-red-500' : 'text-blue-900' }} dark:text-white">{{ $dc }}</span>
                    
                       
                    </h1>
                </div>
                
            </div>
            
        </div>
    
        
    </div>
    
    <div class="flex flex-col items-center px-5 bg-white border border-gray-200 rounded-lg shadow md:max-w-xl hover:bg-gray-100 dark:bg-black">
        <div class="p-4 leading-normal w-full">
            <h6 class="text-xl font-bold text-blue-900 text-center tracking-tight text-gray-900 dark:text-white">Department's</h6>
            {{-- <p class="mb-3 font-normal text-gray-700 dark:text-gray-400">Here are the biggest enterprise technology acquisitions of 2021 so far, in reverse chronological order.</p> --}}
        </div>
        <div class="flex items-center justify-between gap-5 mb-3">
           
            <div class="flex flex-row gap-1">
                <div class="text-white">
                    <span class="text-4xl font-bold {{ $dept===0 ? 'text-red-500' : 'text-blue-900' }} dark:text-white">{{ $dept }}</span>
                    
                       
                    </h1>
                </div>
                
            </div>
            
        </div>
    
        
    </div>
    
    
    
        <!-- Card Item End -->
    
    