<?php
$catid = isset($_GET['catid']) ? filter_var($_GET['catid'], FILTER_VALIDATE_INT) : 0;

if ($catid === false || $catid <= 0) {
    header('Location: '  . $_SERVER['PHP_SELF'] . '?do=add');
    exit();
}

$stmt = $con->prepare("SELECT * FROM categories WHERE ID = ?");
$stmt->execute([$catid]);
$cat = $stmt->fetch();
$count = $stmt->rowCount();

if ($count < 1) {
    echo '<h6 class="alert alert-danger d-flex align-items-center">
                <i class="fa-solid fa-circle-exclamation me-2 text-center"></i>
                You are not allowed to modify another user\'s data.
              </h6>';
    exit();
}

include 'pagesCategorie/edit.php';
