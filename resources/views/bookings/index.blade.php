<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            @forelse ($bookings as $booking)
                <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                    <div class="flex-1">
                        <div class="flex justify-between items-center">
                            <div>
                                <span class="text-gray-800">Visit ID: {{ $booking->id }}</span>
                                <small class="ml-2 text-sm text-gray-600">Start time:
                                    {{ Carbon\Carbon::parse($booking->start_time)->format('Y-m-d H:i') }}</small>
                                <small class="ml-2 text-sm text-gray-600">End time:
                                    {{ Carbon\Carbon::parse($booking->end_time)->format('Y-m-d H:i') }}</small>
                                @if ($booking->status == '0')
                                    <p>Booking not started</p>
                                @else
                                    <p>Booking started</p>
                                @endif
                                @php
                                    $timeLeft = now('Europe/Vilnius')->diff($booking->start_time);
                                    $hoursLeft = $timeLeft->h;
                                    $minutesLeft = $timeLeft->i;
                                @endphp
                                @if ($timeLeft->invert == 0)
                                    <p>Time left: {{ $hoursLeft }} hours and {{ $minutesLeft }} minutes</p>
                                @else
                                    <p>Booking has passed</p>
                                @endif
                            </div>
                            @auth
                                <form method="POST" action="{{ route('bookings.update', $booking) }}">
                                    @csrf
                                    @method('patch')
                                    @if ($status === 'Yes' && $booking->status != 2)
                                        <x-primary-button name="status"
                                            value="1">{{ __('Mark as Started') }}</x-primary-button>
                                    @elseif ($booking->status == 1)
                                        <x-primary-button name="status"
                                            value="2">{{ __('Mark as Done') }}</x-primary-button>
                                    @endif
                                    <x-input-error :messages="$errors->get('message')" class="mt-2" />
                                </form>
                            @endauth
                        </div>
                    </div>
                </div>
            @empty
                <div class="p-6 flex space-x-2">
                    <p>No bookings available</p>
                </div>
            @endforelse
        </div>
    </div>
</x-app-layout>
