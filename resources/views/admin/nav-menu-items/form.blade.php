@extends('admin.layouts.app')
@section('title', $item->exists ? 'Edit Menu Item' : 'Add Menu Item')
@section('heading', $item->exists ? 'Edit Menu Item' : 'Add Menu Item')
@section('content')
<form class="admin-card p-4" method="POST" action="{{ $item->exists ? route('admin.nav-menu-items.update', $item) : route('admin.nav-menu-items.store') }}">
    @csrf
    @if($item->exists)
        @method('PUT')
    @endif
    <div class="row g-3">
        <div class="col-md-6">
            <label class="form-label">Label</label>
            <input name="label" class="form-control" value="{{ old('label', $item->label) }}" required>
        </div>
        <div class="col-md-6">
            <label class="form-label">URL / href</label>
            <input name="href" class="form-control" value="{{ old('href', $item->href) }}" required>
        </div>
        <div class="col-md-4">
            <label class="form-label">Sort Order</label>
            <input name="sort_order" type="number" min="0" class="form-control" value="{{ old('sort_order', $item->sort_order ?? 0) }}">
        </div>
        <div class="col-md-4 d-flex align-items-end">
            <label class="form-check-label">
                <input type="checkbox" name="open_in_new_tab" value="1" @checked(old('open_in_new_tab', $item->open_in_new_tab))> Open in new tab
            </label>
        </div>
        <div class="col-md-4 d-flex align-items-end">
            <label class="form-check-label">
                <input type="checkbox" name="is_active" value="1" @checked(old('is_active', $item->is_active ?? true))> Active
            </label>
        </div>
    </div>
    <div class="mt-4">
        <button class="btn btn-rose">Save Menu Item</button>
        <a href="{{ route('admin.nav-menu-items.index') }}" class="btn btn-outline-dark">Cancel</a>
    </div>
</form>
@endsection
