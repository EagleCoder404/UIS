<?php
$resp['status'] = 'failed';
$resp['errors'] = [];
include_once("../../lemons.php");

$middle_name = NULL;

$user_id = strtoupper($_POST['user_id']);
$first_name = strtolower($_POST['first_name']);
$middle_name = strtolower($_POST['middle_name']);
$last_name = strtolower($_POST['last_name']);
$phone = $_POST['phone_number'];
$email = strtolower($_POST['email']);
$password = $_POST['password'];
$type = $_POST['type'];

if(!($user_id && $first_name && $last_name && $phone && $email && $password && $type)){
    $resp['message'] = 'Empty Inputs';
    echo json_encode($resp);
    die();
}
$pdo = getCon();

$st = $pdo->prepare("select * from account where user_id = ?");
$st->execute([$user_id]);
if ($st->rowCount())
    array_push($resp['errors'],"User ID already Exists");

$st = $pdo->prepare("select * from account where phone_number = ?");
$st->execute([$phone]);
if ($st->rowCount())
        array_push($resp['errors'],"Phone Number taken");


$st = $pdo->prepare("select * from account where email = ?");
$st->execute([$email]);
if ($st->rowCount())
array_push($resp['errors'],"Email Id in use");

if (!$resp['errors']) {
    $st = $pdo->prepare('insert into account values(?,?,?,?,?,?,?,?)');
    $st->execute([$user_id, $first_name, $middle_name, $last_name, $email, $phone, $type, $password]);
    $resp['status'] = 'success';
    $resp['message'] = "$user_id succesfully created" ;
}
echo json_encode($resp);

