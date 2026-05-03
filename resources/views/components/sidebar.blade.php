<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">

<div class="sidebar">

    <!-- LOGO -->
    <div class="logo">
        <img src="{{ asset('images/MARSTAY LOGO2.png') }}" alt="Logo">
    </div>

    <!-- MENU -->
    <div class="sidebar-menu">

        <a href="/dashboard">
            <i class="bi bi-house"></i> Beranda
        </a>

        <a href="/admin/kelola_kamar">
            <i class="bi bi-door-open"></i> Kelola Kamar
        </a>

        <a href="/reservasi">
            <i class="bi bi-calendar-check"></i> Reservasi
        </a>

        <a href="/admin/pembayaran">
            <i class="bi bi-cash-stack"></i> Pembayaran
        </a>

        <a href="/admin/pembatalan">
            <i class="bi bi-x-circle"></i> Pembatalan
        </a>


    </div>

    <div class="sidebar-footer">
        <div class="logout">
            <a href="/logout">
                <i class="bi bi-box-arrow-right"></i> Keluar
            </a>
        </div>

        <div class="admin-profile">
            <i class="bi bi-person-circle"></i>
            <div class="profile-info">
                <h5>{{ explode(' ', Auth::user()->name)[0] }}</h5>
                <small>Administrator</small>
            </div>
        </div>
    </div>
</div>

