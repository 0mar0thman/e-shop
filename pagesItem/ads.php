<div class="profile-card p-2 col-md-12">
    <h3>Latest Advertisements</h3>
    <div class="scrollable-container">
        <div class="row g-3">
            <?php if (empty($userItems)): ?>
                <div class="d-flex gap-2 fs-5">
                    <span class="badge bg-dark fs-5">No items added</span>
                </div>
            <?php endif; ?>

            <?php foreach ($userItems as $item): ?>
                <?php if ($item['Approve'] == 0): ?>
                    <div class="col-12 col-md-6 col-lg-4 pb-4">
                        <a href="item.php?itemid=<?= $item['itemsID'] ?>" class="text-decoration-none">
                            <div class="item-card h-100">
                                <div class="card-header">
                                    <div class="d-flex justify-content-between align-items-center mb-2 text-white">
                                        <h5 class="mb-0"><?= $item['ItemName'] ?></h5>
                                        <h6 class="text-white">#<?= $item['itemsID'] ?></h6>
                                    </div>
                                    <div class="d-flex gap-2 text-sm">
                                        <span class="badge bg-dark">
                                            <i class="fas fa-tag me-1"></i><?= $item['Name'] ?>
                                        </span>
                                    </div>
                                </div>

                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-start mb-23">
                                        <div class="price-tag">
                                            $<?= number_format($item['Price'], 2) ?>
                                        </div>
                                        <div class="status-badge">
                                            <?= $item['Status'] ?>
                                        </div>
                                    </div>
                                    <p class="card-text text-truncate-3 mb-4 text-white fw-bold">
                                        <?= $item['Description'] ?>
                                    </p>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div class="rating-stars">
                                            <?php
                                            for ($i = 0; $i < 5; $i++) {
                                                echo $i < $item['Rating']
                                                    ? '<i class="fas fa-star"></i>'
                                                    : '<i class="far fa-star"></i>';
                                            }
                                            ?>
                                        </div>
                                        <div class="text-muted small">
                                            <strong class="text-white">
                                                <i class="fas fa-clock me-1"></i>
                                                <?= date('M d, Y', strtotime($item['AddDate'])) ?>
                                            </strong>
                                        </div>
                                    </div>
                                </div>

                                <div class="card-footer bg-transparent">
                                    <div class="btn-group">
                                        <a href="profile.php?do=ads_edit&itemid=<?= $item['itemsID'] ?>"
                                            class="btn btn-actions btn-sm">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <a href="profile.php?do=delete&itemid=<?= $item['itemsID'] ?>"
                                            class="btn btn-actions btn-sm delete-btn">
                                            <i class="fas fa-trash"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                <?php endif; ?>
            <?php endforeach; ?>
        </div>
    </div>
</div>