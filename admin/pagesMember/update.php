<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $id = $_POST['userid'];

    // التحقق من كلمة المرور القديمة
    if (sha1($_POST['oldPassword']) === $_POST['thePassword']) {
        $newPassword = $_POST['newPassword'] ?? '';
        if (empty($newPassword)) {
            $password = $_POST['thePassword'];
        } else {
            if (strlen($newPassword) < 4) {
                $_SESSION['error'] = "The new password must be at least 4 characters long.";
                header('Location: http://localhost:3000/admin/members.php?do=edit&id=' . $id);
                exit();
            }
            if ($newPassword === $_POST['oldPassword']) {
                $_SESSION['error'] = "The new password cannot be the same as the old password.";
                header('Location: http://localhost:3000/admin/members.php?do=edit&id=' . $id);
                exit();
            }
            $password = sha1($newPassword);
        }

        $error = [];
        $username = $_POST['newUsername'] ?: $_POST['oldUsername'];
        $email = $_POST['newEmail'] ?: $_POST['oldEmail'];
        $fullname = $_POST['newFullname'] ?: $_POST['oldFullname'];

        if (empty($username)) $error[] = 'User Name cannot be empty.';
        if (empty($email)) $error[] = 'Email cannot be empty.';
        if (empty($fullname)) $error[] = 'Full Name cannot be empty.';

        if (!empty($error)) {
            $_SESSION['errorValid'] = $error;
            header('Location: http://localhost:3000/admin/members.php?do=edit&id=' . $id);
            exit();
        }
        $stmt2 = $con->prepare('SELECT Username FROM users WHERE Username =? AND UserID != ?');
        $stmt2->execute([$username, $id]);
        $count =  $stmt2->rowCount();

        if ($count == 1) {
            echo '    <div class="card-header bg-danger bg-gradient text-white">
                        <h6 class="h4 fw-bold mb-0">Sorry this user is Already there</h6>
                    </div>';
            exit();
        }
        $_SESSION['user'] = $username;

        $stmt = $con->prepare('UPDATE users SET Username = ?, FullName = ?, Email = ?, Password = ? WHERE UserID = ?');
        $stmt->execute([$username, $fullname, $email, $password, $id]);

        $_SESSION['updated_data'] = [
            'username' => $username,
            'email' => $email,
            'fullname' => $fullname,
        ];
    } else {
        $_SESSION['error'] = "Old Password is Incorrect !!";
        header('Location: http://localhost:3000/admin/members.php?do=edit&id=' . $id);
        exit();
    }

    // التحقق من وجود بيانات محدثة في الجلسة
    if (!isset($_SESSION['updated_data'])) {
        header('Location: http://localhost:3000/admin/members.php');
        exit();
    }

    // استرجاع البيانات المحدثة
    $updatedData = $_SESSION['updated_data'];
    unset($_SESSION['updated_data']); // تنظيف الجلسة بعد الاستخدام     
?>
    <style>
     
    </style>
    <div class="container my-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow-lg bg-dark bg-gradient">
                    <!-- Card Header -->
                    <div class="card-header bg-success bg-gradient text-white">
                        <h1 class="h4 fw-bold mb-0">Updated Member Details</h1>
                    </div>
                    <!-- Card Body -->
                    <div class="card-body p-4">
                        <!-- Display Updated Data -->
                        <div class="mb-4">
                            <h2 class="h5 fw-bold text-white">Updated Information</h2>
                            <ul class="list-group">
                                <li class="list-group-item"><strong>Username:</strong> <?= htmlspecialchars($updatedData['username']); ?></li>
                                <li class="list-group-item"><strong>Email:</strong> <?= htmlspecialchars($updatedData['email']); ?></li>
                                <li class="list-group-item"><strong>Full Name:</strong> <?= htmlspecialchars($updatedData['fullname']); ?></li>
                            </ul>
                        </div>
                        <!-- Back Button -->
                        <div class="d-grid mt-4">
                            <a href="http://localhost:3000/admin/members.php?do=edit&id=<?= $_SESSION['id'] ?>" class="btn btn-secondary w-50 btn-lg fw-bold text-white">Edit Members</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

<?php
} else {
    echo 'not available <br> please go back to form and insert informations and submit';
}
