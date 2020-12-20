<?php
include_once("../../lemons.php");

$subject_id = $_POST['subject_id'];
$title = $_POST['title'];
$min_attendance = $_POST['min_attendance'];
$group_id = $_POST['group_id'];
$attendance_list = $_POST['attendance_list'];
$dbh = getCon();

$addAttendance = $dbh->prepare("insert into attendance(subject_id,title,minimum) values(?,?,?)");
$setAttendanceGroup = $dbh->prepare('insert into sgroup_attendances values(?,?)');
$setPercentage = $dbh->prepare('insert into attendance_for values(?,?,?)');

$addAttendance->execute([$subject_id,$title,$min_attendance]);
$attendance_id = $dbh->lastInsertId();
$setAttendanceGroup->execute([$attendance_id,$group_id]);

foreach($attendance_list as $attendance)
    $setPercentage->execute([$attendance['user_id'],$attendance_id,$attendance['attendance_percentage']]);