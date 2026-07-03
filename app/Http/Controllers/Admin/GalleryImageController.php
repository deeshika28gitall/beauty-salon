<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\GalleryImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class GalleryImageController extends Controller
{
    private const CATEGORIES = [
        'bridal' => 'Bridal Makeup',
        'party' => 'Party Makeup',
        'engagement' => 'Engagement Makeup',
        'hair-styling' => 'Hair Styling',
        'reception' => 'Reception Look',
        'other' => 'Other',
    ];

    public function index()
    {
        return view('admin.gallery-images.index', [
            'images' => GalleryImage::orderBy('sort_order')->latest()->paginate(5)->withQueryString(),
            'categories' => self::CATEGORIES,
        ]);
    }

    public function create()
    {
        return view('admin.gallery-images.form', [
            'image' => new GalleryImage(['category' => 'other']),
            'categories' => self::CATEGORIES,
        ]);
    }

    public function store(Request $request)
    {
        $hasUpload = $request->hasFile('images');
        $urlsInput = trim($request->input('external_image_urls') ?? '');
        $hasUrls = !empty($urlsInput);

        if (!$hasUpload && !$hasUrls) {
            return back()
                ->withErrors(['images' => 'Please upload at least one image file or paste at least one image URL.'])
                ->withInput();
        }

        // Validate uploaded images if present
        if ($hasUpload) {
            $request->validate([
                'images' => ['required', 'array'],
                'images.*' => ['image', 'mimes:jpg,jpeg,png,webp', 'max:3072'],
            ], [
                'images.*.image' => 'The selected files must be valid images.',
                'images.*.mimes' => 'Only JPG, JPEG, PNG, and WEBP formats are accepted.',
                'images.*.max' => 'Each image must be smaller than 3MB.',
            ]);
        }

        // Parse and validate URLs if present
        $validUrls = [];
        if ($hasUrls) {
            $rawUrls = preg_split('/\r\n|\r|\n/', $urlsInput);
            foreach ($rawUrls as $rawUrl) {
                $trimmed = trim($rawUrl);
                if (empty($trimmed)) {
                    continue;
                }
                
                if (!filter_var($trimmed, FILTER_VALIDATE_URL)) {
                    return back()
                        ->withErrors(['external_image_urls' => "The URL '$trimmed' is not a valid URL format."])
                        ->withInput();
                }
                $validUrls[] = $trimmed;
            }
        }

        $isActive = $request->boolean('is_active', true);
        $category = $this->normalizedCategory($request->input('category'));
        $maxSort = GalleryImage::max('sort_order') ?? 0;

        // Process Uploaded Images
        if ($hasUpload) {
            foreach ($request->file('images') as $file) {
                $maxSort++;
                $storedPath = $file->store('gallery', 'public');
                
                GalleryImage::create([
                    'title' => 'Gallery Image',
                    'category' => $category,
                    'alt_text' => 'Kharbanda Makeup Studio bridal makeup portfolio',
                    'image_path' => $storedPath,
                    'external_image_url' => null,
                    'is_featured' => false,
                    'is_active' => $isActive,
                    'sort_order' => $maxSort,
                ]);
            }
        }

        // Process URL Images
        foreach ($validUrls as $url) {
            $maxSort++;
            GalleryImage::create([
                'title' => 'Gallery Image',
                'category' => $category,
                'alt_text' => 'Kharbanda Makeup Studio bridal makeup portfolio',
                'image_path' => null,
                'external_image_url' => $url,
                'is_featured' => false,
                'is_active' => $isActive,
                'sort_order' => $maxSort,
            ]);
        }

        return redirect()->route('admin.gallery-images.index')->with('success', 'Gallery image(s) created.');
    }

    public function show(GalleryImage $galleryImage)
    {
        return view('admin.gallery-images.show', ['image' => $galleryImage]);
    }

    public function edit(GalleryImage $galleryImage)
    {
        return view('admin.gallery-images.form', [
            'image' => $galleryImage,
            'categories' => self::CATEGORIES,
        ]);
    }

    public function update(Request $request, GalleryImage $galleryImage)
    {
        $request->validate([
            'image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:3072'],
            'external_image_url' => ['nullable', 'url', 'max:2048'],
        ]);

        $hasUpload = $request->hasFile('image');
        $externalUrl = trim($request->input('external_image_url') ?? '');

        if (!$hasUpload && empty($externalUrl) && (!$galleryImage->image_path || !Storage::disk('public')->exists($galleryImage->image_path))) {
            return back()
                ->withErrors(['external_image_url' => 'Please upload a replacement image or provide a direct image URL.'])
                ->withInput();
        }

        $data = [
            'is_active' => $request->boolean('is_active'),
            'category' => $this->normalizedCategory($request->input('category')),
        ];

        if ($hasUpload) {
            if ($galleryImage->image_path) {
                Storage::disk('public')->delete($galleryImage->image_path);
            }
            $data['image_path'] = $request->file('image')->store('gallery', 'public');
            $data['external_image_url'] = null;
        } elseif (!empty($externalUrl)) {
            if ($galleryImage->image_path) {
                Storage::disk('public')->delete($galleryImage->image_path);
                $data['image_path'] = null;
            }
            $data['external_image_url'] = $externalUrl;
        } else {
            // Keep existing image_path but clear external URL if present
            if ($galleryImage->image_path) {
                $data['external_image_url'] = null;
            }
        }

        $galleryImage->update($data);

        return redirect()->route('admin.gallery-images.index')->with('success', 'Gallery image updated.');
    }

    public function destroy(GalleryImage $galleryImage)
    {
        if ($galleryImage->image_path) {
            Storage::disk('public')->delete($galleryImage->image_path);
        }

        $galleryImage->delete();

        return redirect()->route('admin.gallery-images.index')->with('success', 'Gallery image deleted.');
    }

    private function normalizedCategory(?string $category): string
    {
        return array_key_exists($category, self::CATEGORIES) ? $category : 'other';
    }
}
