@extends('layouts.app')

@section('title', $page == 'login' ? 'Login' : 'Register')

@section('content')

<body class="auth-page">

    <div class="container d-flex justify-content-end align-items-center vh-100 pe-5">
        <div class="login-card p-4 shadow">

            @if($page == 'login')

                <!-- JUDUL DINAMIS -->
                <div class="text-center mb-3">
                    @if($role == 'admin')
                        <h4 class="fw-bold">ADMIN LOGIN</h4>
                         <h5>Selamat datang di</h5>
                        <img src="{{ asset('images/MARSTAY LOGO.png') }}" alt="Logo MARStay" style="width:150px;" class="mb-1">
                        <p class="text-muted small">Panel Manajemen MARStay</p>
                        <hr>
                    @else
                        <h5>Selamat datang di</h5>
                        <img src="{{ asset('images/MARSTAY LOGO.png') }}" alt="Logo MARStay" style="width:150px;" class="mb-1">
                        <small class="d-block text-center mt-1">
                            Masuk untuk melanjutkan ke akun Anda
                        </small>
                    @endif
                </div>

                <!-- FORM LOGIN -->
                @if(session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                @endif

                <form method="POST" action="{{ $role == 'admin' ? '/admin/login' : '/login' }}">
                    @csrf

                    <div class="mb-3">
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-person"></i></span>
                            <input type="email" name="email" class="form-control" placeholder="Email" required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-lock"></i></span>
                            <input type="password" name="password" class="form-control" placeholder="Password" required>
                        </div>
                    </div>

                    <button type="submit" class="btn {{ $role == 'admin' ? 'btn-dark' : 'btn-marstay' }} w-100">
                        Masuk
                    </button>
                </form>

                <!-- SOCIAL LOGIN (Hanya untuk non-admin) -->
                @if($role != 'admin')
                    <div class="text-center my-3">
                        <small>atau masuk dengan</small>
                    </div>

                    <div class="d-flex justify-content-center align-items-center">
                        <button class="btn social-btn"><i class="bi bi-google"></i></button>
                        <button class="btn social-btn"><i class="bi bi-facebook"></i></button>
                        <button class="btn social-btn"><i class="bi bi-instagram"></i></button>
                    </div>

                    <div class="text-center mt-3">
                        <small>
                            Belum punya akun?
                            <a href="/register" class="text-warning link-auth">Daftar Sekarang</a>
                        </small>
                    </div>
                @endif

            @elseif($page == 'register')

                <!-- JUDUL REGISTER -->
                <div class="text-center mb-4">
                    <h5>Buat akun</h5>
                    <img src="{{ asset('images/MARSTAY LOGO.png') }}" alt="Logo MARStay" style="width:150px;" class="mb-2">
                </div>

                <!-- FORM REGISTER -->
                <form method="POST" action="/register">
                    @csrf
                    <div class="mb-3">
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-person"></i></span>
                            <input type="text" name="name" class="form-control" placeholder="Nama Lengkap" required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                            <input type="email" name="email" class="form-control" placeholder="Email" required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-lock"></i></span>
                            <input type="password" name="password" class="form-control" placeholder="Password" required>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-outline-marstay w-100">Daftar</button>
                </form>

                <div class="text-center mt-3">
                    <small>Sudah punya akun? <a href="/login" class="text-warning link-auth">Login</a></small>
                </div>

            @endif  

        </div>
    </div>

</body>

@endsection