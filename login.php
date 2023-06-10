<?php include_once "./api/db.php";?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>南港展覽館接駁專車-管理員登入</title>
    <link rel="stylesheet" href="./bootstrap/bootstrap.css">
</head>
<body>
<?php include "header.php";?>
<div class="container">
    <h1 class="text-center">網站管理-登入</h1>
    <form action="./api/login.php" method="post">
    <?php 
        //根據網址的error參數，顯示不同的錯誤內容
        if(isset($_GET['error']) ){
            switch($_GET['error']){
                case 1:
                    echo "<div class='text-danger text-center my-3'>帳號或密碼錯誤</div>";
                break;
                case 2:
                        echo "<div class='text-danger text-center my-3'>驗證碼錯誤，請重新輸入</div>";
                break;
            }
        }


    ?>
    <div class="row w-100">
        <label for="" class="col-2">帳號</label>   
        <input  type="text" name="acc" id="acc" class='form-group form-control col-10'>
    </div>
    <div class="row w-100">
        <label for="" class="col-2">密碼</label>   
        <input  type="password" name="pw" id="pw" class='form-group form-control col-10'>
    </div>
    <div class="row w-100 align-items-center">
        <label for="" class="col-2">驗證碼</label>   
        <input  type="text" name="code" id="code" class='form-group form-control col-5'>
        <div class="btn btn-primary btn-lg m-2" id="btnCode">
            <?php
                //使用rand()來產生一個四位數驗證碼，並存入session中
                echo $_SESSION['code']=rand(1000,9999);
            ?>
        </div>
        <div class="btn btn-dark m-2" id="resetCode">重新產生驗證碼</div>
    </div>

    <div class="row w-100">
        <input  type="submit" value="登入" class='col-12 btn btn-success '>
    </div>

    </form>
</div>


<script src="./jquery/jquery.js"></script>
<script src="./bootstrap/bootstrap.js"></script>
</body>
</html>
<script>
//重設驗證碼時，使用ajax向後端請求新的驗證碼，並更新至btnCode按鈕中
$("#resetCode").on('click',function(){
    $.get("./api/reset_code.php",function(code){
        $("#btnCode").text(code);
    })
})
</script>