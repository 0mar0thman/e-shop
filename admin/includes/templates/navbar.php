<nav class="navbar navbar-expand-lg bg-dark bg-gradient">
    <div class="container text-white">
        <a class="navbar-brand text-white fw-bold" href="dashboard.php"><i class="fa-solid fa-gear"></i></a>
        <button class="navbar-toggler text-white" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <i class="fa-solid fa-bars"></i>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0 w-100 align-items-start">
                <li class="nav-item"><a class="nav-link text-white" href="categories.php"><?= lang('CATEGORIES') ?></a></li>
                <li class="nav-item"><a class="nav-link text-white" href="members.php"><?= lang('MEMBER') ?></a></li>
                <li class="nav-item"><a class="nav-link text-white" href="items.php"><?= lang('ITEM') ?></a></li>
                <li class="nav-item"><a class="nav-link text-white" href="comments.php"><?= lang('COMMENT') ?></a></li>
                <!-- <li class="nav-item"><a class="nav-link text-white" href="#"><?= lang('STATISTICS') ?></a></li> -->
                <!-- <li class="nav-item"><a class="nav-link text-white" href="#"><?= lang('LOGS') ?></a></li> -->
            </ul>
            <ul class="navbar-nav ms-auto align-items-start">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle text-white admin" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <?= lang('ADMIN') ?>
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="../../index.php"><?= lang('VIST_SHOP') ?></a></li>
                        <?php if (isset($_SESSION['id'])): ?>
                            <li><a class="dropdown-item" href="members.php?do=edit&id=<?= $_SESSION['id'] ?>"><?= lang('EDIT_PROFILE') ?></a></li>
                        <?php endif; ?>
                        <!-- <li><a class="dropdown-item" href="#"><?= lang('SETTINGS') ?></a></li> -->
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li><a class="dropdown-item" href="pagesMember/logout.php"><?= lang('LOGOUT') ?></a></li>
                    </ul>
                </li>

            </ul>
        </div>
    </div>
</nav>