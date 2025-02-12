<?php

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['catid'])) {
    $catid = filter_var($_GET['catid'], FILTER_VALIDATE_INT) ?: 0;

    $check = checkItem('ID', 'categories', $catid);
    if ($check > 0) {
        try {
            $stmt = $con->prepare('DELETE FROM categories WHERE ID = :zcatid');
            $stmt->bindParam('zcatid', $catid);
            $stmt->execute();

            // إضافة رسالة نجاح
            $_SESSION['success'] = 'Category deleted successfully!';
            
            header('location: ' . ($_SERVER['HTTP_REFERER'] ?? 'categories.php'));
            exit();
        } catch (PDOException $e) {
            echo '<div class="alert alert-danger">Error deleting category: ' . $e->getMessage() . '</div>';
        }
    } else {
        echo '
            <div class="alert alert-danger d-flex align-items-center" role="alert">
                <i class="fa-solid fa-circle-exclamation me-2 text-center"></i>
                <div>
                    Not Found Categories. <a href="categories.php">Return to Categories</a>
                </div>
            </div>';
    }
}


?>
