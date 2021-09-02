<div class="container-fluid" style="width:95%">
    <h3 style="text-align:center"></h3>
    <div class="row">
        <div class="col-md-7">
            <?php if (isset($data['mess'])) { ?>
                <h5><?= $data['mess'] ?></h5>
                <script>
                setTimeout(function(){
                    window.location.href = '../home';
                 }, 5000);
                </script>
            <?php } else { ?>
                <span>
                    <h4>Thông tin đơn hàng</h4>
                </span>
                <table class="table table-hover table-responsive">
                    <thead class="thead-default">
                        <tr class='cart-head'>
                            <th>Sản phẩm</th>
                            <th>Đơn giá</th>
                            <th>Số lượng</th>
                            <th>Thành tiền</th>
                            <th>Xóa</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if (isset($_SESSION['cart'])) {
                            foreach ($_SESSION['cart'] as $item) { ?>
                                <tr class='cart-body' data-id="<?= $item['id'] ?>">
                                    <td scope="row"><?= $item['name'] ?></td>
                                    <td class='price' data-id="<?= $item['id'] ?>">
                                        <?= number_format($item['price']) ?>
                                    </td>
                                    <td>
                                        <input type="number" name="qtt" style="max-width:50px;" class='qtt1' data-id="<?= $item['id'] ?>" min="1" value="<?= $item['quantity'] ?>">
                                    </td>
                                    <td class='sub' data-id="<?= $item['id'] ?>"><?= number_format($item['subtotal']) ?></td>
                                    <td>
                                        <button class='remove btn btn-warning' data-id="<?= $item['id'] ?>">
                                            <i class="far fa-trash-alt"></i>
                                        </button>
                                    </td>
                                </tr>

                        <?php    }
                        }     ?>
                    </tbody>
                    <tfoot class="cart-total">
                        <tr>
                            <td colspan="3"><b>Tổng cộng tiền hàng:</b></td>
                            <td><b id='total1'><?= isset($_SESSION['total']) ? number_format($_SESSION['total']) : 0 ?></b></td>
                            <td></td>
                        </tr>
                    </tfoot>
                </table>
            <?php } ?>
        </div>
        <div class="col-md-1"></div>
        <div class="col-md-4">
            <span>
                <h4>Thông tin giao hàng</h4>
            </span>
            <form action="/shop/cart/dathang" method="post">
                <div class="mb-3">
                    <label for="" class="form-label">Điện thoại:</label>
                    <input type="phone" class="form-control" name="dienThoai" id="dienThoai" aria-describedby="helpId" placeholder="" required oninvalid="this.setCustomValidity('Hãy nhập số điện thoại của bạn')" oninput="setCustomValidity('')">
                    <small id="helpPhone" class="form-text text-muted"></small>
                </div>
                <div class="mb-3">
                    <label for="" class="form-label">Họ tên:</label>
                    <input type="text" class="form-control" name="tenKH" id="tenKH" aria-describedby="helpId" placeholder="" required oninvalid="this.setCustomValidity('Hãy nhập tên của bạn')" oninput="setCustomValidity('')">
                    <small id="helpName" class="form-text text-muted"></small>
                </div>
                <div class="mb-3">
                    <label for="" class="form-label">Địa chỉ nhận hàng:</label>
                    <input type="text" class="form-control" name="diaChi" id="diaChi" aria-describedby="helpId" placeholder="" required oninvalid="this.setCustomValidity('Hãy nhập địa chỉ nhận hàng')" oninput="setCustomValidity('')">
                    <small id="helpAdd" class="form-text text-muted"></small>
                </div>
                <div class="mb-3">
                    <label for="" class="form-label">Yêu cầu chi tiết:</label>
                    <textarea class="form-control" name="yeuCau" id="" rows="3"></textarea>
                </div>
                <div class="checkbox mb-3" style="text-align: center;">
                    <div class="form-check form-check-inline">
                        <label class="form-check-label">
                            <input class="form-check-input" type="radio" name="thanhToan" id="" value="1" checked> Thanh toán khi nhận hàng
                        </label>
                    </div>
                    <div class="form-check form-check-inline">
                        <label class="form-check-label">
                            <input class="form-check-input" type="radio" name="thanhToan" id="" value="0"> Chuyển khoản
                        </label>
                    </div>
                </div>

                <div class="mb-3" style="text-align: center;">
                    <button id="checkout" style="width:40%" type="submit" name="checkout" class="btn btn-primary">Đặt hàng</button>
                </div>
            </form>
        </div>
    </div>
</div>
<?php
// unset($_SESSION['cart']); unset($_SESSION['total']);


?>