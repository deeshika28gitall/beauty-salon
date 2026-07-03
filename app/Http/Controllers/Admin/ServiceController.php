<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ServiceFaq;
use App\Models\ServiceFeature;
use App\Models\ServiceGalleryImage;
use App\Models\ServiceProduct;
use App\Models\ServiceStep;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ServiceController extends Controller
{
    public function index()
    {
        return view('admin.services.index', [
            'services' => Service::orderBy('sort_order')->latest()->paginate(15),
        ]);
    }

    public function create()
    {
        return view('admin.services.form', [
            'service' => new Service(),
            'featureText' => '',
            'productText' => '',
            'stepText' => '',
            'faqText' => '',
        ]);
    }

    public function store(Request $request)
    {
        $data = $this->validated($request);
        $data['slug'] = Str::slug($data['slug'] ?: $data['name']);
        $data['is_active'] = $request->boolean('is_active');
        $data['is_featured'] = $request->boolean('is_featured');
        $data['short_description'] = $data['short_description'] ?? null;
        $data['full_description'] = $data['full_description'] ?? null;

        if ($request->hasFile('image')) {
            $data['image_path'] = $request->file('image')->store('services', 'public');
        }

        $service = Service::create($data);
        $this->syncChildContent($request, $service);

        return redirect()->route('admin.services.index')->with('success', 'Service created.');
    }

    public function show(Service $service)
    {
        return view('admin.services.show', [
            'service' => $service->load([
                'features' => fn ($query) => $query->orderBy('sort_order'),
                'galleryImages' => fn ($query) => $query->orderBy('sort_order'),
                'products' => fn ($query) => $query->orderBy('sort_order'),
                'steps' => fn ($query) => $query->orderBy('sort_order'),
                'faqs' => fn ($query) => $query->orderBy('sort_order'),
            ]),
            'featureText' => $service->features->pluck('feature')->implode("\n"),
            'productText' => $service->products->pluck('product_name')->implode("\n"),
            'stepText' => $service->steps->map(fn ($step) => trim($step->title.' | '.$step->description))->implode("\n"),
            'faqText' => $service->faqs->map(fn ($faq) => trim($faq->question.' | '.$faq->answer))->implode("\n"),
        ]);
    }

    public function edit(Service $service)
    {
        $service->load(['features', 'galleryImages', 'products', 'steps', 'faqs']);

        return view('admin.services.form', [
            'service' => $service,
            'featureText' => $service->features->pluck('feature')->implode("\n"),
            'productText' => $service->products->pluck('product_name')->implode("\n"),
            'stepText' => $service->steps->map(fn ($step) => trim($step->title.' | '.$step->description))->implode("\n"),
            'faqText' => $service->faqs->map(fn ($faq) => trim($faq->question.' | '.$faq->answer))->implode("\n"),
        ]);
    }

    public function update(Request $request, Service $service)
    {
        $data = $this->validated($request, $service->id);
        $data['slug'] = Str::slug($data['slug'] ?: $data['name']);
        $data['is_active'] = $request->boolean('is_active');
        $data['is_featured'] = $request->boolean('is_featured');
        $data['short_description'] = $data['short_description'] ?? null;
        $data['full_description'] = $data['full_description'] ?? null;

        if ($request->hasFile('image')) {
            if ($service->image_path) {
                Storage::disk('public')->delete($service->image_path);
            }
            $data['image_path'] = $request->file('image')->store('services', 'public');
        }

        $service->update($data);
        $this->syncChildContent($request, $service);

        return redirect()->route('admin.services.index')->with('success', 'Service updated.');
    }

    public function destroy(Service $service)
    {
        if ($service->image_path) {
            Storage::disk('public')->delete($service->image_path);
        }

        $service->delete();

        return redirect()->route('admin.services.index')->with('success', 'Service deleted.');
    }

    private function validated(Request $request, ?int $ignoreId = null): array
    {
        return $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:255', 'unique:services,slug'.($ignoreId ? ','.$ignoreId : '')],
            'short_description' => ['nullable', 'string', 'max:500'],
            'description' => ['nullable', 'string'],
            'full_description' => ['nullable', 'string'],
            'starting_price' => ['nullable', 'numeric', 'min:0'],
            'duration_minutes' => ['nullable', 'integer', 'min:1'],
            'icon' => ['nullable', 'string', 'max:80'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
            'image' => ['nullable', 'image', 'max:2048'],
            'gallery_images.*' => ['nullable', 'image', 'max:2048'],
            'features_text' => ['nullable', 'string'],
            'products_text' => ['nullable', 'string'],
            'steps_text' => ['nullable', 'string'],
            'faqs_text' => ['nullable', 'string'],
        ]);
    }

    private function syncChildContent(Request $request, Service $service): void
    {
        ServiceFeature::where('service_id', $service->id)->delete();
        ServiceProduct::where('service_id', $service->id)->delete();
        ServiceStep::where('service_id', $service->id)->delete();
        ServiceFaq::where('service_id', $service->id)->delete();

        foreach (preg_split('/\r\n|\r|\n/', (string) $request->input('features_text')) ?: [] as $index => $feature) {
            $feature = trim($feature);
            if ($feature !== '') {
                ServiceFeature::create([
                    'service_id' => $service->id,
                    'feature' => $feature,
                    'sort_order' => $index,
                    'is_active' => true,
                ]);
            }
        }

        foreach (preg_split('/\r\n|\r|\n/', (string) $request->input('products_text')) ?: [] as $index => $product) {
            $product = trim($product);
            if ($product !== '') {
                ServiceProduct::create([
                    'service_id' => $service->id,
                    'product_name' => $product,
                    'sort_order' => $index,
                    'is_active' => true,
                ]);
            }
        }

        foreach (preg_split('/\r\n|\r|\n/', (string) $request->input('steps_text')) ?: [] as $index => $stepLine) {
            $stepLine = trim($stepLine);
            if ($stepLine === '') {
                continue;
            }

            [$title, $description] = array_pad(array_map('trim', explode('|', $stepLine, 2)), 2, '');
            ServiceStep::create([
                'service_id' => $service->id,
                'title' => $title ?: 'Step ' . ($index + 1),
                'description' => $description ?: null,
                'sort_order' => $index,
                'is_active' => true,
            ]);
        }

        foreach (preg_split('/\r\n|\r|\n/', (string) $request->input('faqs_text')) ?: [] as $index => $faqLine) {
            $faqLine = trim($faqLine);
            if ($faqLine === '') {
                continue;
            }

            [$question, $answer] = array_pad(array_map('trim', explode('|', $faqLine, 2)), 2, '');
            if ($question !== '' && $answer !== '') {
                ServiceFaq::create([
                    'service_id' => $service->id,
                    'question' => $question,
                    'answer' => $answer,
                    'sort_order' => $index,
                    'is_active' => true,
                ]);
            }
        }

        if ($request->hasFile('gallery_images')) {
            ServiceGalleryImage::where('service_id', $service->id)->each(function (ServiceGalleryImage $galleryImage) {
                Storage::disk('public')->delete($galleryImage->image_path);
                $galleryImage->delete();
            });

            foreach ($request->file('gallery_images') as $index => $file) {
                if (! $file) {
                    continue;
                }

                ServiceGalleryImage::create([
                    'service_id' => $service->id,
                    'title' => $service->name . ' image ' . ($index + 1),
                    'image_path' => $file->store('service-gallery', 'public'),
                    'sort_order' => $index,
                    'is_active' => true,
                ]);
            }
        }
    }
}
