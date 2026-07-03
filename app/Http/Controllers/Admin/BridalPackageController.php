<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BridalPackage;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class BridalPackageController extends Controller
{
    public function index()
    {
        return view('admin.bridal-packages.index', [
            'packages' => BridalPackage::orderBy('sort_order')->latest()->paginate(15),
        ]);
    }

    public function create()
    {
        return view('admin.bridal-packages.form', ['package' => new BridalPackage()]);
    }

    public function store(Request $request)
    {
        BridalPackage::create($this->payload($request));

        return redirect()->route('admin.bridal-packages.index')->with('success', 'Package created.');
    }

    public function show(BridalPackage $bridalPackage)
    {
        return view('admin.bridal-packages.show', ['package' => $bridalPackage]);
    }

    public function edit(BridalPackage $bridalPackage)
    {
        return view('admin.bridal-packages.form', ['package' => $bridalPackage]);
    }

    public function update(Request $request, BridalPackage $bridalPackage)
    {
        $bridalPackage->update($this->payload($request, $bridalPackage->id));

        return redirect()->route('admin.bridal-packages.index')->with('success', 'Package updated.');
    }

    public function destroy(BridalPackage $bridalPackage)
    {
        $bridalPackage->delete();

        return redirect()->route('admin.bridal-packages.index')->with('success', 'Package deleted.');
    }

    private function payload(Request $request, ?int $ignoreId = null): array
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:255', 'unique:bridal_packages,slug'.($ignoreId ? ','.$ignoreId : '')],
            'description' => ['nullable', 'string'],
            'short_description' => ['nullable', 'string'],
            'full_description' => ['nullable', 'string'],
            'features' => ['nullable', 'string'],
            'included_items' => ['nullable', 'string'],
            'price' => ['nullable', 'numeric', 'min:0'],
            'discount_price' => ['nullable', 'numeric', 'min:0'],
            'old_price' => ['nullable', 'numeric', 'min:0'],
            'duration_hours' => ['nullable', 'integer', 'min:1'],
            'duration_text' => ['nullable', 'string', 'max:120'],
            'badge' => ['nullable', 'string', 'max:80'],
            'suitable_for' => ['nullable', 'string'],
            'important_notes' => ['nullable', 'string'],
            'image' => ['nullable', 'image', 'max:5120'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
        ]);

        $existing = null;
        if ($ignoreId) {
            $existing = BridalPackage::find($ignoreId);
        }

        $data['slug'] = Str::slug($data['slug'] ?: $data['name']);
        $data['includes'] = collect(preg_split('/\r\n|\r|\n/', $request->input('included_items', '')))
            ->map(fn ($item) => trim($item))
            ->filter()
            ->values()
            ->all();
        $data['features'] = collect(preg_split('/\r\n|\r|\n/', $data['features'] ?? ''))
            ->map(fn ($item) => trim($item))
            ->filter()
            ->values()
            ->all();
        unset($data['included_items']);
        $data['is_active'] = $request->boolean('is_active');
        $data['is_featured'] = $request->boolean('is_featured');

        if ($request->hasFile('image')) {
            if ($existing?->image_path) {
                Storage::disk('public')->delete($existing->image_path);
            }
            $data['image_path'] = $request->file('image')->store('packages', 'public');
        }

        return $data;
    }
}
