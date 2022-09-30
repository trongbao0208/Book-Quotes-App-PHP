<?php
    $host = 'localhost';
    $data = 'book_quotes';
    $user = 'root';
    $pass = 'mysql';
    $chrs = 'utf8mb4';
    $attr = "mysql:host=$host;dbname=$data;charset=$chrs";
    $opts = 
    [
        PDO::ATTR_ERRMODE   => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false,
    ];
    error_reporting (E_ALL ^ E_NOTICE);

    //prevent SQL injection
    function get_post($pdo, $var){
        return $_POST[$var];
    };
?>