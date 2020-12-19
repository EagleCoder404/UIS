<?php
include_once("../../lemons.php");
include_once("../../header.php");
$dbh = getCon();
$group_ids = $dbh->query("select group_id from sgroup;")->fetchAll();
$subject_ids = $dbh->query("select subject_id,title from subject;")->fetchAll();
$subject_ids = json_encode($subject_ids);
$group_ids = json_encode($group_ids);
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
        }

        .result:active {
            transform: scale(1.01);
        }
        .fixed-height{
            height:200px !important;
        }
    </style>
</head>

<body>
    <?= $html ?>
    <div class='col-sm'>
        <a href="../" class='btn btn-primary my-3'>Go Back</a>

        <div class='container border border-dark p-2 rounded mb-3'>
            <!-- group search bar -->
            <div class='d-flex flex-column'>
                <div class='form-floating'>
                    <input type="text" class='form-control' id='group_key' placeholder="lol" oninput="updateSearchResults()">
                    <label>Group ID Search</label>
                </div>
                <div class='mt-4 border border-secondary rounded p-2 d-flex flex-column overflow-auto' id='group-search-results'>

                </div>
            </div>
            <!-- selected group -->
            <div class='container'>
                <p>Group ID: <span id='current-gid'> </span></p>
            </div>
        </div>

        <div class='container border border-dark p-2 rounded mb-3'>
            <!-- subject search bar -->
            <div class='d-flex flex-column'>
                <div class='form-floating'>
                    <input type="text" class='form-control' id='subject_key' placeholder="lol" oninput="updateSubjectSearchResults()">
                    <label>Subject Search</label>
                </div>
                <div class='mt-4 border border-secondary rounded p-2 d-flex flex-column overflow-auto fixed-height' id='subject-search-results'>

                </div>
            </div>
            <!-- selected subjects -->
            <div class='container'>
                <p>selected subjects</p>
                <div class='container border border-dark rounded' id='selected-subjects'>
                </div>
            </div>
        </div>
        <button class='btn btn-success' onclick="formSubmit()">Submit</button>

    </div>
    <script>
        let group_ids = <?= $group_ids ?>;
        let current_group_id = "?";

        let subject_ids = <?= $subject_ids ?>;
        let selected_subject_ids = [];

        updateSearchResults();
        updateSubjectSearchResults()

        function addSubject(subject_id) {
            if (selected_subject_ids.includes(subject_id))
                return
            else {
                selected_subject_ids.push(subject_id);
                let selected_subjects_box = $('#selected-subjects');
                selected_subjects_box.append(`<button onclick='removeSubject("${subject_id}");this.remove()'>${subject_id}</button>`);
            }
        }

        function removeSubject(subject_id) {
            if (selected_subject_ids.includes(subject_id)) {
                const index = selected_subject_ids.indexOf(subject_id);
                if (index > -1) {
                    selected_subject_ids.splice(index, 1);
                }
            }
        }

        function setCurrentGID(new_gid) {
            if (new_gid) {
                current_group_id = new_gid;
                $('#current-gid')[0].innerHTML = new_gid;
            }
        }

        function updateSearchResults() {
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
            if (subject_ids == []) {
                return
            }
            console.log('lol')
            let key = $('#subject_key')[0].value
            let re = new RegExp(key, 'i');
            let search_results_box = $('#subject-search-results');
            search_results_box[0].innerHTML = "";
            for (let i = 0; i < subject_ids.length; i++) {
                if (re.test(subject_ids[i].subject_id) || re.test(subject_ids[i].title))
                    search_results_box.append(`<span class='result p-1 rounded' onclick='addSubject("${subject_ids[i].subject_id}")'>${subject_ids[i].subject_id} ${subject_ids[i].title}</span>`)
            }
        }
        function formSubmit(){
            let data = {group_id:current_group_id,subjects:selected_subject_ids};
            $.ajax({
                url:"actual_add_subject_lol.php",
                data:data,
                method:'POST',
                success:function(response){
                    console.log(response);
                }
            })
        }
    </script>

</body>

</html>