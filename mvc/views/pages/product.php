<style>
    .goto-cart {
        position: fixed;
        top: 150px;
        left: 10px;
        display: inline-flex;
        justify-content: center;
        align-items: center;
        background-color: #77B81E;
        width: 60px;
        height: 60px;
        border-radius: 50%;
        color: #fff;
        text-decoration: none;
    }

    .goto-cart .badge {
        position: absolute;
        top: -7px;
        right: -5px;
        padding: 5px 10px;
        border-radius: 50%;
        background: red;
        color: white;
    }

    .goto-cart i {
        color: #fff;
        font-size: 2em;
        transition: .5s;
        text-decoration: none;
    }

    .goto-cart:hover i {
        transform: rotate(25deg);
        text-decoration: none;
        color: #fff;
    }

    .goto-cart:hover {
        text-emphasis: none;
    }

    .side-cart {
        height: 100%;
        /* 100% Full-height */
        width: 0;
        /* 0 width - change this with JavaScript */
        position: fixed;
        /* Stay in place */
        z-index: 2;
        /* Stay on top */
        top: 0;
        /* Stay at the top */
        left: 0;
        background-color: whitesmoke;
        /* Black*/
        overflow-x: hidden;
        /* Disable horizontal scroll */
        padding-top: 60px;
        /* Place content 60px from the top */
        transition: 0.5s;
        /* 0.5 second transition effect to slide in the sidenav */
    }

    .side-cart .closebtn {
        position: absolute;
        top: 0;
        right: 25px;
        font-size: 36px;
        margin-left: 50px;
    }
</style>
<div class="container-fluid">
    <h2 style="text-align: center;">Sản phẩm</h2>
    <div class="row">
        <?php foreach ($data['table'] as $sp) : ?>
            <div class="col-lg-3 col-md-4 col-sm-6 col-xm-12 text-center" style="padding-bottom: 10px; text-align:center;">
                <div>
                    <a class='link-product' href="/shop/product/detail/<?= $sp['id'] ?>/<?= $sp['url'] ?>">
                        <img style="width:100%; height: 250px; border-radius:10px" src="/shop/public/images/sanpham/<?= $sp['img'] ?>" alt="" srcset="">
                    </a>
                </div>
                <div style="text-align: center;">
                    <span class="tenSP" data-id="<?= $sp['id'] ?>" style="font-size:xx-large"><?= $sp['tenSP'] ?></span> &nbsp;<br>
                    <span class="donGia" data-id="<?= $sp['id'] ?>" style="font-size:large"><?= number_format($sp['donGia']) ?>/kg</span><br>
                    <input type="hidden" data-id="<?= $sp['id'] ?>" class='hidden-price' value="<?= $sp['donGia'] ?>">
                    <form action="" class='form-group' method="post">
                        <div class="input-group">
                            <span class='input-group-text'>Số lượng:</span>
                            <input type="number" name="soluong" data-id='<?= $sp['id'] ?>' class="soluong form-control" value='1' min='1' step="any" oninvalid="this.setCustomValidity('Hãy nhập số lượng cần mua hợp lệ')">
                            <button class='dathang btn btn-outline-success' data-id='<?= $sp['id'] ?>'>Đặt mua</button>
                        </div>
                    </form>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
    <a href="#" class="goto-cart" id='goto-cart' onclick="openCart();">
    <i class="fas fa-cart-arrow-down"></i>
        <span id='badge' class='badge'></span>
    </a>
</div>
<div class="side-cart" id='side-cart'>
    <a href="javascript:void(0)" class="closebtn" onclick="closeCart()">&times;</a>
    <div class="container">
        <h4 style="text-align:center">Giỏ hàng</h4>
        <table class='table' id='cart-table'>
            <tr>
                <th>Sản phẩm</th>
                <th>Đơn giá</th>
                <th>Số lượng</th>
                <th>Thành tiền</th>
                <th></th>
            </tr>
            <?php
            if (isset($_SESSION['cart'])) {
                foreach ($_SESSION['cart'] as $sp) { ?>
                    <tr class='cart-body' data-id="<?= $sp['id'] ?>">
                        <td class='checkname'><?= $sp['name'] ?></td>
                        <td class='price' data-id="<?= $sp['id'] ?>"><?= number_format($sp['price']) ?></td>
                        <td> <input data-id="<?= $sp['id'] ?>" style="width:50px" type="number" name="" class='qtt1' value="<?= $sp['quantity'] ?>"></td>
                        <td class='sub' data-id="<?= $sp['id'] ?>"><?= number_format($sp['subtotal']) ?></td>
                        <td>
                            <button class='remove btn btn-warning' data-id="<?= $sp['id'] ?>">
                                <i class="far fa-trash-alt"></i>
                            </button>
                        </td>
                    </tr>
            <?php  }
            }
            ?>

        </table>
        <table class='table'>
            <tr>
                <td colspan="3">Tổng cộng</td>
                <td id='total1'><?= isset($_SESSION['total']) ? number_format($_SESSION['total']) : '' ?></td>
                <td></td>
            </tr>
        </table>
        <div class="row">
            <div class="col" style="text-align: center;">
                <a href="./cart" class="btn btn-success">Thanh toán</a>
            </div>
        </div>
    </div>
</div>
<br>
<script>
    function openCart() {
        document.querySelector('#side-cart').style.width = '370px';
    }

    function closeCart() {
        document.querySelector('#side-cart').style.width = '0px';
    }

    
</script>