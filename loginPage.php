<?php
require_once 'required.php';
try {
    $pdo = new PDO($attr, $user, $pass, $opts);
} catch (PDOException $e) {
    throw new PDOException($e->getMessage(), (int)$e->getCode());
}
session_start();
if (isset($_SESSION['email']) && isset($_SESSION['userID']))
    header("Location: ./index.php"); // redirect the user to the home page

if (isset($_POST['loginBtn'])) {
    $email = get_post($pdo, 'email');
    $password = get_post($pdo, 'password');

    // make sure the required fields were entered
    if ($email != "" && $password != "") {
        // query the database to see if the email exists
        $stmt = $pdo->prepare('SELECT * FROM users WHERE email= ?');
        $stmt->bindParam(1, $email, PDO::PARAM_STR);
        $stmt->execute();

        if ($stmt->rowCount() == 1) {
            $record = $stmt->fetch();
            $returnedpw = $record['password'];
            if (password_verify($password, $returnedpw)) {
                $_SESSION['email'] = $record['email'];
                $_SESSION['userID'] = $record['userID'];

                $success = true;

                // redirect the user to the home page
                header("Location: ./index.php");
            } else {
                $error_msg = 'Your password was incorrect.';
            }
        } else {
            $error_msg = 'That account does not exist.';
        }
    } else
        $error_msg = 'Please fill out all required fields.';
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <link rel="stylesheet" href="./css/bootstrap.css">
</head>

<body>
    <div class="container vh-100">

        <div class="row justify-content-center h-100">
            <div class="card w-50 my-auto shadow">
                <div class="card-header text-center bg-primary text-white ">
                    <h2>Welcome to Quotes Awesome!</h2>
                </div>
                <div class="card-body">

                    <?php
                    // check to see if the user successfully logged in
                    if (isset($success) && $success = true) {
                        echo '<font color="green">You have logged in. Please go to the <a href="./index.php">home page</a>.<font>';
                    }
                    // check to see if the error message is set, if so display it
                    else if (isset($error_msg))
                        echo $test;
                    echo '<font color="red">' . $error_msg . '</font>';
                    ?>

                    <form action="loginPage.php" method="post">

                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" id="email" class="form-control" name="email">
                        </div>

                        <div class="form-group">
                            <label for="password">Password</label>
                            <input type="password" id="password" class="form-control" name="password">
                        </div>
                        <input type="submit" name="loginBtn" class="btn btn-primary w-100 mt-3" value="Login">
                        <p>
                            Don't have an account? <a href="./register.php">Register here</a>
                        </p>
                    </form>
                </div>
                <div class="card-footer text-right">
                    <small>&copy; Trong Bao</small>
                </div>
            </div>
        </div>
    </div>
</body>

</html>