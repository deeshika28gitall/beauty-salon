@extends('layouts.app')

@section('title', $service->name . ' | Kharbanda Makeup Studio')

@section('content')
@php
    $heroImage = $service->hero_image_path ?: $service->image_path;
    $resolvedHeroImage = $heroImage && file_exists(public_path('storage/' . $heroImage))
        ? asset('storage/' . $heroImage)
        : 'https://images.unsplash.com/photo-1516975080664-ed2fc6a32937?auto=format&fit=crop&w=1800&q=85';
@endphp

<section class="hero-section" style="--hero-image: url('{{ $resolvedHeroImage }}')">
    <div class="hero-overlay"></div>
    <div class="container hero-content">
        <div class="row align-items-center hero-row">
            <div class="col-lg-7">
                <span class="eyebrow"><i class="bi bi-stars"></i> Service Detail</span>
                <h1>{{ $service->name }}</h1>
                <p>{{ $service->short_description ?: $service->description }}</p>
                <div class="hero-stats">
                    @if($service->starting_price)
                        <span><strong>From</strong> ₹{{ number_format($service->starting_price) }}</span>
                    @endif
                    @if($service->duration_minutes)
                        <span><strong>{{ $service->duration_minutes }}</strong> min</span>
                    @endif
                </div>
                <div class="hero-actions">
                    <a href="#service-booking" class="btn btn-rose btn-lg"><i class="bi bi-calendar2-heart me-2"></i>Book Appointment</a>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="section-pad">
    <div class="container">
        <div class="row g-4 align-items-start">
            <div class="col-lg-7">
                <div class="admin-card p-4 h-100">
                    <div class="section-heading text-start mb-4">
                        <span class="eyebrow">Service Overview</span>
                        <h2>{{ $service->name }} Experience</h2>
                    </div>
                    <p class="text-muted">{{ $service->full_description ?: $service->description }}</p>

                    @if($service->features->isNotEmpty())
                        <h3 class="h5 mt-4">What's Included</h3>
                        <ul class="list-unstyled mt-3 mb-0">
                            @foreach($service->features as $feature)
                                <li class="mb-2"><i class="bi bi-check2 text-danger me-2"></i>{{ $feature->feature }}</li>
                            @endforeach
                        </ul>
                    @endif

                    @if($service->products->isNotEmpty())
                        <h3 class="h5 mt-4">Products Used</h3>
                        <div class="d-flex flex-wrap gap-2 mt-3">
                            @foreach($service->products as $product)
                                <span class="badge rounded-pill text-bg-light border">{{ $product->product_name }}</span>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
            <div class="col-lg-5">
                <div class="admin-card p-4 h-100">
                    <h3 class="h5 mb-3">Service Summary</h3>
                    <div class="mb-2"><strong>Starting Price:</strong> {{ $service->starting_price ? '₹' . number_format($service->starting_price) : 'Custom' }}</div>
                    <div class="mb-2"><strong>Duration:</strong> {{ $service->duration_minutes ? $service->duration_minutes . ' min' : 'Consultation based' }}</div>
                    <div class="mb-2"><strong>Suitable For:</strong> Bridal, engagement, party and special events</div>

                    @if($service->steps->isNotEmpty())
                        <h3 class="h6 mt-4">Process</h3>
                        <ol class="ps-3">
                            @foreach($service->steps as $step)
                                <li class="mb-2">
                                    <strong>{{ $step->title }}</strong>
                                    @if($step->description)
                                        <div class="text-muted">{{ $step->description }}</div>
                                    @endif
                                </li>
                            @endforeach
                        </ol>
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>

@if($service->galleryImages->isNotEmpty())
<section class="section-pad blush-band">
    <div class="container">
        <div class="section-heading">
            <span class="eyebrow">Gallery</span>
            <h2>{{ $service->name }} Looks</h2>
        </div>
        <div class="gallery-grid">
            @foreach($service->galleryImages as $image)
                @php($imageUrl = file_exists(public_path('storage/' . $image->image_path)) ? asset('storage/' . $image->image_path) : null)
                <figure class="gallery-item">
                    <img src="{{ $imageUrl }}" alt="{{ $image->title ?: $service->name }}">
                </figure>
            @endforeach
        </div>
    </div>
</section>
@endif

@if($serviceTestimonials->isNotEmpty())
<section class="section-pad blush-soft">
    <div class="container">
        <div class="section-heading">
            <span class="eyebrow">Testimonials</span>
            <h2>Client Love for {{ $service->name }}</h2>
        </div>
        <div class="row g-4">
            @foreach($serviceTestimonials as $testimonial)
                <div class="col-md-6 col-lg-4">
                    <article class="testimonial-card h-100">
                        <div class="stars">
                            @for($i = 0; $i < $testimonial->rating; $i++)
                                <i class="bi bi-star-fill"></i>
                            @endfor
                        </div>
                        <p>“{{ $testimonial->message }}”</p>
                        <div class="client">
                            <span>{{ substr($testimonial->client_name, 0, 1) }}</span>
                            <div>
                                <strong>{{ $testimonial->client_name }}</strong>
                                <small>{{ $testimonial->client_role ?: $testimonial->service_name }}</small>
                            </div>
                        </div>
                    </article>
                </div>
            @endforeach
        </div>
    </div>
</section>
@endif

@if($relatedServices->isNotEmpty())
<section class="section-pad">
    <div class="container">
        <div class="section-heading">
            <span class="eyebrow">Related Services</span>
            <h2>Explore More Services</h2>
        </div>
        <div class="row g-4">
            @foreach($relatedServices as $related)
                <div class="col-md-6 col-lg-4">
                    <article class="lux-card service-card h-100">
                        <div class="service-visual visual-{{ $loop->iteration }}" @if($related->image_path) style="background-image: linear-gradient(135deg, rgba(232, 75, 121, .72), rgba(201, 154, 100, .46)), url('{{ asset('storage/' . $related->image_path) }}')" @endif>
                            <i class="bi {{ $related->icon ?: 'bi-stars' }}"></i>
                        </div>
                        <div class="card-body">
                            <h3>{{ $related->name }}</h3>
                            <p>{{ $related->short_description ?: $related->description }}</p>
                            <a href="{{ route('services.show', $related->slug) }}" class="btn btn-soft w-100">View Service</a>
                        </div>
                    </article>
                </div>
            @endforeach
        </div>
    </div>
</section>
@endif

<section id="service-booking" class="section-pad appointment-section">
    <div class="container">
        <div class="row g-4 align-items-stretch">
            <div class="col-lg-5">
                <div class="booking-card h-100">
                    <span class="eyebrow">Service Booking</span>
                    <h2 class="h3 mt-2">{{ $service->name }}</h2>
                    <p>{{ $service->short_description ?: $service->description }}</p>
                    <div class="card-meta mt-4">
                        @if($service->starting_price)
                            <span>From ₹{{ number_format($service->starting_price) }}</span>
                        @endif
                        @if($service->duration_minutes)
                            <span>{{ $service->duration_minutes }} min</span>
                        @endif
                    </div>
                </div>
            </div>
            <div class="col-lg-7">
                <div class="booking-card">
                    @if(session('appointment_success'))
                        <div class="alert alert-success">{{ session('appointment_success') }}</div>
                    @endif
                    <form method="POST" action="{{ route('appointments.store') }}">
                        @csrf
                        <input type="hidden" name="service" value="{{ $service->slug }}">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label" for="name">Name</label>
                                <input id="name" name="name" class="form-control" value="{{ old('name', auth()->user()->name ?? '') }}" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label" for="phone">Phone</label>
                                <input id="phone" name="phone" class="form-control" value="{{ old('phone') }}" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label" for="email">Email</label>
                                <input id="email" name="email" type="email" class="form-control" value="{{ old('email', auth()->user()->email ?? '') }}">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label" for="preferred_date">Preferred Date</label>
                                <input id="preferred_date" name="preferred_date" type="date" class="form-control" value="{{ old('preferred_date') }}">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label" for="preferred_time">Preferred Time</label>
                                <input id="preferred_time" name="preferred_time" type="time" class="form-control" value="{{ old('preferred_time') }}">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label" for="event_location">Address / Venue</label>
                                <input id="event_location" name="event_location" class="form-control" value="{{ old('event_location') }}">
                            </div>
                            <div class="col-12">
                                <label class="form-label" for="message">Notes</label>
                                <textarea id="message" name="message" class="form-control" rows="4">{{ old('message') }}</textarea>
                            </div>
                        </div>
                        <div class="mt-4">
                            <button class="btn btn-rose btn-lg w-100">Book Appointment</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
