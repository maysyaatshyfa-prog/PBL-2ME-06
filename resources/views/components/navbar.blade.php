<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
<div class="navbar-custom">
    <!--NAVBAR-->
    <div class="navbar-left">
        <img src="{{ asset('images/MARSTAY LOGO.png') }}" alt="Logo">
    </div>

    <!--MENU-->
    <div class="navbar-right">
        <a href="/">Beranda</a>

        @if(Auth::check())
        <a href="/bookinghistory">Reservasi Saya</a>
        <a href="/login" class="btn-masuk">Logout</a>
        @else

        <a href="/login" class="btn-masuk">Masuk</a>
        @endif
    </div>
</div>