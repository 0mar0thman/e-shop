<?php
$dsn = 'mysql:host=localhost;dbname=shop';
$username = 'root';
$password = '';
$option = array(
    PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'
);
try {
    $con = new PDO($dsn, $username, $password, $option);
    $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException) {
    echo 'Failed to Connect' . $e->getMessage();
}
