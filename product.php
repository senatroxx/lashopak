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
                <a href="index.php?page=home">Home</a>
                <a href="index.php?page=about">About</a>
                <a href="index.php?page=category">Contact</a>
        </div>
        <div class="right">
            <?php if(isset($_SESSION['user'])){
                $countCart = $def->countCart();
            ?>
            <a href="cart.php" id="cart"><i class="fas fa-shopping-cart"></i> Cart <span class="badge"><?= $countCart ?></span></a>
                <div class="shopping-cart">
                    <div class="shopping-cart-header">
                    <i class="fa fa-shopping-cart cart-icon"></i><span class="badge"><?= $countCart ?></span>
                    <div class="shopping-cart-total">
                        <span class="lighter-text">Total:</span>
                        <?php
                         $memID = $_SESSION['user']['id'];
                         $getTotal = $def->cartTotal($memID)->fetch(PDO::FETCH_ASSOC);
                         $priceTotal = number_format($getTotal['priceSum'],2,',','.');
                        ?>
                        <span class="main-color-text total">Rp. <?= $priceTotal ?></span>
                    </div>
                    </div> <!--end shopping-cart-header -->

                    <ul class="shopping-cart-items">
                        <?php
                            if ($countCart > 0) {
                                $showCart = $def->showCart($memID);
                                $dataCart = $showCart->fetchAll();
                                foreach ($dataCart as $rowCart) {
                                    $dataPrice = number_format($rowCart['harga'],2,',','.');
                                    $productID = $rowCart['prodID'];
                                    $cartImage = $def->cartImage($productID);
                                    $dataCartImage = $cartImage->fetchAll();
                                    foreach ($dataCartImage as $dataDataCartImage) {
                        ?>
                        <li class="clearfix">
                            <img src="img/prod/<?= $dataDataCartImage['poto']; ?>"/>
                            <span class="item-name"><?= $rowCart['nama'] ?></span>
                            <span class="item-price">Rp. <?= $dataPrice ?></span><br>
                            <span class="item-quantity">Quantity: <?= $rowCart['jumlah'] ?></span>
                        </li>
                        <?php
                            }}
                        }else{ ?>
                            <div class="empty">
                                <h1 style="font-size:16px"><i class="fas fa-minus-circle fa-md"></i> Your shopping cart is empty <i class="fas fa-minus-circle fa-lg"></i></h1>
                            </div>
                    <?php }
                        ?>
                    </ul>

                    <a href="cart.php" class="checkout">Checkout <i class="fa fa-chevron-right"></i></a>
                </div>
                <div class="dropdown"><p><?= $_SESSION['user']['nama'] ?></p>
                <div class="dropdown-content">
                <?php
                $countTrans = $def->transUserOnly($memID);
                ?>
                    <a href="order.php">Order <span class="badge"><?= $countTrans ?></span></a>
                    <a href="">Settings</a>
                </div>
                </div>
                <a href="logout.php">Logout</a>
            <?php } if (empty($_SESSION['user'])) { ?>
                <a href="cart.php" id="cart"><i class="fas fa-shopping-cart"></i> Cart <span class="badge">0</span></a>
                <div class="shopping-cart">
                    <div class="shopping-cart-header">
                    <i class="fa fa-shopping-cart cart-icon"></i><span class="badge">0</span>
                    <div class="shopping-cart-total">
                        <span class="lighter-text">Total:</span>
                        <span class="main-color-text total">Rp. 0</span>
                    </div>
                    </div> <!--end shopping-cart-header -->

                    <ul class="shopping-cart-items">
                        <div class="empty">
                            <h1 style="font-size:16px">You must be logged in to view the cart</h1>
                        </div>
                    </ul>

                    <a href="cart.php" class="checkout">Checkout <i class="fa fa-chevron-right"></i></a>
                </div>
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