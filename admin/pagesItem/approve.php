<?php
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['itemid'])) {

    $itemid = (is_numeric($_GET['itemid']) && $_GET['itemid'] > 0) ? intval($_GET['itemid']) : 0;

    $check = checkItem('itemsID', 'items', $itemid);

    Admin();

    if ($check > 0) {
        $stmt = $con->prepare('UPDATE items SET Approve = 1 WHERE itemsID = ?');
        $stmt->execute(array($itemid));

        redirectBack();
    } else {
        echo '
                <div class="alert alert-danger d-flex align-items-center" role="alert">
                    <i class="fa-solid fa-circle-exclamation me-2 text-center"></i>
                    <div class="">
                        Not Found approve
                    </div>
                </div>';
    }
}
