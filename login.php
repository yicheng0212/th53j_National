<?php include_once "./api/db.php"; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>南港展覽館接駁專車-管理員登入</title>
    <link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="./bootstrap/bootstrap.css">
</head>

<body class="bg-warning">
    <?php include "header.php"; ?>
    <div class="container">
        <h1 class="text-center mt-5">網站管理-登入</h1>
        <form action="./api/login.php" method="post">
            <?php
            if (isset($_GET['error'])) {
                switch ($_GET['error']) {
                    case 1:
                        echo "<div class='text-danger text-center my-3'>帳號或密碼錯誤</div>";
                        break;
                    case 2:
                        echo "<div class='text-danger text-center my-3'>驗證碼錯誤</div>";
                        break;
                }
            }


            ?>
            <div class="row w-100">
                <label for="" class="col-2">帳號(acc)</label>
                <input type="text" name="acc" id="acc" class='form-group form-control col-10'>
            </div>
            <div class="row w-100">
                <label for="" class="col-2">密碼(pw)</label>
                <input type="password" name="pw" id="pw" class='form-group form-control col-10'>
            </div>
            <div class="row w-100 align-items-center">
                <label for="" class="col-2">驗證碼(veri)</label>
                <input type="text" name="code" id="code" class='form-group form-control col-5'>
                <div class="btn btn-primary btn-lg m-2" id="btnCode">
                    <?php
                    echo $_SESSION['code'] = rand(1000, 9999);
                    ?>
                </div>
                <div class="btn btn-dark m-2" id="resetCode">重新產生驗證碼(resetCode)</div>
            </div>

            <div class="row w-100">
                <input type="submit" value="登入(login)&#x1F513;" class='col-12 btn btn-success '>
            </div>
            <br>
            <div class="row w-100">
                <a href="./index.php" class="col-12 btn btn-light">返回(back)</a>
            </div>

        </form>
    </div>


    <script src="./jquery/jquery.js"></script>
    <script src="./bootstrap/bootstrap.js"></script>
    <script>
        $("#resetCode").on('click', function() {
            $.get("./api/reset_code.php", function(code) {
                $("#btnCode").text(code);
            })
        })
    </script>
</body>

</html>