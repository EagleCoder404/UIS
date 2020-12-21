<?php 
include_once('../../lemons.php');
$pdo = getCon();
$group_id = $_POST['group_id'];
$groupSubjects = $pdo->prepare('select s.subject_id,s.title from sgroup_subjects as sg,subject as s where sg.subject_id=s.subject_id and group_id=?');
$groupSubjects->execute([$group_id]);
echo json_encode($groupSubjects->fetchAll());
?>