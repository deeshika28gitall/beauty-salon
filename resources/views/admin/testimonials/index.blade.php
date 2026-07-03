@extends('admin.layouts.app')
@section('title', 'Testimonials')
@section('heading', 'Testimonials')
@section('action')<a href="{{ route('admin.testimonials.create') }}" class="btn btn-rose">Add Testimonial</a>@endsection
@section('content')
<div class="admin-card p-3 table-responsive">
    <table class="table align-middle">
        <thead><tr><th>Client</th><th>Rating</th><th>Review</th><th>Status</th><th></th></tr></thead>
        <tbody>@foreach($testimonials as $testimonial)<tr>
            <td><strong>{{ $testimonial->client_name }}</strong><br><small>{{ $testimonial->client_role ?: $testimonial->service_name }}</small></td>
            <td>{{ $testimonial->rating }}/5</td>
            <td>{{ \Illuminate\Support\Str::limit($testimonial->message, 80) }}</td>
            <td><span class="badge {{ $testimonial->is_active ? 'text-bg-success' : 'text-bg-secondary' }}">{{ $testimonial->is_active ? 'Active' : 'Inactive' }}</span></td>
            <td class="text-end"><a href="{{ route('admin.testimonials.edit', $testimonial) }}" class="btn btn-sm btn-outline-dark">Edit</a>
                <form action="{{ route('admin.testimonials.destroy', $testimonial) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this testimonial?')">@csrf @method('DELETE')<button class="btn btn-sm btn-outline-danger">Delete</button></form></td>
        </tr>@endforeach</tbody>
    </table>
    {{ $testimonials->links() }}
</div>
@endsection
