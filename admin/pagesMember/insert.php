<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $errors = [];

    $username = $_POST['username'];
    $password = $_POST['password'];
    $hashPassword = sha1($password);
    $email = $_POST['email'];
    $fullname = $_POST['fullname'];

    // ===========================
    //   --- ERRORS  ---
    // ===========================

    $errors['username'] = !empty(ErrorEmpty($username)) ? ErrorEmpty($username) : "";
    $errors['password'] = !empty(ErrorEmpty($password)) ? ErrorEmpty($password) : "";
    $errors['email'] = !empty(ErrorEmpty($email)) ? ErrorEmpty($email) : "";
    $errors['fullname'] = !empty(ErrorEmpty($fullname)) ? ErrorEmpty($fullname) : "";

    // تصفية الأخطاء لإزالة القيم الفارغة
    $errors = array_filter($errors);

    if (!empty($errors)) {
        $_SESSION['error'] = $errors;
        header('Location: http://localhost:3000/admin/members.php?do=add');
        exit();
    }

    //===================================
    // ----  conaction DATABASE  ----
    //===================================

    try {
        // التحقق من وجود اسم مستخدم مسبقًا
        $stmt = $con->prepare('SELECT UserID FROM users WHERE Username = ?');
        $stmt->execute([$username]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($result) {
            echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">
                      This user is pre-registered with the ID: <strong>' . $result['UserID'] . '</strong>.
                      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                  </div>';

            echo '<script>
                      document.addEventListener("DOMContentLoaded", function() {
                          var alertElement = document.querySelector(".alert");
                          var closeButton = alertElement.querySelector(".btn-close");

                          closeButton.addEventListener("click", function() {
                              window.location.href = "http://localhost:3000/admin/members.php?do=add";
                          });
                      });
                  </script>';
        } else {
            // إذا لم يتم العثور على سجل مسبق، قم بالإدراج
            $stmt = $con->prepare('INSERT INTO users (Username, FullName, Email, Password, GroupID, Date) 
                VALUES (?, ?, ?, ?, 1, NOW())');
            $stmt->execute([$username, $fullname, $email, $hashPassword]);

            // الحصول على الـ ID الذي تم إنشاؤه تلقائيًا
            $id = $con->lastInsertId();

            $success = true;
        }
    } catch (PDOException $e) {
        die("حدث خطأ في قاعدة البيانات: " . $e->getMessage());
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
<!-- عرض البيانات بعد التخزين -->
<?php if (isset($success) && $success): ?>
    <div class="container my-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow-lg bg-dark bg-gradient">
                    <!-- Card Header -->
                    <div class="card-header bg-success bg-gradient text-white">
                        <h1 class="h4 fw-bold mb-0">Member Details</h1>
                    </div>
                    <!-- Card Body -->
                    <div class="card-body p-4">
                        <!-- Display Member Details -->
                        <div class="mb-4">
                            <h2 class="h5 fw-bold text-white">User Information</h2>
                            <ul class="list-group">
                                <li class="list-group-item"><strong>ID:</strong> <?= $id; ?></li>
                                <li class="list-group-item"><strong>Username:</strong> <?= $username; ?></li>
                                <li class="list-group-item"><strong>Email:</strong> <?= $email; ?></li>
                                <li class="list-group-item"><strong>Full Name:</strong> <?= $fullname; ?></li>
                            </ul>
                        </div>
                        <!-- Back Button -->
                        <div class="d-grid mt-4">
                            <a href="http://localhost:3000/admin/members.php?do=add" class="btn w-50 btn-secondary btn-lg fw-bold text-white">Add Another Member</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>