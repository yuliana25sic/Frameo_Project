@extends('layouts.app')

@section('title', 'FRAMEO - Self Photo Studio')

@section('content')
<div class="text-center py-4 mb-4">
    <h1 class="fw-bold">Abadikan Momen Terbaikmu di FRAMEO</h1>
    <p class="text-muted">Studio foto mandiri dengan pencahayaan profesional, privasi penuh, dan hasil instan.</p>
</div>

<div class="row g-4">
    @foreach($packages as $package)
        <div class="col-md-4">
            <div class="card h-100 border-0 shadow-sm rounded-4">
                <div class="card-body p-4 d-flex flex-column">
                    <span class="badge bg-light text-dark border mb-2 align-self-start">{{ $package->category->name }}</span>
                    <h5 class="fw-bold">{{ $package->name }}</h5>
                    <p class="text-muted small flex-grow-1">{{ $package->description }}</p>
                    <div class="d-flex justify-content-between text-muted small mb-3 border-top pt-2">
                        <span><i class="bi bi-clock me-1"></i> {{ $package->duration_minutes }} Menit</span>
                        <span><i class="bi bi-people me-1"></i> Maks. {{ $package->max_people }} Orang</span>
                    </div>
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="fw-bold mb-0">Rp {{ number_format($package->price, 0, ',', '.') }}</h5>
                        <a href="{{ Auth::check() ? url('/booking/' . $package->id) : route('login') }}" class="btn btn-dark-frameo btn-sm px-3">
                            Booking Sekarang
                        </a>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
</div>
@endsection
