<div class="backdrop hidden"></div>
<div class="edit_user_modal rounded-md border-none w-[40%] hidden">
    <div class="flex justify-between border-b-2">
        <h1 class="mb-2">Edit User Account</h1>
        <button type="button" class="edit-close rounded-md bg-red-500 px-2 text-white hover:bg-red-800 mb-2">X</button>
    </div>

    <div class="shadow-md p-2">
        <form action="{{ route('eteeap.edit.user') }}" method="post">
            @csrf     
            
            <div class="mt-2">
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
                        <input type="number" id="edit_department_id" name="department_id" class="w-full rounded-md tracking-wide focus:ring-offset-2 focus:ring-2" required>
                        <input type="number" id="edit_user_id" name="user_id" class="w-full rounded-md tracking-wide focus:ring-offset-2 focus:ring-2" required>
                    </div>
                    <div class="mt-2">
                        <label for="name">Name:</label>
                        <input type="text" id="edit_name" name="name" class="w-full rounded-md tracking-wide focus:ring-offset-2 focus:ring-2" required>
                    </div>
                    <div class="mt-2">
                        <label for="email">Email:</label>
                        <input type="text" id="edit_email" name="email" class="w-full rounded-md tracking-wide focus:ring-offset-2 focus:ring-2" required>
                    </div>
                    {{-- <div class="mt-2">
                        <label for="email">Verified Email Now? </label>
                        <input type="date" id="edit_email" name="email" class="w-full rounded-md tracking-wide focus:ring-offset-2 focus:ring-2" required>
                    </div> --}}
                    
                </div>
            </div>

            <div class="mt-2">
                <input type="submit" value="Save Information" class=" bg-blue-700 text-white w-full p-2 rounded-md hover:bg-blue-800">
            </div>
        </form>
    </div>
</div>