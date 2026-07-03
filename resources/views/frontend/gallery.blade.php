@extends('layouts.app')

@section('title', 'Kharbanda Makeup Studio | Gallery')

@section('content')
@php
    $galleryFallbacks = [
        'https://images.unsplash.com/photo-1595475884562-073c30d45670?auto=format&fit=crop&w=900&q=80',
        'https://images.unsplash.com/photo-1524504388940-b1c1722653e1?auto=format&fit=crop&w=900&q=80',
        'https://images.unsplash.com/photo-1583391733956-6c78276477e2?auto=format&fit=crop&w=900&q=80',
        'https://images.unsplash.com/photo-1512316609839-ce289d3eba0a?auto=format&fit=crop&w=900&q=80',
        'https://images.unsplash.com/photo-1519699047748-de8e457a634e?auto=format&fit=crop&w=900&q=80',
        'https://images.unsplash.com/photo-1617113930975-f9c7243ae527?auto=format&fit=crop&w=900&q=80',
    ];
@endphp

<section class="section-pad">
    <div class="container">
        <div class="section-heading">
            <span class="eyebrow">Our Work</span>
            <h2>Full Gallery</h2>
            <p>Browse bridal, party, engagement, hair styling and reception looks from Kharbanda Makeup Studio.</p>
        </div>

        <div class="d-flex flex-wrap justify-content-center gap-2 mb-5">
            @foreach($categories as $key => $label)
                <a href="{{ route('gallery', ['category' => $key]) }}" class="btn {{ $activeCategory === $key ? 'btn-rose' : 'btn-soft' }}">{{ $label }}</a>
            @endforeach
        </div>

        @if($images->isEmpty())
            <div class="text-center py-5">
                <h3>No gallery images available yet.</h3>
                <p class="text-muted mb-0">Please check back soon for our latest looks.</p>
            </div>
        @else
            <div class="gallery-grid">
                @foreach($images as $image)
                    @php($imageUrl = $image->image_path && file_exists(public_path('storage/'.$image->image_path)) ? asset('storage/'.$image->image_path) : ($image->external_image_url ?: $galleryFallbacks[($loop->index) % count($galleryFallbacks)]))
                    <figure class="gallery-item item-{{ $loop->iteration }}">
                        <img src="{{ $imageUrl }}" alt="{{ $image->alt_text ?: $image->title }}">
                    </figure>
                @endforeach
            </div>
        @endif
    </div>
</section>
@endsection
