<?php
include_once('../header.php');
include_once('../lemons.php');
accessAdmin();
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

        .search-results-del .row:hover,
        .search-results-mod .row:hover {
            background-color: slategray !important;
        }
    </style>
</head>

<body class='bg-light'>
    <?= $html ?>
    <div class='container'>
        <div class='jumbotron display-1 text-decoration-underline'>
            Admin Panel
        </div>
        <div class='settings-menu p-3'>
            <div class='d-flex flex-sm-row flex-column justify-content-around flex-wrap'>
                <div class='border border-dark rounded p-3'>
                    <svg xmlns="http://www.w3.org/2000/svg" width="100" height="100" fill="currentColor" class="bi bi-person-plus-fill" viewBox="0 0 16 16">
                        <path fill-rule="evenodd" d="M1 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1H1zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm7.5-3a.5.5 0 0 1 .5.5V7h1.5a.5.5 0 0 1 0 1H14v1.5a.5.5 0 0 1-1 0V8h-1.5a.5.5 0 0 1 0-1H13V5.5a.5.5 0 0 1 .5-.5z" />
                    </svg>
                    <div class='d-grid gap-2'>
                        <a href="#" class='streatchable-link btn btn-block btn-primary rounded-0' data-bs-toggle="modal" data-bs-target="#addModal">ADD</a>
                    </div>
                </div>
                <div class='border border-dark rounded p-3'>
                    <svg xmlns="http://www.w3.org/2000/svg" width="100" height="100" fill="currentColor" class="bi bi-person-dash-fill" viewBox="0 0 16 16">
                        <path fill-rule="evenodd" d="M1 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1H1zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm5-.5a.5.5 0 0 1 .5-.5h4a.5.5 0 0 1 0 1h-4a.5.5 0 0 1-.5-.5z" />
                    </svg>
                    <div class='d-grid gap-2'>
                        <a href="#" class='streatchable-link btn btn-block btn-primary rounded-0' data-bs-toggle="modal" data-bs-target="#deleteModal">DELETE</a>
                    </div>
                </div>
                <div class='border border-dark rounded p-3'>
                    <svg xmlns="http://www.w3.org/2000/svg" width="100" height="100" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                        <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456l-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z" />
                        <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z" />
                    </svg>
                    <div class='d-grid gap-2'>
                        <a href="#" class='streatchable-link btn btn-block btn-primary rounded-0' data-bs-toggle="modal" data-bs-target="#modifyModal">MODIFY</a>
                    </div>
                </div>
                <div class='border border-dark rounded p-3'>
                    <svg xmlns="http://www.w3.org/2000/svg" width="100" height="100" fill="currentColor" class="bi bi-bell-fill" viewBox="0 0 16 16">
                        <path d="M8 16a2 2 0 0 0 2-2H6a2 2 0 0 0 2 2zm.995-14.901a1 1 0 1 0-1.99 0A5.002 5.002 0 0 0 3 6c0 1.098-.5 6-2 7h14c-1.5-1-2-5.902-2-7 0-2.42-1.72-4.44-4.005-4.901z" />
                    </svg>
                    <div class='d-grid gap-2'>
                        <a href="#" class='streatchable-link btn btn-block btn-primary rounded-0' data-bs-toggle="modal" data-bs-target="#annoucementModal">Notify</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Add Modal -->
    <div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="addModal" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add New User</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form onsubmit="event.preventDefault();addUser()" id='addUser'>
                    <div class="modal-body">
                        <div class="container-fluid">
                            <div class='row'>
                                <div class='col-sm'>
                                    <div class="form-floating mb-3">
                                        <input type="text" class="form-control" name='user_id' id="user_id" maxlength=10 placeholder="USER ID" required>
                                        <label for="user_id">USER ID</label>
                                    </div>
                                </div>
                            </div>
                            <div class='row'>
                                <div class='col-sm'>
                                    <div class="col-sm form-floating mb-3">
                                        <input type="text" class="form-control" name='first_name' id="first_name" maxlength=60 placeholder="First Name" required>
                                        <label for="first_name">First Name</label>
                                    </div>

                                </div>
                                <div class='col-sm'>
                                    <div class="col-sm form-floating mb-3">
                                        <input type="text" class="form-control " name='middle_name' id="middle_name" maxlength=60 placeholder="Middle Name">
                                        <label for="middle_name">Middle Name</label>
                                    </div>
                                </div>
                                <div class='col-sm'>
                                    <div class="col-sm form-floating mb-3">
                                        <input type="text" class="form-control " name='last_name' id="last_name" maxlength=60 placeholder="Last Name" required>
                                        <label for="last_name">Last Name</label>
                                    </div>

                                </div>
                            </div>
                            <div class='row'>
                                <div class='col-sm'>
                                    <div class="col-sm form-floating mb-3">
                                        <input type="email" class="form-control " maxlength=128 name='email' id="email" placeholder="E-Mail" required>
                                        <label for="email">E-Mail</label>
                                    </div>

                                </div>
                                <div class='col-sm'>
                                    <div class="col-sm form-floating mb-3">
                                        <input type="tel" class="form-control " maxlength=10 name='phone_number' id="phone" placeholder="Phone" required>
                                        <label for="Phone">Phone</label>
                                    </div>

                                </div>
                            </div>
                            <div class='row'>
                                <div class='col-sm'>
                                    <select class="form-select h-75" name='type' required aria-label="Default select example">
                                        <option selected>Type Of User</option>
                                        <option value="a">Administrator</option>
                                        <option value="t">Teacher</option>
                                        <option value="s">Student</option>
                                    </select>
                                </div>
                                <div class='col-sm'>
                                    <div class=" form-floating mb-3">
                                        <input type="password" class="form-control" name='password' id="password" placeholder="Password" required>
                                        <label for="password">password</label>
                                    </div>
                                </div>
                            </div>
                            <div class='log'>
                                <span class='status text-success'></span>
                                <span class='errors text-danger'></span>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Create</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Delete Modal -->
    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Delete User</h5>
                </div>
                <div class="modal-body">
                    <form onsubmit="event.preventDefault();searchUser()" id='searchUserDelete'>
                        <div class='row'>

                            <div class='col-sm'>
                                <div class="input-group mb-3">
                                    <select class="form-select form-select-md" name='search_param' required aria-label="Default select example">
                                        <option selected>Search Param</option>
                                        <option value="first_name">First name</option>
                                        <option value="middle_name">Middle Name</option>
                                        <option value="last_name">Last Name</option>
                                        <option value="user_id">User ID</option>
                                    </select>
                                    <input type="text" class="form-control" placeholder="Search Key" name='search_key' id='search_key' aria-label="Recipient's username" aria-describedby="basic-addon2" required>
                                    <button class='btn btn-primary'>
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
                                            <path fill-rule="evenodd" d="M10.442 10.442a1 1 0 0 1 1.415 0l3.85 3.85a1 1 0 0 1-1.414 1.415l-3.85-3.85a1 1 0 0 1 0-1.415z" />
                                            <path fill-rule="evenodd" d="M6.5 12a5.5 5.5 0 1 0 0-11 5.5 5.5 0 0 0 0 11zM13 6.5a6.5 6.5 0 1 1-13 0 6.5 6.5 0 0 1 13 0z" />
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        </div>

                    </form>
                    <div class='container-fluid search-result-container my-2'>
                        <h1 class='text-success display-2'>Search Results</h1>
                        <div class='overflow-auto border border-dark search-results-del'>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Modify Modal -->
    <div class="modal fade" id="modifyModal" tabindex="-1" aria-labelledby="" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Modify User Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form onsubmit="event.preventDefault();searchUserModify()" id='searchUserModify'>
                        <div class='row'>
                            <div class='col-sm'>
                                <div class="input-group mb-3">
                                    <select class="form-select form-select-md" name='search_param' required aria-label="Default select example">
                                        <option selected>Search Param</option>
                                        <option value="first_name">First name</option>
                                        <option value="middle_name">Middle Name</option>
                                        <option value="last_name">Last Name</option>
                                        <option value="user_id">User ID</option>
                                    </select>
                                    <input type="text" class="form-control" placeholder="Search Key" name='search_key' id='search_key' aria-label="Recipient's username" aria-describedby="basic-addon2" required>
                                    <button class='btn btn-primary'>
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
                                            <path fill-rule="evenodd" d="M10.442 10.442a1 1 0 0 1 1.415 0l3.85 3.85a1 1 0 0 1-1.414 1.415l-3.85-3.85a1 1 0 0 1 0-1.415z" />
                                            <path fill-rule="evenodd" d="M6.5 12a5.5 5.5 0 1 0 0-11 5.5 5.5 0 0 0 0 11zM13 6.5a6.5 6.5 0 1 1-13 0 6.5 6.5 0 0 1 13 0z" />
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        </div>

                    </form>
                    <div class='container-fluid search-result-container my-2'>
                        <h1 class='text-success display-2'>Search Results</h1>
                        <div class='overflow-auto border border-dark search-results-mod'>

                        </div>
                    </div>
                    <form onsubmit="event.preventDefault();submitModifiedUser()" id='modifyUserForm' class='d-none'>
                        <div class="modal-body">
                            <div class="container-fluid">
                                <div class='row'>
                                    <div class='col-sm'>
                                        <div class="form-floating mb-3">
                                            <input type="text" class="form-control" disabled name='user_id' id="user_id" maxlength=10 placeholder="USER ID" required>
                                            <label for="user_id">USER ID</label>
                                        </div>
                                    </div>
                                </div>
                                <div class='row'>
                                    <div class='col-sm'>
                                        <div class="col-sm form-floating mb-3">
                                            <input type="text" class="form-control" name='first_name' id="first_name" maxlength=60 placeholder="First Name" required>
                                            <label for="first_name">First Name</label>
                                        </div>

                                    </div>
                                    <div class='col-sm'>
                                        <div class="col-sm form-floating mb-3">
                                            <input type="text" class="form-control " name='middle_name' id="middle_name" maxlength=60 placeholder="Middle Name">
                                            <label for="middle_name">Middle Name</label>
                                        </div>
                                    </div>
                                    <div class='col-sm'>
                                        <div class="col-sm form-floating mb-3">
                                            <input type="text" class="form-control " name='last_name' id="last_name" maxlength=60 placeholder="Last Name" required>
                                            <label for="last_name">Last Name</label>
                                        </div>

                                    </div>
                                </div>
                                <div class='row'>
                                    <div class='col-sm'>
                                        <div class="col-sm form-floating mb-3">
                                            <input type="email" class="form-control " maxlength=128 name='email' id="email" placeholder="E-Mail" required>
                                            <label for="email">E-Mail</label>
                                        </div>

                                    </div>
                                    <div class='col-sm'>
                                        <div class="col-sm form-floating mb-3">
                                            <input type="tel" class="form-control " maxlength=10 name='phone_number' id="phone" placeholder="Phone" required>
                                            <label for="Phone">Phone</label>
                                        </div>

                                    </div>
                                </div>
                                <div class='row'>
                                    <div class='col-sm'>
                                        <select class="form-select " name='type' required aria-label="Default select example">
                                            <option selected>Type Of User</option>
                                            <option value="a">Administrator</option>
                                            <option value="t">Teacher</option>
                                            <option value="s">Student</option>
                                        </select>
                                    </div>
                                    <div class='col-sm'>
                                        <div class=" form-floating mb-3">
                                            <input type="password" class="form-control" name='hash' id="password" placeholder="Password" required>
                                            <label for="password">password</label>
                                        </div>
                                    </div>
                                </div>
                                <div class='log'>
                                    <span class='status text-success'></span>
                                    <span class='errors text-danger'></span>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- announcement modal -->
    <div class="modal fade" id="annoucementModal" tabindex="-1" aria-labelledby="annoucementModal" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Announcement Form</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="">
                        <div class='form-floating'>
                            <input type="text" class='form-control' name='body' id='announcement_body' autocomplete='off' placeholder="Announcement Text">
                            <label>Announcement Text</label>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success" data-bs-dismiss="modal" onclick="announce()">Submit</button>
                </div>
            </div>
        </div>
    </div>
    <script src="main.js"></script>
    <script>
        function announce() {
            let body = $('#announcement_body')[0].value;
            $.ajax({
                url: "user/make_announcement.php",
                method: 'POST',
                data: {
                    body: body
                },
                success: function(resp) {
                    console.log(resp);
                }
            })
        }
    </script>
</body>

</html>