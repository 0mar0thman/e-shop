<?php

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $comid = $_POST['comid'];
    $comment = $_POST['comment'];

    $stmt = $con->prepare('UPDATE comments SET Comment = ? WHERE CID = ?');
    $stmt->execute([$comment, $comid]);

?>
    <div class="container my-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow-lg bg-dark bg-gradient">
                    <!-- Card Header -->
                    <div class="card-header bg-success bg-gradient text-white">
                        <h1 class="h4 fw-bold mb-0">Updated Comment Details</h1>
                    </div>
                    <!-- Card Body -->
                    <div class="card-body p-4">
                        <!-- Display Updated Data -->
                        <div class="mb-4">
                            <h2 class="h5 fw-bold text-white">Updated Information</h2>
                            <ul class="list-group">
                                <li class="list-group-item"><strong class="text-black">Comment:</strong> <?= htmlspecialchars($comment); ?></li>
                            </ul>
                        </div>
                        <!-- Back Button -->
                        <div class="row">
                            <!-- Back to Edit Button -->
                            <div class="col-lg-6 col-md-6 col-sm-12">
                                <a href="http://localhost:3000/admin/comments.php?do=edit&comid=<?= $comid ?>" class="btn btn-secondary w-100 btn-lg fw-bold text-white">Back to Edit</a>
                            </div>

                            <!-- All Comments Button -->
                            <div class="col-lg-6 col-md-6 col-sm-12 ">
                                <a href="http://localhost:3000/admin/comments.php" class="btn btn-warning w-50 btn-lg fw-bold text-dark">All Comments</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
<?php
} else {
    echo 'not available <br> please go back to form and insert informations and submit';
}
?>