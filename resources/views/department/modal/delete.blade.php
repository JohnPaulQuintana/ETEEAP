<div class="backdrop hidden"></div>
<div class="delete_user_modal rounded-md border-none w-[40%] hidden">
    <div class="flex flex-col justify-center items-center border-b-2">
        <span class=""><i class="fa-sharp fa-solid fa-circle-info text-5xl text-red-700"></i></span>
        <h1 class="mb-2">Delete User Account</h1>
       <span class="text-red-400 p-2"> All the information is deleted and no longer be available!</span>
    </div>

    <div class="shadow-md p-2">
        <form action="{{ route('eteeap.delete.user') }}" method="post">
            @csrf     
            
            <div class="mt-5">
                {{-- <div class="border border-dashed p-2 py-5 relative">
                    <span class="absolute top-[-12px] bg-white font-bold">user Information</span>
                    <div class="mt-2">
                        <label for="department_name">Department Name:</label>
                        <input type="text" name="department_name" class="w-full rounded-md tracking-wide focus:ring-offset-2 focus:ring-2" required>
                    </div>
                </div> --}}
                <div class="border border-dashed relative p-2">
                    <span class="absolute top-[-12px] bg-white font-bold">User Information</span>
                    <div class="mt-2 hidden">
                        <input type="number" id="delete_department_id" name="department_id" class="w-full rounded-md tracking-wide focus:ring-offset-2 focus:ring-2" required>
                        <input type="number" id="delete_user_id" name="user_id" class="w-full rounded-md tracking-wide focus:ring-offset-2 focus:ring-2" readonly>
                    </div>
                    <div class="mt-2">
                        <label for="name">Name:</label>
                        <input type="text" id="delete_name" name="name" class="w-full rounded-md tracking-wide focus:ring-offset-2 focus:ring-2" readonly>
                    </div>
                    <div class="mt-2">
                        <label for="email">Email:</label>
                        <input type="text" id="delete_email" name="email" class="w-full rounded-md tracking-wide focus:ring-offset-2 focus:ring-2" readonly>
                    </div>
                    {{-- <div class="mt-2">
                        <label for="email">Verified Email Now? </label>
                        <input type="date" id="edit_email" name="email" class="w-full rounded-md tracking-wide focus:ring-offset-2 focus:ring-2" required>
                    </div> --}}
                    
                </div>
            </div>

            <div class="mt-5 flex justify-between items-center gap-2">
                <input type="submit" value="Delete Information" class="bg-blue-700 text-white w-[50%] p-2 rounded-md hover:bg-blue-800 hover:cursor-pointer" />
                <input type="button" class="delete-close rounded-md w-[50%] bg-red-500 p-2 text-white hover:bg-red-800 hover:cursor-pointer" value="Cancel" />
            </div>
        </form>
    </div>
</div>