@extends('layouts.app')

@section('title', 'Reservasi Saya - FRAMEO')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="fw-bold mb-0">Riwayat Reservasi Saya</h4>
    <a href="{{ route('home') }}" class="btn btn-dark-frameo btn-sm">+ Booking Baru</a>
</div>

@forelse($reservations as $res)
    <div class="card border-0 shadow-sm rounded-4 mb-3">
        <div class="card-body p-4">
            <div class="d-flex flex-wrap justify-content-between align-items-center border-bottom pb-3 mb-3">
                <div>
                    <span class="badge bg-dark me-2">{{ $res->booking_code }}</span>
                    <span class="text-muted small">{{ $res->branch->name }}</span>
                </div>
                <div>
                    @if($res->status == 'pending')
                        <span class="badge bg-warning text-dark">Menunggu Konfirmasi</span>
                    @elseif($res->status == 'confirmed')
                        <span class="badge bg-success">Terkonfirmasi</span>
                    @elseif($res->status == 'completed')
                        <span class="badge bg-secondary">Selesai</span>
                    @else
                        <span class="badge bg-danger">Dibatalkan</span>
                    @endif
                </div>
            </div>

            <div class="row">
                <div class="col-md-7">
                    <h5 class="fw-bold mb-1">{{ $res->package->name }}</h5>
                    <p class="text-muted small mb-2">
                        <i class="bi bi-calendar-event me-1"></i> {{ \Carbon\Carbon::parse($res->booking_date)->format('d M Y') }} |
                        <i class="bi bi-clock ms-2 me-1"></i> {{ substr($res->start_time, 0, 5) }} - {{ substr($res->end_time, 0, 5) }} WIB |
                        <i class="bi bi-people ms-2 me-1"></i> {{ $res->total_people }} Orang
                    </p>
                    @if($res->reservationAddons->count() > 0)
                        <div class="small text-muted">
                            <strong>Add-ons:</strong>
                            @foreach($res->reservationAddons as $item)
                                {{ $item->addon->name }} ({{ $item->quantity }}x){{ !$loop->last ? ',' : '' }}
                            @endforeach
                        </div>
                    @endif
                </div>

                <div class="col-md-5 text-md-end mt-3 mt-md-0">
                    <div class="text-muted small">Total Tagihan ({{ $res->payment->payment_method }})</div>
                    <h5 class="fw-bold text-dark mb-2">Rp {{ number_format($res->total_price, 0, ',', '.') }}</h5>

                    @if($res->payment->payment_status == 'unpaid')
                        <form action="{{ route('reservations.uploadPayment', $res->id) }}" method="POST" enctype="multipart/form-data" class="mt-2">
                            @csrf
                            <div class="input-group input-group-sm">
                                <input type="file" name="proof_image" class="form-control" accept="image/*" required>
                                <button type="submit" class="btn btn-dark-frameo">Kirim Bukti</button>
                            </div>
                        </form>
                    @elseif($res->payment->payment_status == 'pending_verification')
                        <span class="badge bg-info text-dark">Bukti Terkirim (Menunggu Verifikasi)</span>
                    @elseif($res->payment->payment_status == 'paid')
                        <span class="badge bg-success"><i class="bi bi-check-circle me-1"></i> Lunas</span>
                    @endif
                </div>
            </div>
        </div>
    </div>
@empty
    <div class="text-center py-5 bg-white rounded-4 shadow-sm">
        <p class="text-muted mb-3">Anda belum memiliki riwayat reservasi studio.</p>
        <a href="{{ route('home') }}" class="btn btn-dark-frameo">Pilih Paket Foto Sekarang</a>
    </div>
@endforelse
@endsection
