@extends('admin.layouts.app')
@section('title', 'Hero Slides')
@section('heading', 'Hero Slides')
@section('action')
    <a href="{{ route('admin.hero-slides.create') }}" class="btn btn-rose">Add Slide</a>
@endsection
@section('content')
<div class="admin-card p-3 table-responsive">
    <table class="table align-middle">
        <thead>
            <tr>
                <th style="width: 120px;">Image</th>
                <th>Content</th>
                <th>Status</th>
                <th>Order</th>
                <th class="text-end" style="width: 220px;">Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($slides as $slide)
                @php
                    $imageUrl = $slide->background_image_path && file_exists(public_path('storage/' . $slide->background_image_path))
                        ? asset('storage/' . $slide->background_image_path)
                        : null;
                @endphp
                <tr>
                    <td>@if($imageUrl)<img src="{{ $imageUrl }}" alt="{{ $slide->main_heading }}" class="border shadow-sm" style="width: 74px; height: 58px; object-fit: cover; border-radius: 12px;">@else<div class="bg-secondary-subtle border text-muted d-flex align-items-center justify-content-center" style="width: 74px; height: 58px; border-radius: 12px; font-size: 0.65rem; font-weight: bold;">No Image</div>@endif</td>
                    <td><strong>{{ $slide->main_heading }}</strong><br><small class="text-muted">{{ \Illuminate\Support\Str::limit($slide->description, 90) }}</small></td>
                    <td><span class="badge {{ $slide->is_active ? 'text-bg-success' : 'text-bg-secondary' }}">{{ $slide->is_active ? 'Active' : 'Inactive' }}</span></td>
                    <td>{{ $slide->sort_order }}</td>
                    <td class="text-end">
                        <div class="d-flex justify-content-end gap-2 flex-wrap">
                            <a href="{{ route('admin.hero-slides.edit', $slide) }}" class="btn btn-sm btn-outline-dark">Edit</a>
                            <form action="{{ route('admin.hero-slides.destroy', $slide) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this hero slide?')">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-outline-danger">Delete</button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr><td colspan="5" class="text-center text-muted py-4">No hero slides created yet.</td></tr>
            @endforelse
        </tbody>
    </table>
    {{ $slides->links() }}
</div>
@endsection
