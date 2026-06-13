<!DOCTYPE html>
<html>
<head>
    <title>Login Sistem Puskesmas</title>
</head>
<body>

<h2>Login</h2>

@if(session('error'))
    <p style="color:red">{{ session('error') }}</p>
@endif

<form method="POST" action="/login">
    @csrf

    <label>No Identitas</label><br>
    <input type="text" name="no_identitas"><br><br>

    <label>Password</label><br>
    <input type="password" name="password"><br><br>

    <button type="submit">Login</button>
</form>

</body>
</html>