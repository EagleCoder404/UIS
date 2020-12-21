<?php
include_once("../../lemons.php");
$group_id = $_POST['group_id'];
$subject_id = $_POST['subject_id'];
$pdo = getCon();

$getShortes = $pdo->prepare("select af.user_id from attendance as a,sgroup_attendances as sa,attendance_for as af where sa.group_id=? and a.attendance_id=sa.attendance_id and af.attendance_id=a.attendance_id and a.subject_id=? and af.percentage < a.minimum group by af.user_id");
$getShortes->execute([$group_id,$subject_id]);

echo json_encode($getShortes->fetchAll());
?> 