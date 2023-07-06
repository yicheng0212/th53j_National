<?php include_once "./api/db.php"; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="./icon/53icon.png" type="image/x-icon">
    <link rel="stylesheet" href="./bootstrap/bootstrap.css">
    <title>南港展覽館接駁專車-管理員登入</title>
</head>

<body class="bg-warning">
    <?php include "header.php"; ?>
    <div class="container">
        <h1 class="text-center mt-5">網站管理-登入</h1>
        <form action="./api/login.php" method="post">
            <?php
            if (isset($_GET['error'])) {
                echo "<div class='text-danger text-center my-3'>" . ($_GET['error'] == 1 ? '帳號或密碼錯誤' : '驗證碼錯誤') . "</div>";
            }
            ?>
            <div class="row w-100">
                <label for="acc" class="col-2">帳號</label>
                <input type="text" name="acc" id="acc" class="form-control col-10">
            </div>
            <br>
            <div class="row w-100">
                <label for="pw" class="col-2">密碼</label>
                <input type="password" name="pw" id="pw" class="form-control col-10">
            </div>
            <div class="row w-100 align-items-center">
                <label for="code" class="col-2">驗證碼</label>
                <input type="text" name="code" id="code" class="form-control col-5">
                <div class="btn btn-primary btn-lg m-2" id="btnCode"><?= $_SESSION['code'] = rand(1000, 9999); ?></div>
                <div class="btn btn-dark m-2" id="resetCode">重新產生驗證碼</div>
            </div>
            <div class="row w-100">
                <input type="submit" value="登入" class="col-12 btn btn-success">
            </div>
            <br>
            <div class="row w-100">
                <a href="./index.php" class="col-12 btn btn-light">返回</a>
            </div>

        </form>
    </div>

    <script src="./jquery/jquery.js"></script>
    <script src="./bootstrap/bootstrap.js"></script>
    <script>
        $("#resetCode").click(() => {
            $.get("./api/reset_code.php", (code) => {
                $("#btnCode").text(code);
            })
        })
    </script>
</body>

</html>