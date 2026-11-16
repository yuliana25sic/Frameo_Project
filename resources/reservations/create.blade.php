@extends('layouts.app')

@section('title', 'Booking Studio - FRAMEO')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-body p-4 p-md-5">
                <h4 class="fw-bold mb-1">Formulir Reservasi Studio</h4>
                <p class="text-muted small mb-4">Paket Pilihan: <strong>{{ $package->name }}</strong> (Rp {{ number_format($package->price, 0, ',', '.') }} / {{ $package->duration_minutes }} Menit)</p>

                @if($errors->any())
                    <div class="alert alert-danger small">
                        <ul class="mb-0 ps-3">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('reservations.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="package_id" value="{{ $package->id }}">

                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label class="form-label small fw-semibold">Pilih Cabang Studio</label>
                            <select name="branch_id" class="form-select" required>
                                <option value="">-- Pilih Cabang --</option>
                                @foreach($branches as $branch)
                                    <option value="{{ $branch->id }}" {{ old('branch_id') == $branch->id ? 'selected' : '' }}>
                                        {{ $branch->name }} ({{ $branch->city }})
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-semibold">Jumlah Peserta (Maks. {{ $package->max_people }} Orang)</label>
                            <input type="number" name="total_people" class="form-control" min="1" value="{{ old('total_people', 1) }}" required>
                        </div>
                    </div>

                    <div class="row g-3 mb-4">
                        <div class="col-md-6">
                            <label class="form-label small fw-semibold">Tanggal Sesi Foto</label>
                            <input type="date" name="booking_date" class="form-control" min="{{ date('Y-m-d') }}" value="{{ old('booking_date') }}" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-semibold">Jam Mulai Sesi</label>
                            <input type="time" name="start_time" class="form-control" value="{{ old('start_time') }}" required>
                        </div>
                    </div>

                    <h6 class="fw-bold mb-2">Layanan Tambahan / Add-Ons (Opsional)</h6>
                    <div class="border rounded-3 p-3 mb-4 bg-light">
                        @foreach($addons as $addon)
                            <div class="d-flex justify-content-between align-items-center mb-2 pb-2 border-bottom">
                                <div>
                                    <div class="fw-semibold small">{{ $addon->name }}</div>
                                    <div class="text-muted" style="font-size: 12px;">Rp {{ number_format($addon->price, 0, ',', '.') }} — {{ $addon->description }}</div>
                                </div>
                                <div style="width: 80px;">
                                    <input type="number" name="addons[{{ $addon->id }}]" class="form-control form-control-sm text-center" min="0" value="0">
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div class="mb-3">
                        <label class="form-label small fw-semibold">Metode Pembayaran</label>
                        <select name="payment_method" class="form-select" required>
                            <option value="Transfer Bank BCA">Transfer Bank BCA (1234567890 a.n FRAMEO Studio)</option>
                            <option value="QRIS">QRIS (Scan via Aplikasi E-Wallet / Mobile Banking)</option>
                        </select>
                    </div>

                    <div class="mb-4">
                        <label class="form-label small fw-semibold">Catatan Tambahan (Opsional)</label>
                        <textarea name="notes" class="form-control" rows="2" placeholder="Contoh: Request background warna abu-abu...">{{ old('notes') }}</textarea>
                    </div>

                    <div class="d-flex justify-content-between">
                        <a href="{{ route('home') }}" class="btn btn-outline-secondary">Kembali</a>
                        <button type="submit" class="btn btn-dark-frameo px-4 fw-semibold">Konfirmasi Reservasi</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
