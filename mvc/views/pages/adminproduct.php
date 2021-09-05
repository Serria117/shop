
<div class="container-fluid">
    <button class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#add-sp">Thêm sản phẩm</button>
    <button class="btn btn-primary">Nhập hàng</button>

    <table style="table-layout: fixed;" class="table table-hover">
        <tr>
            <th style="width:5%">STT</th>
            <th>Sản phẩm</th>
            <th>Giá bán</th>
            <th>Tồn kho</th>
            <th>Đã bán</th>
            <th>Quản lý</th>
        </tr>
        </thead>
        <tbody>
            <?php
            $stt = 1;
            foreach ($data['table'] as $sp) :
            ?>
                <tr data-bs-toggle="modal" data-bs-target="#edit-sp" data-id="<?= $sp['id'] ?>">
                    <td scope="row"><?= $stt ?></td>
                    <td>
                        <img style="width:100px" src="/shop/public/images/sanpham/<?=$sp['img']?>" alt="">
                        <?= $sp['tenSP'] ?>
                    </td>
                    <td><?= $sp['donGia'] ?></td>
                    <td></td>
                    <td></td>
                    <td><button class='btn btn-success' data-bs-toggle="modal" data-bs-target="#edit-sp"><i class="far fa-edit"></i></button></td>
                </tr>
            <?php
                $stt++;
            endforeach;
            ?>
        </tbody>
    </table>

    <!-- Modal -->
    <div class="modal fade" id="add-sp" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <form action="" method="post" enctype="multipart/form-data">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Thêm sản phẩm</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="name" class="form-label">Tên sản phẩm</label>
                            <input type="text" class="form-control" name="name" id="name" aria-describedby="nameHelp" placeholder="" required>
                            <small id="nameHelp" class="form-text text-muted"></small>
                        </div>
                        <div class="mb-3">
                            <label for="loai" class="form-label">Loại sản phẩm</label>
                            <select class="form-control" name="loai" id="loai">
                                <option value="0">Chọn:</option>
                                <?php foreach ($data['loaisp'] as $loai) : ?>
                                    <option value="<?= $loai['id'] ?>"><?= $loai['tenLoai'] ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="mota" class="form-label">Mô tả</label>
                            <textarea class="form-control" name="mota" id="mota" rows="3"></textarea>
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <div class="mb-3">
                                    <label for="donGia" class="form-label">Giá bán</label>
                                    <input type="text" class="form-control" name="donGia" id="donGia" aria-describedby="donGiaHelp" placeholder="" required>
                                    <small id="donGiaHelp" class="form-text text-muted"></small>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="mb-3">
                                    <label for="donVi" class="form-label">Đơn vị tính</label>
                                    <input type="text" class="form-control" name="donVi" id="donVi" aria-describedby="helpDonVi" placeholder="" required>
                                    <small id="helpDonVi" class="form-text text-muted"></small>
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <div class="mb-3">
                                <label for="" class="form-label">Ảnh đại diện</label>
                                <input type="file" class="form-control" name="img" id="img" placeholder="" aria-describedby="imgHelp" required>
                                <small id="imgHelp" class="form-text text-muted">*Chấp nhận ảnh jpg, png hoặc gif dung lượng không quá 5MB.</small>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                        <button type="submit" name="add" class="btn btn-primary">Thêm</button>
                    </div>
            </form>
        </div>
    </div>
</div>


<!-- Modal -->
<div class="modal fade" id="edit-sp" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Modal title</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Body
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Save</button>
            </div>
        </div>
    </div>
</div>


</div>