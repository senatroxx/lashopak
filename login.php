<?php require ("config.php");
if (isset($_POST['username'])) {
    $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING);
    $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);
    $def = new lashopak();
    $add = $def->login($username, $password);
    if (isset($_SESSION['user'])) {
        header ('location: index.php');
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="css/style.css">
    <title>Login</title>
</head>
<body>
<div class="containerlog">
<div class="menu">
    <h1>Lashopak</h1>
    <p>Terinspirasi dari secangkir kopi, bahwa dia tak pernah dusta atas nama rasa.<br> Kopi punya cerita, hitam tak selalu kotor, pahit tak harus sedih.</p>
    <p id="regis">Tidak Memiliki akun? <a href="register.php">Registrasi.</a></p>
    <a class="kembali" href="javascript:history.back()">Kembali</a>
</div>
<div class="login">
    <form action="" method="post">
        <div class="inputWrap">
            <input class="nginput" type="text" name="username" placeholder="Username or Email" autocomplete="off">
        </div>
        <div class="inputWrap">
            <input class="nginput" type="password" name="password" placeholder="Password" autocomplete="off">
        </div>
        <div class="inputWrap">
            <input type="submit" name="masuk" value="Login">
        </div>
    </form>
</div>
</div>
</body>
</html>