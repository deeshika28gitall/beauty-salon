<?php

namespace App\Http\Controllers;

use App\Models\BridalPackage;
use Illuminate\Http\Request;

class BridalPackageController extends Controller
{
    public function index()
    {
        return BridalPackage::query()
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->orderBy('name')
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

    public function show(BridalPackage $bridalPackage)
    {
        abort_if(! $bridalPackage->is_active, 404);

        return $bridalPackage;
    }

    public function detail(string $slug)
    {
        $package = BridalPackage::query()
            ->where('slug', $slug)
            ->where('is_active', true)
            ->firstOrFail();

        return view('frontend.package-detail', [
            'package' => $package,
        ]);
    }

    public function book(string $slug)
    {
        $package = BridalPackage::query()
            ->where('slug', $slug)
            ->where('is_active', true)
            ->firstOrFail();

        return redirect()->to(url('/?package=' . $package->slug . '#appointment'));
    }

    public function edit(BridalPackage $bridalPackage)
    {
        abort(404);
    }

    public function update(Request $request, BridalPackage $bridalPackage)
    {
        abort(404);
    }

    public function destroy(BridalPackage $bridalPackage)
    {
        abort(404);
    }
}
