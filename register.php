<?php
ob_start();
$pageTitle = 'Register';
include 'init.php';
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST)) {
    $row = checkUserActivationStatusFetch($_POST['username']);
    if ($row) {
        echo "this username is aready used";
    } else {
        try {

            addNewUser($_POST['username'], sha1($_POST['password']), $_POST['email'], $_POST['fullname']);
            header("location: login.php");
        } catch (PDOException $e) {
            echo "This user cannot be registered, the name is already in use!";
        }
    }
}

?>
<div class="auth-container">
    <div class="auth-login-panel">
        <div class="auth-login">
            <h4>Register</h4>
            <form action="<?= htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="POST">
                <div class="mb-3">
                    <input class="form-control" type="text" name="username" placeholder="Username" autocomplete="off">
                </div>
                <div class="mb-3">
                    <input class="form-control" type="password" name="password" placeholder="Password" autocomplete="new-password">
                </div>
                <div class="mb-3">
                    <input class="form-control" type="email" name="email" placeholder="Email">
                </div>
                <div class="mb-3">
                    <input class="form-control" type="text" name="fullname" placeholder="Full Name">
                </div>
                <div class="d-grid gap-2">
                    <button type="submit" class="btn btn-primary">Register</button>
                    <hr class="text-black">
                    <button type="button" class="btn btn-outline-primary" onclick="window.location.href='login.php'">Login</button>
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
<?php ob_end_flush(); ?>