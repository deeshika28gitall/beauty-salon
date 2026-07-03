@extends('layouts.app')

@section('title', 'Kharbanda Makeup Studio | Luxury Bridal Makeup')

@section('content')
@php
    $heroImage = 'https://images.unsplash.com/photo-1516975080664-ed2fc6a32937?auto=format&fit=crop&w=1800&q=85';
    $heroSlides = $heroSlides ?? collect();
    $galleryFallbacks = [
        'https://images.unsplash.com/photo-1595475884562-073c30d45670?auto=format&fit=crop&w=900&q=80',
        'https://images.unsplash.com/photo-1524504388940-b1c1722653e1?auto=format&fit=crop&w=900&q=80',
        'https://images.unsplash.com/photo-1583391733956-6c78276477e2?auto=format&fit=crop&w=900&q=80',
        'https://images.unsplash.com/photo-1512316609839-ce289d3eba0a?auto=format&fit=crop&w=900&q=80',
        'https://images.unsplash.com/photo-1519699047748-de8e457a634e?auto=format&fit=crop&w=900&q=80',
        'https://images.unsplash.com/photo-1617113930975-f9c7243ae527?auto=format&fit=crop&w=900&q=80',
    ];
@endphp

@if($heroSlides->count())
    <section id="home" class="hero-section hero-carousel carousel slide carousel-fade" data-bs-ride="carousel" data-bs-interval="6000">
        <div class="carousel-inner">
            @foreach($heroSlides as $slide)
                @php
                    $slideImage = $slide->background_image_path ? Storage::url($slide->background_image_path) : $heroImage;
                @endphp
                <div class="carousel-item @if($loop->first) active @endif" style="--hero-image: url('{{ $slideImage }}')">
                    <div class="hero-overlay"></div>
                    <div class="container hero-content">
                        <div class="row align-items-center hero-row">
                            <div class="col-lg-7">
                                @if($slide->badge_text)
                                    <span class="eyebrow"><i class="bi bi-stars"></i> {{ $slide->badge_text }}</span>
                                @endif
                                <h1>{{ $slide->main_heading }}</h1>
                                <p>{{ $slide->description }}</p>
                                <div class="hero-stats">
                                    @if($slide->stat_1_value || $slide->stat_1_label)<span><strong>{{ $slide->stat_1_value }}</strong> {{ $slide->stat_1_label }}</span>@endif
                                    @if($slide->stat_2_value || $slide->stat_2_label)<span><strong>{{ $slide->stat_2_value }}</strong> {{ $slide->stat_2_label }}</span>@endif
                                    @if($slide->stat_3_value || $slide->stat_3_label)<span><strong>{{ $slide->stat_3_value }}</strong> {{ $slide->stat_3_label }}</span>@endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </section>
@else
    <section id="home" class="hero-section" style="--hero-image: url('{{ $heroImage }}')">
        <div class="hero-overlay"></div>
        <div class="container hero-content">
            <div class="row align-items-center hero-row">
                <div class="col-lg-7">
                    <span class="eyebrow"><i class="bi bi-stars"></i> Premium Beauty Studio</span>
                    <h1>Where Beauty Meets Perfection</h1>
                    <p>Kharbanda Makeup Studio creates luminous bridal looks, occasion glam and elevated beauty experiences with polished artistry and personal care.</p>
                    <div class="hero-stats">
                        <span><strong>3+</strong> Signature services</span>
                        <span><strong>5★</strong> Client loved</span>
                        <span><strong>100%</strong> Bridal focus</span>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endif

<section id="services" class="section-pad">
    <div class="container">
        <div class="section-heading">
            <span class="eyebrow">Our Services</span>
            <h2>Beauty Services We Offer</h2>
            <p>Thoughtful makeup and styling services designed for weddings, celebrations and milestone moments.</p>
        </div>
        <div class="row g-4">
            @foreach($services as $service)
                @php
                    $serviceImageUrl = null;
                    if ($service->image_path) {
                        if (filter_var($service->image_path, FILTER_VALIDATE_URL)) {
                            $serviceImageUrl = $service->image_path;
                        } elseif (file_exists(public_path('storage/' . $service->image_path))) {
                            $serviceImageUrl = asset('storage/' . $service->image_path);
                        }
                    }
                @endphp
                <div class="col-md-6 col-lg-4">
                    <article class="lux-card service-card h-100">
                        <div class="service-visual visual-{{ $loop->iteration }}" @if($serviceImageUrl) style="background-image: linear-gradient(135deg, rgba(232, 75, 121, .72), rgba(201, 154, 100, .46)), url('{{ $serviceImageUrl }}')" @endif>
                            <i class="bi {{ $service->icon ?: 'bi-stars' }}"></i>
                        </div>
                        <div class="card-body">
                            <div class="d-flex justify-content-between gap-3">
                                <h3>{{ $service->name }}</h3>
                                @if($service->is_featured)
                                    <span class="pill">Featured</span>
                                @endif
                            </div>
                            <p>{{ $service->description }}</p>
                            <div class="card-meta">
                                @if($service->starting_price)
                                    <span>From ₹{{ number_format($service->starting_price) }}</span>
                                @endif
                                @if($service->duration_minutes)
                                    <span>{{ $service->duration_minutes }} min</span>
                                @endif
                            </div>
                            <div class="mt-3">
                                <a href="{{ route('services.show', $service->slug) }}" class="btn btn-soft w-100">View Service</a>
                            </div>
                        </div>
                    </article>
                </div>
            @endforeach
        </div>
    </div>
</section>

<section id="packages" class="section-pad blush-band">
    <div class="container">
        <div class="section-heading">
            <span class="eyebrow">Bridal Packages</span>
            <h2>Your Perfect Bridal Journey</h2>
            <p>Premium bridal experiences with curated inclusions for your most photographed day.</p>
        </div>
        <div class="row g-4 justify-content-center">
            @foreach($bridalPackages as $package)
                <div class="col-md-6 col-lg-4">
                    <article class="pricing-card h-100 {{ $package->is_featured ? 'popular' : '' }}">
                        @if($package->is_featured)
                            <span class="popular-badge">{{ $package->badge ?: 'Most Popular' }}</span>
                        @endif
                        <i class="bi bi-gem pricing-icon"></i>
                        <h3>{{ $package->name }}</h3>
                        <p>{{ $package->short_description ?: $package->description }}</p>
                        <div class="price">
                            @if($package->price)
                                <span>₹{{ number_format($package->price) }}</span>
                                @if($package->old_price || $package->discount_price)
                                    <small>₹{{ number_format($package->old_price ?: $package->discount_price) }}</small>
                                @endif
                            @elseif($package->discount_price)
                                <span>₹{{ number_format($package->discount_price) }}</span>
                            @else
                                <span>Custom</span>
                            @endif
                        </div>
                        <ul>
                            @foreach(($package->includes ?? []) as $item)
                                <li><i class="bi bi-check2"></i>{{ $item }}</li>
                            @endforeach
                        </ul>
                        <a href="{{ route('packages.show', $package->slug) }}" class="btn {{ $package->is_featured ? 'btn-rose' : 'btn-soft' }} w-100">Book This Package</a>
                    </article>
                </div>
            @endforeach
        </div>
    </div>
</section>

<section id="gallery" class="section-pad">
    <div class="container">
        <div class="section-heading">
            <span class="eyebrow">Our Work</span>
            <h2>Gallery</h2>
            <p>A curated showcase of bridal, engagement, party and special occasion makeup looks crafted by Kharbanda Makeup Studio.</p>
        </div>
        <div class="gallery-grid">
            @forelse($galleryImages->take(6) as $image)
                @php($imageUrl = $image->image_path && file_exists(public_path('storage/'.$image->image_path)) ? asset('storage/'.$image->image_path) : ($image->external_image_url ?: $galleryFallbacks[($loop->index) % count($galleryFallbacks)]))
                <figure class="gallery-item item-{{ $loop->iteration }}">
                    <img src="{{ $imageUrl }}" alt="{{ $image->alt_text ?: $image->title }}">
                </figure>
            @empty
                <div class="col-12 text-center py-5">
                    <p class="text-muted mb-4">No gallery images available right now.</p>
                </div>
            @endforelse
        </div>
        <div class="text-center mt-5">
            <a href="{{ route('gallery') }}" class="btn btn-rose btn-lg">View Full Gallery</a>
        </div>
    </div>
</section>

<section id="testimonials" class="section-pad blush-soft">
    <div class="container">
        <div class="section-heading">
            <span class="eyebrow">Testimonials</span>
            <h2>What Our Clients Say</h2>
        </div>
        <div class="row g-4">
            @foreach($testimonials as $testimonial)
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

<section id="appointment" class="section-pad appointment-section">
    <div class="container">
        <div class="row g-5 align-items-center">
            <div class="col-lg-5">
                <span class="eyebrow">Book Your Visit</span>
                <h2>Ready to Glow?</h2>
                <p>Send your preferred date and service. The studio team will follow up to confirm availability and details.</p>
                <div class="contact-strip">
                    <span><i class="bi bi-telephone"></i>{{ $contactSetting?->phone ?? '+91 98765 43210' }}</span>
                    <span><i class="bi bi-envelope"></i>{{ $contactSetting?->email ?? 'hello@kharbandamakeupstudio.com' }}</span>
                </div>
            </div>
            <div class="col-lg-7">
                <div class="booking-card">
                    @if(session('appointment_success'))
                        <div class="alert alert-success">{{ session('appointment_success') }}</div>
                    @endif
                    <form method="POST" action="{{ route('appointments.store') }}">
                        @csrf
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label" for="name">Name</label>
                                <input id="name" name="name" class="form-control" value="{{ old('name') }}" required>
                                @error('name') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label" for="phone">Phone</label>
                                <input id="phone" name="phone" class="form-control" value="{{ old('phone') }}" required>
                                @error('phone') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label" for="email">Email</label>
                                <input id="email" name="email" type="email" class="form-control" value="{{ old('email') }}">
                                @error('email') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label" for="service">Service</label>
                                <select id="service" name="service" class="form-select">
                                    <option value="">Select a service</option>
                                    @foreach($services as $service)
                                        <option value="{{ $service->name }}" @selected(old('service') === $service->name)>{{ $service->name }}</option>
                                    @endforeach
                                    @foreach($bridalPackages as $package)
                                        <option value="{{ $package->slug }}" @selected(old('service') === $package->slug || request('package') === $package->slug)>{{ $package->name }}</option>
                                    @endforeach
                                </select>
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
                                <label class="form-label" for="message">Message</label>
                                <textarea id="message" name="message" rows="4" class="form-control">{{ old('message') }}</textarea>
                                @error('message') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>
                            <div class="col-12">
                                <button class="btn btn-rose btn-lg w-100" type="submit">Book Appointment <i class="bi bi-arrow-right ms-2"></i></button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

<section id="contact" class="section-pad contact-section">
    <div class="container">
        <div class="section-heading">
            <span class="eyebrow">Contact Us</span>
            <h2>Find Us Here</h2>
        </div>
        <div class="row g-4 align-items-stretch">
            <div class="col-lg-5">
                <div class="contact-card h-100">
                    <h3>{{ $contactSetting?->studio_name ?? 'Kharbanda Makeup Studio' }}</h3>
                    <p>{{ $contactSetting?->address ?? 'Main Market' }}<br>{{ $contactSetting?->city ?? 'Delhi' }}</p>
                    <a href="tel:{{ $contactSetting?->phone }}"><i class="bi bi-telephone"></i>{{ $contactSetting?->phone ?? '+91 98765 43210' }}</a>
                    <a href="mailto:{{ $contactSetting?->email }}"><i class="bi bi-envelope"></i>{{ $contactSetting?->email ?? 'hello@kharbandamakeupstudio.com' }}</a>
                    <a href="{{ $contactSetting?->instagram_url ?? '#' }}"><i class="bi bi-instagram"></i>Instagram</a>
                    @if($contactSetting?->business_hours)
                        <div class="hours">
                            <strong>Business Hours</strong>
                            @foreach($contactSetting->business_hours as $day => $hours)
                                <span>{{ ucfirst($day) }}: {{ $hours }}</span>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
            <div class="col-lg-7">
                <div class="map-card h-100">
                    @if($contactSetting?->map_embed_url)
                        <iframe src="{{ $contactSetting->map_embed_url }}" loading="lazy" referrerpolicy="no-referrer-when-downgrade" title="Kharbanda Makeup Studio map"></iframe>
                    @else
                        <div>
                            <i class="bi bi-geo-alt-fill"></i>
                            <h3>Studio Location</h3>
                            <p>Map integration can be connected when the final studio map link is ready.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
