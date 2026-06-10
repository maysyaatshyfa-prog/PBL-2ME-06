@extends('layouts.app')

@section('content')

@include('components.navbar')

<div class="profile-page">

    <div class="page-header">
        <h1>Profil Saya</h1>
    </div>

    {{-- PROFILE CARD --}}
    <div class="profile-banner">

        <div class="profile-left">

            <form id="avatarForm"
                  action="{{ route('profile.avatar') }}"
                  method="POST"
                  enctype="multipart/form-data">

                @csrf

                <input type="file"
                       id="avatarInput"
                       name="avatar"
                       accept="image/*"
                       hidden>

                <div class="profile-avatar clickable-avatar">

                    @if(Auth::user()->avatar)

                        <img src="{{ asset('storage/' . Auth::user()->avatar) }}"
                             class="profile-avatar-img"
                             alt="Profile">

                    @else

                        {{ strtoupper(substr(Auth::user()->name,0,1)) }}

                    @endif

                </div>

            </form>

            <div class="profile-info">

                <h2>{{ Auth::user()->name }}</h2>

                <span class="member-badge">
                    Tamu MARStay
                </span>

                <p>{{ Auth::user()->email }}</p>

            </div>

        </div>

        <a href="/profile/edit" class="btn-edit">
            Edit Profil
        </a>

    </div>

    {{-- INFORMASI PRIBADI --}}
    <div class="profile-card">

        <h3>Informasi Pribadi</h3>

        <div class="info-row">
            <span>Nama Lengkap</span>
            <strong>{{ Auth::user()->name }}</strong>
        </div>

        <div class="info-row">
            <span>Email</span>
            <strong>{{ Auth::user()->email }}</strong>
        </div>

        <div class="info-row">
            <span>No. Telepon</span>
            <strong>{{ Auth::user()->phone ?? '-' }}</strong>
        </div>

        <div class="info-row">
            <span>Jenis Kelamin</span>
            <strong>{{ Auth::user()->gender ?? '-' }}</strong>
        </div>

        <div class="info-row">
            <span>Tanggal Lahir</span>
            <strong>{{ Auth::user()->birth_date ?? '-' }}</strong>
        </div>

        <div class="info-row">
            <span>Alamat</span>
            <strong>{{ Auth::user()->address ?? '-' }}</strong>
        </div>

    </div>

    {{-- KEAMANAN --}}
    <div class="profile-card">

        <h3>Keamanan Akun</h3>

        <div class="info-row">
            <span>Password</span>
            <strong>********</strong>
        </div>

        <div class="security-action">
            <a href="/change-password" class="btn-password">
                Ubah Password
            </a>
        </div>

    </div>

</div>

<script>
document.addEventListener('DOMContentLoaded', function(){

    const avatar = document.querySelector('.clickable-avatar');
    const input = document.getElementById('avatarInput');
    const form = document.getElementById('avatarForm');

    avatar.addEventListener('click', function(){
        input.click();
    });

    input.addEventListener('change', function(){

        if(this.files.length > 0){
            form.submit();
        }

    });

});
</script>

@endsection