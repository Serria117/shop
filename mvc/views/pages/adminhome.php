<div>
    <div class="container">
        <form action="/shop/admin/timkiem" method="POST">
            <div class="input-group mb-3">
                <input name="search-order" style="max-width:30%;" type="text" class="form-control" placeholder="Tìm kiếm" aria-label="Tìm kiếm" aria-describedby="button-addon2">
                <div class="input-group-append">
                    <button class="btn btn-outline-secondary" name="submit" type="submit" id="button-addon2"><i class="fas fa-search"></i></button>
                </div>
            </div>
        </form>
    </div>
    <table class="table table-hover">
        <thead>
            <tr>
                <th>STT</th>
                <th>Khách hàng</th>
                <th>Số điện thoại</th>
                <th>Tổng tiền</th>
                <th>Trạng thái</th>
                <th>Ngày đặt hàng</th>
                <th>Ngày cập nhật</th>
            </tr>
        </thead>
        <tbody>
            <?php $stt = 1;
            foreach ($data['table'] as $item) :
                $createDate = date("d/m/Y", strtotime($item['created_on']));
                $updateDate = date("d/m/Y", strtotime($item['updated_on']));
            ?>
                <tr>
                    <td><?= $stt ?></td>
                    <td scope="row"><?= $item['tenKH'] ?></td>
                    <td><?= $item['dienThoai'] ?></td>
                    <td> <?= number_format($item['giaTri']) ?> </td>
                    <td>
                        <button style="width:110px" class="btn xuly btn-sm" data-id="<?= $item['dhID'] ?>" data-bs-toggle="modal" data-bs-target="#xuLyDon" data-value="<?= $item['status'] ?>">
                            <?php
                            switch ($item['status']) {
                                case 0:
                                    echo "Chưa xử lý";
                                    break;
                                case 1:
                                    echo "Đang xử lý";
                                    break;
                                case 2:
                                    echo "Thành công";
                                    break;
                                case -1:
                                    echo "Đã hủy";
                                    break;
                            }
                            ?>
                        </button>
                    </td>
                    <td><?= $createDate ?></td>
                    <td><?= $updateDate ?></td>
                </tr>
            <?php $stt++;
            endforeach; ?>
        </tbody>
    </table>

    <!-- Modal -->
    <div class="modal fade" id="xuLyDon" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Xử lý đơn số: <span id='ct-id'></span></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="thongtinDH">
                    <div class="container-fluid">
                        <table class="table" style="table-layout: fixed;">
                            <tbody>
                                <tr>
                                    <td scope="row" style="width:20%">Khách hàng:</td>
                                    <td id="ct-tenKH"></td>
                                    <td>Điện thoại: <span id='ct-dienThoai'></span></td>
                                </tr>
                                <tr>
                                    <td scope="row">Địa chỉ:</td>
                                    <td id='ct-diaChi' colspan="2"></td>
                                </tr>
                                <tr>
                                    <td scope="row">Ngày đặt hàng:</td>
                                    <td id='ct-date'></td>
                                    <td>Cập nhật: <span id="ct-trangthai"></span></td>
                                </tr>
                            </tbody>
                        </table>
                    </div><br>
                    <form action="/shop/admin/updateorder" method="post">
                        <div class="container">
                            <input type="hidden" name="id" value="">
                            <div class="btn-group" data-bs-toggle="buttons">
                                <label class="btn btn-warning"> Chưa xử lý
                                    <input type="radio" class="me-2 radio-trangthai" name="trangthai" id="" autocomplete="off" value='0'>
                                </label>
                                <label class="btn btn-primary"> Đang xử lý
                                    <input type="radio" class='radio-trangthai' name="trangthai" id="" autocomplete="off" value='1'>
                                </label>
                                <label class="btn btn-success"> Đã giao hàng
                                    <input type="radio" class='radio-trangthai' name="trangthai" id="" autocomplete="off" value="2">
                                </label>
                                <label class="btn btn-danger"> Hủy đơn
                                    <input type="radio" class='radio-trangthai' name="trangthai" id="" autocomplete="off" value="-1">
                                </label>
                            </div>
                        </div>
                        <div class="container-fluid">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>STT</th>
                                        <th>Sản phẩm</th>
                                        <th>Số lượng</th>
                                        <th>Đơn giá</th>
                                        <th>Thành tiền</th>
                                    </tr>
                                </thead>
                                <tbody id='chitietdon'>
                                    <!-- Chi tiết đơn hàng trả về bằng ajax -->
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th colspan="4" style="text-align: center;">Tổng cộng</th>
                                        <th id='total'></th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" name='save' class="btn btn-success">Save</button>
                </div>
                </form>
            </div>
        </div>
    </div>
</div>