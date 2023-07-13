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
    <title>南港展覽館接駁專車-路網圖</title>
</head>

<body class="bg-warning">
    <?php include "header.php"; ?>
    <div class="d-flex flex-wrap my-4 mx-auto p-5 mt-5 shadow bg-light" style="width: min-content;">
        <?php
        $stations = $pdo->query("SELECT * FROM `station`")->fetchAll(PDO::FETCH_ASSOC);
        $timer = [];
        $arrive = 0;
        $leave = 0;
        foreach ($stations as $station) {
            $timer[$station['name']] = [
                'arrive' => $leave += $station['minute'],
                'leave' => $leave += $station['waiting']
            ];
        }
        $tmp = array_chunk($stations, 3);
        foreach ($tmp as $k => $t) {
            $tmp[$k] = ($k % 2 === 1) ? array_reverse($t) : $t;
        }           
        $buses = $pdo->query("SELECT * FROM `bus`")->fetchAll(PDO::FETCH_ASSOC);
        foreach ($tmp as $key => $t) {
            $justifyClass = ($key % 2 === 1) ? 'justify-content-end' : '';
            echo "<div class='d-flex w-100 position-relative $justifyClass'>";

            if ($key < ceil(count($stations) / 3) - 1) {
                $connectClass = ($key % 2 === 1) ? 'connect-left' : 'connect-right';
                echo "<div class='connect $connectClass'></div>";
            }
            foreach ($t as $k => $station) {
                $blockClass = 'block line';
                if ($key === 0 && $k === 0) {
                    $blockClass = 'block right';
                } elseif ($key === ceil(count($t) / 3) - 1) {
                    if ($key % 2 === 0 && $k === count($t) - 1) {
                        $blockClass = 'block left';
                    } elseif ($key % 2 !== 0 && $k === 0) {
                        $blockClass = 'block right';
                    }
                }
                echo "<div class='$blockClass'>";
                foreach ($buses as $bus) {
                    $arrive = $bus['minute'] - $timer[$station['name']]['arrive'];
                    $leave = $bus['minute'] - $timer[$station['name']]['leave'];
                    $status = ($arrive >= 0 && $leave <= 0) ? '已到站' : ($leave > 0 ? '已過站' : '約' . abs($arrive) . '分鐘');
                    $busInfo[$bus['name']] = ['arrive' => $arrive, 'leave' => $leave, 'status' => $status];
                }                
                $min = ['min' => -999999, 'bus' => ''];
                $flag = 0;
                foreach ($busInfo as $bus => $info) {
                    if ($info['status'] === '已到站' && $flag !== 1) {
                        echo "<div class='block-top arrive'>$bus<br>已到站</div>";
                        $flag = 1;
                    } elseif ($info['status'] !== '已過站' && $info['arrive'] > $min['min']) {
                        $min = ['min' => $info['arrive'], 'bus' => $bus];
                    }
                }                
                if ($flag === 0) {
                    $message = ($min['bus'] !== '') ? "<div class='block-top'>$min[bus]<br>約" . abs($min['min']) . "分鐘</div>" : "<div class='block-top'>未發車</div>";
                    echo $message;
                }
                $infoTmp = [];
                foreach ($busInfo as $bus => $info) {
                    if ($info['status'] === '已到站') {
                        $infoTmp['已到站'][$bus] = $info;
                    } elseif ($info['status'] === '已過站') {
                        $infoTmp['已過站'][$bus] = $info;
                    } else {
                        $infoTmp['未到站'][$bus] = $info;
                    }
                }
                $busList = [];
                $maxBus = min(3, count($buses));
                $statusOrder = ['已到站', '未到站', '已過站'];
                foreach ($statusOrder as $status) {
                    while (count($busList) < $maxBus && !empty($infoTmp[$status])) {
                        $busList[key($infoTmp[$status])] = array_shift($infoTmp[$status]);
                    }
                }
                echo "<div class='point'><img src='./icon/point.svg' alt='point' height='40px'></div>";
                echo "<div class='bus-info'>";
                foreach ($busList as $name => $info) {
                    $statusClass = ($info['status'] === '已到站') ? 'arrive' : '';
                    echo "<div class='$statusClass'>";
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
    <script scr="js.js"></script>
</body>

</html>
<script>
    $(".point").hover(function() {
        $(this).next().toggle();
    });
</script>