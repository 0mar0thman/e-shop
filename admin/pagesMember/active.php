<?php
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['id'])) {

    $userid = (is_numeric($_GET['id']) && $_GET['id'] > 0) ? intval($_GET['id']) : 0;

    Admin();

    if ($userid > 0) {
        $stmt = $con->prepare('SELECT COUNT(*) FROM users WHERE UserID = ?');
        $stmt->execute(array($userid));
        $check = $stmt->fetchColumn();

        if ($check > 0) {
            // تحديث حالة المستخدم
            $stmt = $con->prepare('UPDATE users SET RagStatus = 1 WHERE UserID = ?');
            $stmt->execute(array($userid));

            redirectBack();
        } else {
            echo '
                <div class="alert alert-danger d-flex align-items-center" role="alert">
                    <i class="fa-solid fa-circle-exclamation me-2 text-center"></i>
                    <div class="">
                        Not Found Member
                    </div>
                </div>';
        }
    } else {
        echo '
            <div class="alert alert-danger d-flex align-items-center" role="alert">
                <i class="fa-solid fa-circle-exclamation me-2 text-center"></i>
                <div class="">
                    Invalid User ID
                </div>
            </div>';
    }
}
