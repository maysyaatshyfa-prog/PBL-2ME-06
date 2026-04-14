<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login & Register</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <Style>
        html,
        body {
            height: 100%;
            margin: 0;
        }

        body {
           //background: url('{{ asset('background login.png') }}') no-repeat center center fixed;//
            background-size: cover;
        }
    </style>
</head>

<body>
    <div class="container d-flex justify-content-end align-items-center vh-100 pe-5">
        <div class="login-card p-$ shadow">

            <!---JUDUL--->
            <div class="text-center mb-4">
                <h5>Selamat datang di</h5>
                <img src="{{ asset('MARSTAY LOGO.png') }}" alt="Logo MARStay" style="width:150px;" class="mb-2">

                <small class="d-block text-center">
                    Masuk untuk melanjutkan ke akun Anda
                </small>
            </div>

            <!---FORM--->
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
                    </div>
                </div>
                <div class="d-flex justify-between mb-3">
                    <div>
                        <input type="checkbox"> Ingat saya </div>



</body>

</html>