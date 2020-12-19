<?php
include_once("../../header.php");
include_once("../../lemons.php");
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
        <a href="../" class='btn btn-primary my-3'>Go Back</a>

        <form onsubmit="event.preventDefault();submitForm()">
            <div class='row'>
                <div class='col-sm  border p-2 rounded m-1'>
                    <!-- group search bar -->
                    <div class=''>
                        <div class='form-floating'>
                            <input type="text" class='form-control' id='group_key' placeholder="lol" oninput="updateGroupSearchResults()">
                            <label>Group ID Search</label>
                        </div>
                        <div class='mt-4 border border-secondary rounded p-2 d-flex flex-column overflow-auto h-100' id='group-search-results'>

                        </div>
                    </div>
                    <!-- selected group -->
                </div>
                <div class='col-sm border p-2 rounded m-1'>
                    <!-- subject-search-bar -->
                    <!-- <div class=''> -->
                    <div class='form-floating'>
                        <input type="text" class='form-control' id='subject_key' placeholder="lol" oninput="updateSubjectSearchResults()">
                        <label>Subject Search</label>
                    </div>
                    <div class='mt-4 border border-secondary rounded p-2 d-flex flex-column overflow-auto' id='subject-search-results'>

                    </div>
                    <!-- </div> -->
                </div>
            </div>
            <div class='row my-3'>
                <div class='col-sm '>
                    <div class='form-floating'>
                        <input type="text" name='title' required class='form-control' id='title' placeholder="Title">
                        <label for="">Internal Title</label>
                    </div>
                </div>
                <div class='col-sm '>
                    <div class='form-floating'>
                        <input type="number" name='max_marks' required class='form-control' id='max_marks' placeholder="Max Marks">
                        <label for="">Max Marks</label>
                    </div>
                </div>
            </div>
            <!-- grade list table -->
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th scope="col">USER ID</th>
                        <th scope="col">GRADE</th>
                    </tr>
                </thead>
                <tbody id='grade-list'>

                </tbody>
            </table>
            <button class='btn btn-lg btn-primary' onclick="event.preventDefault();loadSubjectsAndUsers()">Load Users And Subjects</button>
            <button class='btn btn-lg btn-success'>Submit</button>
        </form>
    </div>
    <script>
        let group_ids = <?= $group_ids ?>;
        let subject_ids = [];

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
                    url: "get_group_members.php",
                    method: "POST",
                    data: {
                        group_id: current_group_id
                    },
                    success: function(response) {
                        response = JSON.parse(response);
                        if(response.length){
                            let user_ids = response[0];
                            subject_ids = response[1];
                            if(!subject_ids.length)
                            {
                                console.log('lol')
                                alert("Hey, Maybe try adding some subjects before you um... ")
                                return;
                            }
                            updateSubjectSearchResults();
                            $('#grade-list')[0].innerHTML="";
                            user_ids.forEach(element => {
                                    $('#grade-list').append(`                    
                                <tr>
                                    <th scope="row">${element}</th>
                                    <td><input type='number' class='grade form-control' id='${element}'></td>
                                </tr>
                                `)
                            });
                        }
                    }
                })
            }
        }


        function submitForm() {
            let title = $('#title')[0].value;
            let max_marks = $('#max_marks')[0].value;
            let grade_list = []

            $('.grade').each(function(){
                let user_grade = {user_id:this.id,grade:this.value}
                grade_list.push(user_grade);
            })

            let data = {
                title: title,
                max_marks: max_marks,
                group_id: current_group_id,
                subject_id: current_subject_id,
                grade_list:grade_list,
            };
            $.ajax({
                url: 'internals.php',
                method: 'post',
                data: data,
                success: function(resp) {
                    console.log(resp);
                }
            })
        }
    </script>
</body>

</html>