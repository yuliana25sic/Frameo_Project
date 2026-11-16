@extends('layouts.app')

@section('title', 'Daftar Akun - FRAMEO')

@section('content')
<div class="row justify-content-center mt-3">
    <div class="col-md-5">
        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-body p-4 p-md-5">
                <h4 class="fw-bold text-center mb-1">Buat Akun Baru</h4>
                <p class="text-muted text-center small mb-4">Bergabung bersama FRAMEO Self Photo Studio</p>

                @if($errors->any())
                    <div class="alert alert-danger small">
                        <ul class="mb-0 ps-3">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('register') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label small fw-semibold">Nama Lengkap</label>
                        <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-semibold">Alamat Email</label>
                        <input type="email" name="email" class="form-control" value="{{ old('email') }}" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-semibold">Nomor WhatsApp</label>
                        <input type="text" name="phone_number" class="form-control" value="{{ old('phone_number') }}" placeholder="08xxxxxxxxxx" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-semibold">Kata Sandi</label>
                        <input type="password" name="password" class="form-control" placeholder="Minimal 6 karakter" required>
                    </div>
                    <div class="mb-4">
                        <label class="form-label small fw-semibold">Konfirmasi Kata Sandi</label>
                        <input type="password" name="password_confirmation" class="form-control" required>
                    </div>
                    <button type="submit" class="btn btn-dark-frameo w-100 py-2 fw-semibold">Daftar Akun</button>
                </form>

                <div class="text-center mt-4 small">
                    Sudah punya akun? <a href="{{ route('login') }}" class="text-dark fw-bold text-decoration-none">Masuk di sini</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
