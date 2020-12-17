<?php
    include_once("../../lemons.php");
    $resp = [];
    $resp['data'] = [];
    
    $search_param = $_POST['search_param'];
    $search_key = $_POST['search_key'];
    
    // $search_param = 'user_id';
    // $search_key = '1BI17CS';
    $pdo = getCon();
    $resp['data'] = $pdo->query("select * from account where $search_param like '%$search_key%' ;")->fetchAll();
    echo json_encode($resp);
?>