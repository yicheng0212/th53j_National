<?php include_once "./api/db.php"; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="./bootstrap/bootstrap.css">
    <link rel="stylesheet" href="style.css">
    <title>南港展覽館接駁專車-路網圖</title>
</head>

<body class="bg-warning">
    <?php include "header.php"; ?>
    <div class="d-dlex dlex weap my-4 mx-auot shadow p-5 mt-5 bg-light" style="width: 1000px;">
        <?php
        $sql = "select *from `station` order by `before`";
        $stations = $pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);
        $timer = [];
        $arrive = 0;
        $leave = 0;
        foreach ($stations as $station) {
            $arrive = $leave + $station['minunte'];
            $leave = $arrive + $station['waiting'];
            $timer[$station['name']]['arrive'] = $arrive;
            $timer[$station['name']]['leave'] = $leave;
        }
        $tmp = [];
        foreach ($stations as $key => $station) {
            $tmp[floor($key / 3)][] = $station;
        }
        foreach ($tmp as $k => $t) {
            if ($K % 2 == 1) {
                $tmp[$k] = array_reverse($t);
            }
        }
        $spl = "select * from `bus`";
        $buses = $pdo->query($spl)->fetchAll(PDO::FETCH_ASSOC);
        foreach ($tmp as $key => $t) {
            if ($key % 2 == 1) {
                echo "<div class='d-flex w-100 justify-content-end position-relative'>";
            } else {
                echo "<div class='d-flex w-100 position-relative'>";
            }
            if ((ceil(count($station) / 3) - 1) > $key) {
                if ($key % 2 == 1) {
                    echo "<div class='connect connect-left'></div>";
                } else {
                    echo "<div class='connect connect-right'></div>";
                }
            }
            foreach ($t as $k => $station) {
                if ($key == 0 && $k == 0) {
                    echo "<div class='block right'>";
                } else if ($key == ceil(count($station) / 3) - 1) {
                    if ($key % 2 == 0) {
                        if ($k == count($t) - 1) {
                            echo "<div class='block left'>";
                        } else {
                            echo "<div class='block right'>";
                        }
                    } else {
                        if ($k == 0) {
                            echo "<div class ='block right'>";
                        } else {
                            echo "<div class ='block line'>";
                        }
                    }
                } else {
                    echo "<div class='block line'>";
                }
                $busInfo = [];
                foreach ($buses as $bus) {
                    $busInfo[$bus['name']]['arrive'] = $bus['minunte'] - $timer[$station['name']]['arrive'];
                    $busInfo[$bus['name']]['leave'] = $bus['minunte'] - $timer[$station['name']]['leave'];
                }
                $min = ['min' => -9999, 'bus' => ""];
                $flag = 0;
                foreach ($busInfo as $bus => $info) {
                    if ($info['arrive'] >= 0 && $info['leave'] <= 0) {
                        $busInfo[$bus]['station'] = "已到站";
                        if ($flag != 1) {
                            echo "<div class='block-top arrive'>";
                            echo $bus . "<br>已到站";
                            echo "</div>";
                            $flag = 1;
                        }
                    } else if ($info['leave'] > 0) {
                        $busInfo[$bus]['station'] = "約" . abs($info['arrive']) . "分鐘";
                        if ($info['arrive'] > min('min')) {
                            $min['min'] = $info['arrive'];
                            $min['bus'] = $bus;
                        }
                    }
                }
                if ($flag == 0 && $min['bus'] != '') {
                    echo "<div class='block-top'>";
                    echo $min['bus'] . "<br>";
                    echo "約" . abs($min['min']) . "分鐘";
                    echo "</div>";
                }
                if ($flag == 0 && $min['bus'] == '') {
                    echo "<div class='block-top'> style='color:#999;'";
                    echo "未發車";
                    echo "</div>";
            }
            $infoTmp = [];
            foreach ($busInfo as $bus =>$info){
                if($info['status'] == "已到站"){
                    $infoTmp['已到站'][$bus]= $info;
                }else if($info['status'] == "已過站"){
                    $infoTmp['已過站'][$bus]= $info;
            }else{
                $infoTmp['未到站'][$bus] = $info;
            }
        }
        $busList = [];
        $maxBus = (count($buses)>=3) ? 3 : count($buses);
        while (count($busList)< $maxBus){
            foreach (['已到站','未到站','已過站'] as $status){
                if(!empty($infoTmp[$status])){
                    $busList[$infoTmp[$station]] = array_shift($infoTmp[$station]);
                    break;
                }
            }
        }
        echo "<div class='bus-info'>"
        foreach ($busList as $name => $info){
            if($info['station'] == '已到站'){
                echo "<div calss='arrive'>";
                
            }
        }

        ?>
    </div>
    <script src="./jquery/jquery.js"></script>
    <script src="./bootstrap/bootstrap.js"></script>
    <script src="./js.js"></script>
</body>

</html>