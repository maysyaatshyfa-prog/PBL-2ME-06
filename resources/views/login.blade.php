// Nama File: login.blade.php
// Deskripsi: Halaman login
// Dibuat oleh: Resika Hutagalung - 3312511124

<!DOCTYPE html>
<html lang="en">
<head>

<meta charset="UTF-8">
<title>Hotel  MARstay </title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

<style>

body{
height:100vh;
background: linear-gradient(rgba(0,0,0,0.5),rgba(0,0,0,0.5)),
url("https://images.unsplash.com/photo-1566073771259-6a8506099945");
background-size:cover;
background-position:center;
display:flex;
align-items:center;
justify-content:center;
font-family:Arial;
}

.login-box{
width:420px;
background:white;
border-radius:15px;
padding:35px;
box-shadow:0 10px 40px rgba(0,0,0,0.3);
}

.logo{
font-size:28px;
font-weight:bold;
text-align:center;
margin-bottom:10px;
}

.subtitle{
text-align:center;
color:gray;
margin-bottom:25px;
}

.btn-login{
background:#0d6efd;
border:none;
}

.footer{
text-align:center;
margin-top:20px;
font-size:13px;
color:gray;
}

.top-logo{
position:absolute;
top:20px;
left:30px;
width:230px;
z-index:3;
}

.top-logo{
position:absolute;
top:20px;
left:30px;
width:230px;
z-index:3;
mix-blend-mode: multiply;
}

.top-logo{
position:absolute;
top:20px;
left:30px;
width:230px;
z-index:3;
filter: drop-shadow(0px 2px 6px rgba(0, 0, 0, 0));
}

#splash{
position:fixed;
top:0;
left:0;
width:100%;
height:100%;
background:#ffffff;
display:flex;
justify-content:center;
align-items:center;
z-index:9999;
}

.splash-logo{
width:350px;
animation: zoom 2s ease;
}

@keyframes zoom{
0%{
transform:scale(0.5);
opacity:0;
}

100%{
transform:scale(1);
opacity:1;
}
}
</style>


</head>

<body>
<div id="splash">
    <img src="{{ asset('logo hotel.png') }}" class="splash-logo">
</div>

<body>

<img src="{{ asset('logo hotel.png') }}" class="top-logo">

<div class="overlay"></div>

<div class="login-box">

<div class="logo">
Hotel  MARstay 
</div>


<form>

<div class="mb-3">
<label class="form-label">Email</label>
<div class="input-group">
<span class="input-group-text">
<i class="bi bi-envelope"></i>
</span>
<input type="email" class="form-control" placeholder="Masukkan Email">
</div>
</div>

<div class="mb-3">
<label class="form-label">Password</label>
<div class="input-group">
<span class="input-group-text">
<i class="bi bi-lock"></i>
</span>
<input type="password" class="form-control" placeholder="Masukkan Password">
</div>
</div>

<div class="d-grid">
<button class="btn btn-login text-white">
Login
</button>
</div>

</form>

<div class="footer">
Hotel MARstay 
</div>

</div>
<script>

setTimeout(function(){
document.getElementById("splash").style.display="none";
},3000);

</script>
</body>
</html>
