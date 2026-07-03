@extends('admin.layouts.app')
@section('title', 'Bridal Packages')
@section('heading', 'Bridal Packages')
@section('action')<a href="{{ route('admin.bridal-packages.create') }}" class="btn btn-rose">Add Package</a>@endsection
@section('content')
<div class="admin-card p-3 table-responsive">
    <table class="table align-middle">
        <thead><tr><th>Name</th><th>Price</th><th>Badge</th><th>Status</th><th></th></tr></thead>
        <tbody>@foreach($packages as $package)<tr>
            <td><strong>{{ $package->name }}</strong><br><small>{{ collect($package->includes)->take(2)->join(', ') }}</small></td>
            <td>{{ $package->discount_price ? '₹'.number_format($package->discount_price) : ($package->price ? '₹'.number_format($package->price) : 'Custom') }}</td>
            <td>{{ $package->badge ?: ($package->is_featured ? 'Most Popular' : '-') }}</td>
            <td><span class="badge {{ $package->is_active ? 'text-bg-success' : 'text-bg-secondary' }}">{{ $package->is_active ? 'Active' : 'Inactive' }}</span></td>
            <td class="text-end"><a href="{{ route('admin.bridal-packages.edit', $package) }}" class="btn btn-sm btn-outline-dark">Edit</a>
                <form action="{{ route('admin.bridal-packages.destroy', $package) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this package?')">@csrf @method('DELETE')<button class="btn btn-sm btn-outline-danger">Delete</button></form></td>
        </tr>@endforeach</tbody>
    </table>
    {{ $packages->links() }}
</div>
@endsection
