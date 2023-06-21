<?php include_once "db.php";
if ($_POST['code'] != $_SESSION['code']) {
    header("location:../login.php?error=2");
    exit();
}
$sql = "select count(*) from `admin` where `acc`='{$_POST['acc']}' && `pw`='{$_POST['pw']}'";

$chk = $pdo->query($sql)->fetchColumn();
if ($chk == 1) {
    $_SESSION['login'] = $_POST['acc'];
    header("location:../admin.php");
} else {
    header("location:../login.php?error=1");
}
