if (window.history.replaceState) {
    window.history.replaceState(null, null, location.href);
};

$(document).ready(function () {
    countBadge();
    //Thêm sản phẩm vào giỏ hàng: khi khách hàng chọn 'đặt mua', sản phẩm và số lượng được thêm vào session
    $(".dathang").on("click", function (e) {
        e.preventDefault();
        var id = $(this).attr("data-id");
        var name = $('.tenSP[data-id=' + id + ']');
        var price = $('.hidden-price[data-id=' + id + ']');
        var qtt = $('.soluong[data-id=' + id + ']');
        var qttVal = qtt.val();
        var row = '';

        //Kiểm tra sản phẩm đã có trong giỏ hàng chưa
        var checkname = document.querySelectorAll('.checkname');
        
        var error = 0;
        $.each(checkname, function () {
            if ($(this).html() == name.html()) {
                error += 1;
            }
        });
        if (error === 0) {
            //Sản phẩm chưa có trong giỏ hàng: thêm vào giỏ
            row += "<tr class='cart-body' data-id=\""+id+"\"><td class='checkname'>" + name.html() + "</td>";
            row += "<td class=\'price\' data-id=\""+id+"\">" + (price.val()) + "</td>";
            row += "<td><input class=\'qtt1\' data-id=\""+id+"\" type=\'number\' style=\'width:50px\' value=" + qttVal + "></td>";
            row += "<td class=\'sub\' data-id=\""+id+"\">" + price.val() * qttVal + "</td>"
            row += "<td><button class='btn remove btn-warning' data-id=\""+id+"\"><i class='far fa-trash-alt'></i></button></td>"
            $("#cart-table").append(row);

            //Request to server:
            $.ajax({
                type: "post",
                url: "./ajax/addcart",
                data: {
                    id: id,
                    qtt: qttVal
                },
                success: function (data) {
                    var total = data.toLocaleString();
                    $('#total1').html(total);
                }
            });
            countBadge();

        } else {
            alert("Sản phẩm đã có trong giỏ hàng!");
        }

    })

    //Không cho nhập số lượng <=0
    $(".soluong").on("blur", function () {
        if ($(this).val() <= 0 || $(this).val() == "") {
            alert("Số lượng hàng phải lớn hơn 0!")
            $(this).val(1);
        }
    });

    //Cập nhật sản phẩm:
    $("body").on("input", ".qtt1", function () {
        if ($(this).val() <= 0 || $(this).val() == "") {
            $(this).val(1);
        }
        
        var id = $(this).attr("data-id");
        var sub = $(".sub[data-id=" + id + "]");
        var price = $(".price[data-id=" + id + "]");
        var total = 0;
        var newSub = parseFloat($(this).val()) * parseInt(price.html().replace(/,/g, ""));
        
        sub.html(newSub.toLocaleString());
        console.log(sub.html());
        $(".sub").each(function () {
            total += parseInt($(this).html().replace(/,/g, ""));
        })
        $("#total1").html(total.toLocaleString());

        $.post(
            "./ajax/updatecart", {
                updateID: id,
                updateQtt: $(this).val(),
                updateSub: newSub,
                updateTotal: total
            },
        );
        countBadge();
    })

    //Xóa sản phẩm khỏi giỏ hàng:
    $("body").on("click",".remove" , function () {
        var id = $(this).attr('data-id');
        var item = $("tr[data-id=" + id + "]");
        var sub = parseFloat($(".sub[data-id=" + id + "]").html().replace(/,/g, ""));
        var total = parseFloat($("#total1").html().replace(/,/g, ""));
        total -= sub;
        $("#total1").html(total.toLocaleString());
        item.remove();
        countBadge();
        $.post("./ajax/updatecart", {
            removeID: id
        });
        
    });

    $("#checkout").on("click", function (e) {
        if (parseFloat($("#total1").html()) <= 0) {
            e.preventDefault();
            alert("Bạn vui lòng chọn sản phẩm để đặt hàng.");
        };
    });

    $('#dienThoai').keyup(function () {
        $.post(
            "./ajax/checkuser", {
                phone: $(this).val(),
            },
            function (json) {
                if (json != '') {
                    var user = JSON.parse(json);
                    $("#helpPhone").html('Hello ' + user.tenKH + "! Chào mừng bạn quay trở lại với cửa hàng!");
                    $("#tenKH").val(user.tenKH);
                    $("#diaChi").val(user.diaChi);
                } else {
                    $("#helpPhone").html("");
                    $("#tenKH").val("");
                    $("#diaChi").val("");
                }
            }
        );
    })

    function countBadge(){
        var item = document.querySelectorAll(".cart-body");
        var count = item.length;
        if(count > 0){
            $('#badge').html(count);
        } else if(count == 0) {
            $('#badge').html("");
        }
        
    }

});