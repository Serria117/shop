<div class="container-fluid">
    <div class="row">
        <button class="btn btn-danger">Thêm sản phẩm</button>
        <button class="btn btn-primary">Nhập hàng</button>
    </div>
    <table class="table table-striped">
            <tr>
                <th>STT</th>
                <th>Sản phẩm</th>
                <th>Giá bán</th>
                <th>Chỉnh sửa</th>
            </tr>
            </thead>
            <tbody>
            <?php 
            $stt = 1; foreach($data['table'] as $sp):
            ?>
                <tr>
                    <td scope="row"><?=$stt?></td>
                    <td><?=$sp['tenSP']?></td>
                    <td><?=$sp['donGia']?></td>
                    <td></td>
                </tr>
            <?php
            $stt++; endforeach;
            ?>
            </tbody>
    </table>
    
</div>