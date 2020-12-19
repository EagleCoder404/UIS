<?php 
include_once("../../lemons.php");
$group_id = $_POST['group_id'];
$pdo = getCon();
$groupMembers = $pdo->prepare('select user_id from sgroup_members where group_id=?');
$groupSubjects = $pdo->prepare('select s.subject_id,s.title from sgroup_subjects as sg,subject as s where sg.subject_id=s.subject_id and group_id=?');

$groupMembers->execute([$group_id]);
$groupSubjects->execute([$group_id]);

$user_ids = $groupMembers->fetchAll(PDO::FETCH_COLUMN,0);
$subject_ids = $groupSubjects->fetchAll();
echo json_encode([$user_ids,$subject_ids]);