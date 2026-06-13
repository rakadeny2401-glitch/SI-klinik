<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <link rel="stylesheet" href="{{ asset('css/loginstyle.css') }}">
</head>
<body>

<div class="login-container">
    <h2>Login</h2>

    @if ($errors->any())
        <div class="alert alert-danger">
            @foreach ($errors->all() as $error)
                <p>{{ $error }}</p>
            @endforeach
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    <form action="{{ route('login') }}" method="POST">
        @csrf

        <label>No Identitas:</label>
        <input type="text" name="no_identitas" required autofocus><br><br>

        <button type="submit">LOGIN</button>
    </form>
</div>

</body>
</html>
