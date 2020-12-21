<?php
    include_once("../../lemons.php");  
    $group_id = $_POST['group_id'];
    $subject_id = $_POST['subject_id'];
    $user_ids = $_POST['users'];
    $emails = [];
    $pdo = getCon();
    $getMail = $pdo->prepare("select email from account where user_id = ?");
    foreach($user_ids as $user_id)
    {
        $getMail->execute([$user_id]);
        array_push($emails,$getMail->fetch()['email']);
    }
    echo "MAILED\n";
    echo var_dump($emails);
?>