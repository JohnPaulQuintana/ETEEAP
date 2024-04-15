<div class="backdrop hidden"></div>
<div class="notification_modal rounded-md border-none w-[30%] hidden">
    <div class="flex justify-between items-center mb-5">
        <h1 class="font-bold text-[20px]"><i class="fa-solid fa-envelope text-blue-700 hover:text-blue-800 mr-2"></i> New
            Application Received</h1>
        <button class="n-close"><i
                class="fa-sharp fa-solid fa-xmark font-bold text-[20px] text-red-500 hover:text-red-700"></i></button>
    </div>
    <div class="grid grid-cols-1 justify-center gap-2 bg-slate-100 rounded-md p-5">


        <form action="{{ route('alert.destroy') }}" method="post">
            @csrf
            <div class="alert-container flex flex-col gap-2">

                

            </div>
            <div class="mt-2 flex justify-end">
                <button type="submit" class="bg-blue-700 p-2 text-white rounded-md hover:bg-blue-800"><i
                        class="fa-solid fa-broom-wide"></i> Clear All</button>
            </div>
        </form>

    </div>
    <h6 class="text-center mt-3 text-slate-300">This is the available new application received</h6>
</div>
