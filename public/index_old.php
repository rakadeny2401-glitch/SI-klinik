<?php
$page_style = ['loginstyle.css'];
$page_title = 'Login';
?>

<!DOCTYPE html>
<html>
<head>
    <title><?php echo $page_title; ?></title>
    <link rel="stylesheet" href="style/css/loginstyle.css">
</head>
<body>

<div class="login-container">
    <h2>Login</h2>

    <form action="controller/login_proses.php" method="POST">
        <label>No Identitas (16 digit):</label>
        <input type="text" name="no_identitas" maxlength="16" required autofocus>

        <button type="submit">LOGIN</button>

        <button type="button" class="alt-btn"
            onclick="window.location.href='view/login/login_nama.php'">
            Login dengan Cara Lain
        </button>
    </form>
</div>

</body>
</html>
