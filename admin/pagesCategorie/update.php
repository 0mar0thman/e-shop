<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    // جلب معرّف الفئة من النموذج
    $catid = isset($_POST['catid']) ? intval($_POST['catid']) : 0;

    $name = $_POST['name'];
    $desc = $_POST['description'];
    $price = $_POST['price'];
    $quantity = $_POST['quantity'];
    $visibility = $_POST['visibility'];


    // ===========================
    //   --- ERRORS  ---
    // ===========================

    $errors['name'] = !empty(ErrorEmpty($name)) ? ErrorEmpty($name) : " ";
    $errors['desc'] = !empty(ErrorEmpty($desc)) ? ErrorEmpty($desc) : " ";
    $errors['price'] = !empty(ErrorEmpty($price)) ? ErrorEmpty($price) : 0;
    $errors['quantity'] = !empty(ErrorEmpty($quantity)) ? ErrorEmpty($quantity) : 0;
    $errors['visibility'] = !empty(ErrorEmpty($visibility)) ? ErrorEmpty($visibility) : 0;

    if (!empty($error)) {
        $_SESSION['errorValid'] = $error;
        header('Location: http://localhost:3000/admin/categories.php?do=edit&catid=' . $catid);
        exit();
    }

    // تحديث بيانات الفئة في قاعدة البيانات
    $stmt = $con->prepare('UPDATE categories SET Name = ?, Description = ?, Price = ?, Quantity = ? , Visibility = ? WHERE ID = ?');
    $stmt->execute([$name, $desc, $price, $quantity, $visibility, $catid]);

    // تخزين البيانات المحدثة في الجلسة لعرضها لاحقًا
    $_SESSION['updated_data'] = [
        'name' => $name,
        'desc' => $desc,
        'price' => $price,
        'quantity' => $quantity,
        'visibility' => $visibility,
    ];

    // التحقق من وجود بيانات محدثة في الجلسة
    if (!isset($_SESSION['updated_data'])) {
        header('Location: http://localhost:3000/admin/categories.php');
        exit();
    }

    // استرجاع البيانات المحدثة
    $updatedData = $_SESSION['updated_data'];
    unset($_SESSION['updated_data']); // تنظيف الجلسة بعد الاستخدام
?>
    <style>
        strong {
            color: black;
        }
    </style>

    <div class="container my-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow-lg bg-gradient bg-dark">
                    <!-- Card Header -->
                    <div class="card-header bg-success bg-gradient text-white">
                        <h1 class="h4 fw-bold mb-0">Updated Category Details</h1>
                    </div>
                    <!-- Card Body -->
                    <div class="card-body p-4">
                        <!-- Display Updated Data -->
                        <div class="mb-4">
                            <h2 class="h5 fw-bold text-white">Updated Information</h2>
                            <ul class="list-group bg-dark">
                                <li class="list-group-item"><strong>Name:</strong> <?= htmlspecialchars($updatedData['name']); ?></li>
                                <li class="list-group-item"><strong>Description:</strong> <?= htmlspecialchars($updatedData['desc']); ?></li>
                                <li class="list-group-item"><strong>Price:</strong> <?= htmlspecialchars($updatedData['price']); ?></li>
                                <li class="list-group-item"><strong>Quantity:</strong> <?= htmlspecialchars($updatedData['quantity']); ?></li>
                                <li class="list-group-item"><strong>Visible:</strong> <?= $updatedData['visibility'] ? 'no' : 'yes' ?></li>
                            </ul>
                        </div>
                        <!-- Back Button -->
                        <div class="d-grid mt-4">
                            <a href="http://localhost:3000/admin/categories.php?do=edit&catid=<?= $catid ?>" class="btn btn-secondary w-50 btn-lg fw-bold text-white">Edit Category</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

<?php
} else {
    echo  '<h4 class="alert alert-danger container">not available <br> please go back to form and insert informations and submit</h4>';
}
