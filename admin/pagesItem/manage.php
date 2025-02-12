<?php
// Helper functions
function generateStarRating($rating)
{
    $stars = '';
    $fullStars = floor($rating);
    $halfStar = ($rating - $fullStars) >= 0.5 ? 1 : 0;

    for ($i = 0; $i < $fullStars; $i++) {
        $stars .= '<i class="fas fa-star"></i>';
    }
    if ($halfStar) {
        $stars .= '<i class="fas fa-star-half-alt"></i>';
    }
    for ($i = 0; $i < (5 - $fullStars - $halfStar); $i++) {
        $stars .= '<i class="far fa-star"></i>';
    }
    return $stars;
}

function getStatusLabel($status)
{
    $statusMap = [
        'new' => 'New',
        'used' => 'Used',
        'old' => 'Old'
    ];
    return $statusMap[$status] ?? 'Unknown';
}

// Database Query
$query = isset($_GET['page']) && $_GET['page'] == 'pending' ? 'AND Approve = 0' : '';
$query = isset($_GET['page']) && $_GET['page'] == 'unpending' ? 'AND Approve = 1' : '';

$sort = isset($_GET['sort']) && $_GET['sort'] == 'DESC' ? 'ASC' : 'DESC';

$stmt = $con->prepare("SELECT items.*, categories.Name AS Cat_Name, users.Username AS User_Name
                      FROM items
                      INNER JOIN categories ON categories.ID = items.CatID
                      INNER JOIN users ON users.UserID = items.MemberID
                      WHERE 1 $query
                      ORDER BY itemsID $sort
                      LIMIT 25");
$stmt->execute();
$rows = $stmt->fetchAll();
?>

<style>
    :root {
        --primary-color: #1a1e24;
        --secondary-color: #2d333b;
        --accent-color: #4ecca3;
        --text-primary: #e6edf3;
        --text-secondary: #848d97;
    }

    .text-muted {
        color: white;
    }

    .item-card {
        background: var(--primary-color);
        border: 1px solid #30363d;
        border-radius: 12px;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        padding: 5px;

    }

    .item-card:hover {
        transform: translateY(-5px);
        border-color: var(--accent-color);
        box-shadow: 0 12px 24px rgba(0, 0, 0, 0.2);
        border-radius: 12px;
    }

    .card-header {
        background: linear-gradient(135deg, var(--secondary-color), var(--primary-color)) !important;
        border-bottom: 2px solid var(--accent-color) !important;
        padding: 15px;
        border-radius: 12px;
        /* color: #e6edf3; */
    }

    .card-body {
        padding: 10px 20px;
    }

    .price-tag {
        background: rgba(78, 204, 163, 0.1);
        padding: 0.4rem 1rem;
        border-radius: 20px;
        border: 1px solid var(--accent-color);
        color: var(--accent-color);
        font-weight: 600;
        border-radius: 12px;
    }

    .status-badge {
        padding: 0.3rem 1rem;
        border-radius: 20px;
        font-size: 0.85rem;
        background: rgba(255, 255, 255, 0.1);
    }

    .rating-stars {
        color: var(--accent-color);
        font-size: 1.1rem;
    }

    .btn-actions {
        border: 1px solid #30363d;
        background: rgba(255, 255, 255, 0.05);
        color: var(--text-secondary);
        transition: all 0.3s ease;
        margin: 5px;
    }

    .btn-actions:hover {
        background: var(--accent-color);
        color: var(--primary-color);
        border-color: var(--accent-color);
    }

    .text-truncate-3 {
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
</style>

<div class="container">
    <div class="header-section">
        <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
            <div>
                <h2 class="custom-h2 fw-bold text-start me-2"><i class="fa-solid fa-list"></i> <?= isset($_GET['page']) && $_GET['page'] == 'pending' ? 'UnApproved Items' : 'Manage Items' ?></h2>
            </div>
            <div class="d-flex align-items-center flex-wrap gap-3">
                <!-- زر الترتيب -->
                <a id="sortOrdering" class="btn btn-secondary" href="?sort=<?= $sort ?>">
                    <i class="fa-solid fa-sort"></i> Sort Ordering
                </a>
                <!-- زر عرض الكل -->
                <a id="showAll" class="btn btn-primary" href="items.php?do=all_comments">
                    <i class="fa-solid fa-list"></i> Show All Items
                </a>
                <!-- زر إضافة عنصر جديد -->
                <a href="items.php?do=add" class="btn btn-success">
                    <i class="fas fa-plus-circle me-2"></i>Add New Item
                </a>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <?php foreach ($rows as $item): ?>
            <?php if (isset($_GET['page']) && $_GET['page'] == 'pending') : ?>
                <?php if ($item['Approve'] == 0) : ?>
                    <div class="col-12 col-md-6 col-lg-4">
                        <div class="item-card h-100">
                            <div class="card-header">
                                <div class="d-flex justify-content-between align-items-center mb-2 text-white">
                                    <h5 class="mb-0"><?= $item['Name'] ?></h5>
                                    <h6 class="text-white">#<?= $item['itemsID'] ?></h6>
                                </div>
                                <div class="d-flex gap-2 text-sm">
                                    <span class="badge bg-dark">
                                        <i class="fas fa-tag me-1"></i><?= $item['Cat_Name'] ?>
                                    </span>
                                    <span class="badge bg-dark">
                                        <i class="fas fa-user me-1"></i><?= $item['User_Name'] ?>
                                    </span>
                                </div>
                            </div>

                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-start mb-3">
                                    <div class="price-tag">
                                        <?= number_format($item['Price'], 2) ?> $
                                    </div>
                                    <div class="status-badge">
                                        <?= getStatusLabel($item['Status']) ?>
                                    </div>
                                </div>
                                <strong class="text-white">
                                    <p class="card-text text-truncate-3 mb-4 text-white">
                                        <?= $item['Description'] ?>
                                    </p>
                                </strong>
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="rating-stars">
                                        <?= generateStarRating($item['Rating']) ?>
                                    </div>
                                    <div class="text-muted small ">
                                        <strong class="text-white">
                                            <i class="fas fa-clock me-1"></i>
                                            <?= date('M d, Y', strtotime($item['AddDate'])) ?>
                                        </strong>
                                    </div>
                                </div>
                            </div>

                            <div class="card-footer bg-transparent">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="btn-group">
                                        <a href="items.php?do=edit&itemid=<?= $item['itemsID'] ?>"
                                            class="btn btn-actions btn-sm">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <a href="items.php?do=delete&itemid=<?= $item['itemsID'] ?>"
                                            class="btn btn-actions btn-sm delete-btn">
                                            <i class="fas fa-trash"></i>
                                        </a>
                                    </div>
                                    <?php if ($item['Approve'] == 0): ?>
                                        <a href="items.php?do=approve&itemid=<?= $item['itemsID'] ?>"
                                            class="btn btn-sm btn-success px-3">
                                            Approve
                                        </a>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endif ?>
            <?php endif ?>
        <?php endforeach; ?>

        <?php foreach ($rows as $item): ?>
            <?php if (isset($_GET['page']) && $_GET['page'] == 'unpending') : ?>
                <?php if ($item['Approve'] == 1) : ?>
                    <div class="col-12 col-md-6 col-lg-4">
                        <div class="item-card h-100">
                            <div class="card-header">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <h5 class="mb-0"><?= $item['Name'] ?></h5>
                                    <div class="text-muted">#<?= $item['itemsID'] ?></div>
                                </div>
                                <div class="d-flex gap-2 text-sm">
                                    <span class="badge bg-dark">
                                        <i class="fas fa-tag me-1"></i><?= $item['Cat_Name'] ?>
                                    </span>
                                    <span class="badge bg-dark">
                                        <i class="fas fa-user me-1"></i><?= $item['User_Name'] ?>
                                    </span>
                                </div>
                            </div>

                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-start mb-3">
                                    <div class="price-tag">
                                        <?= number_format($item['Price'], 2) ?> $
                                    </div>
                                    <div class="status-badge">
                                        <?= getStatusLabel($item['Status']) ?>
                                    </div>
                                </div>
                                <strong class="text-white">
                                    <p class="card-text text-truncate-3 mb-4 text-white">
                                        <?= $item['Description'] ?>
                                    </p>
                                </strong>
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="rating-stars">
                                        <?= generateStarRating($item['Rating']) ?>
                                    </div>
                                    <div class="text-muted small ">
                                        <strong class="text-white">
                                            <i class="fas fa-clock me-1"></i>
                                            <?= date('M d, Y', strtotime($item['AddDate'])) ?>
                                        </strong>
                                    </div>
                                </div>
                            </div>

                            <div class="card-footer bg-transparent">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="btn-group">
                                        <a href="items.php?do=edit&itemid=<?= $item['itemsID'] ?>"
                                            class="btn btn-actions btn-sm">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <a href="items.php?do=delete&itemid=<?= $item['itemsID'] ?>"
                                            class="btn btn-actions btn-sm delete-btn">
                                            <i class="fas fa-trash"></i>
                                        </a>
                                    </div>
                                    <?php if ($item['Approve'] == 0): ?>
                                        <a href="items.php?do=approve&itemid=<?= $item['itemsID'] ?>"
                                            class="btn btn-sm btn-success px-3">
                                            Approve
                                        </a>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endif ?>
            <?php endif ?>
        <?php endforeach; ?>

        <?php foreach ($rows as $item): ?>
            <?php if (!isset($_GET['page'])) : ?>
                <div class="col-12 col-md-6 col-lg-4">
                    <div class="item-card h-100">
                        <div class="card-header">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <h5 class="mb-0"><?= $item['Name'] ?></h5>
                                <div class="text-muted">#<?= $item['itemsID'] ?></div>
                            </div>
                            <div class="d-flex gap-2 text-sm">
                                <span class="badge bg-dark">
                                    <i class="fas fa-tag me-1"></i><?= $item['Cat_Name'] ?>
                                </span>
                                <span class="badge bg-dark">
                                    <i class="fas fa-user me-1"></i><?= $item['User_Name'] ?>
                                </span>
                            </div>
                        </div>

                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-start mb-3">
                                <div class="price-tag">
                                    <?= number_format($item['Price'], 2) ?> $
                                </div>
                                <div class="status-badge">
                                    <?= getStatusLabel($item['Status']) ?>
                                </div>
                            </div>
                            <strong class="text-white">
                                <p class="card-text text-truncate-3 mb-4 text-white">
                                    <?= $item['Description'] ?>
                                </p>
                            </strong>
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="rating-stars">
                                    <?= generateStarRating($item['Rating']) ?>
                                </div>
                                <div class="text-muted small ">
                                    <strong class="text-white">
                                        <i class="fas fa-clock me-1"></i>
                                        <?= date('M d, Y', strtotime($item['AddDate'])) ?>
                                    </strong>
                                </div>
                            </div>
                        </div>

                        <div class="card-footer bg-transparent">
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="btn-group">
                                    <a href="items.php?do=edit&itemid=<?= $item['itemsID'] ?>"
                                        class="btn btn-actions btn-sm">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <a href="items.php?do=delete&itemid=<?= $item['itemsID'] ?>"
                                        class="btn btn-actions btn-sm delete-btn">
                                        <i class="fas fa-trash"></i>
                                    </a>
                                </div>
                                <?php if ($item['Approve'] == 0): ?>
                                    <a href="items.php?do=approve&itemid=<?= $item['itemsID'] ?>"
                                        class="btn btn-sm btn-success px-3">
                                        Approve
                                    </a>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endif ?>
        <?php endforeach; ?>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    $(document).ready(function() {
        $('.delete-btn').on('click', function(e) {
            e.preventDefault();
            const deleteUrl = $(this).attr('href');

            Swal.fire({
                title: 'Confirm Delete',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#4ecca3',
                cancelButtonColor: '#dc3545',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = deleteUrl;
                }
            });
        });
    });
</script>