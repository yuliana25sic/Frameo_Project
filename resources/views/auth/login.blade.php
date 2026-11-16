@extends('layouts.app')

@section('title', 'Masuk - FRAMEO')

@section('content')
<div class="row justify-content-center mt-4">
    <div class="col-md-5">
        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-body p-4 p-md-5">
                <h4 class="fw-bold text-center mb-1">Selamat Datang Kembali</h4>
                <p class="text-muted text-center small mb-4">Masuk ke akun FRAMEO untuk melakukan reservasi studio</p>

                @if($errors->any())
                    <div class="alert alert-danger small">
                        {{ $errors->first() }}
                    </div>
                @endif

                <form action="{{ route('login') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label small fw-semibold">Alamat Email</label>
                        <input type="email" name="email" class="form-control" value="{{ old('email') }}" placeholder="contoh@email.com" required autofocus>
                    </div>
                    <div class="mb-4">
                        <label class="form-label small fw-semibold">Kata Sandi</label>
                        <input type="password" name="password" class="form-control" placeholder="••••••••" required>
                    </div>
                    <button type="submit" class="btn btn-dark-frameo w-100 py-2 fw-semibold">Masuk</button>
                </form>

                <div class="text-center mt-4 small">
                    Belum punya akun? <a href="{{ route('register') }}" class="text-dark fw-bold text-decoration-none">Daftar sekarang</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
