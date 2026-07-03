<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\BridalPackage;
use App\Models\GalleryImage;
use App\Models\Service;
use App\Models\Testimonial;

class DashboardController extends Controller
{
    public function __invoke()
    {
        return view('admin.dashboard', [
            'totalServices' => Service::count(),
            'totalPackages' => BridalPackage::count(),
            'totalGalleryImages' => GalleryImage::count(),
            'totalTestimonials' => Testimonial::count(),
            'totalAppointments' => Appointment::count(),
            'recentAppointments' => Appointment::latest()->take(8)->get(),
        ]);
    }
}
