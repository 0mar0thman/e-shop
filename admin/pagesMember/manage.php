<?php
if (isset($_GET['page']) && $_GET['page'] == 'pending') {
    $query = 'AND RagStatus = 0';
} elseif (isset($_GET['page']) && $_GET['page'] == 'unpending') {
    $query = 'AND RagStatus = 1';
} else {
    $query = null;
}
$sort = isset($_GET['sort']) && $_GET['sort'] == 'DESC' ? 'ASC' : 'DESC';
$stmt = $con->prepare("SELECT * FROM users WHERE GroupID = 1 AND AdminID = 0 $query 
                       ORDER BY UserID $sort
                       LIMIT 25");
$stmt->execute();
$rows = $stmt->fetchAll();
?>

<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <!-- Header Section -->
                <div class="members-header-section">
                    <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
                        <!-- العنوان الرئيسي (يسار الصفحة) -->
                        <div>
                            <h2 class="custom-header fw-bold text-start me-2"><i class="fa-solid fa-user"></i> <?= isset($_GET['page']) && $_GET['page'] == 'pending' ? 'UnActived Members' : 'Manage Members' ?></h2>
                        </div>

                        <!-- الأزرار (يمين الصفحة) -->
                        <div class="d-flex align-items-center flex-wrap gap-3">
                            <!-- زر الترتيب -->
                            <a id="members-sortOrdering" class="members-btn members-btn-secondary" href="?sort=<?= $sort ?>">
                                <i class="fa-solid fa-sort"></i> Sort Ordering
                            </a>
                            <!-- زر عرض الكل -->
                            <a id="members-showAll" class="members-btn members-btn-primary" href="members.php?do=all_comments">
                                <i class="fa-solid fa-list"></i> Show All Comments
                            </a>
                            <!-- زر إضافة عضو جديد -->
                            <a href="members.php?do=add" class="members-btn members-btn-success">
                                <i class="fas fa-plus-circle me-2"></i>Add New Member
                            </a>
                        </div>
                    </div>
                </div>

                <?php if (isset($_GET['page']) && $_GET['page'] == 'pending') : ?>
                    <div class="row mt-4 g-4">
                        <?php foreach ($rows as $member): ?>
                            <?php if ($member['RagStatus'] == 0): ?>
                                <div class="col-md-6 col-lg-4">
                                    <div class="members-card shadow-sm border-0">
                                        <div class="members-card-body">
                                            <div class="d-flex align-items-center mb-3">
                                                <div class="members-icon-circle bg-primary text-white me-3">
                                                    <i class="fas fa-user"></i>
                                                </div>
                                                <h5 class="members-card-title mb-0"><?= htmlspecialchars($member['Username']) ?></h5>
                                            </div>
                                            <hr>
                                            <p class="members-card-text text-muted mb-3">
                                                <strong class="text-white">Email:</strong>
                                                <span><?= htmlspecialchars($member['Email']) ?></span><br>
                                                <strong>Full Name:</strong>
                                                <span><?= htmlspecialchars($member['FullName']) ?></span><br>
                                                <strong>Registered Date:</strong>
                                                <span><?= htmlspecialchars($member['Date']) ?></span>
                                            </p>
                                            <div class="d-flex justify-content-between">
                                                <a class="members-btn members-btn-sm members-btn-danger delete-btn" href="members.php?do=delete&id=<?= $member['UserID'] ?>">
                                                    <i class="fas fa-trash"></i> Delete
                                                </a>
                                                <?php if ($member['RagStatus'] == 0): ?>
                                                    <a class="members-btn members-btn-sm members-btn-success active-btn" href="members.php?do=active&id=<?= $member['UserID'] ?>">
                                                        <i class="fas fa-check"></i> Active
                                                    </a>
                                                <?php endif; ?>
                                                <a class="members-btn members-btn-sm members-btn-primary edit-btn " href="members.php?do=edit&id=<?= $member['UserID'] ?>">
                                                    <i class="fas fa-edit"></i> Edit
                                                </a>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endif ?>
                        <?php endforeach; ?>
                    </div>
                <?php endif ?>

                <?php if (isset($_GET['page']) &&  $_GET['page'] == 'unpending') : ?>
                    <div class="row mt-4 g-4">
                        <?php foreach ($rows as $member): ?>
                            <?php if ($member['RagStatus'] == 1): ?>
                                <div class="col-md-6 col-lg-4">
                                    <div class="members-card shadow-sm border-0">
                                        <div class="members-card-body">
                                            <div class="d-flex align-items-center mb-3">
                                                <div class="members-icon-circle bg-primary text-white me-3">
                                                    <i class="fas fa-user"></i>
                                                </div>
                                                <h5 class="members-card-title mb-0"><?= htmlspecialchars($member['Username']) ?></h5>
                                            </div>
                                            <hr>
                                            <p class="members-card-text text-muted mb-3">
                                                <strong class="text-white">Email:</strong>
                                                <span><?= htmlspecialchars($member['Email']) ?></span><br>
                                                <strong>Full Name:</strong>
                                                <span><?= htmlspecialchars($member['FullName']) ?></span><br>
                                                <strong>Registered Date:</strong>
                                                <span><?= htmlspecialchars($member['Date']) ?></span>
                                            </p>
                                            <div class="d-flex justify-content-between">
                                                <a class="members-btn members-btn-sm members-btn-danger delete-btn" href="members.php?do=delete&id=<?= $member['UserID'] ?>">
                                                    <i class="fas fa-trash"></i> Delete
                                                </a>
                                                <a class="members-btn members-btn-sm members-btn-primary edit-btn " href="members.php?do=edit&id=<?= $member['UserID'] ?>">
                                                    <i class="fas fa-edit"></i> Edit
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endif ?>
                        <?php endforeach; ?>
                    </div>
                <?php endif ?>

                <?php if (!isset($_GET['page'])) : ?>
                    <div class="row mt-4 g-4">
                        <?php foreach ($rows as $member): ?>
                            <div class="col-md-6 col-lg-4">
                                <div class="members-card shadow-sm border-0">
                                    <div class="members-card-body">
                                        <div class="d-flex align-items-center mb-3">
                                            <div class="members-icon-circle bg-primary text-white me-3">
                                                <i class="fas fa-user"></i>
                                            </div>
                                            <h5 class="members-card-title mb-0"><?= htmlspecialchars($member['Username']) ?></h5>
                                        </div>
                                        <hr>
                                        <p class="members-card-text text-muted mb-3">
                                            <strong class="text-white">Email:</strong>
                                            <span><?= htmlspecialchars($member['Email']) ?></span><br>
                                            <strong>Full Name:</strong>
                                            <span><?= htmlspecialchars($member['FullName']) ?></span><br>
                                            <strong>Registered Date:</strong>
                                            <span><?= htmlspecialchars($member['Date']) ?></span>
                                        </p>
                                        <div class="d-flex justify-content-between">
                                            <a class="members-btn members-btn-sm members-btn-danger delete-btn" href="members.php?do=delete&id=<?= $member['UserID'] ?>">
                                                <i class="fas fa-trash"></i> Delete
                                            </a>
                                            <?php if ($member['RagStatus'] == 0): ?>
                                                <a class="members-btn members-btn-sm members-btn-success active-btn" href="members.php?do=active&id=<?= $member['UserID'] ?>">
                                                    <i class="fas fa-check"></i> Active
                                                </a>
                                            <?php endif; ?>
                                            <a class="members-btn members-btn-sm members-btn-primary edit-btn " href="members.php?do=edit&id=<?= $member['UserID'] ?>">
                                                <i class="fas fa-edit"></i> Edit
                                            </a>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif ?>
            </div>
        </div>
    </div>
</body>
