<?php
$resp = [];
$resp['status'] = 'failed';
$resp['errors'] = [];
$comment = "";

include_once("../../lemons.php");
$group_id = strtoupper($_POST['group_id']);
$comment = $_POST['comment'];
$sem = $_POST['sem'];
$branch = strtoupper($_POST['branch']);
$students = $_POST['students'];

$pdo = getCon();

$group_exists = $pdo->prepare("select * from sgroup where group_id=?");
$group_add = $pdo->prepare("insert into sgroup(group_id,comment,sem,branch) values(?,?,?,?)");
$member_add = $pdo->prepare("insert into sgroup_members values(?,?)");

$group_exists->execute([$group_id]);
if ($group_exists->rowCount()) {
    array_push($resp['errors'], 'Group ID already exists');
} else {
    $group_add->execute([$group_id, $comment, $sem, $branch]);
    foreach($students as $user_id)
        $member_add->execute([$group_id,$user_id]);
    $resp['status'] = 'success';
}

echo json_encode($resp);
