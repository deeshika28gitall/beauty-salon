@extends('admin.layouts.app')
@section('title', 'Gallery')
@section('heading', 'Gallery Images')
@section('action')
    <a href="{{ route('admin.gallery-images.create') }}" class="btn btn-rose">Add Image</a>
@endsection
@section('content')
<style>
    .gallery-table th {
        font-size: 14px;
        font-weight: 700;
        padding: 8px 12px !important;
    }
    .gallery-table td {
        font-size: 13px;
        padding: 6px 12px !important;
    }
    .gallery-table .badge {
        font-size: 11px !important;
        padding: 4px 8px !important;
    }
    .gallery-table .btn-sm {
        font-size: 12px !important;
        padding: 3px 8px !important;
    }
</style>
<div class="admin-card p-3">
    <div class="table-responsive">
        <table class="table align-middle table-hover gallery-table">
            <thead>
                <tr>
                    <th style="width: 100px;">Thumbnail</th>
                    <th>Source Type</th>
                    <th>Category</th>
                    <th style="width: 120px;">Status</th>
                    <th class="text-end" style="width: 160px;">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($images as $image)
                    @php
                        $imageUrl = $image->image_path && file_exists(public_path('storage/'.$image->image_path)) 
                            ? asset('storage/'.$image->image_path) 
                            : $image->external_image_url;
                    @endphp
                    <tr>
                        <td>
                            @if($imageUrl)
                                <img src="{{ $imageUrl }}" alt="Gallery Thumbnail" class="rounded border shadow-sm" style="width: 70px; height: 70px; object-fit: cover;">
                            @else
                                <div class="bg-secondary text-white rounded d-flex align-items-center justify-content-center border shadow-sm" style="width: 70px; height: 70px; font-size: 0.65rem;">
                                    No Image
                                </div>
                            @endif
                        </td>
                        <td>
                            <span class="badge text-bg-light border">
                                @if($image->image_path)
                                    <i class="bi bi-hdd-fill text-primary me-1"></i> Device Upload
                                @else
                                    <i class="bi bi-link-45deg text-info me-1"></i> External URL
                                @endif
                            </span>
                            
                            {{-- Show URL only when image is NOT a device upload AND has external URL --}}
                            @if(!$image->image_path && $image->external_image_url)
                                <div class="text-muted text-truncate mt-1" style="max-width: 250px; font-size: 12px;" title="{{ $image->external_image_url }}">
                                    {{ $image->external_image_url }}
                                </div>
                            @endif
                        </td>
                        <td>
                            <span class="badge text-bg-secondary">{{ $categories[$image->category ?: 'other'] ?? ucfirst(str_replace('-', ' ', $image->category ?: 'other')) }}</span>
                        </td>
                        <td>
                            @if($image->is_active)
                                <span class="badge text-bg-success"><i class="bi bi-check-circle-fill me-1"></i> Active</span>
                            @else
                                <span class="badge text-bg-secondary"><i class="bi bi-slash-circle-fill me-1"></i> Inactive</span>
                            @endif
                        </td>
                        <td class="text-end">
                            <div class="d-flex justify-content-end gap-1">
                                <a href="{{ route('admin.gallery-images.edit', $image) }}" class="btn btn-sm btn-outline-dark">
                                    <i class="bi bi-pencil-square"></i> Edit
                                </a>
                                <form action="{{ route('admin.gallery-images.destroy', $image) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this image?')">
                                    @csrf 
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-outline-danger">
                                        <i class="bi bi-trash"></i> Delete
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center text-muted py-4">No gallery images found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-3">
        {{ $images->links('pagination::bootstrap-5') }}
    </div>
</div>
@endsection
