<div class="backdrop hidden"></div>
<div class="add_department rounded-md border-none w-[30%] hidden">
    <div class="flex justify-between border-b-2">
        <h1 class="mb-2">
            <i class="fa-solid fa-building-circle-check text-blue-700 hover:text-blue-800 text-[18px]"></i>
            Add Department</h1>
        <button type="button" class="department-close rounded-md bg-red-500 px-2 text-white hover:bg-red-800 mb-2">X</button>
    </div>

    <div class="shadow-md p-2">
        <form action="{{ route('eteeap.add.department') }}" method="post">
            @csrf     
            
            <div class="mt-2">
                <div class="border border-dashed p-2 py-5 relative">
                    <span class="absolute top-[-12px] bg-white font-bold">Department Information</span>
                    <div class="mt-2">
                        <label for="department_name">Department Name:</label>
                        <input type="text" name="department_name" class="w-full rounded-md tracking-wide focus:ring-offset-2 focus:ring-2" required>
                    </div>
                </div>
                {{-- <div class="border border-dashed relative p-2">
                    <span class="absolute top-[-12px] bg-white font-bold">Staff Information</span>
                    <div class="mt-2">
                        <label for="name">Name:</label>
                        <input type="text" name="name" class="w-full rounded-md tracking-wide focus:ring-offset-2 focus:ring-2">
                    </div>
                    <div class="mt-2">
                        <label for="email">Email:</label>
                        <input type="text" name="email" class="w-full rounded-md tracking-wide focus:ring-offset-2 focus:ring-2">
                    </div>
                    <div class="mt-2">
                        <label for="password">Password:</label>
                        <input type="password" name="password" class="w-full rounded-md tracking-wide focus:ring-offset-2 focus:ring-2">
                    </div>
                </div> --}}
            </div>

            <div class="mt-2">
                <input type="submit" value="Save Information" class=" bg-blue-700 text-white w-full p-2 rounded-md hover:bg-blue-800">
            </div>
        </form>
    </div>
</div>