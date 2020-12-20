<?php
session_start();
include_once("../header.php");
include_once("../lemons.php");
$user_id = $_SESSION['user_id'];
$pdo = getCon();
$group_rows = $pdo->query("select g.sem,g.group_id,g.comment,g.status from sgroup_members m,sgroup g where m.group_id=g.group_id and m.user_id='$user_id' order by g.sem desc")->fetchAll();
$announcements = $pdo->query("select u.user_id,u.first_name,u.last_name,a.body,a.time from announcement as a,account as u where a.user_id = u.user_id order by time")->fetchAll();

$semesters = [[], [], [], [], [], [], [], []];
foreach ($group_rows as $row)
    array_push($semesters[$row['sem']], ['group_id' => $row['group_id'], 'comment' => $row['comment'], 'status' => $row['status']]);
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

        .group:hover {
            transition-duration: 0.2s;
            /* transform: scale(1.02); */
            background-color: gray;
            color: white;
        }

        .fixed-height {
            height: 400px;
        }
    </style>
</head>

<body class='bg-light'>
    <?= $html ?>
    <div class="container">

        <div class='announcement-box container'>
            <h1 class='display-3'>Annoucements</h1>

            <div class='announcement-list container p-3 border border-dark overflow-auto rounded fixed-height'>
                <?php foreach ($announcements as $x) { ?>
                    <div class='container mb-2 p-3 border border-dark rounded'>
                        <p class='lead'>
                            <?= $x['body'] ?>
                        </p>
                        <div class='d-flex d-row border-top  border-dark justify-content-between'>
                            <p class='text-capitalize'><?= $x['user_id'] . " / " . $x['first_name'] . " " . $x['last_name'] ?></p>
                            <p class='text-muted'><?= $x['time'] ?></p>
                        </div>

                    </div>
                <?php } ?>
            </div>

        </div>
        <div class='container mb-3'>
            <h1 class='display-3'>Semesters</h1>
            <div class="accordion" id="accordionExample">
                <?php foreach ($semesters as $sem => $groups) { ?>
                    <?php if ($groups) { ?>
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type=" button" data-bs-toggle="collapse" data-bs-target="#<?= 'lol' . $sem ?>" aria-expanded="false" aria-controls="collapseOne">
                                    <?= $sem ?>
                                </button>
                            </h2>
                            <div id="<?= 'lol' . $sem ?>" class="accordion-collapse collapse" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                                <div class="accordion-body">
                                    <?php foreach ($groups as $group) { ?>
                                        <div class='group d-flex flex-row justify-content-between my-4 border border-dark rounded p-3'>
                                            <p class='m-0'><?= $group['group_id'] . "  |  " . $group['comment'] ?></p>
                                            <a href="group/group_details.php?group_id=<?= $group['group_id'] ?>" class='btn btn-primary'>Check It Out</a>
                                        </div>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                <?php } ?>
            </div>
        </div>
    </div>
</body>

</html>