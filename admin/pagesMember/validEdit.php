<?php
if (!isset($_SESSION['id'])) {
    echo '<h4 class="text-center mt-5">You must log in first.</h4>';
    exit();
}

$userid = (is_numeric($_GET['id']) && intval($_GET['id'])) ? $_GET['id'] : 0;

Admin();

$stmt = $con->prepare("SELECT * FROM users WHERE UserID = ? LIMIT 1");
$stmt->execute(array($userid));
$rows = $stmt->fetch();
$count = $stmt->rowCount();

if ($count > 0) {
    include 'pagesMember/edit.php';
} else {
    echo '<h4 class="text-center mt-5">This user does not exist.</h4>';
}
