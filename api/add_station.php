<?php include_once "db.php";
$before = $pdo->query("select max(`id`) from `station` ")->fetchColumn() + 1;
$sql = "insert into `station` (`name`,`minute`,`waiting`,`before`) values('{$_POST['name']}','{$_POST['minute']}','{$_POST['waiting']}','$before')";
$pdo->exec($sql);
header("location:../admin.php?pos=station");
