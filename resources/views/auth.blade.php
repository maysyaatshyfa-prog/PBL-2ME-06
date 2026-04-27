@extends('layouts.app')

@section('title', $page == 'login' ? 'Login' : 'Register')

@section('content')

<body class="auth-page">

    <div class="container d-flex justify-content-end align-items-center vh-100 pe-5">
        <div class="login-card p-4 shadow">

            @if($page == 'login')

            <!-- JUDUL -->
            <div class="text-center mb-2">
                <h5>Selamat datang di</h5>

                <img src="{{ asset('images/MARSTAY LOGO.png') }}"
                    alt="Logo MARStay"
                    style="width:150px;"
                    class="mb-1">

                <small class="d-block text-center mt-1">
                    Masuk untuk melanjutkan ke akun Anda
                </small>
            </div>

            <!-- FORM LOGIN -->
            <form>
                <div class="mb-3">
                    <div class="input-group">
                        <span class="input-group-text">
                            <i class="bi bi-person"></i>
                        </span>
                        <input type="text" class="form-control" placeholder="Email atau Username">
                    </div>
                </div>

                <div class="mb-3">
                    <div class="input-group">
                        <span class="input-group-text">
                            <i class="bi bi-lock"></i>
                        </span>

                        <input type="password" class="form-control" placeholder="Password">

                        <span class="input-group-text">
                            <i class="bi bi-eye"></i>
                        </span>
                    </div>
                </div>

                <div class="d-flex justify-content-between mb-3">
                    <div>
                        <input type="checkbox"> Ingat saya
                    </div>

                    <a href="#" class="text-warning text-decoration-none link-auth">
                        Lupa Password?
                    </a>
                </div>

                <button class="btn btn-marstay w-100">
                    Masuk
                </button>
            </form>

            <!-- DIVIDER -->
            <div class="text-center my-3">
                <small>atau masuk dengan</small>
            </div>

            <!-- SOCIAL -->
            <div class="d-flex justify-content-center align-items-center">
                <button class="btn social-btn"><i class="bi bi-google"></i></button>
                <button class="btn social-btn"><i class="bi bi-facebook"></i></button>
                <button class="btn social-btn"><i class="bi bi-instagram"></i></button>
            </div>

            <!-- REGISTER -->
            <div class="text-center mt-3">
                <small>
                    Belum punya akun?
                    <a href="/register" class="text-warning link-auth">
                        Daftar Sekarang
                    </a>
                </small>
            </div>

            @endif


            @if($page == 'register')

            <!-- REGISTER TITLE -->
            <div class="text-center mb-4">
                <h5>Buat akun</h5>

                <img src="{{ asset('images/MARSTAY LOGO.png') }}"
                    alt="Logo MARStay"
                    style="width:150px;"
                    class="mb-2">
            </div>

            <!-- FORM REGISTER -->
            <form>

                <div class="mb-3">
                    <div class="input-group">
                        <span class="input-group-text">
                            <i class="bi bi-person"></i>
                        </span>
                        <input type="text" class="form-control" placeholder="Nama Lengkap">
                    </div>
                </div>

                <div class="mb-3">
                    <div class="input-group">
                        <span class="input-group-text">
                            <i class="bi bi-envelope"></i>
                        </span>
                        <input type="email" class="form-control" placeholder="Email">
                    </div>
                </div>

                <div class="mb-3">
                    <div class="input-group">
                        <span class="input-group-text">
                            <i class="bi bi-lock"></i>
                        </span>
                        <input type="password" class="form-control" placeholder="Password">
                    </div>
                </div>

                <div class="mb-3">
                    <div class="input-group">
                        <span class="input-group-text">
                            <i class="bi bi-shield-lock"></i>
                        </span>
                        <input type="password" class="form-control" placeholder="Konfirmasi Password">
                    </div>
                </div>

                <button class="btn btn-outline-marstay w-100">
                    Daftar
                </button>

            </form>

            <div class="text-center mt-3">
                <small>
                    Sudah punya akun?
                    <a href="/login" class="text-warning link-auth">
                        Login
                    </a>
                </small>
            </div>

            @endif

        </div>
    </div>

</body>

@endsection