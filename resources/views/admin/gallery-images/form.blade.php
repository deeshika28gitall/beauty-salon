@extends('admin.layouts.app')
@section('title', $image->exists ? 'Edit Gallery Image' : 'Add Gallery Images')
@section('heading', $image->exists ? 'Edit Gallery Image' : 'Add Gallery Images')
@section('content')

@php
    $currentImageUrl = $image->image_path && file_exists(public_path('storage/'.$image->image_path))
        ? asset('storage/'.$image->image_path)
        : $image->external_image_url;
@endphp

<form class="admin-card p-4" method="POST" enctype="multipart/form-data" action="{{ $image->exists ? route('admin.gallery-images.update', $image) : route('admin.gallery-images.store') }}">
    @csrf 
    @if($image->exists) 
        @method('PUT') 
    @endif
    
    <div class="row g-3">
        <div class="col-md-6">
            <label class="form-label" for="galleryCategory">Category</label>
            <select id="galleryCategory" name="category" class="form-select">
                @foreach($categories as $value => $label)
                    <option value="{{ $value }}" @selected(old('category', $image->category ?? 'other') === $value)>{{ $label }}</option>
                @endforeach
            </select>
            @error('category') <div class="text-danger small">{{ $message }}</div> @enderror
        </div>

        @if(!$image->exists)
            <!-- Create Mode: Multiple Device Upload -->
            <div class="col-md-6">
                <label class="form-label" for="galleryImagesFiles">Option A: Upload Multiple Images</label>
                <input id="galleryImagesFiles" name="images[]" type="file" class="form-control" accept=".jpg,.jpeg,.png,.webp,image/jpeg,image/png,image/webp" multiple>
                <small class="text-muted">You can select multiple images from your device. Accepted formats: JPG, JPEG, PNG, WEBP.</small>
                @error('images') <div class="text-danger small">{{ $message }}</div> @enderror
                @error('images.*') <div class="text-danger small">{{ $message }}</div> @enderror
            </div>
            
            <!-- Create Mode: Multiple URLs Textarea -->
            <div class="col-md-6">
                <label class="form-label" for="galleryImagesUrls">Option B: Image URLs (One URL per line)</label>
                <textarea id="galleryImagesUrls" name="external_image_urls" class="form-control" rows="4" placeholder="https://example.com/bridal-look-1.jpg&#10;https://example.com/bridal-look-2.jpg"></textarea>
                <small class="text-muted">Paste one direct image URL per line. Use this when you do not upload files.</small>
                @error('external_image_urls') <div class="text-danger small">{{ $message }}</div> @enderror
            </div>
        @else
            <!-- Edit Mode: Single Replacement Image Upload -->
            <div class="col-md-6">
                <label class="form-label" for="galleryImageFile">Option A: Upload Replacement Image</label>
                <input id="galleryImageFile" name="image" type="file" class="form-control" accept=".jpg,.jpeg,.png,.webp,image/jpeg,image/png,image/webp">
                <small class="text-muted">Upload a new file to replace the current image. Accepted formats: JPG, JPEG, PNG, WEBP.</small>
                @error('image') <div class="text-danger small">{{ $message }}</div> @enderror
            </div>
            
            <!-- Edit Mode: Single URL Input -->
            <div class="col-md-6">
                <label class="form-label" for="galleryImageUrl">Option B: Image URL</label>
                <input id="galleryImageUrl" name="external_image_url" type="url" class="form-control" value="{{ old('external_image_url', $image->external_image_url) }}" placeholder="https://example.com/bridal-look.jpg">
                <small class="text-muted">Use a direct browser image URL when you do not upload a replacement file.</small>
                @error('external_image_url') <div class="text-danger small">{{ $message }}</div> @enderror
            </div>
        @endif

        <!-- Active Checkbox -->
        <div class="col-12 my-3">
            <label class="d-flex align-items-center gap-2" style="font-weight: 700;">
                <input type="checkbox" name="is_active" value="1" @checked(old('is_active', $image->is_active ?? true))> Active
            </label>
        </div>
        
        <!-- Live Preview Grid -->
        <div class="col-12">
            <div class="border rounded-4 p-3 bg-light">
                <strong class="d-block mb-3">Live Image Preview</strong>
                <div id="galleryPreviewEmpty" class="text-muted small" @if($currentImageUrl) hidden @endif>No images selected yet.</div>
                
                <!-- Single image preview container for Edit mode -->
                @if($image->exists)
                    <img id="galleryImagePreview" src="{{ $currentImageUrl }}" alt="Gallery preview" class="rounded-4 shadow-sm img-thumbnail" style="max-width:320px;height:200px;object-fit:cover;@if(!$currentImageUrl) display:none; @endif">
                @endif

                <!-- Dynamic masonry grid preview for Create mode -->
                <div id="createPreviewsContainer" class="row g-3" style="display: none;">
                    <!-- JS will populate preview columns here dynamically -->
                </div>

                <div id="galleryPreviewError" class="text-danger small mt-2" hidden>One or more image previews could not be loaded. Please verify the file formats or URLs.</div>
            </div>
        </div>
    </div>
    
    <div class="mt-4">
        <button class="btn btn-rose">Save Image(s)</button> 
        <a href="{{ route('admin.gallery-images.index') }}" class="btn btn-outline-dark">Cancel</a>
    </div>
</form>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', () => {
    const isEditMode = {{ $image->exists ? 'true' : 'false' }};

    if (isEditMode) {
        // Edit Mode JS (Single Image)
        const fileInput = document.querySelector('#galleryImageFile');
        const urlInput = document.querySelector('#galleryImageUrl');
        const preview = document.querySelector('#galleryImagePreview');
        const empty = document.querySelector('#galleryPreviewEmpty');
        const error = document.querySelector('#galleryPreviewError');

        const showPreview = (src) => {
            if (!src) {
                if (preview) {
                    preview.style.display = 'none';
                    preview.removeAttribute('src');
                }
                empty.hidden = false;
                error.hidden = true;
                return;
            }

            if (preview) {
                preview.onload = () => {
                    preview.style.display = 'block';
                    empty.hidden = true;
                    error.hidden = true;
                };
                preview.onerror = () => {
                    preview.style.display = 'none';
                    empty.hidden = true;
                    error.hidden = false;
                };
                preview.src = src;
            }
        };

        fileInput?.addEventListener('change', () => {
            const file = fileInput.files?.[0];
            if (!file) {
                showPreview(urlInput.value.trim());
                return;
            }
            showPreview(URL.createObjectURL(file));
        });

        urlInput?.addEventListener('input', () => {
            if (fileInput.files?.length) {
                return;
            }
            showPreview(urlInput.value.trim());
        });
    } else {
        // Create Mode JS (Multiple Images)
        const filesInput = document.querySelector('#galleryImagesFiles');
        const urlsInput = document.querySelector('#galleryImagesUrls');
        const container = document.querySelector('#createPreviewsContainer');
        const empty = document.querySelector('#galleryPreviewEmpty');
        const error = document.querySelector('#galleryPreviewError');

        const updateCreatePreviews = () => {
            // Clear existing previews
            container.innerHTML = '';
            error.hidden = true;

            const previewSources = [];

            // 1. Gather file previews
            if (filesInput && filesInput.files) {
                Array.from(filesInput.files).forEach(file => {
                    previewSources.push({
                        src: URL.createObjectURL(file),
                        label: file.name
                    });
                });
            }

            // 2. Gather URL previews
            if (urlsInput && urlsInput.value) {
                const urls = urlsInput.value.split('\n');
                urls.forEach((url, idx) => {
                    const trimmed = url.trim();
                    if (trimmed) {
                        previewSources.push({
                            src: trimmed,
                            label: `URL ${idx + 1}`
                        });
                    }
                });
            }

            if (previewSources.length === 0) {
                container.style.display = 'none';
                empty.hidden = false;
                return;
            }

            // Show previews
            empty.hidden = true;
            container.style.display = 'flex';

            previewSources.forEach(source => {
                const col = document.createElement('div');
                col.className = 'col-6 col-sm-4 col-md-3';
                
                const card = document.createElement('div');
                card.className = 'card h-100 p-2 shadow-sm border-0 bg-white rounded-3 position-relative';
                
                const img = document.createElement('img');
                img.src = source.src;
                img.alt = source.label;
                img.className = 'rounded-3 w-100';
                img.style.height = '140px';
                img.style.objectFit = 'cover';
                
                img.onerror = () => {
                    img.style.display = 'none';
                    const errorText = document.createElement('div');
                    errorText.className = 'd-flex align-items-center justify-content-center text-danger text-center small p-3 border rounded-3 bg-light';
                    errorText.style.height = '140px';
                    errorText.innerHTML = '<i class="bi bi-exclamation-triangle-fill me-1"></i> Invalid Image';
                    card.replaceChild(errorText, img);
                    error.hidden = false;
                };

                const badge = document.createElement('span');
                badge.className = 'position-absolute top-0 start-0 m-2 badge bg-dark opacity-75';
                badge.textContent = source.label.length > 15 ? source.label.substring(0, 12) + '...' : source.label;

                card.appendChild(img);
                card.appendChild(badge);
                col.appendChild(card);
                container.appendChild(col);
            });
        };

        filesInput?.addEventListener('change', updateCreatePreviews);
        urlsInput?.addEventListener('input', updateCreatePreviews);
    }
});
</script>
@endpush
