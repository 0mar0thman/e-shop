<?php
// include '../../connect.php';
function getTitle()
{
    echo isset($GLOBALS['pageTitle']) ? $GLOBALS['pageTitle'] : 'no title';
}

function redirectHome($theMag, $url = 'index.php', $seconds = 3)
{
    echo $theMag;
    echo "<div class='alert alert-info container'>You Will Be Redirected to HomePage After $seconds Seconds</div>";
    header("refresh: $seconds; url= $url");
    exit();
}

function checkItem($select, $from, $value)
{
    global $con;
    $stmt = $con->prepare("SELECT $select FROM $from WHERE $select = ?");
    $stmt->execute(array($value));
    $count = $stmt->rowCount();

    return $count;
}

// ============================================
// Dashboard / Total Members
// ============================================

function totalMembers($col, $table)
{
    global $con;
    $stmt2 = $con->prepare("SELECT COUNT($col) FROM $table");
    $stmt2->execute();
    return $stmt2->fetchColumn();
}

// ============================================
// Dashboard / latest items
// ============================================

function getLatest($select, $table, $order, $limit = 10)
{
    global $con;
    $stmt = $con->prepare("SELECT $select FROM $table ORDER BY $order DESC LIMIT $limit");
    $stmt->execute();
    return $stmt->fetchAll(); 
}

// ============================================
// Errors Empty 
// ============================================

function ErrorEmpty($var)
{
    $error = [];
    if (empty($var)) {
        $error = "<div class='d-flex align-items-center justify-content-center gap-1'>
                     <i class='fa-solid fa-circle-exclamation'></i> <span> cannot be empty</span>
                  </div>";
    }
    return $error;
}

// تقوم باسترجاع جميع المستخدمين الذين لديهم RagStatus = 0.

function getPendingUsers()
{
    global $con;
    $stmt = $con->prepare("SELECT * FROM users WHERE RagStatus = 0 ORDER BY UserID DESC");
    $stmt->execute();
    return $stmt->fetchAll();
}

// تقوم باسترجاع جميع الـ Items التي لديها Approve = 0.

function getPendingItems()
{
    global $con;
    $stmt = $con->prepare("SELECT * FROM items WHERE Approve = 0 ORDER BY itemsID DESC");
    $stmt->execute();
    return $stmt->fetchAll();
}

// تقوم باسترجاع جميع الـ comments التي لديها Approve = 0.

function getPendingComments()
{
    global $con;
    $stmt = $con->prepare("SELECT comments.*, items.Name, users.Username
                       FROM comments
                       INNER JOIN items ON items.itemsID = comments.ItemID
                       INNER JOIN users ON users.UserID = comments.UserID 
                       ORDER BY comments.Status DESC

                       ");
    $stmt->execute();
    return $stmt->fetchAll();
}


// ======== back page ===============

function redirectBack()
{
    if (isset($_SERVER['HTTP_REFERER'])) {
        header('Location: ' . $_SERVER['HTTP_REFERER']);
    } else {
        // إذا لم يكن هناك صفحة سابقة، يتم التوجيه إلى الصفحة الرئيسية
        header('Location: index.php');
    }
    exit();
}

// ================= REFRESH ======================

function refreshPage()
{
    echo "<script>location.reload();</script>";
    exit;
}


// =========== valid in ADMIN or not =================

function Admin()
{
    global $con;

    $stmt = $con->prepare("SELECT AdminID FROM users WHERE UserID = :userID"); // تأكد من أنك تستخدم الـ UserID المناسب
    $stmt->bindParam(':userID', $_SESSION['id']);
    $stmt->execute();
    $rows = $stmt->fetch();

    if ($rows['AdminID'] == 0) {
        echo '<h6 class="alert alert-danger d-flex align-items-center"><i class="fa-solid fa-circle-exclamation me-2 text-center"></i> You are not allowed to modify another user\'s data.</h6>';
        exit();
    }
}
