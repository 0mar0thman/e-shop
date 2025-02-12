<?php
ob_start();
session_start();
$pageTitle = 'Login';
include 'init.php';

if (isset($_SESSION['UserName'])) {
    header('Location: index.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $hashpass = sha1($password);

    $stmt = $con->prepare("SELECT Username, Password , UserID FROM users WHERE Username = ? AND Password = ?");
    $stmt->execute(array($username, $hashpass));
    $count = $stmt->rowCount();
    $row = $stmt->fetch();
    $errorLogin = array();

    if ($count > 0) {
        $_SESSION['UserName'] = $row['Username'];
        $_SESSION['UserID'] = $row['UserID'];
        header('Location: index.php');
        exit();
    } else {

        if (empty($password)) $errorLogin[] =  "Password Cannot be Empty !!";
        if (empty($username)) $errorLogin[] =  "User Name Cannot be Empty !!";
        if (!empty($username) && !empty($password)) $errorLogin[] = "Not Valid !!";

        foreach ($errorLogin as $value) {
            $_SESSION['errorLogin'][] = $value;
        }
        header('Location: login.php');
        exit();
    }
}
?>
<div class="auth-container">
    <div class="auth-login-panel">
        <div class="auth-login">
            <h4>Login</h4>
            <form action="<?= htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="post">
                <div class="mb-3">
                    <input class="form-control" type="text" name="username" placeholder="Username" autocomplete="off">
                </div>
                <div class="mb-3">
                    <input class="form-control" type="password" name="password" placeholder="Password" autocomplete="new-password">
                </div>
                <div class="d-grid gap-2">
                    <button type="submit" class="btn btn-primary">Login</button>
                    <button type="button" class="btn btn-outline-primary" onclick="window.location.href='register.php'">Register</button>
                </div>
                <?php if (!empty($_SESSION['errorLogin'])): ?>
                    <div class="alert alert-danger text-center">
                        <?php foreach ($_SESSION['errorLogin'] as $value): ?>
                            <?= htmlspecialchars($value) . "<br>" ?>
                        <?php endforeach; ?>
                    </div>
                    <?php unset($_SESSION['errorLogin']); ?>
                <?php endif; ?>
            </form>
        </div>
    </div>
</div>
<?php
ob_end_flush(); 
?>