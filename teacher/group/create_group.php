<?php
include_once("../../header.php");
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

<body>
    <?= $html ?>
    <div class="container ">
        <h1 class='display-1'>Create a Group</h1>
        <a href="../" class='btn btn-danger my-2'>Go Back</a>
        <div class='container form-box bg-light border border-dark p-sm-3'>

            <form action="" id='group-form'>
                <div class='row mb-3'>
                    <div class='col-sm'>
                        <div class='form-floating '>
                            <input type="text" class="form-control" name="group_id" required aria-describedby="helpId" placeholder="Group ID">
                            <label>Group ID</label>
                        </div>
                    </div>
                </div>
                <div class='row mb-3'>
                    <div class='col-sm'>
                        <div class='form-floating '>
                            <input type="number" maxlength='1' class="form-control" min=1 max=8 name="sem" required aria-describedby="helpId" placeholder="Semester">
                            <label>Semester</label>
                        </div>
                    </div>
                    <div class='col-sm'>
                        <select class="form-select h-100" name='branch' required aria-label="Default select example">
                            <option selected>Branch</option>
                            <option value="CSE">Computer Science And Engineering</option>
                            <option value="ISE">Information Science And Engineering</option>
                            <option value="ME">Mechanical Engineering</option>
                        </select>
                    </div>
                </div>
                <div class='row mb-3'>
                    <div class='col-sm'>
                        <div class='form-floating '>
                            <input type="text" class="form-control" name="comment" aria-describedby="helpId" placeholder="Any Remarks?">
                            <label>Any Remarks?</label>
                        </div>
                    </div>
                </div>
                <div class=' p-3 border border-dark student-box row mb-3'>
                    <h4>Group Students</h4>
                    <div class='d-flex flex-row flex-wrap' id='selected-students'>

                    </div>
                </div>
                <div class=' mb-3 justify-content-end d-flex flex-row'>
                    <button onclick="event.preventDefault();" class='btn  btn-primary mx-3' data-bs-toggle="modal" data-bs-target="#searchStudentModal">Add Students To Group?</button>
                    <button type='submit' onclick="event.preventDefault();submitForm()" class='btn btn-success mx-3'>Submit</button>
                </div>
            </form>
        </div>
    </div>
    <!-- studentSearchModal -->
    <div class="modal fade" id="searchStudentModal" tabindex="-1" aria-labelledby="searchStudentModal" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-body">
                    <div class='container-fluid'>
                        <div class='row'>
                            <p>Range with USER ID</p>
                            <div class='input-group col-sm m-1'>
                                <label class='input-group-text'>From:</label>
                                <input type="text" class='form-control' name='from' id='from'>
                            </div>
                            <div class='input-group col-sm m-1'>
                                <label class='input-group-text'>To:</label>
                                <input type="text" class='form-control' name='to' id='to'>
                            </div>
                            <div class='col-sm m-1'>
                                <button class='btn btn-primary w-100' onclick="searchUserByRange()">Search</button>
                            </div>
                        </div>
                        <div class='row mt-3'>
                            <table class='table'>
                                <tr>
                                    <th scope="col">ID</th>
                                    <th scope="col">Name</th>
                                    <th scope="col"></th>

                                </tr>
                                <tbody class='search-result'>

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        let group_userids = [];

        function submitForm() {
            let data = {}
            $('#group-form :input').each(function() {
                let input = $(this)[0];
                data[input.name] = input.value;
            })
            data['students'] = group_userids;
            $.ajax({
                url: 'actual_group_creator_lol.php',
                method: "POST",
                data: data,
                success: function(response) {
                    console.log(response);
                    response = JSON.parse(response);
                    if(response.status=='success')
                        alert("Group Created");
                    else
                        alert(response.errors);
                }
            })
        }

        function removeUser(user_id) {
            if (group_userids.includes(user_id)) {
                const index = group_userids.indexOf(user_id);
                if (index > -1) {
                    group_userids.splice(index, 1);
                }
            }
        }

        function addUser(user_id) {
            if (group_userids.includes(user_id))
                return;
            else {
                group_userids.push(user_id);
                $('#selected-students').append(`
                <div class='btn  m-1 btn-primary text-white'>
                    <span class='user-id'>${user_id}</span>
                    <button class='btn' onclick="event.preventDefault();removeUser('${user_id}');this.parentElement.remove()">x</button>
                </div>
                `)

            }
        }



        function searchUserByRange() {
            let from = $('#from')[0].value;
            let to = $('#to')[0].value;

            if (from && to) {
                $.ajax({
                    url: 'user_search_range.php',
                    data: {
                        from: from,
                        to: to
                    },
                    method: 'POST',
                    success: function(response) {
                        $('.search-result')[0].innerHTML = "";
                        response = JSON.parse(response);
                        console.log(response);
                        for (let i = 0; i < response.length; i++) {
                            let row = response[i];
                            $('.search-result').append(`
                                <tr scope="row">
                                    <td>
                                    ${row.user_id}
                                    </td>
                                    <td>
                                    ${row.first_name} ${row.middle_name} ${row.last_name}
                                    </td>
                                    <td>
                                        <button class='btn btn-success' onclick='addUser("${row.user_id}")'>add</button>
                                    </td>
                                </tr>
                            `)
                        }
                    }
                })
            }
        }
    </script>
</body>

</html>