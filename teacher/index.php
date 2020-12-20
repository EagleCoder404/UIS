<?php
include_once("../header.php");
include_once("../lemons.php");
accessFaculty();

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js" integrity="sha384-q2kxQ16AaE6UbzuKqyBE9/u/KzioAlnx2maXQHiDX9d4/zp8Ok3f+M7DPm+Ib6IU" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.min.js" integrity="sha384-pQQkAEnwaBkjpqZ8RU1fF1AKtTcHJwFl3pblpTlHXybJjHpMYo79HY3hIi4NKxyj" crossorigin="anonymous"></script>
    <link href="https://fonts.googleapis.com/css2?family=Raleway:wght@800&amp;display=swap" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.5.1.js" integrity="sha256-QWo7LDvxbWT2tbbQ97B53yJnYU3WhH/C8ycbRAkjPDc=" crossorigin="anonymous"></script>
    <style>
        * {
            margin: 0px;
            padding: 0px;
            font-family: 'Raleway';
        }
    </style>
</head>

<body class='bg-light'>
    <?= $html ?>
    <div class="container">
        <div class='group-menu container-fluid mb-4'>
            <h2>Groups Menu</h1>
                <div class='row'>
                    <div class="col-sm">
                        <a href='group/create_group.php' class='btn btn-lg btn-primary'>Create Group</a>
                    </div>
                    <div class="col-sm">
                        <a href='group/add_subject.php' class='btn btn-lg btn-primary'>Add Subject</a>
                    </div>
                </div>

        </div>
        <div class='group-menu container-fluid mb-4'>
            <h2>Internals Menu</h1>
                <div class='row'>
                    <div class="col-sm">
                        <a href='group/create_internal.php' class='btn btn-lg btn-primary'>Create Internal</a>
                    </div>
                    <div class="col-sm">
                        <a href='group/create_attendance.php' class='btn btn-lg btn-primary'>Create Attendance</a>
                    </div>
                </div>

        </div>
    </div>
</body>

</html>