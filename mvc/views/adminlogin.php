<!doctype html>
<html lang="en">

<head>
    <title><?= isset($data['title']) ? $data['title'] : '' ?></title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS v5.0.2 -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <style>
        .container {
            width: 50%;
            margin-top: 10%;
            border: 1px solid #dbdbdb;
            background-color: #dbdbdb;
            border-radius: 15px;
            padding: 10px;
            filter: drop-shadow(20px 20px 30px);
        }

        .warper {
            margin: 0 auto;
            max-width: 90%;
        }

        h2 {
            text-align: center;
            color: #d100b5;
        }

        .submit {
            text-align: center;
        }
        .login-alert{
            text-align: center;
            color: red;
            font-style: italic;
        }
    </style>
    <script>
        if (window.history.replaceState) {
            window.history.replaceState(null, null, location.href);
        };
    </script>

</head>

<body>
    <div class="container">
        <div class="warper">
            <h2>Trang quản trị</h2>
            <form action="/shop/admin/login" method="post">
                <div class="mb-3">
                    <label for="" class="form-label">Tên đăng nhập:</label>
                    <input type="text" class="form-control" name="name" id="" aria-describedby="helpId" placeholder="" required>
                    <small id="helpName" class="form-text text-muted"></small>
                </div>
                <div class="mb-3">
                    <label for="" class="form-label">Mật khẩu:</label>
                    <input type="text" class="form-control" name="password" id="" aria-describedby="helpId" placeholder="" required>
                    <small id="helpPass" class="form-text text-muted"></small>
                </div>
                <div class="mb-3 submit">
                    <button type="submit" name='login' id='login' class="btn btn-primary">Đăng nhập</button>
                </div>
            </form>
            <hr>
            <div class='login-alert'>
                <?= isset($data['error']) ? $data['error'] : '' ?>
            </div>
        </div>

    </div>
    <!-- Bootstrap JavaScript Libraries -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
</body>

</html>