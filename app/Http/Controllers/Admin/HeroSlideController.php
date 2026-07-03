<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HeroSlide;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class HeroSlideController extends Controller
{
    public function index()
    {
        return view('admin.hero-slides.index', [
            'slides' => HeroSlide::orderBy('sort_order')->latest()->paginate(15),
        ]);
    }

    public function create()
    {
        return view('admin.hero-slides.form', ['slide' => new HeroSlide()]);
    }

    public function store(Request $request)
    {
        $data = $this->validated($request);
        $data['is_active'] = $request->boolean('is_active');

        if ($request->hasFile('background_image')) {
            $data['background_image_path'] = $request->file('background_image')->store('hero-slides', 'public');
        }

        HeroSlide::create($data);

        return redirect()->route('admin.hero-slides.index')->with('success', 'Hero slide created.');
    }

    public function edit(HeroSlide $heroSlide)
    {
        return view('admin.hero-slides.form', ['slide' => $heroSlide]);
    }

    public function update(Request $request, HeroSlide $heroSlide)
    {
        $data = $this->validated($request);
        $data['is_active'] = $request->boolean('is_active');

        if ($request->hasFile('background_image')) {
            if ($heroSlide->background_image_path) {
                Storage::disk('public')->delete($heroSlide->background_image_path);
            }
            $data['background_image_path'] = $request->file('background_image')->store('hero-slides', 'public');
        }

        $heroSlide->update($data);

        return redirect()->route('admin.hero-slides.index')->with('success', 'Hero slide updated.');
    }

    public function destroy(HeroSlide $heroSlide)
    {
        if ($heroSlide->background_image_path) {
            Storage::disk('public')->delete($heroSlide->background_image_path);
        }

        $heroSlide->delete();

        return redirect()->route('admin.hero-slides.index')->with('success', 'Hero slide deleted.');
    }

    private function validated(Request $request): array
    {
        return $request->validate([
            'badge_text' => ['nullable', 'string', 'max:120'],
            'main_heading' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'background_image' => ['nullable', 'image', 'max:3072'],
            'primary_button_text' => ['nullable', 'string', 'max:80'],
            'primary_button_link' => ['nullable', 'string', 'max:255'],
            'secondary_button_text' => ['nullable', 'string', 'max:80'],
            'secondary_button_link' => ['nullable', 'string', 'max:255'],
            'stat_1_value' => ['nullable', 'string', 'max:40'],
            'stat_1_label' => ['nullable', 'string', 'max:120'],
            'stat_2_value' => ['nullable', 'string', 'max:40'],
            'stat_2_label' => ['nullable', 'string', 'max:120'],
            'stat_3_value' => ['nullable', 'string', 'max:40'],
            'stat_3_label' => ['nullable', 'string', 'max:120'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
        ]);
    }
}
