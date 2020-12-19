<?php
include_once("../../lemons.php");

$subject_id = $_POST['subject_id'];
$title = $_POST['title'];
$max_marks = $_POST['max_marks'];
$group_id = $_POST['group_id'];
$grade_list = $_POST['grade_list'];
echo var_dump($_POST);
$dbh = getCon();

$addInternal = $dbh->prepare("insert into internal(subject_id,title,max_marks) values(?,?,?)");
$setInternalGroup = $dbh->prepare('insert into sgroup_internals values(?,?)');
$setMarks = $dbh->prepare('insert into marks values(?,?,?)');

$addInternal->execute([$subject_id,$title,$max_marks]);
$internal_id = $dbh->lastInsertId();
$setInternalGroup->execute([$internal_id,$group_id]);

foreach($grade_list as $grade)
    $setMarks->execute([$grade['user_id'],$internal_id,$grade['grade']]);