<!DOCTYPE html>
<html>
<head>
    <title>Login SSO</title>
</head>
<body>

<h2>Login Sistem Perpustakaan</h2>

<a href="/auth/google">
    <button>Login dengan Akun Sekolah</button>
</a>

@if(session('error'))
    <p style="color:red">{{ session('error') }}</p>
@endif

</body>
</html>