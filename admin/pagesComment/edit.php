<?php
if (!isset($_SESSION['id'])) {
    echo '<h4 class="text-center mt-5">You must log in first.</h4>';
    exit();
}
$comid = is_numeric($_GET['comid']) && intval($_GET['comid']) ? $_GET['comid'] : 0;

Admin();

$stmt = $con->prepare("SELECT * FROM comments WHERE CID = ? ");
$stmt->execute(array($comid));
$rows = $stmt->fetch();
$count = $stmt->rowCount();

if ($count > 0) {
?>
    <div class="container my-5">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card shadow-lg needs-validation text-white">
                    <!-- زر ارجع -->
                    <a id="sortOrdering" class="btn btn-sm btn-secondary w-25" style="margin: 10px; position: absolute ; right: 5px" href="<?= $_SERVER['HTTP_REFERER'] ?>">
                        <i class="fa-solid fa-backward"></i> Back
                    </a>
                    <!-- Card Body -->
                    <div class=" p-4 mt-4">
                        <!-- START: Check if $rows is available -->
                        <?php if (!empty($rows)): ?>
                            <!-- Form -->
                            <form method="POST" action="?comments.php&do=update" novalidate>
                                <!-- Hidden ID Field -->
                                <input type="hidden" name="comid" value="<?= $comid ?>">

                                <div class="row">
                                    <!-- $comid Field -->
                                    <div class="col-md-6 mb-4">
                                        <label for="username" class="form-label fw-bold">Edit Comment</label>
                                        <div>
                                            <textarea class="form-control" name="comment" id=""><?= $rows['Comment'] ?></textarea>
                                        </div>
                                    </div>
                                </div>

                                <!-- Submit Button -->
                                <div class="row">
                                    <div class="col-md-6 offset-md-3 mt-4">
                                        <button type="submit" class="btn btn-dark btn-lg fw-bold text-white w-100">Save Changes</button>
                                    </div>
                                </div>
                            </form>
                        <?php else: ?>
                            <!-- Display a message if no data is available -->
                            <div class="alert alert-warning text-center">
                                <h4 class="mb-0">No user data found!</h4>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php
} else {
    echo '<h4 class="text-center mt-5">This user does not exist.</h4>';
}
?>