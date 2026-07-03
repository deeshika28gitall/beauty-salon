@extends('admin.layouts.app')
@section('title', 'Services')
@section('heading', 'Services')
@section('action')
    <a href="{{ route('admin.services.create') }}" class="btn btn-rose">Add Service</a>
@endsection
@section('content')
<div class="admin-card p-3">
    <div class="table-responsive">
        <table class="table align-middle table-hover">
            <thead>
                <tr>
                    <th style="width: 120px;">Image</th>
                    <th>Name</th>
                    <th>Price</th>
                    <th>Status</th>
                    <th class="text-end" style="width: 160px;">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($services as $service)
                    @php
                        $resolvedUrl = null;
                        if ($service->image_path) {
                            if (filter_var($service->image_path, FILTER_VALIDATE_URL)) {
                                $resolvedUrl = $service->image_path;
                            } elseif (file_exists(public_path('storage/' . $service->image_path))) {
                                $resolvedUrl = asset('storage/' . $service->image_path);
                            }
                        }
                    @endphp
                    <tr>
                        <td>
                            @if($resolvedUrl)
                                <img src="{{ $resolvedUrl }}" alt="{{ $service->name }}" class="border shadow-sm" style="width: 74px; height: 58px; object-fit: cover; border-radius: 12px;">
                            @else
                                <div class="bg-secondary-subtle border text-muted d-flex align-items-center justify-content-center" style="width: 74px; height: 58px; border-radius: 12px; font-size: 0.65rem; font-weight: bold;">
                                    <i class="bi bi-image text-secondary me-1" style="font-size: 1rem;"></i> No Image
                                </div>
                            @endif
                        </td>
                        <td>
                            <strong>{{ $service->name }}</strong>
                            <br>
                            <small class="text-muted">{{ $service->icon ?: 'No Icon' }}</small>
                        </td>
                        <td>{{ $service->starting_price ? '₹' . number_format($service->starting_price) : 'Custom' }}</td>
                        <td>
                            <span class="badge {{ $service->is_active ? 'text-bg-success' : 'text-bg-secondary' }}">
                                {{ $service->is_active ? 'Active' : 'Inactive' }}
                            </span>
                        </td>
                        <td class="text-end">
                            <div class="d-flex justify-content-end gap-2">
                                <a href="{{ route('admin.services.edit', $service) }}" class="btn btn-sm btn-outline-dark">
                                    <i class="bi bi-pencil-square"></i> Edit
                                </a>
                                <form action="{{ route('admin.services.destroy', $service) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this service?')">
                                    @csrf 
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-outline-danger">
                                        <i class="bi bi-trash"></i> Delete
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    {{ $services->links() }}
</div>
@endsection
