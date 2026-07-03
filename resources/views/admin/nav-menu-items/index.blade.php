@extends('admin.layouts.app')
@section('title', 'Navigation Menu')
@section('heading', 'Navigation Menu')
@section('action')
    <a href="{{ route('admin.nav-menu-items.create') }}" class="btn btn-rose">Add Menu Item</a>
@endsection
@section('content')
<div class="admin-card p-3 table-responsive">
    <table class="table align-middle">
        <thead>
            <tr>
                <th>Label</th>
                <th>Href</th>
                <th>New Tab</th>
                <th>Status</th>
                <th>Order</th>
                <th class="text-end">Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($items as $item)
                <tr>
                    <td><strong>{{ $item->label }}</strong></td>
                    <td>{{ $item->href }}</td>
                    <td>{{ $item->open_in_new_tab ? 'Yes' : 'No' }}</td>
                    <td><span class="badge {{ $item->is_active ? 'text-bg-success' : 'text-bg-secondary' }}">{{ $item->is_active ? 'Active' : 'Inactive' }}</span></td>
                    <td>{{ $item->sort_order }}</td>
                    <td class="text-end">
                        <a href="{{ route('admin.nav-menu-items.edit', $item) }}" class="btn btn-sm btn-outline-dark">Edit</a>
                        <form action="{{ route('admin.nav-menu-items.destroy', $item) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this menu item?')">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-outline-danger">Delete</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="6" class="text-center text-muted py-4">No menu items found.</td></tr>
            @endforelse
        </tbody>
    </table>
    {{ $items->links('pagination::bootstrap-5') }}
</div>
@endsection
