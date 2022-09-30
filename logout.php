<?php // sqltest.php
require_once 'required.php';
try
{
$pdo = new PDO($attr, $user, $pass, $opts);
}
catch (PDOException $e)
{
throw new PDOException($e->getMessage(), (int)$e->getCode());
}

    // verify the user is logged in
    session_start();
    if (isset($_SESSION['email']) && isset($_SESSION['userID'])){
    
    /* IF YOU ARE HERE THEN THE USER IS LOGGED IN, AND WE CAN LOG THEM OUT */
    session_destroy();
    
    // redirect to the home page
    header("Location: ./index.php");
    }
    else
    header("Location: ./loginPage.php"); // redirect the user to the login page
?>