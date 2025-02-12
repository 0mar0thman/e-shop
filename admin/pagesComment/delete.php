<?php
if ($_GET['do'] == 'delete' && isset($_GET['comid'])) {

    $comid = isset($_GET['comid']) && is_numeric($_GET['comid']) ? intval($_GET['comid']) : 0;
    $check = checkItem('CID', 'comments', $comid);
    if ($check > 0) {

        $stmt = $con->prepare('DELETE FROM comments WHERE CID = ?');
        $stmt->execute([$comid]);

        if ($stmt->rowCount() > 0) {
            redirectBack();
        } else {
            echo 'Error: Comment not found.';
        }
    } else {
        echo 'Error: Invalid comment ID.';
    }
}
