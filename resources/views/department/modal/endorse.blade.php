<div class="backdrop hidden"></div>
<div class="endorse_user_modal rounded-md border-none w-[40%] hidden">
    <div class="flex justify-between border-b-2">
        <h1 class="mb-2">Endorse Application</h1>
        <button type="button" class="endorse-close rounded-md bg-red-500 px-2 text-white hover:bg-red-800 mb-2">X</button>
    </div>

    <div class="shadow-md p-2">
        <form action="#" method="post">
            @csrf     
            
            <div class="mt-2">
                
                <div class="border border-dashed relative p-2">
                    <span class="absolute top-[-12px] bg-white font-bold">Department Information</span>
                    <div class="mt-2 hidden">
                        <input type="number" id="edit_department_id" name="department_id" class="w-full rounded-md tracking-wide focus:ring-offset-2 focus:ring-2" required>
                        <input type="number" id="edit_user_id" name="user_id" class="w-full rounded-md tracking-wide focus:ring-offset-2 focus:ring-2" required>
                    </div>
                    <div class="mt-2">
                        <label for="name">Select a department:</label>
                        <select id="endorse_department" name="endorse_department" class="w-full rounded-md tracking-wide focus:ring-offset-2 focus:ring-2" required>

                        </select>
                    </div>
                    <div>
                        <div class="mt-2">
                            <label for="email">Available users:</label>
                            <select id="endorse_users" name="endorse_user" class="w-full rounded-md tracking-wide focus:ring-offset-2 focus:ring-2" required>

                            </select>
                            
                        </div>
                    </div>
                    
                    
                    
                </div>
            </div>

            <div class="mt-2">
                <input type="submit" value="Endorse Application" class=" bg-blue-700 text-white w-full p-2 rounded-md hover:bg-blue-800">
            </div>
        </form>
    </div>
</div>