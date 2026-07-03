@extends('layouts.app')

@section('title', $package->name . ' | Package Details')

@section('content')
@php
    $packageImage = $package->image_path && file_exists(public_path('storage/'.$package->image_path))
        ? asset('storage/'.$package->image_path)
        : 'https://images.unsplash.com/photo-1522338242992-e1a54906a8da?auto=format&fit=crop&w=1400&q=85';
@endphp

<section class="section-pad blush-band">
    <div class="container">
        <div class="row g-4 align-items-start">
            <div class="col-lg-6">
                <div class="admin-card overflow-hidden">
                    <img src="{{ $packageImage }}" alt="{{ $package->name }}" class="w-100" style="max-height:520px; object-fit:cover;">
                </div>
            </div>
            <div class="col-lg-6">
                <span class="eyebrow">Bridal Packages</span>
                <h1 class="mt-3 mb-3">{{ $package->name }}</h1>
                <p class="lead">{{ $package->short_description ?: $package->description }}</p>

                <div class="price mb-4">
                    @if($package->price)
                        <span>₹{{ number_format($package->price) }}</span>
                    @endif
                    @if($package->old_price || $package->discount_price)
                        <small>₹{{ number_format($package->old_price ?: $package->discount_price) }}</small>
                    @endif
                </div>

                @if($package->duration_text || $package->duration_hours)
                    <p><strong>Duration:</strong> {{ $package->duration_text ?: ($package->duration_hours.' hours') }}</p>
                @endif

                @if($package->full_description)
                    <div class="mb-4">
                        <h2 class="h5">Full Description</h2>
                        <p>{{ $package->full_description }}</p>
                    </div>
                @endif

                @if(!empty($package->includes))
                    <div class="mb-4">
                        <h2 class="h5">What’s Included</h2>
                        <ul class="list-unstyled">
                            @foreach($package->includes as $item)
                                <li class="mb-2"><i class="bi bi-check2 text-rose me-2"></i>{{ $item }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @if(!empty($package->features))
                    <div class="mb-4">
                        <h2 class="h5">Features</h2>
                        <ul class="list-unstyled">
                            @foreach($package->features as $item)
                                <li class="mb-2"><i class="bi bi-star-fill text-rose me-2"></i>{{ $item }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @if($package->suitable_for)
                    <div class="mb-4">
                        <h2 class="h5">Suitable For</h2>
                        <p>{{ $package->suitable_for }}</p>
                    </div>
                @endif

                @if($package->important_notes)
                    <div class="mb-4">
                        <h2 class="h5">Important Notes</h2>
                        <p>{{ $package->important_notes }}</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</section>

<section id="package-booking" class="py-5">
    <div class="container">
        <div class="row g-4 align-items-start">
            <div class="col-lg-5">
                <div class="contact-card h-100">
                    <h3>Package Summary</h3>
                    <p class="mb-2"><strong>Package:</strong> {{ $package->name }}</p>
                    @if($package->price)
                        <p class="mb-2"><strong>Price:</strong> ₹{{ number_format($package->price) }}</p>
                    @endif
                    @if($package->duration_text || $package->duration_hours)
                        <p class="mb-2"><strong>Duration:</strong> {{ $package->duration_text ?: ($package->duration_hours.' hours') }}</p>
                    @endif
                    <p class="mb-0">{{ $package->short_description ?: $package->description }}</p>
                </div>
            </div>
            <div class="col-lg-7">
                <div class="booking-card">
                    @if(session('appointment_success'))
                        <div class="alert alert-success">{{ session('appointment_success') }}</div>
                    @endif
                    <form method="POST" action="{{ route('appointments.store') }}">
                        @csrf
                        <input type="hidden" name="service_type" value="{{ $package->slug }}">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label" for="name">Name</label>
                                <input id="name" name="name" class="form-control" value="{{ old('name', auth()->user()->name ?? '') }}" required>
                                @error('name') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label" for="phone">Phone</label>
                                <input id="phone" name="phone" class="form-control" value="{{ old('phone') }}" required>
                                @error('phone') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label" for="email">Email</label>
                                <input id="email" name="email" type="email" class="form-control" value="{{ old('email', auth()->user()->email ?? '') }}">
                                @error('email') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label" for="service">Selected Package</label>
                                <input id="service" class="form-control" value="{{ $package->name }}" disabled>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label" for="preferred_date">Preferred Date</label>
                                <input id="preferred_date" name="preferred_date" type="date" class="form-control" value="{{ old('preferred_date') }}">
                                @error('preferred_date') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label" for="preferred_time">Preferred Time</label>
                                <input id="preferred_time" name="preferred_time" type="time" class="form-control" value="{{ old('preferred_time') }}">
                                @error('preferred_time') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>
                            <div class="col-12">
                                <label class="form-label" for="message">Message / Notes</label>
                                <textarea id="message" name="message" rows="4" class="form-control">{{ old('message') }}</textarea>
                                @error('message') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>
                            <div class="col-12">
                                <button class="btn btn-rose btn-lg w-100" type="submit">Book This Package <i class="bi bi-arrow-right ms-2"></i></button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
