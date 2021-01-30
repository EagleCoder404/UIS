<?php
include_once('../../lemons.php');

$dbh = getCon();
$group_id = $_POST['group_id'];
$subjects = $_POST['subjects'];

$sent_subject_count = count($subjects);
$actually_added_subject_count = 0;
$subjectExists = $dbh->prepare('select * from sgroup_subjects where subject_id=? and group_id=?');
$addSubject = $dbh->prepare("insert into sgroup_subjects values(?,?)");

foreach($subjects as $subject_id){
    $subjectExists->execute([$subject_id,$group_id]);
    if($subjectExists->rowCount() == 0)
    {
        $actually_added_subject_count++;
        $addSubject->execute([$subject_id,$group_id]);
    }
}

echo json_encode(['status'=>'success',"duplicates"=>$sent_subject_count-$actually_added_subject_count]);