@extends('admin.layouts.app')
@section('title', $service->exists ? 'Edit Service' : 'Add Service')
@section('heading', $service->exists ? 'Edit Service' : 'Add Service')
@section('content')
<form class="admin-card p-4" method="POST" enctype="multipart/form-data" action="{{ $service->exists ? route('admin.services.update', $service) : route('admin.services.store') }}">
    @csrf 
    @if($service->exists) 
        @method('PUT') 
    @endif
    
    <div class="row g-3">
        <div class="col-md-6">
            <label class="form-label">Name</label>
            <input name="name" class="form-control" value="{{ old('name', $service->name) }}" required>
            @error('name')<small class="text-danger">{{ $message }}</small>@enderror
        </div>
        
        <div class="col-md-6">
            <label class="form-label">Slug</label>
            <input name="slug" class="form-control" value="{{ old('slug', $service->slug) }}">
        </div>

        <div class="col-12">
            <label class="form-label">Short Description</label>
            <textarea name="short_description" class="form-control" rows="2">{{ old('short_description', $service->short_description) }}</textarea>
        </div>
        
        <div class="col-12">
            <label class="form-label">Description</label>
            <textarea name="description" class="form-control" rows="4">{{ old('description', $service->description) }}</textarea>
        </div>

        <div class="col-12">
            <label class="form-label">Full Description</label>
            <textarea name="full_description" class="form-control" rows="5">{{ old('full_description', $service->full_description) }}</textarea>
        </div>
        
        <div class="col-md-4">
            <label class="form-label">Starting Price</label>
            <input name="starting_price" type="number" step="0.01" class="form-control" value="{{ old('starting_price', $service->starting_price) }}">
        </div>
        
        <div class="col-md-4">
            <label class="form-label">Duration Minutes</label>
            <input name="duration_minutes" type="number" class="form-control" value="{{ old('duration_minutes', $service->duration_minutes) }}">
        </div>
        
        <div class="col-md-4">
            <label class="form-label">Icon</label>
            <input name="icon" class="form-control" placeholder="bi-stars" value="{{ old('icon', $service->icon) }}">
        </div>
        
        <div class="col-md-6">
            <label class="form-label">Hero / Main Image</label>
            <input id="serviceImageFile" name="image" type="file" class="form-control" accept="image/*">
            @error('image')<small class="text-danger">{{ $message }}</small>@enderror
            
            {{-- Dynamic Image Preview --}}
            <div class="mt-3 border rounded-3 p-2 bg-light d-flex align-items-center gap-3" style="max-width: 320px;">
                @php
                    $resolvedFormUrl = null;
                    if ($service->exists && $service->image_path) {
                        if (filter_var($service->image_path, FILTER_VALIDATE_URL)) {
                            $resolvedFormUrl = $service->image_path;
                        } elseif (file_exists(public_path('storage/' . $service->image_path))) {
                            $resolvedFormUrl = asset('storage/' . $service->image_path);
                        }
                    }
                @endphp
                <div id="servicePreviewEmpty" class="text-muted small" @if($resolvedFormUrl) hidden @endif>No image selected.</div>
                <img id="serviceImagePreview" src="{{ $resolvedFormUrl }}" alt="Service preview" class="rounded shadow-sm border" style="width: 74px; height: 58px; object-fit: cover; @if(!$resolvedFormUrl) display:none; @endif">
                <span class="text-muted small" id="servicePreviewLabel" @if(!$resolvedFormUrl) hidden @endif>Current Image</span>
            </div>
        </div>
        
        <div class="col-md-3">
            <label class="form-label">Sort Order</label>
            <input name="sort_order" type="number" class="form-control" value="{{ old('sort_order', $service->sort_order ?? 0) }}">
        </div>
        
        <div class="col-md-3 d-flex align-items-end gap-3">
            <label>
                <input type="checkbox" name="is_active" value="1" @checked(old('is_active', $service->is_active ?? true))> Active
            </label>
            <label>
                <input type="checkbox" name="is_featured" value="1" @checked(old('is_featured', $service->is_featured))> Featured
            </label>
        </div>

        <div class="col-12">
            <label class="form-label">Included Features <small class="text-muted">(one per line)</small></label>
            <textarea name="features_text" class="form-control" rows="5" placeholder="HD Makeup&#10;Hair Styling&#10;Draping">{{ old('features_text', $featureText) }}</textarea>
        </div>

        <div class="col-12">
            <label class="form-label">Products Used <small class="text-muted">(one per line)</small></label>
            <textarea name="products_text" class="form-control" rows="4" placeholder="MAC&#10;Huda Beauty&#10;Bobbi Brown">{{ old('products_text', $productText) }}</textarea>
        </div>

        <div class="col-12">
            <label class="form-label">Process Steps <small class="text-muted">(Title | Description, one per line)</small></label>
            <textarea name="steps_text" class="form-control" rows="5" placeholder="Consultation | Understand look and venue&#10;Skin Prep | Prepare skin for makeup">{{ old('steps_text', $stepText) }}</textarea>
        </div>

        <div class="col-12">
            <label class="form-label">FAQs <small class="text-muted">(Question | Answer, one per line)</small></label>
            <textarea name="faqs_text" class="form-control" rows="5" placeholder="How early should I book? | Book 2-4 weeks in advance.">{{ old('faqs_text', $faqText) }}</textarea>
        </div>

        <div class="col-12">
            <label class="form-label">Service Gallery Images</label>
            <input name="gallery_images[]" type="file" class="form-control" accept="image/*" multiple>
            <small class="text-muted">You can upload multiple images for the service detail gallery.</small>
        </div>
    </div>
    
    <div class="mt-4">
        <button class="btn btn-rose">Save Service</button> 
        <a href="{{ route('admin.services.index') }}" class="btn btn-outline-dark">Cancel</a>
    </div>
</form>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', () => {
    const fileInput = document.querySelector('#serviceImageFile');
    const preview = document.querySelector('#serviceImagePreview');
    const empty = document.querySelector('#servicePreviewEmpty');
    const label = document.querySelector('#servicePreviewLabel');

    fileInput?.addEventListener('change', () => {
        const file = fileInput.files?.[0];
        if (!file) {
            @if($resolvedFormUrl)
                preview.src = "{{ $resolvedFormUrl }}";
                preview.style.display = 'block';
                empty.hidden = true;
                label.hidden = false;
                label.textContent = "Current Image";
            @else
                preview.style.display = 'none';
                preview.removeAttribute('src');
                empty.hidden = false;
                label.hidden = true;
            @endif
            return;
        }

        preview.src = URL.createObjectURL(file);
        preview.style.display = 'block';
        empty.hidden = true;
        label.hidden = false;
        label.textContent = "Selected File";
    });
});
</script>
@endpush
