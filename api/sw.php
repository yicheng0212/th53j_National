<?php
include_once "db.php";

$firstId = $_POST['ids'][0];
$secondId = $_POST['ids'][1];

$first = $pdo->query("SELECT * FROM `station` WHERE `id` = '{$firstId}'")->fetch(PDO::FETCH_ASSOC);
$second = $pdo->query("SELECT * FROM `station` WHERE `id` = '{$secondId}'")->fetch(PDO::FETCH_ASSOC);

$minBefore = $pdo->query("SELECT MIN(`before`) FROM `station`")->fetchColumn();

if ($minBefore === $first['before']) {
    $pdo->exec("UPDATE `station` SET `before` = '{$second['before']}', `minute` = '{$second['minute']}' WHERE `id` = '{$firstId}'");
    $pdo->exec("UPDATE `station` SET `before` = '{$first['before']}', `minute` = '{$first['minute']}' WHERE `id` = '{$secondId}'");
} else {
    $pdo->exec("UPDATE `station` SET `before` = '{$first['before']}' WHERE `id` = '{$secondId}'");
    $pdo->exec("UPDATE `station` SET `before` = '{$second['before']}' WHERE `id` = '{$firstId}'");
}
