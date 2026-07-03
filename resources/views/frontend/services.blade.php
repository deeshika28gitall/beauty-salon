@extends('layouts.app')

@section('title', 'Kharbanda Makeup Studio | Services')

@section('content')
<section class="section-pad">
    <div class="container">
        <div class="section-heading">
            <span class="eyebrow">Our Services</span>
            <h2>Beauty Services We Offer</h2>
            <p>Explore every salon service in detail and choose the look that fits your occasion.</p>
        </div>
        <div class="row g-4">
            @foreach($services as $service)
                <div class="col-md-6 col-lg-4">
                    <article class="lux-card service-card h-100">
                        <div class="service-visual visual-{{ $loop->iteration }}" @if($service->image_path) style="background-image: linear-gradient(135deg, rgba(232, 75, 121, .72), rgba(201, 154, 100, .46)), url('{{ asset('storage/' . $service->image_path) }}')" @endif>
                            <i class="bi {{ $service->icon ?: 'bi-stars' }}"></i>
                        </div>
                        <div class="card-body">
                            <div class="d-flex justify-content-between gap-3">
                                <h3>{{ $service->name }}</h3>
                                @if($service->is_featured)
                                    <span class="pill">Featured</span>
                                @endif
                            </div>
                            <p>{{ $service->short_description ?: $service->description }}</p>
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
@endsection
