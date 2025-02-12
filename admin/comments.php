<style>
    .ml1 {
        margin-left: 4px;
    }
</style>
<?php
ob_start();
session_start();

if (isset($_SESSION['user'])) {
    $pageTitle = 'Comments';
    include 'init.php';
    $do = isset($_GET['do']) ? $_GET['do'] : 'manage';
    if ($do == 'delete') {

        include 'pagesComment/delete.php';
    } elseif ($do == 'manage') {

        include 'pagesComment/manage.php';
    } elseif ($do == 'edit') {

        include 'pagesComment/edit.php';
    } elseif ($do == 'update') {

        include 'pagesComment/update.php';
    } elseif ($do == 'approve') {

        include 'pagesComment/approve.php';
    } elseif ($do == 'all_comments') {

        include 'pagesComment/all_comments.php';
    }
    include $tpl . 'footer.php';
} else {
    header('location: index.php');
}
ob_end_flush();
?>