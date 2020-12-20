<?php
$user_id = "";
session_start();
if(isset($_SESSION['user_id']))
{
    $type=$_SESSION['type'];
    $user_id=$_SESSION['user_id'];
    $home_link="#";
    if($type=='s')
        $home_link="/UIS/app/student/";
    else if($type=='t')
        $home_link="/UIS/app/teacher/";
    else if($type=='a')
        $home_link=='/UIS/app/admin';
}
$html =<<<EOD
    <nav class="navbar navbar-expand-md navbar-dark bg-dark m-sm-2 m-0">
        <div class="container-fluid px-2">
            <a class="navbar-brand" href="$home_link">
                <span class='bg-primary px-3 py-2'>UIS</span>
                <span class='d-none d-sm-inline'>Bangalore Insitute Of Tecnology</span>
                <span class='d-inline d-sm-none'>BIT</span>
            </a>
            <span class='text-light'>$user_id</span>
        </div>
    </nav>
EOD;

?>
