<?php include_once "./api/db.php"; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
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
            padding: 5px 0;
        }

        .block-top {
            align-items: flex-end;
        }

        .point {
            width: 25px;
            height: 25px;
            border-radius: 50%;
            background-color: skyblue;
            display: flex;
            justify-content: center;
            align-items: center;
            position: relative;
            z-index: 10;
        }

        .point::before {
            content: "";
            width: 20px;
            height: 20px;
            border: 3px solid white;
            border-radius: 50%;
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
            left: 0;
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
            z-index: 100;
            border-radius: 5px;
        }

        .arrive {
            color: red;
        }

        .nobus {
            color: #666;
        }
    </style>
    <title>南港展覽館接駁專車-路網圖</title>
</head>

<body class="bg-warning">
    <?php include "header.php"; ?>
    <div class="d-flex flex-wrap my-4 mx-auto mt-5 p-5 shadow bg-light" style="width:min-content">
        <?php
        $stations = $pdo->query("SELECT * FROM `station` ORDER BY `before`")->fetchAll(PDO::FETCH_ASSOC);
        $timer = [];
        $arrive = 0;
        $leave = 0;
        $div = 3;

        foreach ($stations as $station) {
            $arrive = $leave + $station['minute'];
            $leave = $arrive + $station['waiting'];
            $timer[$station['name']]['arrive'] = $arrive;
            $timer[$station['name']]['leave'] = $leave;
        }

        $tmp = array_chunk($stations, $div);

        foreach ($tmp as $k => $t) {
            if ($k % 2 == 1) {
                $tmp[$k] = array_reverse($t);
            }
        }
        $buses = $pdo->query("SELECT * FROM `bus`")->fetchAll(PDO::FETCH_ASSOC);

        foreach ($tmp as $key => $t) {
            echo "<div class='d-flex w-100 position-relative" . (($key % 2 == 1) ? " justify-content-end" : "") . "'>";
            if ($key < ceil(count($stations) / $div) - 1) {
                echo "<div class='connect connect-" . (($key % 2 == 1) ? "left" : "right") . "'></div>";
            }
            foreach ($t as $k => $station) {
                $class = "block line";
                if ($key == 0 && $k == 0) {
                    $class = "block right";
                } else if ($key == ceil(count($stations) / $div) - 1) {
                    if ($key % 2 == 0) {
                        $class = ($k == count($t) - 1) ? "block left" : "block line";
                    } else {
                        $class = ($k == 0) ? "block right" : "block line";
                    }
                }
                echo "<div class='$class'>";
                $busInfo = [];
                foreach ($buses as $bus) {
                    $busInfo[$bus['name']]['arrive'] = $bus['minute'] - $timer[$station['name']]['arrive'];
                    $busInfo[$bus['name']]['leave'] = $bus['minute'] - $timer[$station['name']]['leave'];
                }
                $min = ['min' => -999999, 'bus' => ''];
                $flag = 0;

                foreach ($busInfo as $bus => &$info) {
                    if ($info['arrive'] >= 0 && $info['leave'] <= 0) {
                        $info['status'] = '已到站';
                        if ($flag != 1) {
                            echo "<div class='block-top arrive'>{$bus}<br>已到站</div>";
                            $flag = 1;
                        }
                    } else if ($info['leave'] > 0) {
                        $info['status'] = '已過站';
                    } else {
                        $info['status'] = "約" . abs($info['arrive']) . "分鐘";
                        if ($info['arrive'] > $min['min']) {
                            $min = ['min' => $info['arrive'], 'bus' => $bus];
                        }
                    }
                }
                if ($flag == 0) {
                    if ($min['bus'] != "") {
                        echo "<div class='block-top'>{$min['bus']}<br>約" . abs($min['min']) . "分鐘</div>";
                    } else {
                        echo "<div class='block-top'>未發車</div>";
                    }
                }
                $infoTmp = [
                    '已到站' => [],
                    '已過站' => [],
                    '未到站' => [],
                ];

                foreach ($busInfo as $bus => $info) {
                    $infoTmp[$info['status']][$bus] = $info;
                }

                $busList = array_slice($infoTmp['已到站'], 0, 1) + array_slice($infoTmp['未到站'], 0, 1) + array_slice($infoTmp['已過站'], 0, 1);

                echo "<div class='point'></div>";
                echo "<div class='bus-info'>";

                foreach ($busList as $name => $info) {
                    $class = ($info['status'] == '已到站') ? " class='arrive'" : "";
                    echo "<div{$class}>";
                    echo $name . ": " . $info['status'];
                    echo "</div>";
                }

                echo "</div>";
                echo "<div class='block-bottom'>{$station['name']}</div>";
                echo "</div>";
            }
            echo "</div>";
        }
        ?>

    </div>
    <script src="./jquery/jquery.js"></script>
    <script src="./bootstrap/bootstrap.js"></script>
    <script>
        $(".point").hover(function() {
            $(this).next().show();
        }, function() {
            $(".block .bus-info").hide();
        });
    </script>
</body>

</html>