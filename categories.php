<?php
session_start();
$pageTitle = 'Category';
include 'init.php';

$CatName = $_GET['name'];
$id = $_GET['cid'];
$desc = retrieveCategoryById($_GET['cid']);

$items = fetchItemsByCategoryId($id);
?>

<div class="container">
    <div class="header-section">
        <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
            <div>
                <h2 class="custom-h2 fw-bold text-start me-2"><i class="fa-solid fa-list"></i> <?= isset($_GET['name']) ? $_GET['name'] : 'Items' ?></h2>
                <h6>
                    <?php foreach ($desc as $desc) echo $desc['Description'] ?>
                </h6>
            </div>
            <!-- <div class="d-flex align-items-center flex-wrap gap-3">
                <a id="sortOrdering" class="btn btn-secondary" href="?sort=<?= $sort ?>">
                    <i class="fa-solid fa-sort"></i> Sort Ordering
                </a>
                <a id="showAll" class="btn btn-primary" href="items.php?do=all_comments">
                    <i class="fa-solid fa-list"></i> Show All Items
                </a>
                <a href="items.php?do=add" class="btn btn-success">
                    <i class="fas fa-plus-circle me-2"></i>Add New Item
                </a>
            </div> -->
        </div>
    </div>

    <div class="row g-4">
        <?php if (empty($items)):   ?>
            <div class="d-flex gap-2 fs-5">
                <span class="badge bg-dark fs-5">
                    on any item
                </span>
            </div>
        <?php endif ?>
        <?php foreach ($items as $item): ?>
            <?php if ($item['Approve'] == 1) : ?>
                <div class="col-12 col-md-6 col-lg-4">
                    <a href="item.php?itemid=<?= $item['itemsID'] ?>" class="text-decoration-none">

                        <div class="item-card h-100">
                            <div class="card-header">
                                <div class="d-flex justify-content-between align-items-center mb-2 text-white">
                                    <h5 class="mb-0"><?= $item['Name'] ?></h5>
                                    <h6 class="text-white">#<?= $item['itemsID'] ?></h6>
                                </div>
                                <div class="d-flex gap-2 text-sm">
                                    <span class="badge bg-dark">
                                        <i class="fas fa-tag me-1"></i><?= $CatName ?>
                                    </span>
                                </div>
                            </div>

                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-start mb-3">
                                    <div class="price-tag">
                                        <?= number_format($item['Price'], 2) ?> $
                                    </div>
                                    <div class="status-badge">
                                        <?= $item['Status'] ?>
                                    </div>
                                </div>
                                <strong class="text-white">
                                    <p class="card-text text-truncate-3 mb-4 text-white">
                                        <?= $item['Description'] ?>
                                    </p>
                                </strong>
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="rating-stars">
                                        <?php
                                        $rating = $item['Rating'];
                                        for ($i = 0; $i < 5; $i++) {
                                            if ($i < $rating) {
                                                echo '<i class="fas fa-star"></i>';
                                            } else {
                                                echo '<i class="far fa-star"></i>';
                                            }
                                        }
                                        ?>
                                    </div>

                                    <div class="text-muted small ">
                                        <strong class="text-white">
                                            <i class="fas fa-clock me-1"></i>
                                            <?= date('M d, Y', strtotime($item['AddDate'])) ?>
                                        </strong>
                                    </div>
                                </div>
                            </div>

                            <!-- <div class="card-footer bg-transparent">
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
                                </div>
                            </div> -->
                        </div>
                    </a>
                </div>
            <?php endif ?>
        <?php endforeach; ?>
    </div>
</div>
<?php include $tpl . 'footer.php'; ?>