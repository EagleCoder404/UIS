<?php
$resp['status'] = 'failed';
$resp['errors'] = [];
include_once("../../lemons.php");

$middle_name = NULL;

$user_id = strtoupper($_POST['user_id']);
$first_name = strtolower($_POST['first_name']);
$middle_name = strtolower($_POST['middle_name']);
$last_name = strtolower($_POST['last_name']);
$phone_number = $_POST['phone_number'];
$email = strtolower($_POST['email']);
$password = $_POST['hash'];
$type = $_POST['type'];
// echo var_dump($_POST);
// if(!($user_id && $first_name && $last_name && $phone && $email && $password && $type)){
//     $resp['message'] = 'Empty Inputs';
//     echo json_encode($resp);
//     die();
// }
$pdo = getCon();

$st = $pdo->prepare("select * from account where phone_number = ? and user_id!= ?");
$st->execute([$phone_number, $user_id]);
if ($st->rowCount())
    array_push($resp['errors'], "Phone Number taken");


$st = $pdo->prepare("select * from account where email = ? and user_id!= ?");
$st->execute([$email, $user_id]);
if ($st->rowCount())
    array_push($resp['errors'], "Email Id in use");

if (!$resp['errors']) {
    $st = $pdo->prepare('update account set first_name=? , middle_name=? , last_name=? , email=? , phone_number=? , type=? , hash=? where user_id=?');
    $st->execute([$first_name, $middle_name, $last_name, $email, $phone_number, $type, $password,$user_id]);
    $resp['status'] = 'success';
    $resp['message'] = "$user_id succesfully modified";
}
echo json_encode($resp);
