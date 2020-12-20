<?php
include_once("../../lemons.php");
session_start();
$user_id = $_SESSION['user_id'];
$body = $_POST['body'];
$pdo = getCon();

$body = $_POST['body'];
$annoucement = $pdo->prepare("insert into announcement(user_id,body) values(?,?)");
$annoucement->execute([$user_id,$body]);
