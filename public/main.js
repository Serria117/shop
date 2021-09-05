if (window.history.replaceState) {
    window.history.replaceState(null, null, location.href);
};

$(document).ready(function () {
    //Thêm sản phẩm vào giỏ hàng: khi khách hàng chọn 'đặt mua', sản phẩm và số lượng được thêm vào session
    $(".dathang").on("click", function (e) {
        e.preventDefault();
        var id = $(this).attr("data-id");
        var qtt = $('input[data-id=' + id + ']');
        var qttVal = qtt.val();
        $.ajax({
            type: "post",
            url: "./ajax/addcart",
            data: {
                id: id,
                qtt: qttVal
            }
        });
    })

    //Không cho nhập số lượng <=0
    $(".soluong").on("input", function () {
        if ($(this).val() <= 0 || $(this).val() == "") {
            $(this).val(1);
        }
    });

    //Cập nhật sản phẩm:
    $(".qtt1").on("input", function () {
        if ($(this).val() <= 0 || $(this).val() == "") {
            $(this).val(1);
        }

        var id = $(this).attr("data-id");
        var sub = $(".sub[data-id=" + id + "]");
        var price = $(".price[data-id=" + id + "]");
        var total = 0;
        var newSub = parseFloat($(this).val()) * parseInt(price.html().replace(/,/g, ""));
        sub.html(newSub.toLocaleString());
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
    })

    //Xóa sản phẩm khỏi giỏ hàng:
    $(".remove").on("click", function () {
        var id = $(this).attr('data-id');
        var item = $("tr[data-id=" + id + "]");
        var sub = parseFloat($(".sub[data-id=" + id + "]").html().replace(/,/g, ""));
        var total = parseFloat($("#total1").html().replace(/,/g, ""));
        total -= sub;
        $("#total1").html(total.toLocaleString());
        item.remove();
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
    
});