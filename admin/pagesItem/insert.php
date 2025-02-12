<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $name = $_POST['name'];
    $desc = $_POST['description'];
    $price = $_POST['price'];
    $countryMade = $_POST['countryMade'];
    $status = $_POST['status'];
    $rating = $_POST['rating'];
    $catID = $_POST['secCategory'];
    $memberID = $_POST['secMember'];


    // ===========================
    //   --- ERRORS  ---
    // ===========================

    $errors['name'] = !empty(ErrorEmpty($name)) ? ErrorEmpty($name) : "";
    $errors['desc'] = !empty(ErrorEmpty($desc)) ? ErrorEmpty($desc) : "";
    $errors['price'] = !empty(ErrorEmpty($price)) ? ErrorEmpty($price) : "";
    $errors['countryMade'] = !empty(ErrorEmpty($countryMade)) ? ErrorEmpty($countryMade) : "";
    $errors['status'] = !empty(ErrorEmpty($status)) ? ErrorEmpty($status) : "";
    $errors['rating'] = !empty(ErrorEmpty($rating)) ? ErrorEmpty($rating) : "";
    $errors['catID'] = !empty(ErrorEmpty($catID)) ? ErrorEmpty($catID) : 0;
    $errors['memberID'] = !empty(ErrorEmpty($memberID)) ? ErrorEmpty($memberID) : 0;

    $errors = array_filter($errors);

    if (!empty($errors)) {
        $_SESSION['error'] = $errors;
        header('Location: http://localhost:3000/admin/items.php?do=add');
        exit();
    }

    //===================================
    // ----  conaction DATABASE  ----
    //===================================

    try {
        // التحقق من وجود عنصر مسبقًا
        $stmt = $con->prepare('SELECT itemsID FROM items WHERE Name = ? AND Description = ?');
        $stmt->execute([$name, $desc]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($result) {
            // إذا وجد سجل مسبق، لا تقم بالإدراج
            echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">
                      This item is pre-registered with the ID: <strong>' . $result['itemsID'] . '</strong>.
                      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                  </div>';

            // إضافة JavaScript لإعادة التوجيه عند إغلاق الرسالة
            echo '<script>
                      document.addEventListener("DOMContentLoaded", function() {
                          var alertElement = document.querySelector(".alert");
                          var closeButton = alertElement.querySelector(".btn-close");

                          closeButton.addEventListener("click", function() {
                              window.location.href = "http://localhost:3000/admin/items.php?do=add";
                          });
                      });
                  </script>';
        } else {
            // إذا لم يتم العثور على سجل مسبق، قم بالإدراج
            $stmt = $con->prepare('INSERT INTO items (Name, Description, Price, AddDate, CountryMade , Status, Rating, CatID, MemberID , Approve) 
                VALUES (?, ?, ?, NOW(), ?, ?, ?, ?, ? , 0)');
            $stmt->execute([$name, $desc, $price, $countryMade, $status, $rating, $catID, $memberID]);

            // الحصول على الـ ID الذي تم إنشاؤه تلقائيًا
            $id = $con->lastInsertId();
            $success = true;
        }
    } catch (PDOException $e) {
        die("A database error occurred: " . $e->getMessage());
    }
} else {
    $msg = "Not Found Insert Page";
    redirectHome(
        "<div class='alert alert-danger'><i class='fa-solid fa-circle-exclamation'> </i> $msg</div>",
        seconds: 6
    );
    exit();
}
?>
<style>
    strong {
        color: black;
    }
</style>

<?php if (isset($success) && $success): ?>
    <div class="container my-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow-lg bg-dark bg-gradient">
                    <!-- Card Header -->
                    <div class="card-header bg-success bg-gradient text-white">
                        <h1 class="h4 fw-bold mb-0">Item Details</h1>
                    </div>
                    <!-- Card Body -->
                    <div class="card-body p-4">
                        <!-- Display Item Details -->
                        <div class="mb-4">
                            <h2 class="h5 fw-bold text-white">Item Information</h2>
                            <ul class="list-group">
                                <li class="list-group-item"><strong>ID:</strong> <?= $id; ?></li>
                                <li class="list-group-item"><strong>Name:</strong> <?= $name; ?></li>
                                <li class="list-group-item"><strong>Description:</strong> <?= $desc; ?></li>
                                <li class="list-group-item"><strong>Price:</strong> <?= $price; ?></li>
                                <li class="list-group-item"><strong>Date:</strong> <?= date('Y-m-d H:i:s');  ?></li>
                                <li class="list-group-item"><strong>Status:</strong> <?= $status; ?></li>
                                <li class="list-group-item"><strong>Rating:</strong> <?= $rating; ?></li>
                                <li class="list-group-item"><strong>Category ID:</strong> <?= $catID; ?></li>
                                <li class="list-group-item"><strong>Member ID:</strong> <?= $memberID; ?></li>
                            </ul>
                        </div>
                        <!-- Back Button -->
                        <div class="d-grid mt-4">
                            <a href="http://localhost:3000/admin/items.php?do=add" class="btn w-50 btn-secondary btn-lg fw-bold text-white">Add Another Item</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>