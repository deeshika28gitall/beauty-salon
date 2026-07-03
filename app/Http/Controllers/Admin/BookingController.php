<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Appointment;

class BookingController extends Controller
{
    public function index()
    {
        $bookings = Appointment::query()
            ->latest()
            ->paginate(10);

        return view('admin.bookings.index', compact('bookings'));
    }

    public function show(Appointment $booking)
    {
        return view('admin.bookings.show', ['booking' => $booking]);
    }
}
