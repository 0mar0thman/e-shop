<?php
ob_start();
session_start();
$pageTitle = 'Edit Profile';
include 'init.php';

if (!isset($_SESSION['UserName'])) { // Changed UserName to Username for consistency
    header('Location: login.php');
    exit();
}

$user = fetchUserByUsername($_SESSION['UserName']); // Changed UserName to Username

// Verify user is editing their own profile
if ($user['UserID'] != $_SESSION['UserID']) {
    $_SESSION['error'] = "Unauthorized access!";
    header("Location: profile.php");
    exit();
}

// Process form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') { // Check for POST request
    // Sanitize and validate form data
    $fullname = htmlspecialchars(trim($_POST['fullname']));
    $username = htmlspecialchars(trim($_POST['username']));
    $email = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL);
    $phone = preg_replace('/[^0-9]/', '', $_POST['phone']);
    $description = htmlspecialchars(trim($_POST['description']));
    $newPassword = $_POST['password'];
    $userID = $_SESSION['UserID'];

    $errors = [];

    // Validation
    if (empty($fullname)) {
        $errors[] = "Full name is required.";
    }
    if (empty($username)) {
        $errors[] = "Username is required.";
    }
    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Valid email is required.";
    }

    // Check username uniqueness if changed
    if ($username != $user['Username']) {
        $stmt = $con->prepare("SELECT UserID FROM users WHERE Username = ?");
        $stmt->execute([$username]);
        if ($stmt->rowCount() > 0) {
            $errors[] = "Username is already taken!";
        }
    }

    // Handle password update
    $password = $user['Password']; // Keep current password by default
    if (!empty($newPassword)) {
        if (strlen($newPassword) < 6) {
            $errors[] = "Password must be at least 6 characters.";
        } else {
            $password = password_hash($newPassword, PASSWORD_DEFAULT);
        }
    }

    // Update database if no errors
    if (empty($errors)) {
        try {
            $stmt = $con->prepare("UPDATE users SET 
                FullName = ?, 
                Email = ?,
                Description = ?,
                Phone = ?,
                Password = ?,
                Username = ?
                WHERE UserID = ?");

            $stmt->execute([
                $fullname,
                $email,
                $description,
                $phone,
                $password,
                $username,
                $userID
            ]);

            $_SESSION['success'] = "Profile updated successfully!";
            header("Location: profile.php");
            exit();
        } catch (PDOException $e) {
            $errors[] = "Error updating profile: " . $e->getMessage();
        }
    }

    // If there are errors, store them in session
    if (!empty($errors)) {
        $_SESSION['error'] = implode('<br>', $errors);
    }
}

// Retrieve current user data to populate form
$user = fetchUserByUsername($_SESSION['UserName']); // Refresh data in case of failed update

// Display form
?>

<body class="text-white">
    <div class="container">
        <div class="mx-auto bg-dark rounded-3 shadow-sm" style="max-width: 1060px;">
            <!-- Header Section -->
            <div class="p-4 border-bottom">
                <h1 class="h3 mb-0 text-ligth">
                    <i class="fas fa-user-edit me-2 text-primary"></i>
                    Edit Profile
                </h1>
            </div>

            <!-- Error Message -->
            <?php if (isset($_SESSION['error'])): ?>
                <div class="alert alert-danger m-4 d-flex align-items-center">
                    <i class="fas fa-exclamation-circle me-2"></i>
                    <?= $_SESSION['error'] ?>
                </div>
                <?php unset($_SESSION['error']); ?>
            <?php endif; ?>

            <!-- Form Section -->
            <form method="POST" class="p-4">
                <input type="hidden" name="userID" value="<?= $user['UserID'] ?>">

                <!-- Two Columns Layout for Name & Username -->
                <div class="row g-4">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label text-ligth mb-2 fw-medium">Full Name</label>
                            <input type="text"
                                name="fullname"
                                class="form-control form-control-lg border-secondary"
                                value="<?= isset($_POST['fullname']) ? htmlspecialchars($_POST['fullname']) : $user['FullName'] ?>"
                                required>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label text-ligth mb-2 fw-medium">Username</label>
                            <input type="text"
                                name="username"
                                class="form-control form-control-lg border-secondary"
                                value="<?= isset($_POST['username']) ? htmlspecialchars($_POST['username']) : $user['Username'] ?>"
                                required>
                        </div>
                    </div>
                </div>

                <!-- Contact Info Section -->
                <div class="row g-4 mt-2">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label text-ligth mb-2 fw-medium">Email</label>
                            <input type="email"
                                name="email"
                                class="form-control form-control-lg border-secondary"
                                value="<?= isset($_POST['email']) ? htmlspecialchars($_POST['email']) : $user['Email'] ?>"
                                required>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label text-ligth mb-2 fw-medium">Phone Number</label>
                            <input type="tel"
                                name="phone"
                                class="form-control form-control-lg border-secondary"
                                placeholder="Example: 0512345678"
                                value="<?= isset($_POST['phone']) ? htmlspecialchars($_POST['phone']) : $user['Phone'] ?>">
                        </div>
                    </div>
                </div>

                <!-- Description Section -->
                <div class="form-group mt-4">
                    <label class="form-label text-ligth mb-2 fw-medium">Profile Description</label>
                    <textarea name="description"
                        class="form-control border-secondary"
                        rows="4"
                        style="resize: none;"><?= isset($_POST['description']) ? htmlspecialchars($_POST['description']) : $user['Description'] ?></textarea>
                </div>

                <!-- Password Section -->
                <div class="form-group mt-4">
                    <label class="form-label text-ligth mb-2 fw-medium">New Password</label>
                    <input type="password"
                        name="password"
                        class="form-control form-control-lg border-secondary"
                        placeholder="Leave empty to keep the current password">
                </div>

                <!-- Profile Picture (Optional) -->
                <!-- <div class="form-group mt-4">
                    <label class="form-label text-ligth mb-2 fw-medium">Profile Picture</label>
                    <div class="d-flex align-items-center">
                        <div class="me-3">
                            <img src="placeholder-profile.jpg"
                                class="rounded-circle"
                                width="80"
                                height="80"
                                alt="Profile Picture">
                        </div>
                        <div>
                            <input type="file"
                                class="form-control"
                                accept="image/*"
                                style="max-width: 250px;">
                            <small class="text-muted">Max size: 2MB</small>
                        </div>
                    </div>
                </div> -->

                <!-- Submit Button -->
                <div class="mt-5 pt-3 border-top">
                    <button type="submit"
                        class="btn btn-primary btn-lg w-50 width-100 fw-medium">
                        <i class="fas fa-save me-2"></i>
                        Save Changes
                    </button>
                </div>
            </form>
        </div>
    </div>
</body>

<?php
include $tpl . 'footer.php';
ob_end_flush();
?>