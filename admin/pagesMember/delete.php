<!-- page DELETE -->
<?php
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['id'])) {

    $userid = (is_numeric($_GET['id']) && intval($_GET['id'])) ? $_GET['id'] : 0;

    $check = checkItem('userid', 'users', $userid);
    if ($check > 0) {

        $stmt = $con->prepare('DELETE FROM users WHERE UserID = :zuserid');
        $stmt->bindParam('zuserid', $userid);
        $stmt->execute();
        header('location: members.php');
        exit();
    } else {
        echo '
            <div class="alert alert-danger d-flex align-items-center" role="alert">
                <i class="fa-solid fa-circle-exclamation me-2 text-center"></i>
                <div class="">
                    Not Found Member
                </div>
            </div>';
    }
}
