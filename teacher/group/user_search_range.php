<?php
    include_once("../../lemons.php");
 
    $resp = [];
    $from = $_POST['from'];
    $to = $_POST['to'];

    $dbh = getCon();
    $stmt = $dbh->prepare('select user_id,first_name,middle_name,last_name from account where type="s" and user_id between ? and ?');
    $stmt->execute([$from,$to]);
    
    $resp = $stmt->fetchAll();

    echo json_encode($resp);
?>