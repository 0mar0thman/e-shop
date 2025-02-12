<?php
ob_start();
session_start();
$pageTitle = 'Item Details';
include 'init.php';

$itemID = isset($_GET['itemid']) ? intval($_GET['itemid']) : 0;

$relatedItems = fetchCategoryItemsByCategoryId($itemID);

$item = fetchItemDetailsWithComments($itemID);

if (!$item) {
    header("Location: item.php?do=add_cart&itemid=55");
    exit();
}
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (!empty($_POST['comment']) && !empty($_POST['commentID'])) {
        $comment = trim(htmlspecialchars($_POST['comment']));
        $commentID = intval($_POST['commentID']);
        if (isset($_SESSION['UserName'])) {

            addNewComment($comment, $commentID, $_SESSION['UserID']);
            header("Location: item.php?itemid=$itemID&success=1");
            exit();
        } else {

            echo "<div class='card text-center w-50 mx-auto mt-3'>
            <div class='card-body'>
                <h5 class='card-title text-danger'>Please login</h5>
            </div>
          </div>";
        }
    }
}
$action = $_GET['do'] ?? '';
?>
<?php if ($action == 'add_cart'): ?>
    <?php include 'cart/checkout.php' ?>

<?php elseif ($action == 'buy_now'): ?>
    <?php include 'cart/buy_now.php' ?>
<?php else: ?>

    <div class="container">
        <div class="item-detail-card">
            <!-- Header Section -->
            <div class="detail-header">
                <div class="d-flex flex-column flex-lg-row justify-content-between align-items-start gap-3">
                    <div>
                        <h1 class="display-5 fw-bold mb-3"><?= $item['ItemName'] ?></h1>
                        <div class="d-flex flex-wrap gap-3 align-items-center">
                            <span class="badge badge-category fs-6">
                                <i class="fas fa-folder-open me-2"></i><?= $item['CategoryName'] ?>
                            </span>
                            <div class="price-tag fs-5">
                                <?= number_format($item['Price'], 2) ?> $
                            </div>
                        </div>
                    </div>
                    <a href="categories.php?cid=<?= $item['CatID'] ?>&name=<?= urlencode($item['CategoryName']) ?>"
                        class="btn btn-outline-accent text-white py-2 px-4">
                        <i class="fas fa-arrow-left me-2"></i>Back to Category
                    </a>
                </div>
            </div>

            <!-- Main Content -->
            <div class="row g-4 p-3">
                <!-- Image Column -->
                <div class="col-lg-6">
                    <div class="position-relative">
                        <?php if (!empty($item['Image'])): ?>
                            <img src="uploads/items/<?= $item['Image'] ?>"
                                class="detail-image img-fluid"
                                alt="<?= $item['ItemName'] ?>"
                                loading="lazy">
                        <?php else: ?>
                            <div class="detail-image d-flex align-items-center justify-content-center bg-dark">
                                <i class="fas fa-image fa-4x text-secondary"></i>
                            </div>
                        <?php endif; ?>
                    </div>
                    <div class="mt-2"><strong class="fs-5">#<?= $item['CatID'] ?></strong></div>
                </div>

                <!-- Details Column -->
                <div class="col-lg-6">
                    <!-- Description Section -->
                    <div class="mb-5">
                        <h3 class="mb-4 border-bottom pb-2"><i class="fas fa-align-left me-2"></i>Description</h3>
                        <p class="lead fs-5"><?= nl2br($item['ItemDescription']) ?></p>
                    </div>

                    <!-- Specifications Section -->
                    <div class="mb-5">
                        <h3 class="mb-4 border-bottom pb-2"><i class="fas fa-info-circle me-2"></i>Specifications</h3>
                        <ul class="specs-list">
                            <li class="d-flex justify-content-between align-items-center p-3 rounded bg-dark mb-3">
                                <span><i class="fas fa-tag me-2"></i>Status</span>
                                <span class="status-badge"><?= $item['ItemStatus'] ?></span>
                            </li>
                            <li class="d-flex justify-content-between align-items-center p-3 rounded bg-dark mb-3">
                                <span><i class="fas fa-star me-2"></i>Rating</span>
                                <span class="rating-stars">
                                    <?php for ($i = 0; $i < 5; $i++): ?>
                                        <i class="<?= ($i < $item['Rating']) ? 'fas' : 'far' ?> fa-star"></i>
                                    <?php endfor; ?>
                                </span>
                            </li>
                            <li class="d-flex justify-content-between align-items-center rounded bg-dark p-3">
                                <span><i class="fas fa-calendar-alt me-2"></i>Added Date</span>
                                <span><?= date('F j, Y', strtotime($item['ItemAddDate'])) ?></span>
                            </li>
                        </ul>
                    </div>

                    <!-- Action Buttons -->
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-6">
                                <form action="item.php?do=add_cart&itemid=55" method="POST">
                                    <input type="submit" value="Add to Cart" class="btn btn-add-cart btn-custom w-100">
                                    <input type="hidden" name="add_cart">
                                    <input type="hidden" value="<?= $item['itemsID'] ?>" name="itemsID">
                                    <input type="hidden" value="<?= $item['ItemName'] ?>" name="ItemName">
                                    <input type="hidden" value="<?= $item['Price'] ?>" name="Price">
                                    <input type="hidden" value="<?= $item['Rating'] ?>" name="Rating">
                                    <input type="hidden" value="<?= $item['CategoryName'] ?>" name="CategoryName">
                                    <input type="hidden" value="<?= $item['ItemDescription'] ?>" name="ItemDescription">
                                    <input type="hidden" value="<?= $item['Author'] ?>" name="Author">
                                    <input type="hidden" value="<?= $item['Image'] ?? 'https://dummyimage.com/300x200/cccccc/ffffff.png&text=No+Image' ?>" name="Image">
                                    <input type="hidden" value="<?= $item['ItemAddDate'] ?>" name="ItemAddDate">
                                </form>
                            </div>
                            <div class="col-6">
                                <form action="item.php?do=buy_cart&itemid=<?= $item['itemsID'] ?>" method="post">
                                    <input type="submit" class="btn btn-buy-now btn-custom delete-btn w-100" value="Buy Now">
                                </form>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <section class=" py-5">
            <div class="container">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <h3 class="">
                        <?= empty($relatedItems) ? "" : "Related Products" ?>
                    </h3>
                    <div class="slider-nav d-flex gap-2">
                        <button class="btn btn-slider-prev">
                            <i class="fas fa-chevron-left"></i>
                        </button>
                        <button class="btn btn-slider-next">
                            <i class="fas fa-chevron-right"></i>
                        </button>
                    </div>
                </div>

                <!-- Related Products -->
                <div class="slider-wrapper position-relative">
                    <div class="row flex-nowrap slider-inner">
                        <?php foreach ($relatedItems as $related): ?>
                            <?php if ($related['Approve'] == 1) : ?>
                                <div class="col-8 col-sm-6 col-md-4 col-lg-3 slider-item">
                                    <div class="item-card h-100">
                                        <a href="item.php?itemid=<?= $related['itemsID'] ?>" class="text-decoration-none">
                                            <div class="card-header">
                                                <div class="d-flex justify-content-between align-items-center mb-2">
                                                    <h5 class="mb-0"><?= $related['Name'] ?></h5>
                                                    <h6 class="text-white">#<?= $related['itemsID'] ?></h6>
                                                </div>
                                                <div class="d-flex gap-2 text-sm">
                                                    <span class="badge bg-dark">
                                                        <i class="fas fa-tag me-1"></i><?= $related['Name'] ?>
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="card-body">
                                                <?php if (!empty($related['Image'])): ?>
                                                    <img src="uploads/items/<?= $related['Image'] ?>"
                                                        class="img-fluid mb-3"
                                                        alt="<?= $related['Name'] ?>"
                                                        style="height: 200px; object-fit: cover;">
                                                <?php endif; ?>
                                                <div class="d-flex justify-content-between align-items-start mb-3">
                                                    <div class="price-tag">
                                                        <?= number_format($related['Price'], 2) ?> $
                                                    </div>
                                                    <div class="status-badge">
                                                        <?= $related['Status'] ?>
                                                    </div>
                                                </div>
                                                <p class="card-text text-truncate-3 mb-4"><?= $related['Description'] ?></p>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                            <?php endif ?>
                        <?php endforeach; ?>
                    </div>
                </div>
               
                <!-- Comments Section -->
                <div class="mt-5">
                    <div class="bg-dark rounded-3 shadow-sm p-4 ">
                        <!-- Section Title -->
                        <i class="fas fa-comments me-2 text-primary d-inline"></i>
                        <h4 class=" text-light border-bottom pb-2 d-inline"><?= empty($item['comments']) ? 'Not Found Comments' : 'Comments' ?></h4>
                        <!-- Comment Form -->
                        <form method="post" class="mt-3">
                            <div class="row g-3 align-items-end">
                                <!-- Hidden Input -->
                                <input type="hidden" name="commentID" value="<?= $itemID ?>">
                                <div class="col-md-8">
                                    <div class="form-group">
                                        <label class="form-label text-light fw-medium">
                                            <i class="fas fa-pencil-alt me-2"></i>
                                            Add your comment
                                        </label>
                                        <input
                                            type="text"
                                            name="comment"
                                            class="form-control form-control-lg bg-dark text-light"
                                            placeholder="Write your comment here..."
                                            aria-label="Comment">
                                    </div>
                                </div>

                                <!-- Submit Button -->
                                <div class="col-md-4">
                                    <button type="submit"
                                        class="btn btn-primary btn-lg w-100"
                                        style="height: 48px;">
                                        <i class="fas fa-paper-plane me-2"></i>
                                        Publish
                                    </button>
                                </div>
                            </div>
                        </form>

                        <!-- Existing Comments Section -->
                        <div class="bg-dark rounded mt-3">

                            <?php foreach ($item['comments'] as $comment) : ?>
                                <?php if ($comment['Status'] == 1) : ?>
                                    <div class="row justify-content-center">
                                        <div class="col-md-12">
                                            <div id="commentsContainer">
                                                <div class="comment-card">
                                                    <div class="comment-header">
                                                        <strong>Comment #<?= $comment['CommentID'] ?></strong>
                                                        <span class="float-end text-light"><?= $comment['CommentDate'] ?></span>
                                                    </div>
                                                    <div class="comment-body">
                                                        <div class="text-light">
                                                            <strong>User:</strong> <?= $comment['CommentAuthor'] ?>
                                                        </div>
                                                        <div class="ms-4">
                                                            <i class="fa-regular fa-comment"></i>
                                                            <span><?= $comment['CommentText'] ?></span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php endif ?>
                            <?php endforeach ?>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
<?php endif ?>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.5.0/dist/sweetalert2.min.js"></script>
<script>
    $(document).ready(function() {
        const slider = $('.slider-wrapper');
        const itemWidth = $('.slider-item').outerWidth(true);
        const scrollAmount = itemWidth * 2; // التمرير بعرض عنصرين في كل مرة

        $('.btn-slider-next').on('click', function() {
            slider.stop().animate({
                scrollLeft: `+=${scrollAmount}`
            }, 600);
        });

        $('.btn-slider-prev').on('click', function() {
            slider.stop().animate({
                scrollLeft: `-=${scrollAmount}`
            }, 600);
        });

        function checkScroll() {
            const maxScroll = slider[0].scrollWidth - slider.innerWidth();
            if (slider.scrollLeft() >= maxScroll - 10) {
                $('.btn-slider-next').fadeOut();
            } else {
                $('.btn-slider-next').fadeIn();
            }

            if (slider.scrollLeft() <= 10) {
                $('.btn-slider-prev').fadeOut();
            } else {
                $('.btn-slider-prev').fadeIn();
            }
        }

        slider.on('scroll', checkScroll);
        checkScroll();
    });
</script>

<?php include $tpl . 'footer.php';
// ob_end_flush(); 
?>