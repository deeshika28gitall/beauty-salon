@extends('admin.layouts.app')
@section('title', 'Contact Settings')
@section('heading', 'Contact Settings')
@section('content')
<form class="admin-card p-4" method="POST" action="{{ route('admin.contact-settings.update') }}">
    @csrf @method('PUT')
    <input type="hidden" name="id" value="{{ $contactSetting->id }}">
    <div class="row g-3">
        <div class="col-md-6"><label class="form-label">Studio Name</label><input name="studio_name" class="form-control" value="{{ old('studio_name', $contactSetting->studio_name) }}" required></div>
        <div class="col-md-6"><label class="form-label">City</label><input name="city" class="form-control" value="{{ old('city', $contactSetting->city) }}"></div>
        <div class="col-md-4"><label class="form-label">Phone</label><input name="phone" class="form-control" value="{{ old('phone', $contactSetting->phone) }}"></div>
        <div class="col-md-4"><label class="form-label">WhatsApp</label><input name="whatsapp" class="form-control" value="{{ old('whatsapp', $contactSetting->whatsapp) }}"></div>
        <div class="col-md-4"><label class="form-label">Email</label><input name="email" type="email" class="form-control" value="{{ old('email', $contactSetting->email) }}"></div>
        <div class="col-12"><label class="form-label">Address</label><textarea name="address" class="form-control" rows="3">{{ old('address', $contactSetting->address) }}</textarea></div>
        <div class="col-md-6"><label class="form-label">Instagram URL</label><input name="instagram_url" class="form-control" value="{{ old('instagram_url', $contactSetting->instagram_url) }}"></div>
        <div class="col-md-6"><label class="form-label">Facebook URL</label><input name="facebook_url" class="form-control" value="{{ old('facebook_url', $contactSetting->facebook_url) }}"></div>
        <div class="col-md-6"><label class="form-label">Google Map URL</label><input name="map_url" class="form-control" value="{{ old('map_url', $contactSetting->map_url) }}"></div>
        <div class="col-md-6"><label class="form-label">Google Map Embed URL</label><input name="map_embed_url" class="form-control" value="{{ old('map_embed_url', $contactSetting->map_embed_url) }}"></div>
        <div class="col-12"><label class="form-label">Opening Hours, one per line as Day: Hours</label><textarea name="business_hours_text" class="form-control" rows="7">{{ old('business_hours_text', collect($contactSetting->business_hours)->map(fn($v,$k) => ucfirst($k).': '.$v)->join(PHP_EOL)) }}</textarea></div>
        <div class="col-12"><label><input type="checkbox" name="is_active" value="1" @checked(old('is_active', $contactSetting->is_active ?? true))> Active</label></div>
    </div>
    <div class="mt-4"><button class="btn btn-rose">Save Contact Settings</button></div>
</form>
@endsection
