<?php
    $cart = Session::get('cart');
    $total = 0;
    $countProduct = 0;
    if (is_array($cart)) {
        foreach ($cart as $item) {
            $total += $item->so_luong_mua * $item->giaban;
            $countProduct++;
        }
    }
    $sql = "SELECT * FROM danhmuc";
    $categories = $DB->query($sql);
    $currentPage = $_SERVER['REQUEST_URI'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> <?php echo $title ?> - JvbVietNam </title>
    <link rel="stylesheet" href="./layouts/pageTQT/style.css">
    <link rel="stylesheet" href="./layouts/pageTQT/styleCart.css">
    <link rel="stylesheet" href="./layouts/pageTQT/styleCheckout.css">
    <link rel="icon" href='<?= BASE_URL . '/layouts/page/assets/wp-content/uploads/2018/02/cropped-favicon-1-75x75.png ' ?>' sizes="32x32" />
    
</head>
<body>
    <!-- Start header -->
    <div id="header">
        <div class="top-header">
            <div class = "cskh">
                <p>Chào mừng đến với JvbVietNam <span> Chăm sóc khách hàng: <a href="#">09843 434 434</a></span></p>
            </div> 
            <div class="login">
                <?php if (!Auth::customer()) : ?>
                    <a href="login.php">Đăng nhập</a>
                    <a href="register.php">Đăng ký</a>
                <?php else : ?>
                <?= Auth::customer()->hoten?><a href="logout.php">Đăng xuất</a>
                <?php endif ?>   
            </div>
        </div>
        <div class="bot-header">
            <div class="logo-search-cart">
                <div class="logo"><a href="#">JvbVietNam</a></div>              
                <div class="cart">
                    <img src="./images/cart.png">
                    <div class="tooltip">
                        <ul class="">
                            <?php if (is_array($cart)) : ?>
                            <?php foreach ($cart as $item) : ?>
                                <li class="">
                                    <a href="<?= url('product-detail.php?id=' . $item->id) ?>"></a> <a href="<?= url('product-detail.php?id=' . $item->id) ?>"></a>
                                    <img width="440" height="440" src="<?= url('product-detail.php?id=' . $item->id) ?>" class="" alt="" srcset="<?= BASE_URL . '/' . $item->hinhanh ?>" sizes="(max-width: 540px) 100vw, 540px"> <span style = "position: relative; top: -45px"><?= $item->tensanpham ?> </span></a><br>
                                    <span style = "position: relative; top: -40px; left: 80px"><?= $item->so_luong_mua ?> × <span class=""><span></span><?= number_format($item->giaban) ?><span class=""> vnđ</span></span></span>
                                </li>
                            <?php endforeach ?>
                            <?php endif ?>
                        </ul>

                        <p class="">
                        <strong style = "margin-left: 13px">Tổng tiền:</strong> <span class=""><span></span><?= number_format($total) . ' vnđ ' ?></span> </p>
                        <p style = "text-align: center; margin-top: 15px; margin-bottom: 15px"><a href="cart.php" class="btn">Xem giỏ hàng</a><a href="checkout.php" class="btn">Thanh toán</a></p>   
                    </div>
                </div>
            </div>
            <div class="menu">
                <ul>
                    <li><a href="index.php">Trang chủ</a></li>
                    <li><a href="shop.php">Cửa hàng</a></li>
                    <li><a href="blog.php">Tin tức</a></li>
                    <li><a href="contact.php">Liên hệ</a></li>
                    <li><a href="about.php">Giới thiệu</a></li>
                </ul>
            </div>            
        </div>
    </div>
    <!-- End header -->
