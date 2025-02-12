<?php
ob_start();
session_start();
if (isset($_SESSION['user'])) {
    $pageTitle = 'Categories';
    include 'init.php';
    $do = isset($_GET['do']) ? $_GET['do'] : 'manage';

    if ($do == 'manage') {
        include 'pagesCategorie/manage.php';
    } elseif ($do == 'add') {

        include 'pagesCategorie/add.php';
    } elseif ($do == 'insert') {

        include 'pagesCategorie/insert.php';
    } elseif ($do == 'edit') {

        include 'pagesCategorie/validEdit.php';
    } elseif ($do == 'update') {

        include 'pagesCategorie/update.php';
    } elseif ($do == 'delete') {

        include 'pagesCategorie/delete.php';
    } elseif ($do == 'active') {

        include 'pagesCategorie/active.php';
    } elseif ($do == 'all_comments') {

        include 'pagesCategorie/all_comments.php';
    }
    include $tpl . 'footer.php';
} else {
    header('location: index.php');
}
ob_end_flush();
