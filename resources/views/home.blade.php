<x-guest-layout>
    <div class="relative flex items-top justify-center sm:items-center py-4 sm:pt-0">
        @if (Route::has('login'))
            <div class="hidden fixed top-0 right-0 px-6 py-4 sm:block">
                @auth
                    <a href="{{ route('bookings.index') }}" class="text-sm text-gray-700 dark:text-gray-500 underline">My
                        Bookings</a>
                @else
                    <a href="{{ route('login') }}" class="text-sm text-gray-700 dark:text-gray-500 underline">Log in</a>

                    {{--
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="ml-4 text-sm text-gray-700 dark:text-gray-500 underline">Register</a>
                        @endif
                        --}}
                @endauth
            </div>
        @endif

        <div class="max-w-2xl mx-auto p-4 sm:p-6 lg:p-8">
            <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900">Book an appointment</h5>
            <form method="POST" action="{{ route('bookings.store') }}">
                @csrf
                <x-primary-button name="user" class="mt-4" value="1">{{ __('Bank') }}</x-primary-button>
                <x-primary-button name="user" class="mt-4"
                    value="2">{{ __('Outpatient clinic') }}</x-primary-button>
                <x-primary-button name="user" class="mt-4"
                    value="3">{{ __('Post Office') }}</x-primary-button>
            </form>
        </div>
    </div>
</x-guest-layout>
