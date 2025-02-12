<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['comid'], $_POST['comment'])) {
    $commentID = $_POST['comid'];
    $newComment = $_POST['comment'];

    // Prepare and execute the update query
    if (!empty($newComment)) {
        $stmt = $con->prepare("UPDATE comments SET Comment = ? WHERE CID = ?");
        $stmt->execute([$newComment, $commentID]);
    } else {
        echo "<div class='alert alert-warning'>Comment cannot be empty!</div>";
    }

    if ($stmt->rowCount() > 0) {
        header("Location: profile.php?do=all_comments");
        exit();
    } else {
        echo "<div class='alert alert-danger'>Failed to update the comment!</div>";
    }
    // Redirect after updating
    header("Location: profile.php?do=all_comments");
    exit();
}

// Check if 'cid' is set in the URL
$commentData = null;
if (isset($_GET['cid'])) {
    $commentID = $_GET['cid'];

    // Fetch the comment data
    $stmt = $con->prepare("SELECT Comment FROM comments WHERE CID = ?");
    $stmt->execute([$commentID]);
    $commentData = $stmt->fetch(); // Fetch only one row
}
?>

<!-- Edit Comment Section -->
<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card shadow-lg needs-validation text-white bg-dark">
                <a id="sortOrdering" class="btn btn-sm btn-secondary w-25"
                    style="margin: 10px; position: absolute; right: 5px"
                    href="<?= htmlspecialchars($_SERVER['HTTP_REFERER'] ?? 'profile.php?do=all_comments') ?>">
                    <i class="fa-solid fa-backward"></i> Back
                </a>
                <div class="p-4 mt-4">
                    <?php if ($commentData): ?>
                        <form method="POST" action='profile.php?do=comments_edit&cid=<?= $_GET["cid"] ?>' novalidate>
                            <input type="hidden" name="comid" value="<?= htmlspecialchars($commentID) ?>">
                            <div class="row">
                                <div class="col-md-6 mb-4">
                                    <label for="comment" class="form-label fw-bold">Edit Comment</label>
                                    <textarea class="form-control" name="comment"><?= htmlspecialchars($commentData['Comment']) ?></textarea>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 offset-md-3 mt-4">
                                    <button type="submit" class="btn btn-primary btn-lg fw-bold text-white w-100">
                                        Save Changes
                                    </button>
                                </div>
                            </div>
                        </form>
                    <?php else: ?>
                        <div class="alert alert-warning text-center">
                            <h4 class="mb-0">No comment data found!</h4>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>