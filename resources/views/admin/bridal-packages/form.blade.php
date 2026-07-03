@extends('admin.layouts.app')
@section('title', $package->exists ? 'Edit Package' : 'Add Package')
@section('heading', $package->exists ? 'Edit Package' : 'Add Package')
@section('content')
<form class="admin-card p-4" method="POST" enctype="multipart/form-data" action="{{ $package->exists ? route('admin.bridal-packages.update', $package) : route('admin.bridal-packages.store') }}">
    @csrf @if($package->exists) @method('PUT') @endif
    <div class="row g-3">
        <div class="col-md-6"><label class="form-label">Title</label><input name="name" class="form-control" value="{{ old('name', $package->name) }}" required></div>
        <div class="col-md-6"><label class="form-label">Slug</label><input name="slug" class="form-control" value="{{ old('slug', $package->slug) }}"></div>
        <div class="col-md-4"><label class="form-label">Price</label><input name="price" type="number" step="0.01" class="form-control" value="{{ old('price', $package->price) }}"></div>
        <div class="col-md-4"><label class="form-label">Old Price</label><input name="old_price" type="number" step="0.01" class="form-control" value="{{ old('old_price', $package->old_price ?: $package->discount_price) }}"></div>
        <div class="col-md-4"><label class="form-label">Badge</label><input name="badge" class="form-control" value="{{ old('badge', $package->badge) }}"></div>
        <div class="col-12"><label class="form-label">Short Description</label><textarea name="short_description" class="form-control" rows="2">{{ old('short_description', $package->short_description) }}</textarea></div>
        <div class="col-12"><label class="form-label">Full Description</label><textarea name="full_description" class="form-control" rows="4">{{ old('full_description', $package->full_description ?: $package->description) }}</textarea></div>
        <div class="col-md-6"><label class="form-label">Included Items, one per line</label><textarea name="included_items" class="form-control" rows="5">{{ old('included_items', collect($package->includes)->join(PHP_EOL)) }}</textarea></div>
        <div class="col-md-6"><label class="form-label">Features, one per line</label><textarea name="features" class="form-control" rows="5">{{ old('features', collect($package->features)->join(PHP_EOL)) }}</textarea></div>
        <div class="col-12"><label class="form-label">Suitable For</label><textarea name="suitable_for" class="form-control" rows="2">{{ old('suitable_for', $package->suitable_for) }}</textarea></div>
        <div class="col-12"><label class="form-label">Important Notes / Terms</label><textarea name="important_notes" class="form-control" rows="3">{{ old('important_notes', $package->important_notes) }}</textarea></div>
        <div class="col-md-4"><label class="form-label">Duration / Session Time</label><input name="duration_text" class="form-control" value="{{ old('duration_text', $package->duration_text) }}" placeholder="e.g. 4-5 hours"></div>
        <div class="col-md-4"><label class="form-label">Hours</label><input name="duration_hours" type="number" class="form-control" value="{{ old('duration_hours', $package->duration_hours) }}"></div>
        <div class="col-md-4"><label class="form-label">Image</label><input name="image" type="file" class="form-control"></div>
        <div class="col-md-2"><label class="form-label">Sort</label><input name="sort_order" type="number" class="form-control" value="{{ old('sort_order', $package->sort_order ?? 0) }}"></div>
        <div class="col-12 d-flex gap-3"><label><input type="checkbox" name="is_active" value="1" @checked(old('is_active', $package->is_active ?? true))> Active</label><label><input type="checkbox" name="is_featured" value="1" @checked(old('is_featured', $package->is_featured))> Most Popular</label></div>
    </div>
    <div class="mt-3">
        <small class="text-muted">Keep the current package card design; these fields power the new detail page and booking flow.</small>
    </div>
    <div class="mt-4"><button class="btn btn-rose">Save Package</button> <a href="{{ route('admin.bridal-packages.index') }}" class="btn btn-outline-dark">Cancel</a></div>
</form>
@endsection
