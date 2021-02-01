
function addUser(e) {
    let data = {}
    $('#addUser .status')[0].innerHTML = "";
    $('#addUser .errors')[0].innerHTML = "";

    $('form#addUser :input').each(function () {
        let input = $(this)[0];
        data[input.name] = input.value;
    })
    if(isNaN(data['phone_number']))
    {
        alert("phone number should only have numbers");
        return;
    }

    console.log(data);
    $.ajax({
        url: "user/add_user.php",
        data: data,
        method: 'POST',
        success: function (response) {
            let r = JSON.parse(response);
            console.log(r);
            if (r.status == 'failed') {
                let errors = r.errors;
                for (let i = 0; i < errors.length; i++)
                    $('#addUser .errors').append(`<span class='d-block'>${errors[i]}</span>`);
            }
            else if (r.status == 'success') {
                $('#addUser .status')[0].innerHTML = r.message;
            }
        }
    });
}

function searchUser() {
    let data = {}
    $('#searchUserDelete :input').each(function () {
        let input = $(this)[0];
        data[input.name] = input.value
    });
    console.log(data);
    $.ajax({
        url: "user/search_user.php",
        data: data,
        method: 'POST',
        success: function (response) {
            $(' .search-results-del')[0].innerHTML = "";

            console.log(response);
            let r = JSON.parse(response);
            console.log(r);

            for (let i = 0; i < r.data.length; i++) {
                let row = r.data[i];
                $(' .search-results-del').append(
                    `
                        <div class='row my-2'>
                            <div class='col'>
                                ${row['user_id']}
                            </div>
                            <div class='col'>
                                ${row['first_name']} ${row['middle_name']} ${row['last_name']}
                            </div>
                            <div class='col'>
                                <button class='btn btn-danger' onclick="deleteUser('${row['user_id']}');this.parentElement.parentElement.remove();alert('deleted')">Delete</button>
                            </div>
                        </div>
                    `
                );
            }
        }
    });
}


function deleteUser(user_id) {
    console.log(user_id);
    $.ajax({
        url: "user/delete_row.php",
        data: { search_param: "user_id", search_key: user_id, table_name: 'account' },
        method: 'POST',
        success: function (response) {
            if (response == '1')
                console.log('deleted');
            else
                console.log('not deleted');
        }
    });
}

function searchUserModify() {
    let data = {}
    $('#searchUserModify :input').each(function () {
        let input = $(this)[0];
        data[input.name] = input.value
    });
    console.log(data);
    $.ajax({
        url: "user/search_user.php",
        data: data,
        method: 'POST',
        success: function (response) {
            $('.search-results-mod')[0].innerHTML = "";

            console.log(response);
            let r = JSON.parse(response);
            console.log(r);

            for (let i = 0; i < r.data.length; i++) {
                let row = r.data[i];
                $('.search-results-mod').append(
                    `
                        <div class='row my-2'>
                            <div class='col'>
                                ${row['user_id']}
                            </div>
                            <div class='col'>
                                ${row['first_name']} ${row['middle_name']} ${row['last_name']}
                            </div>
                            <div class='col'>
                                <button class='btn btn-danger' onclick=getUserData("${row['user_id']}")>Modify</button>
                            </div>
                        </div>
                    `
                );
            }
        }
    });
}

function getUserData(user_id) {
    $.ajax({
        method: "post",
        data: { search_param: "user_id", search_key: user_id },
        url: "user/search_user.php",
        success: function (response) {
            console.log(response);
            let r = JSON.parse(response)
            let row = r.data[0];
            $('#modifyUserForm').toggleClass('d-none');
            $('#modifyUserForm :input').each(function () {
                let input = $(this)[0]
                input.value = row[input.name];

            })
        }
    });
}

function submitModifiedUser() {
    let data = {}
    $('#modifyUserForm .status')[0].innerHTML = "";
    $('#modifyUserForm .errors')[0].innerHTML = "";

    $('form#modifyUserForm :input').each(function () {
        let input = $(this)[0];
        data[input.name] = input.value;
    })
    console.log(data);
    $.ajax({
        url: "user/modify_user.php",
        data: data,
        method: 'POST',
        success: function (response) {
            console.log(response);
            let r = JSON.parse(response);
            console.log(r);
            if (r.status == 'failed') {
                let errors = r.errors;
                for (let i = 0; i < errors.length; i++)
                    $('#modifyUserForm .errors').append(`<span class='d-block'>${errors[i]}</span>`);
            }
            else if (r.status == 'success') {
                $('#modifyUserForm .status')[0].innerHTML = r.message;
            }
        }
    });
}