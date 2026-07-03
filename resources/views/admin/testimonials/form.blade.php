@extends('admin.layouts.app')
@section('title', $testimonial->exists ? 'Edit Testimonial' : 'Add Testimonial')
@section('heading', $testimonial->exists ? 'Edit Testimonial' : 'Add Testimonial')
@section('content')
<form class="admin-card p-4" method="POST" enctype="multipart/form-data" action="{{ $testimonial->exists ? route('admin.testimonials.update', $testimonial) : route('admin.testimonials.store') }}">
    @csrf @if($testimonial->exists) @method('PUT') @endif
    <div class="row g-3">
        <div class="col-md-6"><label class="form-label">Client Name</label><input name="client_name" class="form-control" value="{{ old('client_name', $testimonial->client_name) }}" required></div>
        <div class="col-md-6"><label class="form-label">Client Role</label><input name="client_role" class="form-control" value="{{ old('client_role', $testimonial->client_role) }}"></div>
        <div class="col-md-6"><label class="form-label">Service</label><input name="service_name" class="form-control" value="{{ old('service_name', $testimonial->service_name) }}"></div>
        <div class="col-md-3"><label class="form-label">Rating</label><input name="rating" type="number" min="1" max="5" class="form-control" value="{{ old('rating', $testimonial->rating ?? 5) }}" required></div>
        <div class="col-md-3"><label class="form-label">Sort Order</label><input name="sort_order" type="number" class="form-control" value="{{ old('sort_order', $testimonial->sort_order ?? 0) }}"></div>
        <div class="col-12"><label class="form-label">Review</label><textarea name="message" class="form-control" rows="5" required>{{ old('message', $testimonial->message) }}</textarea></div>
        <div class="col-md-6"><label class="form-label">Client Image</label><input name="client_image" type="file" class="form-control" accept="image/*"></div>
        <div class="col-md-6 d-flex align-items-end gap-3"><label><input type="checkbox" name="is_active" value="1" @checked(old('is_active', $testimonial->is_active ?? true))> Active</label><label><input type="checkbox" name="is_featured" value="1" @checked(old('is_featured', $testimonial->is_featured))> Featured</label></div>
    </div>
    <div class="mt-4"><button class="btn btn-rose">Save Testimonial</button> <a href="{{ route('admin.testimonials.index') }}" class="btn btn-outline-dark">Cancel</a></div>
</form>
@endsection
