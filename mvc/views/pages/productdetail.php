<div class="container">
    <div class="row">
        <div class="col-md-6 col-sm-12" style="padding: 20px;">
            <img style="width: 95%; border-radius:15px;" src="/shop/public/images/sanpham/<?= $data['sanpham']->img ?>" alt="" srcset="">
        </div>
        <div class="col-md-6 col-sm-12">
            <h2><?= $data['sanpham']->tenSP ?></h2>
            <h3><span>Giá: </span><?= number_format($data['sanpham']->donGia) ?>/kg</h3>
            <p style="text-align: justify;"><?= $data['sanpham']->motaSP ?></p>
            <form action="" class='form-group' method="post">
                <div class="input-group">
                    <span class='input-group-text'>Số lượng:</span>
                    <input style="max-width:20%" type="number" name="soluong" class="soluong form-control" value='1' min='1'>
                    <button class='dathang btn btn-outline-success' data-id='<?=$data['id']?>'>Đặt mua</button>
                </div><br>
            </form>
        </div>
    </div>
</div>