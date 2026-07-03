<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Testimonial;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TestimonialController extends Controller
{
    public function index()
    {
        return view('admin.testimonials.index', [
            'testimonials' => Testimonial::orderBy('sort_order')->latest()->paginate(15),
        ]);
    }

    public function create()
    {
        return view('admin.testimonials.form', ['testimonial' => new Testimonial()]);
    }

    public function store(Request $request)
    {
        $data = $this->validated($request);
        $data['is_active'] = $request->boolean('is_active');
        $data['is_featured'] = $request->boolean('is_featured');

        if ($request->hasFile('client_image')) {
            $data['client_image_path'] = $request->file('client_image')->store('testimonials', 'public');
        }

        Testimonial::create($data);

        return redirect()->route('admin.testimonials.index')->with('success', 'Testimonial created.');
    }

    public function show(Testimonial $testimonial)
    {
        return view('admin.testimonials.show', compact('testimonial'));
    }

    public function edit(Testimonial $testimonial)
    {
        return view('admin.testimonials.form', compact('testimonial'));
    }

    public function update(Request $request, Testimonial $testimonial)
    {
        $data = $this->validated($request);
        $data['is_active'] = $request->boolean('is_active');
        $data['is_featured'] = $request->boolean('is_featured');

        if ($request->hasFile('client_image')) {
            if ($testimonial->client_image_path) {
                Storage::disk('public')->delete($testimonial->client_image_path);
            }
            $data['client_image_path'] = $request->file('client_image')->store('testimonials', 'public');
        }

        $testimonial->update($data);

        return redirect()->route('admin.testimonials.index')->with('success', 'Testimonial updated.');
    }

    public function destroy(Testimonial $testimonial)
    {
        if ($testimonial->client_image_path) {
            Storage::disk('public')->delete($testimonial->client_image_path);
        }

        $testimonial->delete();

        return redirect()->route('admin.testimonials.index')->with('success', 'Testimonial deleted.');
    }

    private function validated(Request $request): array
    {
        return $request->validate([
            'client_name' => ['required', 'string', 'max:255'],
            'client_role' => ['nullable', 'string', 'max:120'],
            'service_name' => ['nullable', 'string', 'max:255'],
            'message' => ['required', 'string'],
            'rating' => ['required', 'integer', 'min:1', 'max:5'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
            'client_image' => ['nullable', 'image', 'max:2048'],
        ]);
    }
}
