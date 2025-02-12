<?php
// ============================================
// Page Title Display Function
// ============================================
function displayPageTitle() // Old: getTitle
{
    global $pageTitle;
    echo isset($pageTitle) ? $pageTitle : 'no title';
}

// ============================================
// Category Retrieval Functions
// ============================================
function retrieveAllCategories() // Old: getCat
{
    global $con;
    $stmt = $con->prepare('SELECT * FROM categories');
    $stmt->execute();
    return $stmt->fetchAll();
}

function retrieveCategoryById($CID) // Old: getCatCID
{
    global $con;
    $stmt = $con->prepare('SELECT * FROM categories WHERE ID = ?');
    $stmt->execute(array($CID));
    return $stmt->fetchAll();
}

// ============================================
// User Management Functions
// ============================================
function fetchUserByUsername($Username) // Old: getUsers
{
    global $con;
    $stmt = $con->prepare('SELECT * FROM users WHERE Username = ?');
    $stmt->execute(array($Username));
    return $stmt->fetch();
}

// ============================================
// Item Management Functions
// ============================================
function fetchItemsByCategoryId($itemid) // Old: getItemID
{
    global $con;
    $stmt = $con->prepare('SELECT items.*, categories.Name AS Cat_Name, users.Username AS User_Name
                      FROM items
                      INNER JOIN categories ON categories.ID = items.CatID
                      INNER JOIN users ON users.UserID = items.MemberID
                      WHERE items.CatID = ?
                      ORDER BY itemsID DESC');
    $stmt->execute(array($itemid));
    return $stmt->fetchAll() ?: [];
}

function fetchUserItemsByUserId($userid) // Old: getUserItem
{
    global $con;
    $stmt = $con->prepare('SELECT users.Username, users.UserID, items.*,items.Name AS ItemName, categories.Name
                           FROM items
                           INNER JOIN users ON users.UserID = items.MemberID
                        --    INNER JOIN comments ON comments.UserID = users.UserID
                           INNER JOIN categories ON categories.ID = items.CatID
                           WHERE users.UserID = ?');
    $stmt->execute(array($userid));
    return $stmt->fetchAll() ?: [];
}

function fetchCategoryItemsByCategoryId($catID) // Old: getItemCat
{
    global $con;
    $stmt = $con->prepare('SELECT items.*, categories.Name AS Cat_Name, users.Username AS User_Name
                          FROM items
                          INNER JOIN categories ON categories.ID = items.CatID
                          INNER JOIN users ON users.UserID = items.MemberID
                          WHERE items.CatID = ?
                          ORDER BY itemsID DESC');
    $stmt->execute(array($catID));
    return $stmt->fetchAll() ?: [];
}

// ============================================
// Comment Management Functions
// ============================================
function countUserComments($UserID) // Old: CommentsUser
{
    global $con;
    $stmt = $con->prepare("SELECT Comment FROM comments WHERE UserID = ?");
    $stmt->execute(array($UserID));
    return $stmt->rowCount();
}

function addNewComment($Comment, $ItemID, $UserID) // Old: insertComments
{
    global $con;
    $stmt = $con->prepare("INSERT INTO comments(Comment, itemID, Status, CommentDate, UserID) 
                         VALUES (?, ?, 1, NOW(), ?)");
    $stmt->execute([$Comment, $ItemID, $UserID]);
}

function addNewUser($User, $Pass, $Email, $fullName) // Old: insertUsers
{
    global $con;
    $stmt = $con->prepare("INSERT INTO users(Username, Password, Email , FullName, GroupID, AdminID , RagStatus, Date) 
                         VALUES (? ,? , ?, ? , 1 ,0 ,0 , NOW())");
    $stmt->execute([$User, $Pass, $Email, $fullName]);
}

// ============================================
// Item Detail Functions
// ============================================
function fetchItemDetailsWithComments($id) // Old: getItemDetails
{
    global $con;
    $stmt = $con->prepare("SELECT 
                               items.itemsID,
                               items.Name AS ItemName,
                               items.Description AS ItemDescription,
                               items.Price,
                               items.AddDate AS ItemAddDate,
                               items.Status AS ItemStatus,
                               items.Rating,
                               items.CountryMade,
                               items.CatID,
                               categories.Name AS CategoryName,
                               categories.Description AS CategoryDescription,
                               users.Username AS Author
                           FROM items
                           INNER JOIN categories ON categories.ID = items.CatID
                           INNER JOIN users ON users.UserID = items.MemberID
                           WHERE items.itemsID = ?;
");
    $stmt->execute([$id]);
    $item = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$item) {
        return null;
    }
    $stmtComments = $con->prepare("SELECT 
                                       CID AS CommentID,
                                       Comment AS CommentText,
                                       CommentDate,
                                       UserID,
                                    Status,
                                   (SELECT Username FROM users WHERE UserID = comments.UserID) AS CommentAuthor
                                    FROM comments
                                    WHERE itemID = ?
                                    ORDER BY CommentDate DESC;
     ");
    $stmtComments->execute([$id]);
    $comments = $stmtComments->fetchAll(PDO::FETCH_ASSOC);

    $item['comments'] = $comments;

    return $item;
}


// ============================================
// fetch Comments With User
// ============================================

function fetchCommentsWithUser($UserID)
{
    global $con;
    $stmt = $con->prepare("SELECT * FROM comments WHERE UserID = ?");
    $stmt->execute([$UserID]);
    return $stmt->fetchAll();
}



// ============================================
// DELETE COMMENTS
// ============================================
function deleteComments($ID)
{
    global $con;
    $stmt = $con->prepare("DELETE FROM comments WHERE CID = ?");
    $stmt->execute([$ID]);

    // تحقق من نجاح الحذف
    if ($stmt->rowCount() > 0) {
        return true;  // تم الحذف بنجاح
    } else {
        return false; // لم يتم العثور على التعليق للحذف
    }
    return $stmt->fetchAll();
}

// ============================================
// User Authentication Functions
// ============================================
function checkUserActivationStatus($user) // Old: activeMember
{
    global $con;
    $stmt = $con->prepare("SELECT Username FROM users WHERE Username = ? AND RagStatus = 0");
    $stmt->execute(array($user));
    return $stmt->rowCount();
}

function checkUserActivationStatusFetch($user)
{
    global $con;
    $stmt = $con->prepare("SELECT Username FROM users WHERE Username = ? AND RagStatus = 0");
    $stmt->execute([$user]);
    return $stmt->fetch(PDO::FETCH_ASSOC); // بدلاً من rowCount()
}

// ============================================
// System Functions
// ============================================
function redirectToHomepageWithMessage($theMag, $url = 'index.php', $seconds = 3) // Old: redirectHome
{
    echo $theMag;
    echo "<div class='alert alert-info container'>You Will Be Redirected to HomePage After $seconds Seconds</div>";
    header("refresh: $seconds; url= $url");
    exit();
}

function verifyItemExistence($select, $from, $value) // Old: checkItem
{
    global $con;
    $stmt = $con->prepare("SELECT $select FROM $from WHERE $select = ?");
    $stmt->execute(array($value));
    return $stmt->rowCount();
}

// ============================================
// Statistical Functions
// ============================================
function countTableRecords($col, $table) // Old: totalMembers
{
    global $con;
    $stmt2 = $con->prepare("SELECT COUNT($col) FROM $table");
    $stmt2->execute();
    return $stmt2->fetchColumn();
}

// ============================================
// Validation Functions
// ============================================
function generateEmptyFieldError($var) // Old: ErrorEmpty
{
    return empty($var) ? "<div class='d-flex align-items-center justify-content-center gap-1'>
                        <i class='fa-solid fa-circle-exclamation'></i> <span> cannot be empty</span>
                    </div>" : '';
}

// ============================================
// Moderation Functions
// ============================================
function retrievePendingRegistrationUsers() // Old: getPendingUsers
{
    global $con;
    $stmt = $con->prepare("SELECT * FROM users WHERE RagStatus = 0 ORDER BY UserID DESC");
    $stmt->execute();
    return $stmt->fetchAll();
}

function retrieveUnapprovedItems() // Old: getPendingItems
{
    global $con;
    $stmt = $con->prepare("SELECT * FROM items WHERE Approve = 0 ORDER BY itemsID DESC");
    $stmt->execute();
    return $stmt->fetchAll();
}

function retrieveAllCommentsWithStatus() // Old: getPendingComments
{
    global $con;
    $stmt = $con->prepare("SELECT comments.*, items.Name, users.Username
                        FROM comments
                        INNER JOIN items ON items.itemsID = comments.ItemID
                        INNER JOIN users ON users.UserID = comments.UserID 
                        ORDER BY comments.Status DESC");
    $stmt->execute();
    return $stmt->fetchAll();
}

// ============================================
// Navigation Functions
// ============================================
function redirectToPreviousPage() // Old: redirectBack
{
    header('Location: ' . ($_SERVER['HTTP_REFERER'] ?? 'index.php'));
    exit();
}

function reloadCurrentPage() // Old: refreshPage
{
    echo "<script>location.reload();</script>";
    exit;
}

// ============================================
// Privilege Validation Functions
// ============================================
function validateAdminPrivileges() // Old: Admin
{
    global $con;
    $stmt = $con->prepare("SELECT AdminID FROM users WHERE UserID = :userID");
    $stmt->bindParam(':userID', $_SESSION['id']);
    $stmt->execute();
    $rows = $stmt->fetch();

    if ($rows['AdminID'] == 0) {
        echo '<h6 class="alert alert-danger d-flex align-items-center"><i class="fa-solid fa-circle-exclamation me-2 text-center"></i> You are not allowed to modify another user\'s data.</h6>';
        exit();
    }
}
