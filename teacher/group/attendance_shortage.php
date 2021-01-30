<?php
include_once("../../header.php");
include_once("../../lemons.php");
accessTeacher();
$dbh = getCon();
$group_ids = $dbh->query("select group_id from sgroup;")->fetchAll();
$group_ids = json_encode($group_ids);

$subject_ids = $dbh->query("select subject_id,title from subject;")->fetchAll();
$subject_ids = json_encode($subject_ids);
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

        .result:hover {
            transition-duration: 0.2s;
            background-color: rgba(0, 2, 0, 0.2);
            transform: scale(1.01);

        }
    </style>
</head>

<body>
    <?= $html ?>
    <div class='container'>
        <h1 class='display-1'>Attendance Shortage</h1>
        <a href="../" class='btn btn-danger my-3'>Go Back</a>
        <form onsubmit="event.preventDefault();submitForm()">
            <div class='row p-2'>
                <div class='col-sm  bg-warning border-dark p-2 rounded m-1'>
                    <!-- group search bar -->
                    <div class=''>
                        <div class='form-floating'>
                            <input type="text" class='form-control border-dark' id='group_key' placeholder="lol" oninput="updateGroupSearchResults()">
                            <label>Group ID Search</label>
                        </div>

                        <div class='mt-4 border border-dark bg-white rounded p-2 d-flex flex-column overflow-auto h-100' id='group-search-results'>

                        </div>
                    </div>
                    <!-- selected group -->
                </div>
                <div class='col-sm border-dark bg-warning p-2 rounded m-1'>
                    <!-- subject-search-bar -->
                    <!-- <div class=''> -->
                    <div class='form-floating'>
                        <input type="text" class='form-control border-dark' id='subject_key' placeholder="lol" oninput="updateSubjectSearchResults()">
                        <label>Subject Search</label>
                    </div>
                    <div class='mt-4 border border-dark bg-white rounded p-2 d-flex flex-column overflow-auto' id='subject-search-results'>

                    </div>
                    <!-- </div> -->
                </div>
            </div>
            <div class='container my-2 p-3 flex-row  border border-dark rounded'>
                <p>Here Lies users with low attendance</p>
                <div class='d-flex flex-row flex-wrap' id='users'>

                </div>
            </div>
            <div class='container-fluid border border-dark p-3 rounded'>
                <button class='btn my-2 btn-lg btn-primary' onclick="event.preventDefault();loadSubjectsAndUsers()">Load Subjects</button>
                <button id='load-user-btn' class='btn my-2 btn-lg btn-primary ' onclick="event.preventDefault();loadLowAttendanceUsers()">Load Users</button>
                <button id='mail-them-btn' class='btn btn-lg btn-success '>Mail Them?</button>
            </div>
        </form>
    </div>
    <script>
        let group_ids = <?= $group_ids ?>;
        let subject_ids = [];
        let users = [];
        let current_group_id = "";
        let current_subject_id = "";

        updateGroupSearchResults();
        updateSubjectSearchResults();

        function setCurrentGID(new_gid) {
            if (new_gid) {
                current_group_id = new_gid;
                $('#group_key')[0].value = new_gid;
            }
        }

        function setCurrentSID(new_sid) {
            if (new_sid) {
                current_subject_id = new_sid;
                $('#subject_key')[0].value = new_sid;
            }
        }

        function updateGroupSearchResults() {
            console.log('lol')
            let key = $('#group_key')[0].value
            let re = new RegExp(key, 'i');
            let search_results_box = $('#group-search-results');
            search_results_box[0].innerHTML = "";
            for (let i = 0; i < group_ids.length; i++) {
                if (re.test(group_ids[i].group_id))
                    search_results_box.append(`<span class='result p-1 rounded' onclick='setCurrentGID("${group_ids[i].group_id}")'>${group_ids[i].group_id}</span>`)
            }
        }

        function updateSubjectSearchResults() {
            let key = $('#subject_key')[0].value
            let re = new RegExp(key, 'i');
            let search_results_box = $('#subject-search-results');
            search_results_box[0].innerHTML = "";
            for (let i = 0; i < subject_ids.length; i++) {
                if (re.test(subject_ids[i].subject_id) || re.test(subject_ids[i].title))
                    search_results_box.append(`<span class='result p-1 rounded' onclick='setCurrentSID("${subject_ids[i].subject_id}")'>${subject_ids[i].subject_id} ${subject_ids[i].title}</span>`)
            }
        }

        function loadSubjectsAndUsers() {
            if (current_group_id == "")
                alert("Select A Group first doofus");
            else {
                $.ajax({
                    url: "load_subjects.php",
                    method: "POST",
                    data: {
                        group_id: current_group_id
                    },
                    success: function(response) {
                        console.log(response);
                        response = JSON.parse(response);
                        if (response.length) {
                            subject_ids = response;
                            if (!subject_ids.length) {
                                console.log('lol')
                                alert("Hey, Maybe try adding some subjects before you um... ")
                                return;
                            }
                            updateSubjectSearchResults();

                        }
                    }
                })
            }
        }

        function loadLowAttendanceUsers() {
            users=[];
            $('#users')[0].innerHTML="";
            if ((current_subject_id == "") || (current_group_id == ""))
                alert("inputs missing");
            else {
                $.ajax({
                    url: "get_shortaged_students.php",
                    method: "POST",
                    data: {
                        group_id: current_group_id,
                        subject_id: current_subject_id
                    },
                    success: function(response) {
                        response = JSON.parse(response);
                        console.log(response);
                        response.forEach( x => addUser(x.user_id));
                    }
                })
            }
        }

        function removeUser(user_id) {
            if (users.includes(user_id)) {
                const index = users.indexOf(user_id);
                if (index > -1) {
                    users.splice(index, 1);
                }
            }
        }

        function addUser(user_id) {
            if (users.includes(user_id))
                return;
            else {
                users.push(user_id);
                $('#users').append(`
                <div class='btn  m-1 btn-primary text-white'>
                    <span class='user-id'>${user_id}</span>
                    <button class='btn btn-close' id='${user_id}' onclick="event.preventDefault();removeUser('${user_id}');this.parentElement.remove()"></button>
                </div>
                `)

            }
        }

        function submitForm() {
            if ((current_subject_id == "") || (current_group_id == "") || (users.length == 0 ))
            {
                alert("inputs missing");
                return;
            }

            let data = {
                group_id: current_group_id,
                subject_id: current_subject_id,
                users:users
            };
            $.ajax({
                url: 'mail_low_attendance.php',
                method: 'post',
                data: data,
                success: function(resp) {
                    if(resp)
                        alert(`${resp} mails sent`);
                }
            })
        }
    </script>
</body>

</html>