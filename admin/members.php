<?php
ob_start();
session_start();
if (isset($_SESSION['user'])) {
    $pageTitle = 'Members';
    include 'init.php';
    $do = isset($_GET['do']) ? $_GET['do'] : 'manage';

    if ($do == 'manage') {
        include 'pagesMember/manage.php';
    } elseif ($do == 'add') {

        include 'pagesMember/add.php';
    } elseif ($do == 'insert') {

        include 'pagesMember/insert.php';
    } elseif ($do == 'edit') {

        include 'pagesMember/validEdit.php';
    } elseif ($do == 'update') {

        include 'pagesMember/update.php';
    } elseif ($do == 'delete') {

        include 'pagesMember/delete.php';
    } elseif ($do == 'active') {

        include 'pagesMember/active.php';
    } elseif ($do == 'all_comments') {

        include 'pagesMember/all_comments.php';
    }
    include $tpl . 'footer.php';
} else {
    header('location: index.php');
}
ob_end_flush();