<?php

namespace App\Http\Controllers;

use App\Models\GalleryImage;
use Illuminate\Http\Request;

class GalleryImageController extends Controller
{
    public function index()
    {
        return GalleryImage::query()
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->latest()
            ->get();
    }

    public function gallery(Request $request)
    {
        $categories = [
            'bridal' => 'Bridal Makeup',
            'party' => 'Party Makeup',
            'engagement' => 'Engagement Makeup',
            'hair-styling' => 'Hair Styling',
            'reception' => 'Reception Look',
            'other' => 'Other',
        ];

        $requestedCategory = $request->string('category')->toString();
        $activeCategory = array_key_exists($requestedCategory, $categories)
            ? $requestedCategory
            : 'bridal';

        $images = GalleryImage::query()
            ->where('is_active', true)
            ->when($activeCategory && array_key_exists($activeCategory, $categories), fn ($query) => $query->where('category', $activeCategory))
            ->orderBy('category')
            ->orderBy('sort_order')
            ->get();

        return view('frontend.gallery', compact('images', 'categories', 'activeCategory'));
    }

    public function create()
    {
        abort(404);
    }

    public function store(Request $request)
    {
        abort(404);
    }

    public function show(GalleryImage $galleryImage)
    {
        abort_if(! $galleryImage->is_active, 404);

        return $galleryImage;
    }

    public function edit(GalleryImage $galleryImage)
    {
        abort(404);
    }

    public function update(Request $request, GalleryImage $galleryImage)
    {
        abort(404);
    }

    public function destroy(GalleryImage $galleryImage)
    {
        abort(404);
    }
}
