<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Str;
use Carbon\Carbon;

use function PHPUnit\Framework\isEmpty;

class BookingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(): View
    {
        $id = auth()->user()->id;
        $status = 'Yes';
        if (null !== Booking::where('user_id', $id)->where('status', '=', 1)->first()) {
            $status = 'No';
        }
        return view('bookings.index', [
            'bookings' => Booking::where('user_id', $id)->where('status', '!=', 2)->oldest()->take(8)->get(),
            'status' => $status,
        ]);
    }

    public function serviceIndex()
    {
        return view('service.index', [
            'currentBookings' => Booking::where('status', '=', '1')->get(),
            'upcomingBookings' => Booking::where('status', '=', '0')->oldest('start_time')->take(7)->get(),
        ]);
    }

    public function bookingIndex()
    {
        $id = request()->query('id');
        if ($id == null) {
            return redirect(route('welcome'));
        }
        $booking = Booking::where('id', $id)->first();
        return view('booking.index', [
            'booking' => $booking,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $booking = new Booking();

        $user = $request->get('user');

        $lastAppointment = Booking::latest('end_time')->where('user_id', $user)->where('status', '!=', 2)->first();
        if ($lastAppointment) {
            $nextAvailableTime = Carbon::parse($lastAppointment->end_time);
        } else {
            $nextAvailableTime = Carbon::now('Europe/Vilnius');
            if ($nextAvailableTime->minute >= 30) {
                $nextAvailableTime->addHour()->minute = 0;
            } else {
                $nextAvailableTime->minute = 30;
            }
        }
        if ($nextAvailableTime->hour >= 18 || $nextAvailableTime->hour < 8) {
            $nextAvailableTime = $nextAvailableTime->tomorrow()->setTime(8, 0);
        }
        $appointmentDuration = 30;
        $startDateTime = $nextAvailableTime;
        $endDateTime = $nextAvailableTime->copy()->addMinutes($appointmentDuration);

        $booking->start_time = $startDateTime;
        $booking->end_time = $endDateTime;
        $booking->user_id = $user;
        $booking->save();

        return redirect()->route('booking.index', ['id' => $booking->id]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Booking  $booking
     * @return \Illuminate\Http\Response
     */
    public function show(Booking $booking)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Booking  $booking
     * @return \Illuminate\Http\Response
     */
    public function edit(Booking $booking)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Booking  $booking
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Booking $booking)
    {
        $this->authorize('update', $booking);

        $validated = $request->validate([
            'status' => 'required|integer',
        ]);

        $booking->update($validated);

        return redirect(route('bookings.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Booking  $booking
     * @return \Illuminate\Http\Response
     */
    public function destroy(Booking $booking)
    {
        $booking->delete();

        return redirect(route('welcome'));
    }
}
