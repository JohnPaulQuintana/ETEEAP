
<div id="requirementUpload-modal" tabindex="-1" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
    <div class="realtive p-4 w-full max-w-xl max-h-full">
        <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
            <button type="button" class="rs-close absolute top-3 end-2.5 text-red-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="requirementUpload-modal">
                <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                </svg>
                <span class="sr-only">Close modal</span>
            </button>
            <div class="p-4 md:p-5 text-center">
                <i class="fa-sharp fa-regular fa-circle-check mx-auto mb-2 text-gray-400 w-12 h-12 text-5xl text-bgprimary"></i>
               
                <h3 class="text-lg font-bold text-bgprimary dark:text-gray-400 uppercase">Upload your requirements to ETEEAP.</h3>
                
                <div class="">
                   
                    <form class="max-w-lg mx-auto text-black h-115 overflow-auto" enctype="multipart/form-data" action="{{ route('store') }}" method="post">
                        @csrf
                        <div class="mb-4 border-l-4 shadow-md bg-white p-1">
                            <label class="block mb-2 text-md text-left font-bold text-bgprimary" for="loi">1.Letter of Intent: <i class="fa-solid fa-asterisk text-red-500"></i></label>
                            <input name="loi" class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400" aria-describedby="user_avatar_help" id="loi" type="file" accept=".doc, .pdf, .png, .jpeg" required>
                            <div class="mt-1 text-sm text-left uppercase text-bgprimary dark:text-gray-300" id="user_avatar_help">addressed to: Mr. Philip M. Flores, Director, ETEEAP, Arellano University, 2600 Legarda St., Sampaloc, Manila 1008</div>
                        </div>
                        
                        <div class="mb-4 border-l-4 shadow-md bg-white p-1">
                            <label class="block mb-2 text-md text-left font-bold text-bgprimary" for="ce">2.CHED - ETEEAP Application Form: <i class="fa-solid fa-asterisk text-red-500"></i></label>
                            <input name="ce" class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400" aria-describedby="user_avatar_help" id="ce" type="file" accept=".doc, .pdf, .png, .jpeg" required>
                            <div class="mt-1 text-sm text-left uppercase text-bgprimary dark:text-gray-300" id="user_avatar_help">With 3 pieces of 1x1 picture </div>
                        </div>
                        
                        <div class="mb-4 border-l-4 shadow-md bg-white p-1">
                            <label class="block mb-2 text-md text-left font-bold text-bgprimary" for="cr">3.Comprehensive Resume (original): <i class="fa-solid fa-asterisk text-red-500"></i></label>
                            <input name="cr" class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400" aria-describedby="user_avatar_help" id="cr" type="file" accept=".doc, .pdf, .png, .jpeg" required>
                            
                        </div>
                        
                        <div class="mb-4 border-l-4 shadow-md bg-white p-1">
                            <label class="block mb-2 text-md text-left font-bold text-bgprimary" for="nce">4.Notarized Certificate of Employment with job description: <i class="fa-solid fa-asterisk text-red-500"></i></label>
                            <input name="nce" class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400" aria-describedby="user_avatar_help" id="nce" type="file" accept=".doc, .pdf, .png, .jpeg" required>
                            <div class="mt-1 text-sm text-left uppercase text-bgprimary dark:text-gray-300" id="user_avatar_help">with at least 5 years of working experience </div>
                        </div>
                        
                        <div class="mb-4 border-l-4 shadow-md bg-white p-1">
                            <label class="block mb-2 text-md text-left font-bold text-bgprimary" for="hdt">5.Honorable Dismissal and TOR:</label>
                            <input name="hdt" class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400" aria-describedby="user_avatar_help" id="hdt" type="file" accept=".doc, .pdf, .png, .jpeg" required>
                            <div class="mt-1 text-sm text-left uppercase text-bgprimary dark:text-gray-300" id="user_avatar_help">for undergraduate and for vocational courses </div>
                        </div>
                        
                        <div class="mb-4 border-l-4 shadow-md bg-white p-1">
                            <label class="block mb-2 text-md text-left font-bold text-bgprimary" for="f137_8">6.Form 137–A and Form 138:</label>
                            <input name="f137_8" class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400" aria-describedby="user_avatar_help" id="f137_8" type="file" accept=".doc, .pdf, .png, .jpeg" required>
                            <div class="mt-1 text-sm text-left uppercase text-bgprimary dark:text-gray-300" id="user_avatar_help">for High School Graduate or PEPT/ALS Certificates </div>
                            <div class="mt-1 text-sm text-left uppercase text-bgprimary dark:text-gray-300" id="user_avatar_help">for those who took the acceleration test, must be DepEd certified true copy </div>
                        </div>
                        
                        <div class="mb-4 border-l-4 shadow-md bg-white p-1">
                            <label class="block mb-2 text-md text-left font-bold text-bgprimary" for="abcb">7.Authenticated Birth Certificate/Affidavit of Birth (original):<i class="fa-solid fa-asterisk text-red-500"></i></label>
                            <input name="abcb" class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400" aria-describedby="user_avatar_help" id="abcb" type="file" accept=".doc, .pdf, .png, .jpeg" required>
                            <div class="mt-1 text-sm text-left uppercase text-bgprimary dark:text-gray-300" id="user_avatar_help">issued by the Philippine Statistics Authority  </div>
                           
                        </div>
                        
                        <div class="mb-4 border-l-4 shadow-md bg-white p-1">
                            <label class="block mb-2 text-md text-left font-bold text-bgprimary" for="mc">8.Marriage Certificate:</label>
                            <input name="mc" class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400" aria-describedby="user_avatar_help" id="mc" type="file" accept=".doc, .pdf, .png, .jpeg">
                            <div class="mt-1 text-sm text-left uppercase text-bgprimary dark:text-gray-300" id="user_avatar_help">for female, if married - photocopy  </div>
                           
                        </div>
                        
                        <div class="mb-4 border-l-4 shadow-md bg-white p-1">
                            <label class="block mb-2 text-md text-left font-bold text-bgprimary" for="nbc">9.NBI or Barangay clearance (original): <i class="fa-solid fa-asterisk text-red-500"></i></label>
                            <input name="nbc" class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400" aria-describedby="user_avatar_help" id="nbc" type="file" accept=".doc, .pdf, .png, .jpeg" required>
                            <div class="mt-1 text-sm text-left uppercase text-bgprimary dark:text-gray-300" id="user_avatar_help">for female, if married - photocopy  </div>
                           
                        </div>
                        
                        <div class="mb-4 border-l-4 shadow-md bg-white p-1">
                            <label class="block mb-2 text-md text-left font-bold text-bgprimary" for="tvid">10.Two valid IDs (photocopy): <i class="fa-solid fa-asterisk text-red-500"></i></label>
                            <input name="tvid[]" class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400" aria-describedby="user_avatar_help" id="tvid" type="file" accept=".doc, .pdf, .png, .jpeg" multiple required>
                            {{-- <div class="mt-1 text-sm text-left uppercase text-bgprimary dark:text-gray-300" id="user_avatar_help">for female, if married - photocopy  </div> --}}
                           
                        </div>
                        
                        <div class="mb-4 border-l-4 shadow-md bg-white p-1">
                            <label class="block mb-2 text-md text-left font-bold text-bgprimary" for="ge">11.Government eligibility: </label>
                            <input name="ge" class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400" aria-describedby="user_avatar_help" id="ge" type="file" accept=".doc, .pdf, .png, .jpeg">
                            <div class="mt-1 text-sm text-left uppercase text-bgprimary dark:text-gray-300" id="user_avatar_help">if any, photocopy  </div>
                           
                        </div>
                        
                        <div class="mb-4 border-l-4 shadow-md bg-white p-1">
                            <label class="block mb-2 text-md text-left font-bold text-bgprimary" for="pc">12.Proficiency Certificate: </label>
                            <input name="pc" class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400" aria-describedby="user_avatar_help" id="pc" type="file" accept=".doc, .pdf, .png, .jpeg">
                            <div class="mt-1 text-sm text-left uppercase text-bgprimary dark:text-gray-300" id="user_avatar_help">if any, photocopy  </div>
                            <div class="mt-1 text-sm text-left uppercase text-bgprimary dark:text-gray-300" id="user_avatar_help"> * Government Regulatory Board  </div>
                            <div class="mt-1 text-sm text-left uppercase text-bgprimary dark:text-gray-300" id="user_avatar_help"> * Licensed Practitioner in the Field  </div>
                            <div class="mt-1 text-sm text-left uppercase text-bgprimary dark:text-gray-300" id="user_avatar_help"> * Business Registration  </div>
                           
                        </div>
                        
                        <div class="mb-4 border-l-4 shadow-md bg-white p-1">
                            <label class="block mb-2 text-md text-left font-bold text-bgprimary" for="rl">13.Recommendation Letter: <i class="fa-solid fa-asterisk text-red-500"></i></label>
                            <input name="rl" class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400" aria-describedby="user_avatar_help" id="rl" type="file" accept=".doc, .pdf, .png, .jpeg" required>
                            <div class="mt-1 text-sm text-left uppercase text-bgprimary dark:text-gray-300" id="user_avatar_help">from immediate superior to undergo ETEEAP (original)   </div>
                           
                        </div>
                        
                        <div class="mb-4 border-l-4 shadow-md bg-white p-1">
                            <label class="block mb-2 text-md text-left font-bold text-bgprimary" for="cgmc">14. Certificate of Good Moral Character: </label>
                            <input name="cgmc" class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400" aria-describedby="user_avatar_help" id="cgmc" type="file" accept=".doc, .pdf, .png, .jpeg">
                            <div class="mt-1 text-sm text-left uppercase text-bgprimary dark:text-gray-300" id="user_avatar_help">from previous school (original)   </div>
                           
                        </div>
                        
                        <div class="mb-4 border-l-4 shadow-md bg-white p-1">
                            <label class="block mb-2 text-md text-left font-bold text-bgprimary" for="cer">15. Certificate: </label>
                            <input name="cer" class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400" aria-describedby="user_avatar_help" id="cer" type="file" accept=".doc, .pdf, .png, .jpeg">
                            <div class="mt-1 text-sm text-left uppercase text-bgprimary dark:text-gray-300" id="user_avatar_help">Trainings, Seminars and Workshops attended (photocopy)    </div>
                           
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
