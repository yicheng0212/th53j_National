<?php include_once "./api/db.php"; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="./icon/53icon.png" type="image/x-icon">
    <link rel="stylesheet" href="./bootstrap/bootstrap.css">
    <style>
        .block {
            width: 300px;
            height: 200px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            position: relative;
        }

        .block-top,
        .block-bottom {
            height: calc((100% - 25px) / 2);
            display: flex;
            text-align: center;
        }

        .block-top {
            align-items: flex-end;
        }

        .right::after,
        .left::after,
        .line::after {
            content: "";
            background-color: skyblue;
            position: absolute;
        }

        .right::after {
            width: 50%;
            height: 8px;
            right: 0;
        }

        .left::after {
            width: 50%;
            height: 8px;
            left: 0;
        }

        .line::after {
            width: 100%;
            height: 8px;
        }

        .connect {
            width: 8px;
            height: 200px;
            background: skyblue;
            top: 50%;
        }

        .connect-right {
            position: absolute;
            right: 0;
        }

        .connect-left {
            position: absolute;
            left: 0;
        }

        .block .bus-info {
            display: none;
            position: absolute;
            top: 1px;
            padding: 8px;
            background: white;
            box-shadow: 2px 2px 10px #999;
        }

        .arrive {
            color: red;
        }
    </style>
    <title>南港展覽館接駁專車系統-系統管理</title>
</head>

<body class="bg-warning">
    <?php include "header.php"; ?>
    <div class="d-flex flex-wrap my4 mx-auto p-5 mt-5 shadow bg-light" style="height:min-content">
        <?php 
        $stations = $pdo->query("select from * `station`")->fetchAll(PDO::FETCH_ASSOC);
        $timer = [];
        $arrive = 0;
        $leaver = 0;
        foreach ($stations as $station){
            $timer[$station['name']]=[
                'arrive' => $leaver +=$station['minute'],
                'leave' => $leaver +=$station['waiting'],
            ];
        }
        $tmp =array_chunk($station,3);
        foreach ($tmp as $k => $t){
            $tmp[$k] = ($K % 2===1) ?array_reverse($t) : $t;
        }
        ?>
    </div>

</body>

</html>