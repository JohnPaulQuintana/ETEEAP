<x-app-layout>
    @section('links')
       
    @endsection
    <div class="mx-auto max-w-screen-2xl p-4 md:p-6 2xl:p-5">
        <div class="flex justify-between mb-5">
            <div class="flex items-center">
                <span class="d_back border px-2 py-1 hover:cursor-pointer hover:bg-slate-200">
                    <i class="fa-solid fa-chevrons-left text-red-700 font-bold"></i>
                </span>
                <h1 class="text-blue-900 mx-2 font-bold text-xl border-l-4 pl-2 dark:text-white">
                    Endorse Application</h1>

            </div>
        </div>

        <div class="mb-4 border-b border-gray-200 dark:border-gray-700">

        </div>

        <div class="sm:rounded-lg overflow-hidden px-2">
            <div class="relative w-full max-w-full max-h-full">
                <div class="bg-white rounded-lg shadow dark:bg-gray-700 px-2 p-5">

                    <div class="grid grid-cols-2 gap-1"> <!-- Add overflow-x-auto class here -->

                        <div class="border border-dotted p-2 relative">
                            <span class="absolute top-[-12px] bg-white font-bold">Department Information</span>

                            {{-- department --}}
                            <div class="border rounded-sm p-2 mt-2">

                                <div class="mb-1 border-b border-gray-200 dark:border-gray-700">
                                    <ul class="flex flex-wrap -mb-px text-sm font-medium text-center" id="department-tab"
                                        data-tabs-toggle="#department-tab-content" role="tablist">
                                        <li class="me-2" role="presentation">
                                            <button class="inline-block p-4 border-b-2 rounded-t-lg" id="assessor-tab"
                                                data-tabs-target="#assessor" type="button" role="tab"
                                                aria-controls="assessor" aria-selected="false">ETEEAP Assessor Department</button>
                                        </li>
                                        <li class="me-2" role="presentation">
                                            <button
                                                class="inline-block p-4 border-b-2 rounded-t-lg hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300"
                                                id="director-tab" data-tabs-target="#external" type="button"
                                                role="tab" aria-controls="director" aria-selected="false">ETEEAP Director</button>
                                        </li>

                                    </ul>
                                </div>

                                <div id="department-tab-content">
                                    {{-- internal --}}
                                    <div class="hidden p-2 rounded-lg bg-gray-50 dark:bg-gray-800" id="assessor"
                                        role="tabpanel" aria-labelledby="assessor-tab">
                                        <div
                                            class="border border-dashed mt-2 p-2 flex flex-col gap-3 w-full h-[150px] overflow-y-auto">

                                            

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

    @section('scripts')
       
    @endsection
</x-app-layout>
