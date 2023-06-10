<?php include_once "./api/db.php"?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>南港展覽館接駁專車-路網圖</title>
    <link rel="stylesheet" href="./bootstrap/bootstrap.css">
    <style>
        .block{
            width: 300px;
            height: 200px;
            display: flex;
            flex-direction:column;
            justify-content: center;
            align-items: center;
            position: relative;
        }
        .block-top,.block-bottom{
            height: calc((100%-25px)/2);
            display: flex;
            text-align: center;
            padding:5px 0;
        }
        .block-top{
            align-items: flex-end;
        }
        .point{
            width: 25px;
            height: 25px;
            border-radius: 50%;
            background-color:skyblue;
            display: flex;
            justify-content: center;
            align-items: center;
            position: relative;
            z-index: 10;
        }
        .point::before{
            content:"";
            width: 20px;
            height: 20px;
            border: 3px solid while;
            border: radius 50%;
        }
        .right::after{
            content:"";
            width: 50%;
            height: 8px;
            background-color: skyblue;
            position: absolute;
            right: 0;
        }
        .left::after{
            content:"";
            width: 50%;
            height: 8px;
            background-color: skyblue;
            position: absolute;
            left: 0;
        }
        .line::after{
            content:"";
            width:  100%;
            height: 8px;
            background-color: skyblue;
            position: absolute;
            left: 0;
        }
        .connrct{
            width: 8px;
            height: 200px;
            background:skyblue;
            top: 50%;
        }
        .connect-right{
            position: absolute;
            right: 0;
        }
        .connect-left{
            position: absolute;
            left: 0;
        }
        .block .bus-info{
            display: none;
            position: absolute;
            top: 1px;
            padding: 8px;
            background:white;
            box-shadow:2px 2px 10px #999;
            z-index: 100;
            border-radius:5px;
        }
        .arrive{
            color: red;
        }
        .nobus{
            color:#666;
        }
    </style>
</head>
<body>
    <?php include "hrader.php"; ?>
    <div class="d-flex flex-wrap m-auto shadow p-5" style="width: 996px;">
    <?php
    ?>
    
    </div>
</body>
<script src="./jquery/jquery.js"></script>
<script src="./bootstrap/bootstrap.js"></script>
<script>
    $("point").hover(
        function(){
            $(this).next().show();
        },
        function(){
            $(".block .bus-info").hide();
        }
    )
</script>
</html>