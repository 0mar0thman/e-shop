<?php
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['itemid'])) {
    $itemsid = (is_numeric($_GET['itemid']) && intval($_GET['itemid'])) ? $_GET['itemid'] : 0;

    $check = checkItem('itemsID', 'items', $itemsid);
    if ($check > 0) {
        $stmt = $con->prepare('DELETE FROM items WHERE itemsID = :zitemsid');
        $stmt->bindParam('zitemsid', $itemsid);
        $stmt->execute();

        header('location: items.php');
        exit();
    } else {
        echo '
            <div class="alert alert-danger d-flex align-items-center" role="alert">
                <i class="fa-solid fa-circle-exclamation me-2 text-center"></i>
                <div class="">
                    Not Found items
                </div>
            </div>';
    }
}
