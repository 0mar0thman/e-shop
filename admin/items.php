<?php
ob_start();
session_start();
if (isset($_SESSION['user'])) {
    $pageTitle = 'Items';
    include 'init.php';
    $do = isset($_GET['do']) ? $_GET['do'] : 'manage';

    if ($do == 'manage') {
        include 'pagesItem/manage.php';
    } elseif ($do == 'add') {

        include 'pagesItem/add.php';
    } elseif ($do == 'insert') {

        include 'pagesItem/insert.php';
    } elseif ($do == 'edit') {

        include 'pagesItem/validEdit.php';
    } elseif ($do == 'update') {

        include 'pagesItem/update.php';
    } elseif ($do == 'delete') {

        include 'pagesItem/delete.php';
    } elseif ($do == 'approve') {

        include 'pagesItem/approve.php';
    } elseif ($do == 'all_comments') {

        include 'pagesItem/all_comments.php';
    }
    include $tpl . 'footer.php';
} else {
    header('location: index.php');
}
ob_end_flush();
?>