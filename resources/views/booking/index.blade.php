<x-guest-layout>
    <div class="w-full p-6 bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">
        <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">{{ $booking->user->name }}</h5>
        <p class="text-sm text-gray-500 truncate dark:text-gray-400">
            {{ Carbon\Carbon::parse($booking->start_time)->format('Y-m-d H:i') }} -
            {{ Carbon\Carbon::parse($booking->end_time)->format('Y-m-d H:i') }}
        </p>
        @php
            $timeLeft = now('Europe/Vilnius')->diff($booking->start_time);
            $hoursLeft = $timeLeft->h;
            $minutesLeft = $timeLeft->i;
        @endphp
        @if ($timeLeft->invert == 0)
            <p class="text-sm text-gray-500 truncate dark:text-gray-400">Time left: {{ $hoursLeft }} hours and
                {{ $minutesLeft }} minutes</p>
        @else
            <p class="text-sm text-gray-500 truncate dark:text-gray-400">Booking has passed</p>
        @endif
        <p class="text-l text-gray-500 truncate dark:text-gray-400">Visit ID: {{ $booking->id }}</p>
        <form method="POST" action="{{ route('bookings.destroy', $booking) }}">
            @csrf
            @method('delete')
            <x-primary-button :href="route('bookings.destroy', $booking)" onclick="event.preventDefault(); this.closest('form').submit();">
                {{ __('Cancel') }}
            </x-primary-button>
        </form>
    </div>
</x-guest-layout>
