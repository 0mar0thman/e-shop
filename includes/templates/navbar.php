<nav class="navbar navbar-expand-lg bg-dark bg-gradient mb-3">
    <div class="container text-white">
        <div>
            <a class="navbar-brand text-white fw-bold mr-3" href="index.php">Home</a>
        </div>
        <div class="margin-left-lg">
            <?php if (empty($_SESSION['UserName'])) : ?>
                <a class="btn btn-dark px-4" href="login.php">
                    Log In
                </a>
            <?php else : ?>
                <div class="d-flex align-items-center gap-3">

                </div>
            <?php endif; ?>
        </div>
        <button class="navbar-toggler text-white" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <i class="fa-solid fa-bars"></i>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <?php
            if (!isset($_SESSION['refresh_count'])) {
                $_SESSION['refresh_count'] = 0;
            }

            if (!isset($_SESSION['random_keys'])) {
                $_SESSION['random_keys'] = [];
            }

            $_SESSION['refresh_count']++;

            if ($_SESSION['refresh_count'] >= 10 || empty($_SESSION['random_keys'])) {
                $cat = retrieveAllCategories();

                $count = count($cat);

                if ($count >= 5) {
                    $_SESSION['random_keys'] = array_rand($cat, 5);
                } else {
                    $_SESSION['random_keys'] = [];
                }

                $_SESSION['refresh_count'] = 0;
            }
            ?>
            <ul class="navbar-nav ms-auto">
                <?php
                if (!empty($_SESSION['random_keys'])) {
                    $cat = retrieveAllCategories();
                    foreach ($_SESSION['random_keys'] as $key) :
                ?>
                        <li class="nav-item">
                            <a class="nav-link text-white" href="categories.php?cid=<?= $cat[$key]['ID'] ?>&name=<?= str_replace(" ", "-", $cat[$key]['Name']) ?>">
                                <?= $cat[$key]['Name'] ?>
                            </a>
                        </li>
                <?php
                    endforeach;
                } else {
                    echo "<li class='nav-item'><a class='nav-link text-white' href='#'>عدد التصنيفات غير كافٍ</a></li>";
                }
                ?>
            </ul>

            <ul class="navbar-nav ms-auto align-items-center">
                <li class="me-5">
                    <a href="item.php?do=add_cart&itemid=54"><i class="fa-solid fa-cart-shopping" style="font-size: 18px;"></i></a>
                </li> <!-- تغيير align-items-start إلى center -->
                <?php if (!empty($_SESSION['UserName'])) : ?>
                    <li class="nav-item dropdown me-3 "> <!-- إضافة position-relative وهامش -->
                        <a class="nav-link dropdown-toggle text-white d-flex align-items-center gap-1" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <?php if (checkUserActivationStatus($_SESSION['UserName']) == 1) : ?>
                                <i class="fa-solid fa-triangle-exclamation" style="color: #e66565;"></i>
                            <?php else : ?>
                                <i class="fas fa-user-shield me-2"></i>
                            <?php endif; ?>
                            <?= lang('ADMIN') ?>
                        </a>

                        <ul class="dropdown-menu border-0 shadow">
                            <?php if (isset($_SESSION['UserName'])): ?>
                                <li>
                                    <a class="dropdown-item py-2" href="edit-profile.php">
                                        <i class="fas fa-edit me-2"></i><?= lang('EDIT_PROFILE') ?>
                                    </a>
                                </li>
                            <?php endif; ?>
                            <li>
                                <a class="dropdown-item py-2" href="profile.php">
                                    <i class="fas fa-cog me-2"></i><?= lang('PROFILE') ?>
                                </a>
                            </li>
                            <li>
                                <hr class="dropdown-divider my-1">
                            </li>
                            <li>
                                <a class="dropdown-item py-2 text-danger" href="logout.php">
                                    <i class="fas fa-sign-out-alt me-2"></i><?= lang('LOGOUT') ?>
                                </a>
                            </li>
                        </ul>
                    </li>
                <?php endif ?>
            </ul>
        </div>
    </div>
</nav>