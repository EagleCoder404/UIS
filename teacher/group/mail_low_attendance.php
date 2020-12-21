<?php
    include_once("../../lemons.php");  
    include_once("../../test.php");
    $group_id = $_POST['group_id'];
    $subject_id = $_POST['subject_id'];
    $user_ids = $_POST['users'];
    $emails = [];
    $mails_sent = 0;
    $pdo = getCon();
    $getMail = $pdo->prepare("select email from account where user_id = ?");
    foreach($user_ids as $user_id)
    {
        $getMail->execute([$user_id]);
        array_push($emails,$getMail->fetch()['email']);
    }
    foreach($emails as $email)
        if(sendMailLol($email,"you have low attendance in $subject_id"))
            $mails_sent++;
    echo $mails_sent;
?>