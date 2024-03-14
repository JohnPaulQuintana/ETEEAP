<x-app-layout>
    <div class="mx-auto max-w-screen-2xl p-4 md:p-6 2xl:p-5">
        <div class="mb-2">
            @include('partials.anouncement', ['admin' => 'Here is the list of declined applicants ' . Auth::user()->name])
        </div>

        <div class="shadow-md sm:rounded-lg overflow-hidden">
            <h1 class="font-bold text-blue-900 text-xl mt-5">Declined Applicant's</h1>
            <table id="accepted-table"
                class="table activate-select dt-responsive nowrap w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
            </table>

        </div>
    </div>
</x-app-layout>