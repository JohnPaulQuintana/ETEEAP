<x-app-layout>
    <div class="mx-auto max-w-screen-2xl p-4 md:p-6 2xl:p-5">
        <div class="mb-2">
            @include('partials.anouncement', ['admin' => 'Welcome back, ' . Auth::user()->name . "! We're glad to have you back on your profile. If you need to update any information or explore your profile further, you're in the right place."])
        </div>

        <div class="flex justify-between mt-5">
            <div class="flex">
                <h1 class="text-blue-900 mx-2 font-bold text-xl border-l-4 pl-2 dark:text-white">Profile Management </h1>
                
            </div>
            @include('partials.breadcrumb')
        </div>
    </div>

    <div class="py-2">
        <div class="max-w-full grid grid-cols-1 gap-2 md:grid-cols-2 lg:grid-cols-2 mx-auto sm:px-6 lg:px-8">
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            {{-- <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.delete-user-form')
                </div>
            </div> --}}
        </div>
    </div>
</x-app-layout>
