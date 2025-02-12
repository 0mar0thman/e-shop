
<style>
    /* === Global Styles === */

    @font-face {
        font-family: 'Cairo';
        src: url('style/static/Cairo-Regular.ttf') format('truetype');
    }

    body {
        background: linear-gradient(135deg, #eef2f3, #8e9eab);
        font-family: 'Arial', sans-serif;
        height: 100vh;
        margin: 0;
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
        font-family: 'Cairo', sans-serif;
    }

    .container {
        display: flex;
        width: 90%;
        max-width: 1200px;
        height: 70vh;
        background: rgba(255, 255, 255, 0.9);
        border-radius: 20px;
        box-shadow: 0 15px 40px rgba(0, 0, 0, 0.2);
        overflow: hidden;
        padding-left: 0;
        padding-right: 0;
    }

    /* === Left Panel Styles === */
    .left-panel {
        flex: 1;
        background: linear-gradient(135deg, #6c63ff, #5149c9);
        display: flex;
        align-items: center;
        justify-content: center;
        position: relative;
        overflow: hidden;
    }

    .animation-container {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
    }

    .circle {
        position: absolute;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.2);
        animation: float 6s infinite ease-in-out;
    }

    .circle:nth-child(1) {
        width: 120px;
        height: 120px;
        top: 10%;
        left: 10%;
        animation-delay: 0s;
    }

    .circle:nth-child(2) {
        width: 80px;
        height: 80px;
        top: 50%;
        left: 20%;
        animation-delay: 2s;
    }

    .circle:nth-child(3) {
        width: 100px;
        height: 100px;
        top: 70%;
        left: 70%;
        animation-delay: 4s;
    }

    @keyframes float {

        0%,
        100% {
            transform: translateY(0);
        }

        50% {
            transform: translateY(-20px);
        }
    }

    /* === Login Panel Styles === */
    .login-panel {
        flex: 1;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 40px;
    }

    .login {
        width: 100%;
        max-width: 400px;
    }

    .login h4 {
        color: #4a4a4a;
        margin-bottom: 30px;
        font-size: 2rem;
        text-align: center;
        font-weight: bold;
    }

    .login .form-control {
        height: 55px;
        margin-bottom: 20px;
        border: 1px solid #ddd;
        border-radius: 12px;
        padding: 15px;
        font-size: 1.1rem;
        transition: border-color 0.3s, box-shadow 0.3s;
        background: #f9fafc;
        color: rgba(0, 0, 0, 0.6);
    }

    .login .form-control:focus {
        border-color: #6c63ff;
        box-shadow: 0 0 10px rgba(108, 99, 255, 0.5);
    }

    .login .btn-primary {
        background: #6c63ff;
        border: none;
        color: #fff;
        height: 55px;
        font-weight: bold;
        border-radius: 12px;
        transition: transform 0.3s;
    }

    .login .btn-primary:hover {
        background: #5149c9;
        transform: translateY(-2px);
    }

    .login .btn-outline-primary {
        border-color: #6c63ff;
        color: #6c63ff;
        height: 55px;
        font-weight: bold;
        border-radius: 12px;
        transition: background 0.3s, color 0.3s;
    }

    .login .btn-outline-primary:hover {
        background: #6c63ff;
        color: #fff;
    }

    /* === Left Panel Styles === */
    .left-panel {
        flex: 1;
        background: linear-gradient(135deg, #6c63ff, #5149c9);
        display: flex;
        align-items: center;
        justify-content: center;
        position: relative;
        overflow: hidden;
    }

    .animation-container {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    /* Font Awesome Icon Styles */
    .fa-user-astronaut {
        font-size: 8rem;
        /* حجم الأيقونة */
        color: rgba(255, 255, 255, 0.8);
        /* لون الأيقونة */
        animation: float 4s infinite ease-in-out;
        /* حركة الأيقونة */
    }


    /* === Responsive Design === */
    @media (max-width: 768px) {
        .container {
            flex-direction: column;
            height: 100vh;
            width: 100%;
            border-radius: 0;
            box-shadow: none;
        }

        .left-panel {
            display: none;
        }

        .login-panel {
            width: 100%;
        }

        .login {
            padding: 0;
        }
    }

    @keyframes float {

        0%,
        100% {
            transform: translateY(0);
        }

        50% {
            transform: translateY(-20px);
        }
    }
</style>

<div class="container">
    <!-- Left Panel -->
    <div class="left-panel">
        <div class="animation-container">
            <!-- Font Awesome Icon with Animation -->
            <i class="fas fa-user-astronaut"></i>
        </div>
    </div>

    <!-- Login Panel -->
    <div class="login-panel"> 
        <div class="login">
            <h4 class="text-center fw-bold">Login</h4>
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
                    <div class="alert alert-danger text-center mt-3">
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

<?php  ?>