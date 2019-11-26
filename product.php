<?php require ('config.php');
$def = new lashopak();
$idProd = $_GET['id'];
if (isset($_POST['cart'])) {
    $memberID = $_SESSION['user']['id'];
    $prodID = $idProd;
    $nama = $_POST['nama'];
    $harga = $_POST['harga'];
    $jumlah = $_POST['jumlah'];
    $note = $_POST['catatan'];
    $total = ((int)$harga * (int)$jumlah);
    $add = $def->addCart($memberID, $prodID, $nama, $harga, $jumlah, $total, $note);
    if ($add = "Sukses") {
        header ('Location: '.$_SERVER['REQUEST_URI']);
    }
}
$getProd = $def->detProd($idProd);
$data = $getProd->fetch(PDO::FETCH_OBJ);
$harga = number_format($data->hargabrg,0,',','.');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>LASHOPAK</title>
    <script src="js/jquery.min.js"></script>
    <script src="js/script.js"></script>
    <link rel="stylesheet" href="css/animate.css">
    <link rel="stylesheet" href="css/fontawesome/css/all.min.css">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
<div class="container">
    <div class="topmenu">
        <div class="left" id="menu">
                <h2><a href="index.php" class="brand">LASHOPAK</a></h2>
                <a href="home">Home</a>
                <a href="">Category</a>
                <a href="">About</a>
                <a href="">Contact</a>
        </div>
        <div class="right">
            <?php
                $countCart = $def->countCart();
            ?>
            <p><i class="fas fa-shopping-cart"></i> Cart (<?= $countCart ?>)</p>
            <?php if(isset($_SESSION['user'])){ ?>
                <p><?= $_SESSION['user']['nama'] ?></p>
                <a href="logout.php">Logout</a>
            <?php } if (empty($_SESSION['user'])) { ?>
                <a href="login.php">Login</a>
                <a href="register.php">Register</a>
            <?php } ?>
        </div>
    </div>
    <div class="back">
        <a href="javascript:history.back();">Back</a>
    </div>
    <form action="" method="post">
    <div class="content">
        <div class="kiri">
            <img src="img/prod/<?= $data->poto ?>">
        </div>
        <div class="kanan">
            <div class="judul">
                <h1><?= $data->namaprod ?></h1>
            </div>
            <div class="harga">
                <span>Rp. <?= $harga ?></span>
            </div>
            <div class="stok">
                <span>Stok:</span> <span id="stokbeneran"><?= $data->jumlahbrg ?></span>
            </div>
            <div class="jumlah inputWrap" style="margin:0;line-height:35px">
                <span>Jumlah: </span>
                <input style="margin:0 10px" type="number" min="0" max="100" step="1" value="1" data-inc="1" name="jumlah">
                <input style="width:50%" type="text" name="catatan" class="nginput" placeholder="Catatan..">
            </div>
            <div class="add">
                <button type="submit" name="cart"><i class="fas fa-shopping-cart"></i> Add To Cart</button>
            </div>
        </div>
        <div class="deskripsi">
            <h2>Deskripsi Produk</h2>
            <p><?= $data->deskprod ?></p>
        </div>
        <input type="number" name="harga" value="<?= $data->hargabrg ?>" hidden>
        <input type="text" name="nama" value="<?= $data->namaprod ?>" hidden>
    </div>
    </form>
</div> 
<div class="footer">
    <p>Copyright &copy; 2019 Lashopak. All Rights Reserverd.</p>
</div>
</body>
</html>