<?php

require_once('./autoload/Autoload.php');

if (!Auth::customer()) {
     Redirect::url("login.php");
}

$cart = Session::get('cart');

$total = 0;
$countProduct = 0;

if (is_array($cart)) {
    foreach ($cart as $item) {
        $total += $item->so_luong_mua * $item->giaban;

        $countProduct++;
    }
}

if (Input::post('checkout')) {
    if (Auth::customer()) {
        $DB->update(
            'khachhang',
            [
                'phone'  => Input::post('phone'),
                'diachi' => Input::post('diachi')
            ],
            Auth::customer()->id
        );

        $don_hang = [
            'tongtien'     => $total,
            'khachhang_id' => Auth::customer()->id,
            'trangthai'    => 0,
        ];
    } else {
        $khachhang = [

            'hoten'  => Input::post('hoten'),
            'phone'  => Input::post('phone'),
            'email'  => Input::post('email'),
            'diachi' => Input::post('diachi'),
            'note'   => Input::post('note'),
            'avatar' => 'employee-avatar.png',
            'password' => '',
        ];

        $DB->create('khachhang', $khachhang);

        $idKhachhang = $DB->getInsertID();

        $don_hang = [
            'tongtien'  => $total,
            'khachhang_id'  => $idKhachhang,
            'trangthai' => 0,
        ];
    }


    $created = $DB->create('donhang', $don_hang);

    if ($created) {
        $idDonHang = $DB->getInsertID();
        
        foreach ($_SESSION['cart'] as $product) {
            $chi_tiet = [
                'sanpham_id' => $product->id,
                'donhang_id' => $idDonHang,
                'soluongmua' => $product->so_luong_mua,
                'sale'       => $product->sale,
            ];
            $created = $DB->create('chitietdonhang', $chi_tiet);
            if ($created) {
                $_SESSION['thong_bao'] = true;
                unset($_SESSION['cart']);
                Redirect::url("checkout_success.php");
                //header('location: checkout_success.php');
            } else {
                $_SESSION['thong_bao'] = false;
                Redirect::url("checkout_success.php");
                //header('location: checkout_success.php');
            }
        }   
    }
}



$title = "Thanh to??n";


require_once('./layouts/pageTQT/header.php');


?>

<div id="mainCheckout">
    <form name="checkout" method="post" class="" enctype="multipart/form-data">
             <!-- <div class = "top-checkout">
                <div class = "info-checkout">
                    <h3>Nh???p th??ng tin c???a b???n</h3>
                    <p>H??? t??n *</p>
                    <input type="text" required class="input-text " name="hoten" id="billing_last_name" placeholder="" value="" autocomplete="family-name" />             
                    <p>?????a ch??? *</p>
                    <input type="text" required class="input-text " value="" placeholder="" name="diachi" id="billing_state" autocomplete="address-level1" data-input-classes="" />                  
                    <p>S??? ??i???n tho???i *</p>
                    <input type="tel" required class="input-text " name="phone" id="billing_phone" placeholder="" value="" autocomplete="tel" />                    
                    <p>Email *</p>
                    <input type="email" required class="input-text " name="email" id="billing_email" placeholder="" value="" autocomplete="email username" />             
                </div>
                <div class = "info-add">
                    <h3>Th??ng tin b??? sung</h3>
                    <p>Ghi ch??</p>
                    <textarea name="" id="" cols="50" rows="10"></textarea>
                </div>
            </div>  -->
            <div class = "top-checkout">
                <div class = "info-checkout">
                    <p>Nh???p ?????a ch??? nh???n h??ng *</p> <br>
                    <input type="text" required class="input-text " value="" placeholder="" name="diachi" id="billing_state" autocomplete="address-level1" data-input-classes="" />                                      
                </div>
                <div class = "info-add">
                    <h3>Th??ng tin b??? sung</h3>
                    <p>Ghi ch??</p>
                    <textarea name="" id="" cols="50" rows="10"></textarea>
                </div>
            </div>     
        <?php if (is_array($cart)) : ?>
            <div id="order_review">
                <table>
                    <thead>
                        <tr>
                            <th style = "float: left">S???n ph???m</th>
                            <th style ="position: relative; left: 20px">Th??nh ti???n</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($cart as $item) : ?>
                        <tr>
                            <td>
                                <?= $item->tensanpham ?> &nbsp; <strong>&times;&nbsp;<?= $item->so_luong_mua ?></strong> </td>
                            <td>
                                <span style = "float: right"><?= number_format($item->giaban * $item->so_luong_mua) . ' vn??'  ?></span> </td>
                        </tr>
                    <?php endforeach ?>
                    </tbody>
                    <tfoot>
                        <tr>
                            <th style = "float: left">T???ng ti???n</th>
                            <td><strong><span style = "float: right"><?= number_format($total) . ' vn??'  ?></span></strong> </td>
                        </tr>
                    </tfoot>
                </table>
                <div id="payment">
                    <button type="submit" class="" name="checkout" id="place_order" value="Place order" data-value="Place order">?????t h??ng</button>
                </div>
            </div>
                <?php else : ?>
                    <h2 style="height: 40vh; margin-left: 10%">????n h??ng c???a b???n ch??a c?? s???n ph???m n??o !</h2>
                <?php endif ?>
    </form>
</div>

<?php require_once('./layouts/pageTQT/footer.php') ?>

