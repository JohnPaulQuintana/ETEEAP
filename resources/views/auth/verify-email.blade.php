<x-guest-layout>

    <div class="w-full max-w-md p-4 bg-bgprimary border-bgprimary rounded-lg shadow sm:p-6 md:p-8 dark:bg-gray-800 dark:border-gray-700">
        <div class="mb-4 text-sm text-gray-600">
            {{ __("Thank you for signing up! Before proceeding, please verify your email address by clicking on the link we've sent to your inbox. If you haven't received the email, we're happy to send another one.") }}
        </div>
    
        @if (session('status') == 'verification-link-sent')
            <div class="mb-4 font-medium text-sm text-green-600">
                {{ __('A new verification link has been sent to the email address you provided during registration.') }}
            </div>
        @endif
    
        <div class="mt-4 flex items-center justify-between gap-1">
            <form method="POST" action="{{ route('verification.send') }}">
                @csrf
    
                <div>
                    <button type="submit" class="w-full text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Verification Email</button>
                </div>
            </form>
    
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="w-full text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-800">Cancel Verification</button>
                
            </form>
        </div>
    </div>
</x-guest-layout>
