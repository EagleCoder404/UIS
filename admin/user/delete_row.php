<?php
include_once('../../lemons.php');
$key = $_POST['search_param'];
$val = $_POST['search_key'];
$table = $_POST['table_name'];
// $key = 'user_id';
// $val = '1BI17CS058';
// $table = 'account';
$pdo = getCon();
$sql = "delete from $table where $key=\"$val\"";
if ($pdo->query($sql)->rowCount())
    echo '1';
else
    echo '0';
