<?php
session_start();
if (isset($_SESSION['user'])) {
    $pageTitle = "Dashboard";
    include 'init.php';

    $getLatest = getLatest("*", "users", "Date", "40");
    $getLatestItems = getLatest("*", "items", "AddDate", "40");
    $getLatestComments = getLatest("*", "comments", "CommentDate", "100");

    $pendingUsers = getPendingUsers();
    $countPendingUsers = count($pendingUsers);

    $pendingItems = getPendingItems();
    $countPendingItems = count($pendingItems);

    $pendingComments = getPendingComments();
    $countPendingComments = count($pendingComments);

    $countUsers = count($getLatest);
    $countItems = count($getLatestItems);
    $countCommenta = count($getLatestComments);
?>
    <style>
        .list ul,
        .comment-cards {
            max-height: 500px;
            overflow-y: auto;
            padding-right: 5px;
            margin-bottom: 15px;
        }
    </style>

    <div class="dashboard-container">
        <div class="stats">
            <a class="stat-box stat-box-total bg-dark a" href="members.php">
                <div class="d-flex justify-content-center">
                    <i class="fa-solid fa-users pe-4" style="color: #74C0FC;  font-size: 50px"></i>
                    <div>
                        <strong>
                            <h2 class="text-dashboard">Total Members</h2>
                        </strong>
                        <p><?= totalMembers('UserID', 'users') - 1 ?></p>
                    </div>
                </div>
            </a>
            <a class="stat-box stat-box-total bg-dark a" href="items.php">
                <div class="d-flex justify-content-center">
                    <i class="fa-solid fa-table-list pe-4" style="color: #74C0FC;  font-size: 50px"></i>
                    <div>
                        <strong>
                            <h2>Total Items</h2>
                        </strong>
                        <p><?= totalMembers('itemsID', 'items') ?></p>
                    </div>
                </div>
            </a>

            <a class="stat-box stat-box-total bg-dark a" href="comments.php">
                <div class="d-flex justify-content-center">
                    <i class="fa-solid fa-comments pe-4" style="color: #74C0FC;  font-size: 50px"></i>
                    <div>
                        <strong>
                            <h2>Total Comments</h2>
                        </strong>
                        <p><?= totalMembers('CID', 'comments') ?></p>
                    </div>
                </div>
            </a>

            <a class="stat-box stat-box-pending bg-dark a" href="members.php?page=pending">
                <div class="d-flex justify-content-center">
                    <i class="fa-solid fa-user-minus pe-4" style="color: #ff3d3d;  font-size: 50px"></i>
                    <div>
                        <strong>
                            <h2>Pending Members</h2>
                        </strong>
                        <p><?= $countPendingUsers ?></p>
                    </div>
                </div>
            </a>

            <a class="stat-box stat-box-pending bg-dark a" href="items.php?page=pending">
                <div class="d-flex justify-content-center">
                    <i class="fa-solid fa-layer-group pe-4" style="color: #ff3d3d; font-size: 50px"></i>
                    <div>
                        <strong>
                            <h2>Pending Items</h2>
                        </strong>
                        <p><?= $countPendingItems ?></p>
                    </div>
                </div>
            </a>

            <a class="stat-box stat-box-pending bg-dark a" href="comments.php?page=pending">
                <div class="d-flex justify-content-center">
                    <i class="fa-solid fa-comment-nodes pe-4" style="color: #ff3d3d; font-size: 50px"></i>
                    <div>
                        <strong>
                            <h2>Pending Comments</h2>
                        </strong>
                        <p><?= checkItem('Status', 'comments', 0) ?></p>
                    </div>
                </div>
            </a>
        </div>

        <div class="lists">
            <div class="list bg-dark">
                <h2 class="text-light">Latest Members ( <?= totalMembers('UserID', 'users') - $countPendingUsers  ?> )
                    <a style="float : right" href="members.php?page=unpending">
                        <i class="fa-solid fa-angles-right text-secondary"></i>
                    </a>
                </h2>
                <ul>
                    <?php foreach ($getLatest as $value) : ?>
                        <?php if ($value['RagStatus'] == 1) : ?>
                            <li style="display: flex; justify-content: space-between; align-items: center;">
                                <?php echo $value["Username"]; ?>
                                <div style="display: flex; gap: 5px;">

                                    <a class='btn btn-sm btn-secondary edit-btn' href='members.php?do=edit&id=<?= $value['UserID']; ?>'>
                                        <i class='fas fa-edit'></i> Edit
                                    </a>
                                </div>
                            </li>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </ul>
            </div>

            <div class="list bg-dark">
                <h2 class="text-light">Pending Members ( <?= $countPendingUsers ?> )
                    <a style="float : right" href="members.php?page=pending">
                        <i class="fa-solid fa-angles-right text-secondary" style="float : right"></i>
                    </a>
                </h2>
                <ul>
                    <?php for ($i = 0; $i < min(10, count($getLatestItems)); $i++) : ?>
                        <li style="display: flex; justify-content: space-between; align-items: center;">
                            <?php echo $pendingUsers[$i]["Username"]; ?>
                            <div style="display: flex; gap: 5px;">
                                <a class='btn btn-sm btn-info active-btn' href='members.php?do=active&id=<?= $pendingUsers[$i]['UserID']; ?>'>
                                    <i class='fas fa-check'></i> Active
                                </a>
                                <a class='btn btn-sm btn-secondary edit-btn' href='members.php?do=edit&id=<?= $pendingUsers[$i]['UserID']; ?>'>
                                    <i class='fas fa-edit'></i> Edit
                                </a>
                            </div>
                        </li>
                    <?php endfor; ?>
                </ul>
            </div>

            <!-- أحدث الـ Items -->
            <div class="list bg-dark">
                <h2 class="text-light">Latest Items ( <?= totalMembers('itemsID', 'items') - $countPendingItems ?> )
                    <a style="float : right" href="items.php?page=unpending">
                        <i class="fa-solid fa-angles-right text-secondary" style="float : right"></i>
                    </a>
                </h2>
                <ul>
                    <?php foreach ($getLatestItems as $value) : ?>
                        <?php if ($value["Approve"] == 1) : ?>
                            <li style="display: flex; justify-content: space-between; align-items: center;">
                                <?php echo $value["Name"]; ?>
                                <div style="display: flex; gap: 5px;">
                                    <a class='btn btn-sm btn-secondary edit-btn' href='items.php?do=edit&itemid=<?php echo $value['itemsID']; ?>'>
                                        <i class='fas fa-edit'></i> Edit
                                    </a>
                                </div>
                            </li>
                        <?php endif ?>
                    <?php endforeach; ?>
                </ul>
            </div>

            <div class="list bg-dark">
                <h2 class="text-light">Pending Items ( <?= $countPendingItems ?> )
                    <a style="float : right" href="items.php?page=pending">
                        <i class="fa-solid fa-angles-right text-secondary" style="float : right"></i>
                    </a>
                </h2>
                <ul>
                    <?php for ($i = 0; $i < min(10, count($getLatestItems)); $i++) : ?>
                        <li style="display: flex; justify-content: space-between; align-items: center;">
                            <?php echo $pendingItems[$i]["Name"]; ?>
                            <div style="display: flex; gap: 5px;">
                                <?php if ($pendingItems[$i]['Approve'] == 0): ?>
                                    <a class='btn btn-sm btn-info active-btn' href='items.php?do=approve&itemid=<?= $pendingItems[$i]['itemsID'] ?>'>
                                        <i class='fas fa-arrow-up'></i> Approve
                                    </a>
                                <?php endif; ?>
                                <a class='btn btn-sm btn-secondary edit-btn' href='items.php?do=edit&itemid=<?= $pendingItems[$i]['itemsID'] ?>'>
                                    <i class='fas fa-edit'></i> Edit
                                </a>
                            </div>
                        </li>
                    <?php endfor; ?>
                </ul>
            </div>

            <div class="list bg-dark">
                <h2 class="text-light">Latest Comments ( <?= $countPendingComments - checkItem('Status', 'comments', 0) ?> )
                    <a style="float: right" href="comments.php?page=unpending">
                        <i class="fa-solid fa-angles-right text-secondary"></i>
                    </a>
                </h2>
                <div class="comment-cards">
                    <?php for ($i = 0; $i < min(60, count($getLatestComments)); $i++) : ?>
                        <?php if ($pendingComments[$i]['Status'] == 1): ?>
                            <div class="comment-card">
                                <div class="comment-content">
                                    <div class="comment-header">
                                        <span class="comment-author"><?= $pendingComments[$i]["Username"] ?></span>
                                    </div>
                                    <div class="comment-body">
                                        <p><?= $pendingComments[$i]["Comment"] ?></p>
                                    </div>
                                </div>
                                <div class="comment-actions">
                                    <a class="btn btn-sm btn-secondary edit-btn" href="comments.php?do=edit&comid=<?= $pendingComments[$i]['CID'] ?>">
                                        <i class="fas fa-edit"></i> Edit
                                    </a>
                                </div>
                            </div>
                        <?php endif; ?>
                    <?php endfor; ?>
                </div>
            </div>

            <div class="list bg-dark">
                <h2 class="text-light">Pending Comments ( <?= checkItem('Status', 'comments', 0) ?> )
                    <a style="float : right" href="comments.php?page=pending">
                        <i class="fa-solid fa-angles-right text-secondary" style="float : right"></i>
                    </a>
                </h2>
                <div class="comment-cards">
                    <?php for ($i = 0; $i < min(60, count($getLatestComments)); $i++) : ?>
                        <?php if ($pendingComments[$i]['Status'] == 0): ?>
                            <div class="comment-card">
                                <div class="comment-content">
                                    <div class="comment-header">
                                        <span class="comment-author"><?= $pendingComments[$i]["Username"] ?></span>
                                    </div>
                                    <div class="comment-body">
                                        <p><?= $pendingComments[$i]["Comment"] ?></p>
                                    </div>
                                </div>
                                <div class="comment-actions">

                                    <a class="btn btn-sm btn-info active-btn" href="comments.php?do=approve&comid=<?= $pendingComments[$i]['CID'] ?>">
                                        <i class="fas fa-arrow-up"></i> Approve
                                    </a>

                                    <a class="btn btn-sm btn-secondary edit-btn" href="comments.php?do=edit&comid=<?= $pendingComments[$i]['CID'] ?>">
                                        <i class="fas fa-edit"></i> Edit
                                    </a>
                                </div>
                            </div>
                        <?php endif; ?>
                    <?php endfor; ?>
                </div>
            </div>
        </div>
    <?php
    include $tpl . 'footer.php';
} else {
    header('location: index.php');
}
    ?>
    <script>
        $(function() {
            'use strict';
            $(".toggle-info").click(function() {
                $(this).toggleClass('.selected').parent().next('.panel-body').fadeToggle(100);
                if ($(this).hasClass('selected')) {
                    $(this).html('<i class="fa fa-minus fa-lg"></i>')
                } else {
                    $(this).html('<i class="fa fa-plus fa-lg"></i>')
                }
            })
        })
    </script>

    <script>
        // تفعيل التمرير السلس
        $(document).ready(function() {
            $('.list ul, .comment-cards').scroll(function() {
                $(this).css('scroll-behavior', 'smooth');
            });

            // إضافة ظل أثناء التمرير
            $('.list').each(function() {
                const list = $(this).find('ul, .comment-cards');
                list.scroll(function() {
                    const shadow = $(this).closest('.list');
                    if (this.scrollTop > 0) {
                        shadow.addClass('scrolling');
                    } else {
                        shadow.removeClass('scrolling');
                    }
                });
            });
        });
    </script>