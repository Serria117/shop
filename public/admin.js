if (window.history.replaceState) {
    window.history.replaceState(null, null, location.href);
};
$(document).ready(function () {

    setStatusColor();

    function setStatusColor(){
        var button = document.querySelectorAll('.xuly');
        $.each(button, function(){
            var value = $(this).attr('data-value');
            switch(value){
                case '0':
                    $(this).toggleClass('btn-warning');
                    break;
                case '1':
                    $(this).toggleClass('btn-primary');
                    break;
                case '2':
                    $(this).toggleClass('btn-success');
                    break;
                case '-1':
                    $(this).toggleClass('btn-outline-danger');
                    break;
            }
        })
        
    }

    $('.xuly').on("click", function () {
        var id = $(this).attr("data-id");
        $.post(
            "/shop/ajax/hienthidon", {
                id: id
            },
            function (json) {
                console.log(json);
                var table = $('#chitietdon');
                table.html('');
                var data = JSON.parse(json);
                var row = "";
                var total = 0;
                //Điền thông tin khách hàng:
                $('#ct-id').html(data[0].id);
                $('input[name="id"]').val(data[0].id);
                $('#ct-tenKH').html(data[0].tenKH);
                $('#ct-diaChi').html(data[0].diaChi);
                $('#ct-date').html(data[0].created_on);
                $('#ct-dienThoai').html(data[0].dienThoai);
                
                // $('#ct-trangthai').html(function () {
                //     var status;
                //     switch (data[0].status) {
                //         case '0':
                //             status = 'Chưa xử lý';
                //             break;
                //         case '1':
                //             status = 'Đang xử lý';
                //             break;
                //         case '2':
                //             status = 'Đã giao hàng';
                //             break;
                //         case '-1':
                //             status = 'Hủy đơn';
                //             break;
                //     }
                //     return status;
                // });
                $('#ct-trangthai').html(data[0].updated_on);
                $('.radio-trangthai[value='+data[0].status+']').prop('checked', true);
                
                //Tạo bảng chi tiết đơn hàng:
                $.each(data, function (i, value) {
                    row += '<tr><td>'+(i+1)+'</td>';
                    row += '<td>' + value.tenSP + '</td>';
                    row += '<td>' + parseFloat(value.soluong).toLocaleString() + '</td>';
                    row += '<td>' + parseFloat(value.giaban).toLocaleString() + '</td>';
                    row += '<td>' + (parseFloat(value.soluong) * parseFloat(value.giaban)).toLocaleString() + '</td>'
                    total += (parseFloat(value.soluong) * parseFloat(value.giaban));
                    
                })

                table.append(row);
                $('#total').html(total.toLocaleString());
            }
        );

    });
});