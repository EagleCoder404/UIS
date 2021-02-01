<?php
include_once("header.php");
include_once("lemons.php");
session_start();

function home($user_type)
{
    if ($user_type == 'a') {
        header("location:admin/");
        die();
    } else if ($user_type == 's') {
        header('location:student/');
        die();
    } else if ($user_type == 't') {
        header('location:teacher/');
        die();
    } else {
        die("user type not found");
    }
}

if (isset($_SESSION['user_id']))
    home($_SESSION['type']);
$post = false;
if (isset($_POST['submit'])) {
    $user_id = $_POST['user_id'];
    $password = $_POST['password'];
    $cred = false;
    $post = true;
    $pdo = getCon();
    $statement = $pdo->prepare("select hash,type from account where user_id = ?");
    $result = $statement->execute([$user_id]);
    if ($statement->rowCount()) {
        $cred = true;
        $user_details = $statement->fetch();
        $correct_password = $user_details['hash'];
        $user_type = $user_details['type'];
        if ($correct_password == $password) {
            $cred = true;
            $_SESSION['user_id'] = $user_id;
            $_SESSION['type'] = $user_type;
            if ($user_type == 'a') {
                header("location:admin/");
                die();
            } else if ($user_type == 's') {
                header('location:student/');
                die();
            } else if ($user_type == 't') {
                header('location:teacher/');
                die();
            }
        } else
            $cred = false;
    } else
        $cred = false;
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
    <style>
        * {
            margin: 0px;
            padding: 0px;
            font-family: 'Raleway';
        }
    </style>
</head>

<body>
    <div class='container animate__animated animate__fadeInUp'>
        <div class=' mx-auto my-5 w-50 rounded border border-dark p-3'>
            <div class='d-flex flex-row mb-3 justify-content-center'>
                <div class=' mb-3 mx-2 px-3 display-4  rounded bg-primary text-light '>
                    UIS
                </div>
                <p class='display-4'>Login</p>
            </div>
            <form action="<?= $_SERVER['PHP_SELF'] ?>" method='post'>
                <?php
                if (!$cred && $post)
                    echo '<span class="text-danger">*User ID or Password Incorrect</span>';
                ?>
                <div class="form-floating mb-3">
                    <input type="text" class="form-control border-dark" name='user_id' id="user_id" placeholder="USER ID" required autocomplete="off">
                    <label for="user_id">USER ID</label>
                </div>
                <div class="form-floating mb-3">
                    <input type="password" class="form-control border-dark" name='password' id="floatingPassword" placeholder="Password" required autocomplete="off">
                    <label for="floatingPassword">Password</label>
                </div>
                <input type="submit" class="btn btn-success w-100" name='submit' value='Submit'>
            </form>
        </div>
    </div>
</body>

</html>/