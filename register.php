<?php
require_once 'required.php';
try {
    $pdo = new PDO($attr, $user, $pass, $opts);
} catch (PDOException $e) {
    throw new PDOException($e->getMessage(), (int)$e->getCode());
}

// check to see if there is a user already logged in, if so redirect them 
session_start();
if (isset($_SESSION['email']) && isset($_SESSION['userID'])) {
    header("Location: ./index.php");  // redirect the user to the home page
}

// When the register button is clicked
if (isset($_POST['registerBtn'])) {
    $email = get_post($pdo, 'email');
    $password = get_post($pdo, 'password');
    $retype_password = get_post($pdo, 'retype-password');
    // verify all the required form data was entered
    if ($email != "" && $password != "" && $retype_password != "") {
        // make sure the two passwords match
        if ($password === $retype_password) {
            // make sure the password meets the min strength requirements
            if (strlen($password) >= 5 && strpbrk($password, "!#$.,:;()") != false) {
                $stmt = $pdo->prepare("SELECT * FROM users WHERE email= ?");
                $stmt->bindParam(1, $email, PDO::PARAM_STR);
                $stmt->execute();

                if ($stmt->rowCount() == 0) {
                    //hash the password
                    $password_hash = password_hash($password, PASSWORD_DEFAULT);

                    // Insert the record to data base
                    $stmt = $pdo->prepare("INSERT INTO users VALUES (NULL, ?, ?)");
                    $stmt->bindParam(1, $email, PDO::PARAM_STR);
                    $stmt->bindParam(2, $password_hash, PDO::PARAM_STR);
                    $result = $stmt->execute();

                    // Check if the record has been created
                    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
                    $stmt->bindParam(1, $email, PDO::PARAM_STR);
                    $stmt->execute();
                    if ($stmt->rowCount() == 1) {
                        /* IF WE ARE HERE THEN THE ACCOUNT WAS CREATED! YAY! */
                        $success = true;
                    } else {
                        $error_msg = 'An error occurred and your account was not created.';
                    }
                } else {
                    $error_msg = "There is already an account assiciated with this email, please try again.";
                }
            } else
                $error_msg = 'Please make sure your password is at least 5 characters long and include a special character';
        } else
            $error_msg = 'Your passwords did not match.';
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
    <title>Registration Page</title>
    <link rel="stylesheet" href="./css/bootstrap.css">
</head>

<body>
    <div class="container vh-100">

        <div class="row justify-content-center h-100">
            <div class="card w-50 my-auto shadow">
                <div class="card-header text-center bg-success text-white ">
                    <h2>Registration</h2>
                </div>
                <div class="card-body">
                    <?php
                    // check to see if the user successfully created an account 
                    if (isset($success) && $success == true) {
                        echo '<font color="green">Yay!! Your account has been created. <a href="./loginPage.php">Click here</a> to login!<font>';
                    }
                    // check to see if the error message is set, if so display it 
                    else if (isset($error_msg))
                        echo '<font color="red">' . $error_msg . '</font>';
                    else
                        echo ''; // do nothing
                    ?>
                    <form action="register.php" method="post">

                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" id="email" class="form-control" name="email">
                        </div>

                        <div class="form-group">
                            <label for="password">Password</label>
                            <input type="password" id="password" class="form-control" name="password">
                        </div>
                        <div class="form-group">
                            <label for="retype-password">Retype Password</label>
                            <input type="password" id="retype-password" class="form-control" name="retype-password">
                        </div>
                        <input type="submit" name="registerBtn" class="btn btn-success w-100 mt-3" value="Register">
                        <p>
                            Already had an account? <a href="loginPage.php">Login here</a>
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