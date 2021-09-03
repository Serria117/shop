<div>
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
                $createDate = date("d/m/Y h:m-a", strtotime($item['created_on']));
                $updateDate = date("d/m/Y h:m-a", strtotime($item['updated_on']));
            ?>
                <tr>
                    <td><?= $stt ?></td>
                    <td scope="row"><?= $item['tenKH'] ?></td>
                    <td><?= $item['dienThoai'] ?></td>
                    <td> <?= number_format($item['giaTri']) ?> </td>
                    <td><button class="btn btn-primary"><?= $item['status'] ?></button></td>
                    <td><?= $createDate ?></td>
                    <td><?= $updateDate ?></td>
                </tr>
            <?php $stt++;
            endforeach; ?>
        </tbody>
    </table>

</div>