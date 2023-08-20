<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="refresh" content="5">
</head>

</html>

<x-guest-layout>
    <div class="grid md:grid-cols-2">
        <x-service-card :bookings="$currentBookings" name="Current visits" />
        <x-service-card :bookings="$upcomingBookings" name="Upcoming visits" />
    </div>
</x-guest-layout>
