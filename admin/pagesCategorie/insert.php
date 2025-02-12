<!-- page insert categories -->
<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $name = $_POST['name'];
    $desc = $_POST['description'];
    $price = !empty($_POST['price']) ? (int)$_POST['price'] : 0;
    $quantity = $_POST['quantity'];
    $visibility = $_POST['visibility'] ?? null;

    // ===========================
    //   --- ERRORS  ---
    // ===========================

    $errors['name'] = !empty(ErrorEmpty($name)) ? ErrorEmpty($name) : "";
    $errors['desc'] = !empty(ErrorEmpty($desc)) ? ErrorEmpty($desc) : "";
    $errors['price'] = !empty(ErrorEmpty($price)) ? ErrorEmpty($price) : "";
    $errors['quantity'] = !empty(ErrorEmpty($quantity)) ? ErrorEmpty($quantity) : "";
    $errors['visibility'] = !isset($_POST['visibility']) ? "Please select a visibility option." : "";

    $errors = array_filter($errors);

    if (!empty($errors)) {
        $_SESSION['error'] = $errors;
        header('Location: http://localhost:3000/admin/categories.php?do=add');
        exit();
    }

    //===================================
    // ----  conaction DATABASE  ----
    //===================================

    try {
        $stmt = $con->prepare('SELECT ID FROM categories WHERE Name = ? AND Description = ?');
        $stmt->execute([$name, $desc]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($result) {
?>
            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                This data is pre-registered with the ID: <strong> <?= $result['ID'] ?> </strong>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>

            <script>
                document.addEventListener("DOMContentLoaded", function() {
                    var alertElement = document.querySelector(".alert")
                    var closeButton = alertElement.querySelector(".btn-close")

                    closeButton.addEventListener("click", function() {
                        window.location.href = "http://localhost:3000/admin/categories.php?do=add"
                    })
                })
            </script>
<?php
        } else {
            $stmt = $con->prepare('INSERT INTO categories(Name, Description, Price, Quantity, Visibility) 
                VALUES (?, ?, ?, ?, ?)');
            $stmt->execute([$name, $desc, $price, $quantity, $visibility]);
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

<?php if (isset($success) && $success): ?>
    <style>
        strong {
            color: black;
        }
    </style>
    <div class="container my-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow-lg bg-dark bg-gradient">
                    <!-- Card Header -->
                    <div class="card-header bg-success bg-gradient text-white">
                        <h1 class="h4 fw-bold mb-0">Product Details</h1>
                    </div>
                    <!-- Card Body -->
                    <div class="card-body p-4 ">
                        <!-- Display Product Details -->
                        <div class="mb-4">
                            <h2 class="h5 fw-bold text-white">Product Information</h2>
                            <ul class="list-group">
                                <li class="list-group-item"><strong>ID:</strong> <?= $id; ?></li>
                                <li class="list-group-item"><strong>Name:</strong> <?= $name; ?></li>
                                <li class="list-group-item"><strong>Description:</strong> <?= $desc; ?></li>
                                <li class="list-group-item"><strong>Price:</strong> <?= !empty($price) ? $price : 0; ?></li>
                                <li class="list-group-item"><strong>Quantity:</strong> <?= $quantity; ?></li>
                                <li class="list-group-item"><strong>Visibility:</strong> <?= $visibility == 1 ? 'Yes' : 'No'; ?></li>
                            </ul>
                        </div>
                        <!-- Back Button -->
                        <div class="d-grid mt-4">
                            <a href="http://localhost:3000/admin/categories.php?do=add" class="btn btn-secondary btn-lg fw-bold text-white w-50">Add Another Product</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>