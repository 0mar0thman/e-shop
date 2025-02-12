<?php

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // جلب معرّف الفئة من النموذج
    $itemid = isset($_POST['itemid']) ? intval($_POST['itemid']) : 0;

    $name = $_POST['name'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $addDate = $_POST['AddDate'];
    $countryMade = $_POST['CountryMade'];
    $status = $_POST['status'];
    $rating = $_POST['rating'];
    $member = $_POST['member'];
    $category = $_POST['category'];
    $catName = $_POST['catName'];
    $memberName = $_POST['memberName'];

    // ===========================
    //   --- ERRORS  ---
    // ===========================
    $errors = [];
    if (empty($name)) $errors['name'] = 'Name field cannot be empty.';
    if (empty($description)) $errors['description'] = 'Description field cannot be empty.';
    if (empty($price) || !is_numeric($price)) $errors['price'] = 'Price field cannot be empty or must be a number.';
    if (empty($addDate)) $errors['addDate'] = 'AddDate field cannot be empty.';
    if (empty($countryMade)) $errors['countryMade'] = 'CountryMade field cannot be empty.';
    if (empty($status)) $errors['status'] = 'Status field cannot be empty.';
    if (empty($rating)) $errors['rating'] = 'Rating field cannot be empty.';
    if (empty($member)) $errors['member'] = 'Member field cannot be empty.';
    if (empty($category)) $errors['category'] = 'Category field cannot be empty.';

    if (!empty($errors)) {
        $_SESSION['error'] = $errors;
        redirectBack();
    }

    // تحديث بيانات العنصر في جدول items
    $stmt = $con->prepare('UPDATE items SET Name = ?, Description = ?, Price = ?, AddDate = now() , CountryMade = ?, Status = ?, Rating = ?, CatID = ?, MemberID = ? WHERE itemsID = ?');
    $stmt->execute([$name, $description, $price, $countryMade, $status, $rating, $category, $member, $itemid]);


    $_SESSION['updated_data'] = [
        'name' => $name,
        'description' => $description,
        'price' => $price,
        'addDate' => $addDate,
        'countryMade' => $countryMade,
        'status' => $status,
        'rating' => $rating,
        'member' => $member,
        'memberName' => $memberName,
        'catName' => $catName
    ];

    // التحقق من وجود بيانات محدثة في الجلسة
    if (!isset($_SESSION['updated_data'])) {
        header('Location: http://localhost:3000/admin/items.php');
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
    <!-- عرض البيانات المحدثة -->
    <div class="container my-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow-lg bg-gradient bg-dark">
                    <!-- Card Header -->
                    <div class="card-header bg-success bg-gradient text-white">
                        <h1 class="h4 fw-bold mb-0">Updated Item Details</h1>
                    </div>
                    <!-- Card Body -->
                    <div class="card-body p-4">
                        <!-- Display Updated Data -->
                        <div class="mb-4">
                            <h2 class="h5 fw-bold text-white">Updated Information</h2>
                            <ul class="list-group bg-dark">
                                <li class="list-group-item"><strong>Name:</strong> <?= htmlspecialchars($updatedData['name']); ?></li>
                                <li class="list-group-item"><strong>Description:</strong> <?= htmlspecialchars($updatedData['description']); ?></li>
                                <li class="list-group-item"><strong>Price:</strong> <?= htmlspecialchars($updatedData['price']); ?></li>
                                <?php
                                // تحويل التاريخ والوقت إلى التنسيق المطلوب (mm/dd/yyyy hh:mm AM/PM)
                                $date = isset($updatedData['addDate']) ? new DateTime($updatedData['addDate']) : null;
                                $formattedDate = $date ? $date->format('m/d/Y h:i A') : '';
                                ?>
                                <li class="list-group-item">
                                    <strong>Date: </strong>
                                    <span class="text-black"><?= htmlspecialchars($formattedDate); ?></span>
                                </li>

                                <li class="list-group-item"><strong>Country Made:</strong class="text-black"> <?= htmlspecialchars($updatedData['countryMade']); ?></li>
                                <li class="list-group-item"><strong>Status:</strong class="text-black"> <?= htmlspecialchars($updatedData['status']); ?></li>
                                <li class="list-group-item"><strong>Rating:</strong class="text-black"> <?= htmlspecialchars($updatedData['rating']); ?></li>
                                <li class="list-group-item"><strong>Member:</strong class="text-black"> <?= htmlspecialchars($updatedData['memberName']); ?></li>
                                <li class="list-group-item"><strong>Category:</strong class="text-black"> <?= htmlspecialchars($updatedData['catName']); ?></li>
                            </ul>
                        </div>
                        <!-- Back Button -->
                        <div class="d-grid mt-4">
                            <a href="http://localhost:3000/admin/items.php?do=edit&itemid=<?= $itemid ?>" class="btn btn-secondary w-50 btn-lg fw-bold text-white">Edit Item</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php
} else {
    echo '<h4 class="alert alert-danger container">not available <br> please go back to form and insert informations and submit</h4>';
}
?>