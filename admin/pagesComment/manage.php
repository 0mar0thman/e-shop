<?php
$sort = isset($_GET['sort']) && $_GET['sort'] == 'DESC' ?  'ASC'  :  'DESC';
$limit = 100;
$stmt = $con->prepare("SELECT comments.*, items.Name, users.Username
                       FROM comments
                       INNER JOIN items ON items.itemsID = comments.ItemID
                       INNER JOIN users ON users.UserID = comments.UserID 
                       ORDER BY comments.CommentDate $sort
                       LIMIT $limit");
$stmt->execute();
$rows = $stmt->fetchAll();
?>
<style>
    .comment-card {
        background-color: #212529;
        border: 1px solid #444;
        border-radius: 10px;
        margin-bottom: 15px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);
        transition: transform 0.2s, box-shadow 0.2s;
        display: block;
    }

    .comment-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.5);
    }

    .comment-header {
        background-color: #2c3036;
        padding: 10px;
        border-bottom: 1px solid #444;
        border-radius: 10px 10px 0 0;
    }

    .comment-body {
        padding: 15px;
    }

    .comment-footer {
        background-color: #2c3034;
        padding: 10px;
        border-top: 1px solid #444;
        border-radius: 0 0 10px 10px;
    }

    .btn-custom {
        margin: 2px;
    }


    .text-muted {
        color: #aaa !important;
    }

    .header-section {
        background-color: #1e1e1e;
        padding: 20px;
        border-radius: 15px;
        margin-bottom: 30px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    }
</style>
<div class="container ">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="header-section">
                <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
                    <h2 class="fw-bold"><i class="fas fa-comment"></i> Manage Comments</h2>
                    <div class="d-flex gap-3">
                        <!-- زر الترتيب -->
                        <a id="sortOrdering" class="btn btn-secondary" href="?sort=<?= $sort ?>">
                            <i class="fa-solid fa-sort"></i> Sort Ordering
                        </a>
                        <!-- زر عرض الكل -->
                        <a id="showAll" class="btn btn-primary" href="comments.php?do=all_comments">
                            <i class="fa-solid fa-list"></i> Show All
                        </a>
                    </div>
                </div>
            </div>

            <!-- عرض التعليقات باستخدام البطاقات -->
            <div id="commentsContainer">
                <?php if (!isset($_GET['page'])) : ?>
                    <?php foreach ($rows as $com): ?>
                        <div class="comment-card">
                            <div class="comment-header">
                                <strong>Comment #<?= $com['CID'] ?></strong>
                                <span class="float-end text-muted"><?= $com['CommentDate'] ?></span>
                            </div>
                            <div class="comment-body">
                                <p><?= $com['Comment'] ?></p>
                                <div class="text-muted">
                                    <strong>Item:</strong> <?= $com['Name'] ?> |
                                    <strong>User:</strong> <?= $com['Username'] ?>
                                </div>
                            </div>
                            <div class="comment-footer">
                                <a class="btn btn-sm btn-danger btn-custom" href="comments.php?do=delete&comid=<?= $com['CID'] ?>" id="delete-<?= $com['CID'] ?>">
                                    <i class="fas fa-trash"></i> Delete
                                </a>
                                <a class="btn btn-sm btn-primary btn-custom" href="comments.php?do=edit&comid=<?= $com['CID'] ?>">
                                    <i class="fas fa-edit"></i> Edit
                                </a>
                                <a class="btn btn-sm btn-secondary btn-custom" href="comments.php?do=all_comments&comid=<?= $com['UserID'] ?>">
                                    <i class="fas fa-comment"></i> All Comments
                                </a>
                                <?php if ($com['Status'] == 0): ?>
                                    <a class="btn btn-sm btn-info btn-custom" href="comments.php?do=approve&comid=<?= $com['CID'] ?>">
                                        <i class="fas fa-check"></i> Approve
                                    </a>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif ?>

                <?php if (isset($_GET['page']) && ($_GET['page']) == 'pending') : ?>
                    <?php foreach ($rows as $com): ?>
                        <?php if ($com['Status'] == 0): ?>
                            <div class="comment-card">
                                <div class="comment-header">
                                    <strong>Comment #<?= $com['CID'] ?></strong>
                                    <span class="float-end text-muted"><?= $com['CommentDate'] ?></span>
                                </div>
                                <div class="comment-body">
                                    <p><?= $com['Comment'] ?></p>
                                    <div class="text-muted">
                                        <strong>Item:</strong> <?= $com['Name'] ?> |
                                        <strong>User:</strong> <?= $com['Username'] ?>
                                    </div>
                                </div>
                                <div class="comment-footer">
                                    <a class="btn btn-sm btn-danger btn-custom" href="comments.php?do=delete&comid=<?= $com['CID'] ?>" id="delete-<?= $com['CID'] ?>">
                                        <i class="fas fa-trash"></i> Delete
                                    </a>
                                    <a class="btn btn-sm btn-primary btn-custom" href="comments.php?do=edit&comid=<?= $com['CID'] ?>">
                                        <i class="fas fa-edit"></i> Edit
                                    </a>
                                    <a class="btn btn-sm btn-secondary btn-custom" href="comments.php?do=all_comments&comid=<?= $com['UserID'] ?>">
                                        <i class="fas fa-comment"></i> All Comments
                                    </a>

                                    <a class="btn btn-sm btn-info btn-custom" href="comments.php?do=approve&comid=<?= $com['CID'] ?>">
                                        <i class="fas fa-check"></i> Approve
                                    </a>
                                </div>
                            </div>
                        <?php endif; ?>
                    <?php endforeach; ?>
                <?php endif ?>

                <?php if (isset($_GET['page']) && ($_GET['page']) == 'unpending') : ?>
                    <?php foreach ($rows as $com): ?>
                        <?php if ($com['Status'] == 1): ?>
                            <div class="comment-card">
                                <div class="comment-header">
                                    <strong>Comment #<?= $com['CID'] ?></strong>
                                    <span class="float-end text-muted"><?= $com['CommentDate'] ?></span>
                                </div>
                                <div class="comment-body">
                                    <p><?= $com['Comment'] ?></p>
                                    <div class="text-muted">
                                        <strong>Item:</strong> <?= $com['Name'] ?> |
                                        <strong>User:</strong> <?= $com['Username'] ?>
                                    </div>
                                </div>
                                <div class="comment-footer">
                                    <a class="btn btn-sm btn-danger btn-custom" href="comments.php?do=delete&comid=<?= $com['CID'] ?>" id="delete-<?= $com['CID'] ?>">
                                        <i class="fas fa-trash"></i> Delete
                                    </a>
                                    <a class="btn btn-sm btn-primary btn-custom" href="comments.php?do=edit&comid=<?= $com['CID'] ?>">
                                        <i class="fas fa-edit"></i> Edit
                                    </a>
                                    <a class="btn btn-sm btn-secondary btn-custom" href="comments.php?do=all_comments&comid=<?= $com['UserID'] ?>">
                                        <i class="fas fa-comment"></i> All Comments
                                    </a>
                                </div>
                            </div>
                        <?php endif; ?>
                    <?php endforeach; ?>
                <?php endif ?>
            </div>
        </div>
    </div>
</div>

<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.5.0/dist/sweetalert2.min.js"></script>

<script>
    $(document).ready(function() {
        $('.btn-danger').click(function(e) {
            e.preventDefault();
            var url = $(this).attr('href');
            var comid = $(this).attr('id').split('-')[1];

            Swal.fire({
                title: 'Are you sure?',
                text: "Do you want to delete this comment?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, delete it!',
                cancelButtonText: 'Cancel',
                background: '#2d2d2d',
                color: '#f8f9fa',
                confirmButtonColor: '#dc3545',
                cancelButtonColor: '#6c757d'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: url,
                        type: 'GET',
                        success: function(response) {
                            console.log(response); // تحقق من الاستجابة في وحدة تحكم المتصفح
                            Swal.fire({
                                title: 'Deleted!',
                                text: 'The comment has been deleted.',
                                icon: 'success',
                                background: '#2d2d2d',
                                color: '#f8f9fa',
                                confirmButtonColor: '#0d6efd'
                            });
                            $('#delete-' + comid).closest('.comment-card').remove();
                        },
                        error: function(xhr, status, error) {
                            console.error(xhr.responseText); // طباعة الخطأ في الكونسول
                            Swal.fire({
                                title: 'Error!',
                                text: 'There was a problem deleting the comment.',
                                icon: 'error',
                                background: '#2d2d2d',
                                color: '#f8f9fa',
                                confirmButtonColor: '#dc3545'
                            });
                        }
                    });
                }
            });
        });
    });
</script>
