<div class="container-fluid">
    <button class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#add-sp">Thêm sản phẩm</button>
    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#nhapHang">Nhập hàng</button>

    <table style="table-layout: fixed;" class="table table-hover">
        <tr>
            <th style="width:5%">STT</th>
            <th>Sản phẩm</th>
            <th>Giá bán</th>
            <th>Đã bán</th>
            <th>Tồn kho</th>
            <th>Ngày tạo</th>
            <th>Ngày cập nhật</th>
        </tr>
        </thead>
        <tbody>
            <?php
            $stt = 1;
            foreach ($data['table'] as $sp) :
            ?>
                <tr class='chitietsp' data-bs-toggle="modal" data-bs-target="#edit-sp" data-id="<?= $sp['id'] ?>">
                    <td scope="row"><?= $stt ?></td>
                    <td>
                        <img style="width:100px" src="/shop/public/images/sanpham/<?= $sp['img'] ?>" alt="">
                        <p><?= $sp['tenSP'] ?></p>
                    </td>
                    <td><?= number_format($sp['donGia']) ?></td>
                    <td><?= $sp['daBan'] ?></td>
                    <td><?= $sp['tonKho'] ?></td>
                    <td><?= $sp['created_on']  ?></td>
                    <td><?= $sp['updated_on']  ?></td>
                </tr>
            <?php
                $stt++;
            endforeach;
            ?>
        </tbody>
    </table>

    <!-- Thêm sản phẩm -->
    <div class="modal fade" id="add-sp" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <form action="/shop/admin/themsp" method="post" enctype="multipart/form-data">
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

                            <label for="" class="form-label">Ảnh đại diện</label>
                            <input type="file" class="form-control" name="img" id="img" placeholder="" aria-describedby="imgHelp" required accept=".jpg, .png, .gif">
                            <small id="imgHelp" class="form-text text-muted">*Chấp nhận ảnh jpg, png hoặc gif dung lượng không quá 5MB.</small>

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


<!-- Quản lý sản phẩm -->
<div class="modal fade" id="edit-sp" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <form action="/shop/admin/admin_updatesp" method="post" enctype="multipart/form-data">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Quản lý sản phẩm</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id='update-id' name="update-id" value=''>
                    <div class="row">
                        <div class="col-4">
                            <div class="mb-3">
                                <label for="update-name" class="form-label">Tên sản phẩm:</label>
                                <input type="text" class="form-control" name="update-name" id="update-name" aria-describedby="help-update-name " placeholder="" required>
                                <small id="help-update-name" class="form-text text-muted"></small>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="mb-3">
                                <label for="update-loai" class="form-label">Loại sản phẩm:</label>
                                <select class="form-control" name="update-loai" id="update-loai">
                                    <option value="0">Chọn:</option>
                                    <?php foreach ($data['loaisp'] as $loai) : ?>
                                        <option value="<?= $loai['id'] ?>"><?= $loai['tenLoai'] ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="mb-3">
                                <label for="update-status" class="form-label">Trạng thái</label>
                                <select class="form-control" name="update-status" id="update-status">
                                    <option></option>
                                    <option></option>
                                    <option></option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <div class="mb-3">
                                <label for="update-giaban" class="form-label">Giá bán:</label>
                                <input type="number" class="form-control" name="update-giaban" id="update-giaban" aria-describedby="help-update-giaban" placeholder="" min='500' step="any" required>
                                <small id="help-update-giaban" class="form-text text-muted"></small>
                            </div>
                        </div>
                        <div class="col-6">
                            <label for="" class="form-label">Ảnh đại diện:</label>
                            <input type="file" class="form-control" name="update-img" id="update-img" placeholder="" aria-describedby="imgHelp" accept=".jpg, .png, .gif">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <div class="mb-3">
                                <label for="update-mota" class="form-label">Cập nhật mô tả:</label>
                                <textarea class="form-control" name="update-mota" id="update-mota" rows="2" required></textarea>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" name='update' class="btn btn-primary">Save</button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Nhập hàng -->
<div class="modal fade" id="nhapHang" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Nhập hàng</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Sản phẩm</th>
                            <th>Số lượng nhập</th>
                            <th>Giá nhập</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($data['table'] as $sp) : ?>
                            <tr>
                                <td scope="row"><?= $sp['tenSP'] ?></td>
                                <td>
                                    <input style="width:100px" type="number" min='0' value='0' step='any' class="form-control" name="" id="">
                                </td>
                                <td><input style="width:100px" type="number" step='500' class="form-control" name="" id="" aria-describedby="helpId" placeholder=""></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Save</button>
            </div>
        </div>
    </div>
</div>