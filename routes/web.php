<?php

use App\Http\Controllers\BookingController;
use App\Http\Controllers\ProfileController;
use App\Models\Booking;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('home');
})->name('welcome');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::resource('bookings', BookingController::class)
    ->only(['store', 'edit', 'update', 'destroy']);

Route::get('/bookings', [BookingController::class, 'index'])->middleware(['auth', 'verified'])->name('bookings.index');

Route::get('/service', [BookingController::class, 'serviceIndex'])->middleware(['auth', 'verified'])->name('service.index');
Route::get('/booking', [BookingController::class, 'bookingIndex'])->name('booking.index');

require __DIR__ . '/auth.php';
