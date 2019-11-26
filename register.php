<?php require ("config.php");
$def = new lashopak();
if (isset($_POST['regis'])) {
	$name = filter_input(INPUT_POST, 'nama', FILTER_SANITIZE_STRING);
	$username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING);
	$password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);
	$email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_STRING);
	$telp = filter_input(INPUT_POST, 'telp', FILTER_SANITIZE_STRING);
	$alamat = filter_input(INPUT_POST, 'alamat', FILTER_SANITIZE_STRING);
	$profil = $_FILES['profil'];
	$hashed = password_hash($password, PASSWORD_DEFAULT);
	$add = $def->register($name, $username, $hashed, $email, $telp, $alamat, $profil);
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
    <p id="regis">Sudah Memiliki akun? <a href="login.php">Login.</a></p>
    <a class="kembali" href="javascript:history.back()">Kembali</a>
</div>
<div class="login">
    <form action="" method="post" enctype="multipart/form-data">
        <div class="login">
			<div class="inputWrap">
				<input class="nginput" type="text" name="nama" placeholder="Nama" autocomplete="off" required>
			</div>
			<div class="inputWrap">
				<input class="nginput" type="text" name="username" placeholder="Username" autocomplete="off" required>
			</div>
			<div class="inputWrap">
				<input class="nginput" type="password" name="password" placeholder="Password" autocomplete="off" required>
            </div>
			<div class="inputWrap">
				<input class="nginput" type="email" name="email" placeholder="Email" autocomplete="off" required>
            </div>
			<div class="inputWrap">
				<input class="nginput" type="number" name="telp" placeholder="No. Telp" autocomplete="off" required>
            </div>
			<div class="inputWrap">
                <textarea name="alamat" class="alamat" placeholder="Alamat" autocomplete="off" required></textarea>
			</div>
			<div class="inputWrap">
				<input type="file" name="profil" class="nginput">
			</div>
			<div class="inputWrap">
				<input type="submit" name="regis" value="Register">
			</div>
		</div>
    </form>
</div>
</div>
</body>
</html>