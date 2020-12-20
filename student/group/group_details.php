<?php

session_start();
include_once("../../header.php");
include_once("../../lemons.php");

$user_id = $_SESSION['user_id'];
$group_id = $_GET['group_id'];
$pdo = getCon();

$subjects = $pdo->query("select sub.subject_id,sub.title from subject as sub,sgroup_subjects as mem where sub.subject_id=mem.subject_id and mem.group_id='$group_id'")->fetchAll();
$subject_title_map = [];
foreach ($subjects as $subject)
    $subject_title_map[$subject['subject_id']] = $subject['title'];

$getInternals = $pdo->prepare("select i.internal_id,i.title as i_title,s.subject_id,s.title as s_title,m.grade,i.max_marks from internal as i,subject as s,sgroup_internals as si,marks as m  where si.group_id =? and i.internal_id=si.internal_id and i.subject_id=s.subject_id and m.internal_id=i.internal_id and m.user_id=? order by s.subject_id,i.internal_id");
$getAttendance = $pdo->prepare("select i.attendance_id,i.title as a_title,s.subject_id,s.title as s_title,m.percentage,i.minimum from attendance as i,subject as s,sgroup_attendances as si,attendance_for as m  where si.group_id =? and i.attendance_id=si.attendance_id and i.subject_id=s.subject_id and m.attendance_id=i.attendance_id and m.user_id=? order by s.subject_id,i.attendance_id");

$getInternals->execute([$group_id, $user_id]);
$getAttendance->execute([$group_id, $user_id]);

$internals_rows = $getInternals->fetchAll();
$attendance_rows = $getAttendance->fetchAll();

$subject_attendances = [];
$subject_internals = [];

foreach ($internals_rows as $row) {
    if ($subject_internals[$row['subject_id']] == null)
        $subject_internals[$row['subject_id']] = [];
    array_push($subject_internals[$row['subject_id']], ['i_title' => $row['i_title'], 'grade' => $row['grade'], 'max_marks' => $row['max_marks']]);
}

foreach ($attendance_rows as $row) {
    if ($subject_attendances[$row['subject_id']] == null)
        $subject_attendances[$row['subject_id']] = [];
    array_push($subject_attendances[$row['subject_id']], ['a_title' => $row['a_title'], 'percentage' => $row['percentage'], 'minimum' => $row['minimum']]);
}

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
        .fixed-height{
            height: 600px !important;
        }
    </style>
</head>

<body class='bg-light'>
    <?= $html ?>
    <div class='container'>

        <!-- subject list -->
        <div class='subject-list container h-100 p-3 border border-dark rounded my-3'>
            <h4 class='m-0 p-3 bg-success rounded text-light'>Subjects</h4>
            <div class='container py-3'>
                <?php foreach ($subjects as $subject) { ?>
                    <button class='btn btn-primary m-2 text-truncate'><?= $subject['title'] ?></button>
                <?php } ?>
            </div>
        </div>

        <div class='row'>
            <!-- internal column -->
            <div class='col-sm'>
                <div class='internal-list container fixed-height overflow-auto p-3 border border-dark rounded my-3'>

                    <h4 class='m-0 p-3 bg-success rounded text-light'>Internals</h4>
                    <div class='container'>
                        <?php foreach ($subject_internals as $subject_id => $internals) { ?>

                            <table class='table  caption-top table-bordered border-dark table-hover'>
                                <caption> <?= $subject_id ?> <?= $subject_title_map[$subject_id] ?> </caption>

                                <thead class='table-dark'>
                                    <tr>
                                        <th scope='col'>internal title</th>
                                        <th scope='col'>Grade</th>
                                        <th scope='col'>Max Grade</th>

                                    </tr>
                                </thead>

                                <tbody>
                                    <?php foreach ($internals as $internal) { ?>
                                        <tr scope='row'>
                                            <td><?= $internal['i_title'] ?></td>
                                            <td><?= $internal['grade'] ?></td>
                                            <td><?= $internal['max_marks'] ?></td>
                                        </tr>
                                    <?php } ?>
                                </tbody>

                            </table>
                        <?php } ?>
                    </div>
                </div>
            </div>
            <!-- attendance collumn -->
            <div class='col-sm'>
                <div class='internal-list fixed-height overflow-auto container p-3 border border-dark rounded my-3'>

                    <h4 class='m-0 p-3 bg-success rounded text-light'>Attendances</h4>

                    <div class='container'>
                        <?php foreach ($subject_attendances as $subject_id => $attendances) { ?>

                            <table class='table  caption-top table-bordered border-dark table-hover'>
                                <caption> <?= $subject_id ?> <?= $subject_title_map[$subject_id] ?> </caption>

                                <thead class='table-dark'>
                                    <tr>
                                        <th scope='col'>Attendance title</th>
                                        <th scope='col'>Percentage</th>
                                        <th scope='col'>Minimum</th>

                                    </tr>
                                </thead>

                                <tbody>
                                    <?php foreach ($attendances as $attendance) { ?>
                                        <?php if ($attendance['percentage'] < $attendance['minimum']) { ?>
                                            <tr scope='row' class='table-danger'>
                                            <?php } else { ?>
                                            <tr scope='row'>
                                            <?php } ?>
                                            <td><?= $attendance['a_title'] ?></td>
                                            <td><?= $attendance['percentage'] ?></td>
                                            <td><?= $attendance['minimum'] ?></td>
                                            </tr>
                                        <?php } ?>
                                </tbody>

                            </table>

                        <?php } ?>
                    </div>

                </div>
            </div>
        </div>
    </div>
</body>

</html>