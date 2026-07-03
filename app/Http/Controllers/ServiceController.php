<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;

class ServiceController extends Controller
{
    public function index()
    {
        $services = Service::query()
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->orderBy('name')
            ->get();

        return view('frontend.services', compact('services'));
    }

    public function create()
    {
        abort(404);
    }

    public function store(Request $request)
    {
        abort(404);
    }

    public function show(string $slug)
    {
        $with = [];

        foreach (['service_features', 'service_gallery_images', 'service_products', 'service_steps', 'service_faqs'] as $table) {
            if (Schema::hasTable($table)) {
                match ($table) {
                    'service_features' => $with['features'] = fn ($query) => $query->where('is_active', true)->orderBy('sort_order'),
                    'service_gallery_images' => $with['galleryImages'] = fn ($query) => $query->where('is_active', true)->orderBy('sort_order'),
                    'service_products' => $with['products'] = fn ($query) => $query->where('is_active', true)->orderBy('sort_order'),
                    'service_steps' => $with['steps'] = fn ($query) => $query->where('is_active', true)->orderBy('sort_order'),
                    'service_faqs' => $with['faqs'] = fn ($query) => $query->where('is_active', true)->orderBy('sort_order'),
                };
            }
        }

        $service = Service::query()
            ->where('slug', $slug)
            ->with($with)
            ->where('is_active', true)
            ->firstOrFail();

        return view('frontend.service-detail', [
            'service' => $service,
            'relatedServices' => Service::query()
                ->where('is_active', true)
                ->whereKeyNot($service->id)
                ->orderBy('sort_order')
                ->limit(3)
                ->get(),
            'serviceTestimonials' => \App\Models\Testimonial::query()
                ->where('is_active', true)
                ->where(function ($query) use ($service) {
                    $query->where('service_name', $service->name)
                        ->orWhere('service_name', $service->slug);
                })
                ->orderByDesc('is_featured')
                ->orderBy('sort_order')
                ->get(),
        ]);
    }

    public function edit(Service $service)
    {
        abort(404);
    }

    public function update(Request $request, Service $service)
    {
        abort(404);
    }

    public function destroy(Service $service)
    {
        abort(404);
    }
}
