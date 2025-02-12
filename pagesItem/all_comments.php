<div class="bg-dark rounded mt-3">
    <h4 class="mt-3"><?= empty($allComments) ? 'No Comments Found' : 'Comments' ?></h4>
    <?php foreach ($allComments as $comment): ?>
        <?php if ($comment['Status'] == 1): ?>
            <div class="row justify-content-center">
                <div class="col-md-12" id="commentsContainer">
                    <div class="comment-card">
                        <div class="comment-header">
                            <strong>Comment #<?= $comment['CID'] ?></strong>
                            <span class="float-end text-light"><?= $comment['CommentDate'] ?></span>
                        </div>
                        <div class="d-flex align-items-center justify-content-between">
                            <div class="comment-body d-flex flex-column">
                                <div class="text-light">
                                    <strong>User:</strong> <?= $_SESSION['UserName'] ?>
                                </div>
                                <div class="ms-4 d-flex flex-wrap text-wrap" style="word-break: break-word;">
                                    <i class="fa-regular fa-comment"></i>
                                    <span class="ms-2"><?= $comment['Comment'] ?></span>
                                </div>
                            </div>

                            <div class="card-footer bg-transparent me-3">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="btn-group">
                                        <a href="profile.php?do=all_comments&cid=<?= $comment['CID'] ?>"
                                            class="btn btn-actions btn-sm">
                                            <i class="fas fa-trash"></i>
                                        </a>
                                        <?php
                                        if ((isset($_GET['do']) && $_GET['do'] == 'all_comments') && isset($_GET['cid'])) {

                                            deleteComments($comment['CID']);
                                            redirectToPreviousPage();
                                        }
                                        ?>
                                        <a href="profile.php?do=comments_edit&cid=<?= $comment['CID'] ?>"
                                            class="btn btn-actions btn-sm">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    <?php endforeach; ?>
</div>