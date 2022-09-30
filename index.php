<?php
session_start();
if (!isset($_SESSION['email']) && !isset($_SESSION['userID'])) {
    header("Location: ./loginPage.php");
}

if (isset($_POST['logoutBtn'])) {
    session_destroy();
    header("Location: ./loginPage.php");
}

//  /* IF YOU ARE HERE THEN THE USER IS LOGGED IN, AND WE CAN LOG THEM OUT */
//  session_destroy();

//  redirect to the home page
//  header("Location: ./index.php");
//  }
//  else
//  header("Location: ./loginPage.php"); // redirect the user to




?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quotes Awesome!</title>
    <link rel="stylesheet" href="./css/bootstrap.css">
    <link rel="stylesheet" href="./css/styles.css">

</head>

<body>

    <nav class="navbar sticky-top navbar-expand-sm navbar-dark bg-primary">
        <a href="#" class="navbar-brand mb-1 h1">
            <img class="mx-2" src="./pics/logo blue.jpg" alt="Logo" width="60" height="60">
            Quotes Awesome
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" class="navbar-toggler" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item active">
                    <a href="#" class="nav-link active">
                        Home
                    </a>
                </li>
                <li class="nav-item active">
                    <a href="#" class="nav-link">
                        Books
                    </a>
                </li>
                <li class="nav-item active">
                    <a href="#" class="nav-link">
                        Quotes
                    </a>
                </li>
            </ul>
        </div>

    </nav>



    <div class="container" >
        <div id="title" class="center">
            <h1 id="header" class="text-center mt-5">Book Finder</h1>
            <div class="row">
                <div id="input" class="input-group mx-auto col-lg-6 col-md-8 col-sm-12">
                    <input id="search-box" type="text" class="form-control" placeholder="Search Books!...">
                    <button id="search" class="btn btn-primary" onclick="">Search</button>
                </div>
            </div>
        </div>
        <div class="book-list">
            <h2 class="text-center">Search Result</h2>
            <div id="list-output" class="">
                <div class="container">
                    <div class="row ">
                    <p>Test</p>

                    </div>
                </div>
                

            </div>
        </div>
    </div>

    <form action="index.php" method="post">
        <input type="submit" class="btn btn-danger w-100 mt-3" value="Log out" name="logoutBtn">
    </form>

<script src="https://code.jquery.com/jquery-3.6.1.min.js"></script>
<script src="./js/app.js"></script>
</body>

</html>