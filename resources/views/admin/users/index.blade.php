@extends('admin.layouts.app')
@section('title', 'Users')
@section('heading', 'Registered Users')
@section('content')
<div class="admin-card p-3 table-responsive">
    <table class="table align-middle">
        <thead>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Role / Type</th>
                <th>Total Bookings</th>
                <th>Registered</th>
                <th>Status</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @forelse($users as $user)
                <tr>
                    <td><strong>{{ $user->name }}</strong></td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->is_admin ? 'Admin' : 'User' }}</td>
                    <td>{{ $user->bookings_count ?? 0 }}</td>
                    <td>{{ $user->created_at?->format('d M Y') }}</td>
                    <td>
                        @if($user->is_admin)
                            <span class="badge text-bg-dark">Admin</span>
                        @elseif($user->email_verified_at)
                            <span class="badge text-bg-success">Verified</span>
                        @else
                            <span class="badge text-bg-secondary">Pending</span>
                        @endif
                    </td>
                    <td class="text-end">
                        <a href="{{ route('admin.users.show', $user) }}" class="btn btn-sm btn-outline-dark">View</a>
                    </td>
                </tr>
            @empty
                <tr><td colspan="7" class="text-center text-muted py-4">No users found.</td></tr>
            @endforelse
        </tbody>
    </table>
    {{ $users->links('pagination::bootstrap-5') }}
</div>
@endsection
