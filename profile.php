<?php
ob_start();
session_start();
$pageTitle = 'Profile';
include 'init.php';

// Redirect to login if user is not authenticated
if (empty($_SESSION['UserName'])) {
    header('Location: login.php');
    exit();
}

// Fetch user data and statistics
$user = fetchUserByUsername($_SESSION['UserName']);
$userItems = fetchUserItemsByUserId($user['UserID']);

// Calculate ratings statistics
$itemCount = count($userItems);
$totalRating = 0;
foreach ($userItems as $item) {
    $totalRating += $item['Rating'];
}
$averageRating = $itemCount > 0 ? $totalRating / $itemCount : 0;

// Get user comments
$commentCount = countUserComments($user['UserID']);
$allComments = fetchCommentsWithUser($user['UserID']);

// Get current action from URL
$action = $_GET['do'] ?? '';
?>

<div class="container py-5">
    <div class="row d-flex justify-content-end">
        <?php if ($action == 'all_comments'): ?>
            <?php include 'pagesItem/all_comments.php' ?>

        <?php elseif ($action == 'comments_edit'): ?>
            <?php include 'pagesItem/comments_edit.php' ?>

        <?php elseif ($action == 'delete'): ?>
            <?php include 'pagesItem/delete.php' ?>

        <?php elseif ($action == 'update'): ?>
            <?php include 'pagesItem/update.php' ?>

        <?php elseif ($action == 'add'): ?>
            <?php include 'pagesItem/add.php' ?>

        <?php elseif ($action == 'insert'): ?>
            <?php include 'pagesItem/insert.php' ?>

        <?php elseif ($action == 'ads'): ?>
            <?php include 'pagesItem/ads.php' ?>

        <?php elseif ($action == 'ads_edit'): ?>
            <?php include 'pagesItem/ads_edit.php' ?>

        <?php elseif ($action == 'ads_add'): ?>
            <?php include 'pagesItem/ads_add.php' ?>
        <?php else: ?>
            <!-- Profile Overview Section -->
            <div class="col-md-4 mb-4">
                <div class="profile-card p-4 text-center">
                    <div class="position-relative mb    -4">
                        <a href="edit-profile.php" class="btn btn-primary btn-sm edit-btn">
                            <i class="fas fa-edit"></i>
                        </a>
                        <?php if (isset($_SESSION['success'])): ?>
                            <div class="alert alert-success"><?= $_SESSION['success'] ?></div>
                            <?php unset($_SESSION['success']); ?>
                        <?php endif; ?>

                        <?php if (isset($_SESSION['error'])): ?>
                            <div class="alert alert-danger"><?= $_SESSION['error'] ?></div>
                            <?php unset($_SESSION['error']); ?>
                        <?php endif; ?>
                    </div>

                    <h3 class="mb-3"><?= $_SESSION['UserName'] ?></h3>
                    <p class="text-muted mb-4"><?= $user['Description'] ?? 'No description available' ?></p>

                    <div class="d-flex justify-content-center gap-3 mb-4">
                        <a href="#" class="social-icon btn btn-outline-primary rounded-circle">
                            <i class="fab fa-twitter"></i>
                        </a>
                        <a href="#" class="social-icon btn btn-outline-danger rounded-circle">
                            <i class="fab fa-instagram"></i>
                        </a>
                        <a href="#" class="social-icon btn btn-outline-dark rounded-circle">
                            <i class="fab fa-github"></i>
                        </a>
                    </div>
                </div>
            </div>

            <!-- User Statistics Section -->
            <div class="mb-4 col-md-8">
                <div class="profile-card p-4">
                    <div class="row g-4 mb-4">
                        <div class="col-6 col-md-4">
                            <a href="profile.php?do=ads">
                                <div class="stats-box p-3 text-center">
                                    <h5 class="text-primary">Items</h5>
                                    <h3><?= $itemCount ?></h3>
                                </div>
                            </a>
                        </div>
                        <div class="col-6 col-md-4">
                            <a href="profile.php?do=all_comments">
                                <div class="stats-box p-3 text-center">
                                    <h5 class="text-warning">Comments</h5>
                                    <h3><?= $commentCount ?></h3>
                                </div>
                            </a>
                        </div>
                        <div class="col-6 col-md-4">
                            <div class="stats-box p-3 text-center">
                                <div class="rating-stars mb-2">
                                    <?php for ($i = 0; $i < $averageRating; $i++): ?>
                                        <i class="fas fa-star text-warning"></i>
                                    <?php endfor; ?>
                                </div>
                                <h3><?= number_format($averageRating, 2) ?>
                                    <small class="text-muted">(<?= $itemCount ?> Ratings)</small>
                                </h3>
                            </div>
                        </div>
                    </div>

                    <!-- User Information Section -->
                    <div>
                        <h4 class="border-bottom pb-2 mb-3">Personal Information</h4>
                        <div class="row">
                            <div class="col-md-6">
                                <p><i class="fas fa-envelope me-2"></i> <?= $user['Email'] ?></p>
                                <p><i class="fas fa-phone me-2"></i> <?= $user['Phone'] ?? 'Not added' ?></p>
                            </div>
                            <div class="col-md-6">
                                <p><i class="fa-solid fa-file-signature"></i> <?= $user['FullName'] ?? 'Not specified' ?></p>
                                <p><i class="fas fa-calendar-alt me-2"></i> Joined <?= date('M d, Y', strtotime($user['Date'])) ?></p>
                            </div>
                        </div>
                    </div>
                    <!-- User Information Section -->
                    <div class="mb-4">
                        <h4 class="border-bottom pb-2 mb-3"></h4>
                        <div class="row">
                            <!-- From Uiverse.io by SpatexDEV -->
                            <button class="w-50" onclick="window.location.href='profile.php?do=add'">
                                <svg
                                    aria-hidden="true"
                                    stroke="currentColor"
                                    stroke-width="2"
                                    viewBox="0 0 24 24"
                                    fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        stroke-width="2"
                                        stroke="#fffffff"
                                        d="M13.5 3H12H8C6.34315 3 5 4.34315 5 6V18C5 19.6569 6.34315 21 8 21H11M13.5 3L19 8.625M13.5 3V7.625C13.5 8.17728 13.9477 8.625 14.5 8.625H19M19 8.625V11.8125"
                                        stroke-linejoin="round"
                                        stroke-linecap="round"></path>
                                    <path
                                        stroke-linejoin="round"
                                        stroke-linecap="round"
                                        stroke-width="2"
                                        stroke="#fffffff"
                                        d="M17 15V18M17 21V18M17 18H14M17 18H20"></path>
                                </svg>
                                ADD ITEMS
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php
include $tpl . 'footer.php';
ob_end_flush();
?>