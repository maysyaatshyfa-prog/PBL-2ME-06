<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login & Register</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <link rel="stylesheet" href="{{ asset('styles/style_maysya.css') }}">
</head>

<body>
    <div class="container d-flex justify-content-end align-items-center vh-100 pe-5">
        <div class="login-card p-4 shadow">

            @if($page == 'login')
            <!---JUDUL--->
            <div class="text-center mb-2">
                <h5>Selamat datang di</h5>
                <img src="{{ asset('images/MARSTAY LOGO.png') }}" alt="Logo MARStay" style="width:150px;" class="mb-1">

                <small class="d-block text-center mt-1">
                    Masuk untuk melanjutkan ke akun Anda
                </small>
            </div>

            <!---FORM LOGIN --->
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
                    <a href="#" class="text-warning text-decoration-none link-auth">Lupa Password?</a>
                </div>
                <button class="btn btn-marstay w-100">Masuk</button>
            </form>

            <!--DIVIDER-->
            <div class="text-center my-3">
                <small> atau masuk dengan </small>
            </div>

            <!--SOCIAL MEDIA-->
            <div class="d-flex justify-content-center align-items-center">
                <button class="btn social-btn"><i class="bi bi-google"></i></button>
                <button class="btn social-btn"><i class="bi bi-facebook"></i></button>
                <button class="btn social-btn"><i class="bi bi-instagram"></i></button>
            </div>

            <!--REGISTER LINK-->
            <div class="text-center mt-3">
                <small>Belum punya akun?
                    <a href="/register" class="text-warning link-auth">Daftar Sekarang</a>
                </small>
            </div>
            @endif
            @if($page == 'register')
            <!--FORM REGISTER-->
            <div class="text-center mb-4">
                <h5>Buat akun</h5>
                <img src="{{ asset('images/MARSTAY LOGO.png') }}" alt="Logo MARStay" style="width:150px;" class="mb-2">
            </div>
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
                        <span class="input-group-text">
                            <i class="bi bi-eye"></i>
                        </span>
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
                <button class="btn btn-outline-marstay w-100">Daftar</button>
            </form>
            <div class="text-center mt-3">
                <small>Sudah punya akun?
                    <a href="/login" class="text-warning link-auth">Login</a>
                </small>
            </div>
            @endif
        </div>
    </div>

    <!--FOOTER-->
    <footer class="footer">
        <div class="footer-left">
            <div>
                <i class="bi bi-geo-alt"></i> Jl. S.Parman No.124 Batam, Indonesia
            </div>
            <div>
                <i class="bi bi-telephone"></i> +62 812-7209-6252
            </div>
            <div>
                <i class="bi bi-envelope"></i> info@marstay.com
            </div>
        </div>
        <div class="footer-right">
            <a href="https://www.instagram.com/shyfaput?utm_source=qr&igsh=cTA3ZGF5aDV1bnEw"><i class="bi bi-instagram"></i></a>
            <i class="bi bi-facebook"></i>
            <i class="bi bi-twitter"></i>
        </div>
    </footer>



</body>

</html>