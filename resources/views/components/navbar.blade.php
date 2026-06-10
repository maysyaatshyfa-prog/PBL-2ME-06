<div class="navbar-custom">

    <!-- LOGO -->
    <div class="navbar-left">
        <img src="{{ asset('images/MARSTAY LOGO.png') }}" alt="Logo">
    </div>

    <!-- MENU -->
    <div class="navbar-right">

        <a href="/">Beranda</a>

        @if(Auth::check())

        <a href="/bookinghistory">Reservasi Saya</a>

        <div class="user-dropdown">

            <button class="btn-masuk">

                <div class="user-avatar">

                    @if(Auth::user()->avatar)

                    <img src="{{ asset('storage/' . Auth::user()->avatar) }}" alt="Avatar">

                    @else

                    {{ strtoupper(substr(Auth::user()->name,0,1)) }}

                    @endif

                </div>

                <span class="user-name">
                    {{ Auth::user()->name }}
                </span>

            </button>

            <div class="dropdown-menu">

                <div class="dropdown-header">
                    <strong>{{ Auth::user()->name }}</strong>
                    <small>{{ Auth::user()->email }}</small>
                </div>

                <a href="/profile">
                    <i class="fa-regular fa-user"></i>
                    Profil Saya
                </a>

                <a href="/logout">
                    <i class="fa-solid fa-right-from-bracket"></i>
                    Keluar
                </a>

            </div>

        </div>

        @else

        <a href="/login" class="btn-masuk">Masuk</a>

        @endif

    </div>

</div>