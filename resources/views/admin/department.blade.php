<x-app-layout>
    <div class="mx-auto max-w-screen-2xl p-4 md:p-6 2xl:p-5">


        <div class="flex justify-between mt-5 mb-5">
            <div class="flex">
                <h1 class="text-blue-900 mx-2 font-bold text-xl border-l-4 pl-2 dark:text-white">Department List </h1>

            </div>
            @include('partials.breadcrumb')
        </div>

        <div class="shadow-md sm:rounded-lg overflow-hidden px-2">


            <div class="mb-4 border-b border-gray-200 dark:border-gray-700">
                <ul class="flex flex-wrap -mb-px text-sm font-medium text-center" id="default-tab"
                    data-tabs-toggle="#default-tab-content" role="tablist">
                    @foreach ($departments as $department)
                        <li class="me-2" role="presentation">
                            <button class="inline-block p-4 rounded-t-lg capitalize items-center"
                                id="{{ str_replace(' ', '', $department->department_name) }}-tab"
                                data-tabs-target="#{{ str_replace(' ', '', $department->department_name) }}"
                                type="button" role="tab"
                                aria-controls="{{ str_replace(' ', '', $department->department_name) }}"
                                aria-selected="false">
                                {{ $department->department_name }}
                                <span class="p-1 block w-fit rounded-lg font-bold text-blue-700 mx-auto">
                                    <i class="fa-solid fa-users-medical"></i> {{ $department->user_count }}</span>
                            </button>

                        </li>
                    @endforeach


                    <li role="presentation">
                        <button
                            class="inline-block p-4 rounded-t-lg hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300"
                            id="add-tab" data-tabs-target="#add" type="button" role="tab" aria-controls="add"
                            aria-selected="false">Add Department</button>
                    </li>

                    <li role="presentation">
                        @php
                            $enableD = 'false';
                        @endphp
                        @error('department_id')
                            @php $enableD = 'true'; @endphp
                        @enderror
                        @error('name')
                            @php $enableD = 'true'; @endphp
                        @enderror
                        @error('email')
                            @php $enableD = 'true'; @endphp
                        @enderror
                        @error('password')
                            @php $enableD = 'true'; @endphp
                        @enderror
                        <button
                            class="inline-block p-4 rounded-t-lg hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300"
                            id="users-tab" data-tabs-target="#user" type="button" role="tab" aria-controls="user"
                            aria-selected="@php echo $enableD; @endphp">Add User</button>
                    </li>
                </ul>
            </div>
            <div id="default-tab-content">

                @foreach ($departments as $department)
                    {{-- {{ $department }} --}}
                    <div class="hidden p-4 rounded-lg bg-gray-50 dark:bg-gray-800"
                        id="{{ str_replace(' ', '', $department->department_name) }}" role="tabpanel"
                        aria-labelledby="{{ str_replace(' ', '', $department->department_name) }}-tab">
                        <div class="flex justify-between">
                            <h1 class="border-l-4 pl-2 border-blue-900 text-blue-900 font-bold">Users</h1>
                            <h1 data-id="{{ $department->id }}"
                                class="deleteDept text-red-500 border border-red-500 rounded-md p-1 font-bold hover:text-red-700 hover:cursor-pointer">
                                Delete Department</h1>
                        </div>

                        <div class="relative border border-gray-3 overflow-x-auto shadow-sm sm:rounded-lg">
                            <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                                <thead
                                    class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                    <tr>
                                        <th scope="col" class="px-6 py-3">
                                            Name
                                        </th>
                                        <th scope="col" class="px-6 py-3">
                                            Email
                                        </th>
                                        <th scope="col" class="px-6 py-3">
                                            Verified
                                        </th>
                                        <th scope="col" class="px-6 py-3">
                                            Date
                                        </th>
                                        <th scope="col" class="px-6 py-3">
                                            Department
                                        </th>
                                        <th scope="col" class="px-6 py-3">
                                            Action
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>

                                    @foreach ($department->user as $user)
                                        <tr
                                            class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700">
                                            <th scope="row"
                                                class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                                {{ $user->name }}
                                            </th>
                                            <td class="px-6 py-4">
                                                {{ $user->email }}
                                            </td>
                                            <td class="px-6 py-4">
                                                @if ($user->email_verified_at == null)
                                                    <span
                                                        class="bg-red-100 text-red-800 text-sm font-medium me-2 px-2.5 py-0.5 rounded dark:bg-red-900 dark:text-red-300">No</span>
                                                @else
                                                    <span
                                                        class="bg-green-100 text-green-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded dark:bg-green-900 dark:text-green-300">Yes</span>
                                                @endif

                                            </td>
                                            <td class="px-6 py-4">
                                                {{ $user->created_at }}
                                            </td>
                                            <td class="px-6 py-4">
                                                {{ $department->department_name }}
                                            </td>
                                            <td class="px-6 py-4">
                                                <a data-id="{{ $user->id }}"
                                                    data-department_id="{{ $user->department_id }}"
                                                    class="e-user font-medium mr-2 text-blue-600 dark:text-blue-500 hover:underline hover:cursor-pointer">Edit</a>
                                                <a data-id="{{ $user->id }}"
                                                    data-department_id="{{ $user->department_id }}"
                                                    class="d-user font-medium text-red-500 dark:text-red-500 hover:underline hover:cursor-pointer">Delete</a>
                                            </td>
                                        </tr>
                                    @endforeach


                                </tbody>
                            </table>
                        </div>

                    </div>
                @endforeach




                <div class="hidden p-4 rounded-lg bg-gray-50 dark:bg-gray-800" id="add" role="tabpanel"
                    aria-labelledby="add-tab">

                    <form class="max-w-full" action="{{ route('department.store') }}" method="POST">
                        @csrf
                        <div>
                            <h1 class="text-xl mb-2">Add New Department</h1>
                        </div>
                        <div class="flex items-center gap-2">
                            <div class="relative w-100">
                                <div class="absolute inset-y-0 start-0 flex items-center ps-3.5 pointer-events-none">
                                    <i class="fa-solid fa-house-building"></i>
                                </div>
                                <input type="text" name="department"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full ps-10 p-2.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                    placeholder="Department name" required>
                            </div>
                            <div class="relative">
                                <div class="absolute inset-y-0 start-0 flex items-center ps-3.5 pointer-events-none">
                                    <i class="fa-sharp fa-solid fa-plus text-white"></i>
                                </div>
                                <button type="submit"
                                    class="bg-blue-700 border border-blue-700 text-white text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full ps-10 p-2.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">Create
                                    Department</button>
                            </div>
                        </div>
                    </form>

                </div>

                <div class="hidden p-4 rounded-lg bg-gray-50 dark:bg-gray-800" id="user" role="tabpanel"
                    aria-labelledby="user-tab">

                    <form class="max-w-full" action="{{ route('department.user') }}" method="POST">
                        @csrf
                        <div>
                            <h1 class="text-xl mb-2">Add Users to Designated Departments</h1>
                        </div>
                        <div class="flex items-center gap-2">

                            <div class="relative w-70">


                                <select id="countries" name="department_id"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                    <option value="">Select a Department</option>
                                    <div class="dept-list">
                                        @foreach ($departments as $department)
                                            <option value="{{ $department->id }}">{{ $department->department_name }}
                                            </option>
                                        @endforeach

                                    </div>
                                </select>
                                @error('department_id')
                                    <span class="text-red-500">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="relative w-70">

                                <input type="text" name="name"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full ps-10 p-2.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                    placeholder="John Doe">
                                @error('name')
                                    <span class="text-red-500">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="relative w-70">

                                <input type="email" name="email"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full ps-10 p-2.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                    placeholder="johndoe@email.com">
                                @error('email')
                                    <span class="text-red-500">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="relative w-70">
                                <input type="password" name="password"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full ps-10 p-2.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                    placeholder="password">
                                @error('password')
                                    <span class="text-red-500">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="relative">
                                <div class="absolute inset-y-0 start-0 flex items-center ps-3.5 pointer-events-none">
                                    <i class="fa-sharp fa-solid fa-plus text-white"></i>
                                </div>
                                <button type="submit"
                                    class="bg-blue-700 border border-blue-700 text-white text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full ps-10 p-2.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">Add
                                    user</button>
                            </div>
                        </div>
                    </form>

                </div>

            </div>


            @if (session('status'))
                @if (session('status') === 'success')
                    <div id="toast-success"
                        class="flex items-center w-full max-w-fit p-4 mb-4 text-gray-500 bg-white rounded-lg shadow dark:text-gray-400 dark:bg-gray-800"
                        role="alert">
                        <div
                            class="inline-flex items-center justify-center flex-shrink-0 w-8 h-8 text-green-500 bg-green-100 rounded-lg dark:bg-green-800 dark:text-green-200">
                            <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                fill="currentColor" viewBox="0 0 20 20">
                                <path
                                    d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 8.207-4 4a1 1 0 0 1-1.414 0l-2-2a1 1 0 0 1 1.414-1.414L9 10.586l3.293-3.293a1 1 0 0 1 1.414 1.414Z" />
                            </svg>
                            <span class="sr-only">Check icon</span>
                        </div>
                        <div class="ms-3 text-sm font-normal">{{ session('message') }}.</div>
                        <button type="button"
                            class="ms-auto -mx-1.5 -my-1.5 bg-white text-gray-400 hover:text-gray-900 rounded-lg focus:ring-2 focus:ring-gray-300 p-1.5 hover:bg-gray-100 inline-flex items-center justify-center h-8 w-8 dark:text-gray-500 dark:hover:text-white dark:bg-gray-800 dark:hover:bg-gray-700"
                            data-dismiss-target="#toast-success" aria-label="Close">
                            <span class="sr-only">Close</span>
                            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                fill="none" viewBox="0 0 14 14">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                            </svg>
                        </button>
                    </div>
                @else
                    <div id="toast-danger"
                        class="flex items-center w-full max-w-fit p-4 mb-4 text-gray-500 bg-white rounded-lg shadow dark:text-gray-400 dark:bg-gray-800"
                        role="alert">
                        <div
                            class="inline-flex items-center justify-center flex-shrink-0 w-8 h-8 text-red-500 bg-red-100 rounded-lg dark:bg-red-800 dark:text-red-200">
                            <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                fill="currentColor" viewBox="0 0 20 20">
                                <path
                                    d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 11.793a1 1 0 1 1-1.414 1.414L10 11.414l-2.293 2.293a1 1 0 0 1-1.414-1.414L8.586 10 6.293 7.707a1 1 0 0 1 1.414-1.414L10 8.586l2.293-2.293a1 1 0 0 1 1.414 1.414L11.414 10l2.293 2.293Z" />
                            </svg>
                            <span class="sr-only">Error icon</span>
                        </div>
                        <div class="ms-3 text-sm font-normal">{{ session('message') }}.</div>
                        <button type="button"
                            class="ms-auto -mx-1.5 -my-1.5 bg-white text-gray-400 hover:text-gray-900 rounded-lg focus:ring-2 focus:ring-gray-300 p-1.5 hover:bg-gray-100 inline-flex items-center justify-center h-8 w-8 dark:text-gray-500 dark:hover:text-white dark:bg-gray-800 dark:hover:bg-gray-700"
                            data-dismiss-target="#toast-danger" aria-label="Close">
                            <span class="sr-only">Close</span>
                            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                fill="none" viewBox="0 0 14 14">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                            </svg>
                        </button>
                    </div>
                @endif
            @endif

        </div>
    </div>

    @section('scripts')
        <script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/responsive/2.2.9/js/dataTables.responsive.min.js"></script>
        <script>
            $(document).ready(function() {
                const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                $(document).on('click', '.deleteDept', function() {
                    // alert($(this).data('id'))
                    var data = {
                        'id': $(this).data('id')
                    }
                    actionToDo('/delete-department', 'post', data)
                        .then(function(data) {
                            console.log(data)
                            if (data.status === 'success') {

                                Swal.fire({
                                    title: "Department is no longer available!",
                                    text: "Department deleted successfully!",
                                    icon: "success",
                                    showConfirmButton: false,
                                    timer: 1000
                                });
                                setTimeout(() => {
                                    window.location.reload()
                                }, 1000);
                            } else {

                                Swal.fire({
                                    title: "Error on Deleting!",
                                    text: `${data.message}`,
                                    icon: "error",
                                    showConfirmButton: false,
                                    timer: 1000
                                });
                            }
                            // Handle the data or perform additional actions if needed
                        })
                        .catch(function(errorMessage) {
                            console.error(errorMessage);
                            // Handle the error as needed
                        });
                })

                $(document).on('click', '.e-user', function() {
                    var id = $(this).data('id');
                    var department_id = $(this).data('department_id');
                    console.log(id, department_id)
                    var data = {
                        'user_id': id,
                        'department_id': department_id
                    }
                    actionToDo('/user-info', 'get', data)
                        .then(function(data) {
                            console.log(data)
                            if (data.status === 'success') {
                                triggerSweetInput(data.users[0], data.depts)
                            }

                        })
                        .catch(function(error) {
                            console.log(error)
                        })
                })

                $(document).on('click', '.d-user', function(){
                    var id = $(this).data('id');
                    var data = {
                        'user_id': id,
                    }
                    Swal.fire({
                        title: "Are you sure?",
                        text: "You won't be able to revert this!",
                        icon: "warning",
                        showCancelButton: true,
                        confirmButtonColor: "#3085d6",
                        cancelButtonColor: "#d33",
                        confirmButtonText: "Yes, delete it!"
                        }).then((result) => {
                        if (result.isConfirmed) {
                            actionToDo('/user-delete', 'post', data)
                                .then(function(data) {
                                    console.log(data)
                                    if (data.status === 'success') {
                                        Swal.fire({
                                            title: "Deleted!",
                                            text: "User has been deleted.",
                                            icon: "success"
                                        });
                                        setTimeout(() => {
                                            // if(result.value.refresh){
                                            window.location.reload()
                                            // }
                                        }, 3000);
                                    }

                                })
                                .catch(function(error) {
                                    console.log(error)
                                })
                            
                            
                        }
                    });

                })

                // Function to fetch data
                function actionToDo(endpoint, type, params) {

                    return new Promise(function(resolve, reject) {
                        $.ajax({
                            url: endpoint,
                            type: type,
                            data: params,
                            dataType: 'json',
                            headers: {
                                'X-CSRF-TOKEN': csrfToken
                            },
                            success: function(data) {

                                resolve(data); // Resolve the Promise with the fetched data
                            },
                            error: function(error) {
                                console.error('Error fetching data:', error);
                                reject('Error fetching data: ' + error);
                            }
                        });
                    });
                }

                function triggerSweetInput(users, depts) {
                    Swal.fire({
                        title: `${users.name}`,
                        html: `<div class="border rounded-md p-3">
                                <div class="mb-2 hidden">
                                    <label for="user_id" class="text-left block mb-2 text-md font-bold text-gray-900 dark:text-white">Interviewer Name</label>
                                    <input type="text" id="user_id" value="${users.id}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" />
                                </div>
                                
                               
                                <div class="mb-2">
                                    <label for="name" class="block text-left mb-2 text-md font-bold text-gray-900 dark:text-white">Name</label>
                                    <input type="text" id="name" value="${users.name}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" />
                                </div>

                                <div class="mb-2">
                                    <label for="email" class="block text-left mb-2 text-md font-bold text-gray-900 dark:text-white">Email</label>
                                    <input type="email" id="email" value="${users.email}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" />
                                </div>
                               
                                <div class="mb-2">
                                    <label for="dept" class="block text-left mb-2 text-md font-bold text-gray-900 dark:text-white">Department</label>
                                    <select id="dept" name="dept" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                        <option value="${users.dept_id}">${users.department_name}</option>
                                        ${depts.map(dept => `<option value="${dept.id}">${dept.department_name}</option>`).join('')}
                                    </select>
                                    
                                </div>

                                
                               
                            </div>`,
                        inputAttributes: {
                            autocapitalize: "off"
                        },
                        showCancelButton: true,
                        confirmButtonText: "Update Information",
                        showLoaderOnConfirm: true,
                        allowOutsideClick: false,
                        preConfirm: async () => {
                           
                            var name = $('#name').val()
                            var email = $('#email').val()
                            var dept = $('#dept').val()
                            
                            var user_id = $('#user_id').val()
                           
                            if (name == '' || email == '' || dept == '') {
                                return Swal.showValidationMessage(`All field is required to fill`)
                            }

                            try {
                                // let data = {'user_id': user_id, 'interviewer': interviewer, 'date':date, 'time':time, 'address':address, 'message':message}
                                const response = await fetch(`{{ route('user.update') }}`, {
                                    method: 'POST',
                                    headers: {
                                        'Content-Type': 'application/json',
                                        'X-CSRF-TOKEN': csrfToken
                                    },
                                    body: JSON.stringify({
                                        'user_id': user_id,
                                        'name': name,
                                        'email': email,
                                        'dept': dept
                                    }),
                                });

                                if (!response.ok) {
                                    return Swal.showValidationMessage(`
                                    ${JSON.stringify(await response.json())}
                                    `);
                                }
                                return response.json();

                            } catch (error) {
                                Swal.showValidationMessage(`
                                    Request failed: ${error}
                                `);
                            }
                        },
                        // allowOutsideClick: () => !Swal.isLoading()
                    }).then((result) => {
                        if (result.isConfirmed) {
                            console.log(result)
                            Swal.fire({
                                title: "Information Updated Successfully!",
                                text: `The page is refreshing in 3 seconds`,
                                icon: "success"
                            });

                            setTimeout(() => {
                                // if(result.value.refresh){
                                window.location.reload()
                                // }
                            }, 3000);
                        }
                    });
                }

                
            })
        </script>
    @endsection
</x-app-layout>
