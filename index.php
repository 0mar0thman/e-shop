<?php
ob_start();
session_start();
$pageTitle = 'Home';
include 'init.php';

// ==================== Sections Categories Sort =============
// ===========================================================
function CategorySort($sort)
{
    global $con;
    if (empty($sort)) {
        $sort = 'ID';
    }
    // column categories [ID ,Name , Description, Price, Quantity , Visibility]
    $stmt = $con->prepare("SELECT * FROM categories ORDER BY $sort DESC");
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function DivSort($varName, $sort, $title, $i)
{
    $varName = CategorySort($sort);
?>
    <section class="py-4">
        <div class="container">
            <div class="d-flex justify-content-between align-items-center ">
                <h2 class="custom-h2"><?= $i . $title ?></h2>
                <a href="categories.php" class="btn btn-outline-success">View All</a>
            </div>
            <div class="row g-4">
                <div class="row g-4">
                    <?php
                    $count = count($varName);
                    for ($i = 0; $i < min(8, $count); $i++): ?>
                        <div class="col-6 col-md-4 col-lg-3">
                            <a href="categories.php?cid=<?= htmlspecialchars($varName[$i]['ID']) ?>&name=<?= urlencode($varName[$i]['Name']) ?>" class="category-card d-block">
                                <div class="card bg-dark h-100 border-0">
                                    <div class="card-body text-center p-4">
                                        <i class="fas fa-folder-open fa-3x mb-3 text-success"></i>
                                        <h5 class="card-title text-white mb-2"><?= htmlspecialchars($varName[$i]['Name']) ?></h5>
                                        <p class="text-muted mb-0"><?= htmlspecialchars(substr($varName[$i]['Description'], 0, 60)) ?>...</p>
                                    </div>
                                </div>
                            </a>
                        </div>
                    <?php endfor; ?>
                </div>
            </div>
        </div>
    </section>
<?php
}
$catQuantity = "";
// ============================================
// ============================================

// Update featured/newest items query - there's no getAllItems() function
// We'll need to use getItemCat() but modify it to work for all items

function ItemSort($sort)
{
    global $con;
    if (empty($sort)) {
        $sort = 'ID';
    }
    // columns here [itemsID ,Name , Description, Price, AddDate , CountryMade , Status , Rating , CatID , MemberID , Approve , CategoryName , Username ]
    $stmt = $con->prepare("SELECT 
                        items.*, 
                        categories.Name AS CategoryName, 
                        users.Username 
                    FROM items 
                    INNER JOIN categories ON categories.ID = items.CatID 
                    INNER JOIN users ON users.UserID = items.MemberID 
                    WHERE Approve = 1 
                    ORDER BY $sort DESC 
                    LIMIT 16");
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
function SectionSort($varName, $sort, $title, $i)
{
    $varName = ItemSort($sort)
?>
    <section class="bg-dark py-5">
        <div class="container">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="custom-h2"><?= $i . $title ?></h2>
                <div class="slider-nav d-flex gap-2">
                    <button class="btn btn-slider-prev">
                        <i class="fas fa-chevron-left"></i>
                    </button>
                    <button class="btn btn-slider-next">
                        <i class="fas fa-chevron-right"></i>
                    </button>
                </div>
            </div>
        </div>

        <div class="slider-wrapper">
            <div class="row flex-nowrap slider-inner">
                <?php foreach ($varName as $item): ?>
                    <div class="col-9 col-sm-6 col-md-4 col-lg-3 slider-item">
                        <a href="item.php?itemid=<?= $item['itemsID'] ?>" class="text-decoration-none">
                            <div class="item-card h-100">
                                <div class="card-header">
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <h5 class="mb-0"><?= $item['Name'] ?></h5>
                                        <h6 class="text-white">#<?= $item['itemsID'] ?></h6>
                                    </div>
                                    <span class="badge bg-dark">
                                        <i class="fas fa-tag me-1"></i><?= $item['CategoryName'] ?>
                                    </span>
                                </div>
                                <div class="card-body">
                                    <?php if (!empty($item['Image'])): ?>
                                        <img src="uploads/items/<?= $item['Image'] ?>"
                                            class="img-fluid mb-3"
                                            alt="<?= $item['Name'] ?>"
                                            style="height: 200px; object-fit: cover;">
                                    <?php endif; ?>
                                    <div class="d-flex justify-content-between align-items-start mb-3">
                                        <div class="price-tag">
                                            <?= number_format($item['Price'], 2) ?> $
                                        </div>
                                        <div class="status-badge">
                                            <?= $item['Status'] ?>
                                        </div>
                                    </div>
                                    <p class="card-text text-truncate-3 mb-3"><?= $item['Description'] ?></p>
                                </div>
                            </div>
                        </a>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>

    </section>
<?php
}
$itemAddDate = "";
?>

<div class="hero-section py-5" style="background: linear-gradient(rgba(0,0,0,0.7), rgba(0,0,0,0.7)), url('layout/images/hero-bg.jpg') no-repeat center/cover;">
    <div class="container">
        <div class="row min-vh-50 align-items-center">
            <div class="col-lg-6">
                <h1 class="display-4 fw-bold text-white mb-4">Discover Amazing Products</h1>
                <p class="lead text-light mb-4">Find the best deals on premium products from trusted sellers</p>
                <div class="d-flex gap-3">
                    <?php
                    if (!empty($_SESSION['random_keys'])) {
                        $cat = retrieveAllCategories();
                        $key = $_SESSION['random_keys'][array_rand($_SESSION['random_keys'])]; // الحصول على أول عنصر فقط
                        if (isset($cat[$key])) {
                    ?>
                            <a href="categories.php?cid=<?= $cat[$key]['ID'] ?>&name=<?= str_replace(" ", "-", $cat[$key]['Name']) ?>" class="btn btn-lg btn-success">Browse Categories
                                <?= $cat[$key]['Name'] ?>
                            </a>
                    <?php
                        }
                    } else {
                        echo "<li class='nav-item'><a class='nav-link text-white' href='#'>عدد التصنيفات غير كافٍ</a></li>";
                    }
                    ?>
                    <?php if (!isset($_SESSION['UserName'])): ?>
                        <a href="login.php" class="btn btn-lg btn-outline-light">Sign In</a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Categories Section Popular-->
<?= DivSort($catQuantity, 'Quantity', ' Popular', '<i class="fas fa-th-large me-2"></i>') ?>

<!-- Featured Products Section -->
<?= SectionSort($itemAddDate, 'AddDate', 'New Arrivals', '<i class="fas fa-fire me-2"></i>') ?>

<!-- Categories Section beloved -->
<?= DivSort($catQuantity, 'ID', ' beloved', '<i class="fa-solid fa-shield-heart"></i>') ?>

<!-- Featured Products Section -->
<?= SectionSort($itemAddDate, 'Rating', ' Highest Rating', '<i class="fa-solid fa-star"></i>') ?>

<!-- Categories Section beloved -->
<?= DivSort($catQuantity, 'Price', ' Sellsy', '<i class="fa-brands fa-sellsy"></i>') ?>

<!-- Featured Products Section -->
<?= SectionSort($itemAddDate, 'Price', ' Best Seller', '<i class="fa-solid fa-genderless"></i>') ?>

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

<?php
include $tpl . 'footer.php';
ob_end_flush();
?>