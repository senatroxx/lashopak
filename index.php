<?php require ("config.php");
$def = new lashopak();
if (isset($_GET['pId'])) {
    if (isset($_SESSION['user'])) {
        $memberID = $_SESSION['user']['id'];
        $prodID = $_GET['pId'];
        $nama = $_GET['nama'];
        $harga = $_GET['harga'];
        $jumlah = $_GET['jumlah'];
        $note = "";
        $total = ((int)$harga * (int)$jumlah);
        $add = $def->addCart($memberID, $prodID, $nama, $harga, $jumlah, $total, $note);
        if ($add = "Sukses") {
            header ("location:index.php");
        }
    }else{
        header("location:login.php?pId=".$_GET['pId']);
    }
}
if (isset($_GET['search'])) {
    // $param = $_GET['search'];
	// $addSearch = $def->searchProd($param);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>LASHOPAK</title>
    <link rel="stylesheet" href="css/animate.css">
    <link rel="stylesheet" href="css/fontawesome/css/all.min.css">
    <link rel="stylesheet" href="css/style.css">
    <script src="js/jquery.min.js"></script>
    <script src="js/script.js"></script>
</head>
<body>
<div class="container">
    <div class="topmenu">
        <div class="left autoload" id="menu">
                <h2><a href="index.php" class="brand">LASHOPAK</a></h2>
                <a href="home">Home</a>
                <a href="about">About</a>
                <a href="category">Contact</a>
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
    <div class="header">
        <div class="searchbar">
            <form action="" method="get">
                <div class="inputWrap" style="display:flex;">
                    <input class="nginput" type="text" placeholder="Search..." name="search">
                    <button type="submit"><i class="fas fa-search"></i></button>
                </div>
            </form>
            <div class="category">
                <span>Catergory</span>:
                <?php
                    $select = $def->getCat();
                    while ($data = $select->fetch(PDO::FETCH_OBJ)) {
                        echo "
                            <a href='?kategori=$data->id'>$data->namaktg</a>
                        ";
                    }
                ?>
            </div>
        </div>
    </div>
    <div class="view" id="view">
        
    </div>
    <div class="footer">
        <p>Copyright &copy; 2019 Lashopak. All Rights Reserverd.</p>
    </div>
</div>
</body>
</html>