@extends('admin.layouts.app')
@section('title', $slide->exists ? 'Edit Hero Slide' : 'Add Hero Slide')
@section('heading', $slide->exists ? 'Edit Hero Slide' : 'Add Hero Slide')
@section('content')
<form class="admin-card p-4" method="POST" enctype="multipart/form-data" action="{{ $slide->exists ? route('admin.hero-slides.update', $slide) : route('admin.hero-slides.store') }}">
    @csrf
    @if($slide->exists)
        @method('PUT')
    @endif
    @php
        $resolvedImage = $slide->exists && $slide->background_image_path && file_exists(public_path('storage/' . $slide->background_image_path))
            ? asset('storage/' . $slide->background_image_path)
            : null;
    @endphp
    <div class="row g-3">
        <div class="col-md-4"><label class="form-label">Badge Text</label><input name="badge_text" class="form-control" value="{{ old('badge_text', $slide->badge_text) }}"></div>
        <div class="col-md-8"><label class="form-label">Main Heading</label><input name="main_heading" class="form-control" value="{{ old('main_heading', $slide->main_heading) }}" required></div>
        <div class="col-12"><label class="form-label">Description</label><textarea name="description" class="form-control" rows="4" required>{{ old('description', $slide->description) }}</textarea></div>
        <div class="col-md-6">
            <label class="form-label">Background Image</label>
            <input id="heroBackgroundFile" name="background_image" type="file" class="form-control" accept="image/*">
            <div class="mt-3 d-flex align-items-center gap-3">
                <div id="heroPreviewEmpty" class="text-muted small" @if($resolvedImage) hidden @endif>No image selected.</div>
                <img id="heroImagePreview" src="{{ $resolvedImage }}" alt="Hero preview" class="rounded shadow-sm border" style="width: 120px; height: 80px; object-fit: cover; @if(!$resolvedImage) display:none; @endif">
            </div>
        </div>
        <div class="col-md-3"><label class="form-label">Primary Button Text</label><input name="primary_button_text" class="form-control" value="{{ old('primary_button_text', $slide->primary_button_text) }}"></div>
        <div class="col-md-3"><label class="form-label">Primary Button Link</label><input name="primary_button_link" class="form-control" value="{{ old('primary_button_link', $slide->primary_button_link) }}"></div>
        <div class="col-md-3"><label class="form-label">Secondary Button Text</label><input name="secondary_button_text" class="form-control" value="{{ old('secondary_button_text', $slide->secondary_button_text) }}"></div>
        <div class="col-md-3"><label class="form-label">Secondary Button Link</label><input name="secondary_button_link" class="form-control" value="{{ old('secondary_button_link', $slide->secondary_button_link) }}"></div>
        <div class="col-md-4"><label class="form-label">Stat 1 Value</label><input name="stat_1_value" class="form-control" value="{{ old('stat_1_value', $slide->stat_1_value) }}"></div>
        <div class="col-md-4"><label class="form-label">Stat 1 Label</label><input name="stat_1_label" class="form-control" value="{{ old('stat_1_label', $slide->stat_1_label) }}"></div>
        <div class="col-md-4"><label class="form-label">Stat 2 Value</label><input name="stat_2_value" class="form-control" value="{{ old('stat_2_value', $slide->stat_2_value) }}"></div>
        <div class="col-md-4"><label class="form-label">Stat 2 Label</label><input name="stat_2_label" class="form-control" value="{{ old('stat_2_label', $slide->stat_2_label) }}"></div>
        <div class="col-md-4"><label class="form-label">Stat 3 Value</label><input name="stat_3_value" class="form-control" value="{{ old('stat_3_value', $slide->stat_3_value) }}"></div>
        <div class="col-md-4"><label class="form-label">Stat 3 Label</label><input name="stat_3_label" class="form-control" value="{{ old('stat_3_label', $slide->stat_3_label) }}"></div>
        <div class="col-md-3"><label class="form-label">Sort Order</label><input name="sort_order" type="number" class="form-control" value="{{ old('sort_order', $slide->sort_order ?? 0) }}"></div>
        <div class="col-md-3 d-flex align-items-end"><label class="form-check-label"><input type="checkbox" name="is_active" value="1" @checked(old('is_active', $slide->is_active ?? true))> Active</label></div>
    </div>
    <div class="mt-4">
        <button class="btn btn-rose">Save Slide</button>
        <a href="{{ route('admin.hero-slides.index') }}" class="btn btn-outline-dark">Cancel</a>
    </div>
</form>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', () => {
    const fileInput = document.querySelector('#heroBackgroundFile');
    const preview = document.querySelector('#heroImagePreview');
    const empty = document.querySelector('#heroPreviewEmpty');

    fileInput?.addEventListener('change', () => {
        const file = fileInput.files?.[0];
        if (!file) {
            @if($resolvedImage)
                preview.src = "{{ $resolvedImage }}";
                preview.style.display = 'block';
                empty.hidden = true;
            @else
                preview.style.display = 'none';
                preview.removeAttribute('src');
                empty.hidden = false;
            @endif
            return;
        }

        preview.src = URL.createObjectURL(file);
        preview.style.display = 'block';
        empty.hidden = true;
    });
});
</script>
@endpush
