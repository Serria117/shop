<div class="container-fluid">
    <h2 style="text-align: center;">Sản phẩm</h2>
    <div class="row">
        <?php foreach ($data['table'] as $sp) : ?>
            <div class="col-lg-3 col-md-4 col-sm-6 col-xm-12 text-center" style="padding-bottom: 10px; text-align:center;">
                <div>
                    <a class='link-product' href="/shop/product/detail/<?=$sp['id']?>/<?=$sp['url']?>">
                    <img style="width:100%; height: 250px; border:1px solid gray; border-radius:15px" src="/shop/public/images/sanpham/<?= $sp['img'] ?>" alt="" srcset="">
                    </a>
                </div>
                <div style="text-align: center;">
                    <span style="font-size:xx-large"><?= $sp['tenSP'] ?></span> &nbsp;<br>
                    <span style="font-size:large"><?= number_format($sp['donGia']) ?>/kg</span><br>
                    <form action="" class='form-group' method="post">
                        <div class="input-group" >
                            <span class='input-group-text'>Số lượng:</span>
                            <input type="number" name="soluong" data-id='<?=$sp['id']?>' class="soluong form-control" value='1' min='1' step="any">
                            <button class='dathang btn btn-outline-success' data-id='<?=$sp['id']?>'>Đặt mua</button>
                        </div>
                    </form>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>
<div id="test">

</div>
<br>
<?php 
print_r($_SESSION['cart']);
echo "<br>";
echo "Total = "; print_r($_SESSION['total']);
// unset($_SESSION['cart']);
?>