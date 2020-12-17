<?php
include_once("header.php");
include_once("lemons.php");
session_start();
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
            if($user_type=='a')
            {
                header("location:admin/");
                die();
            }
            else if($user_type=='s')
            {
                header('location:student/');
                die();
            }
            else if ($user_type=='t') {
                header('location:teacher/');
                die();
            }
        } else
            $cred = false;
    } else
        $cred = false;
    echo var_dump($cred);
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
    <div class='container-fluid align-middle'>
        <div class='row justify-content-end '>
            <div class='col-xl-8 '>

            </div>
            <div class='col-xl-4 mx-xl-4 mx-auto w-md-50 border border-dark p-3'>
                <div class='display-4'>
                    Login
                </div>
                <form action="<?= $_SERVER['PHP_SELF'] ?>" method='post'>
                    <?php
                        if(!$cred && $post)
                            echo '<span class="text-danger">*User ID or Password Incorrect</span>';
                    ?>
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" name='user_id' id="user_id" placeholder="USER ID" required>
                        <label for="user_id">USER ID</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="password" class="form-control" name='password' id="floatingPassword" placeholder="Password" required>
                        <label for="floatingPassword">Password</label>
                    </div>
                    <input type="submit" class="btn btn-success btn-lg" name='submit' value='Submit'>
                </form>
            </div>
        </div>
    </div>
</body>

</html>/