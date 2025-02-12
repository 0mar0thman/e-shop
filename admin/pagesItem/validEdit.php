<!-- page validEdit -->
<?php
if (!isset($_SESSION['id'])) {
    echo '<h4 class="text-center mt-5">You must log in first.</h4>';
    exit();
}

$itemid = is_numeric($_GET['itemid']) && intval($_GET['itemid']) ? $_GET['itemid'] : 0;

Admin();

$stmt = $con->prepare("SELECT items.* , categories.Name AS Cat_Name ,users.Username as User_Name FROM items 
                         INNER JOIN categories ON categories.ID = items.CatID
                         INNER JOIN users ON users.UserID = items.MemberID
                         WHERE itemsID = ?");

$stmt->execute(array($itemid));
$rows = $stmt->fetch();
$count = $stmt->rowCount();


if ($count > 0) {
    include 'pagesItem/edit.php';
} else {
    echo '<h4 class="text-center mt-5">This user does not exist.</h4>';
}
