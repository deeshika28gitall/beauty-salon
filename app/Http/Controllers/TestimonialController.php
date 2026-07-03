<?php

namespace App\Http\Controllers;

use App\Models\Testimonial;
use Illuminate\Http\Request;

class TestimonialController extends Controller
{
    public function index()
    {
        return Testimonial::query()
            ->where('is_active', true)
            ->orderByDesc('is_featured')
            ->orderBy('sort_order')
            ->latest()
            ->get();
    }

    public function create()
    {
        abort(404);
    }

    public function store(Request $request)
    {
        abort(404);
    }

    public function show(Testimonial $testimonial)
    {
        abort_if(! $testimonial->is_active, 404);

        return $testimonial;
    }

    public function edit(Testimonial $testimonial)
    {
        abort(404);
    }

    public function update(Request $request, Testimonial $testimonial)
    {
        abort(404);
    }

    public function destroy(Testimonial $testimonial)
    {
        abort(404);
    }
}
