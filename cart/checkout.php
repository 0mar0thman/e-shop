<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_cart'])) {
    if (!isset($_SESSION['items'])) {
        $_SESSION['items'] = [];
    }

    $itemID = $_POST['itemsID'];
    $itemExists = false;

    foreach ($_SESSION['items'] as &$cartItem) {
        if ($cartItem['itemsID'] == $itemID) {
            $cartItem['quantity'] += 1;
            $itemExists = true;
            break;
        }
    }

    if (!$itemExists) {
        $item = [
            "itemsID" => $_POST['itemsID'],
            "ItemName" => $_POST['ItemName'],
            "ItemDescription" => $_POST['ItemDescription'],
            "Price" => $_POST['Price'],
            "ItemAddDate" => $_POST['ItemAddDate'],
            "Rating" => $_POST['Rating'],
            "CategoryName" => $_POST['CategoryName'],
            "Author" => $_POST['Author'],
            "Image" => $_POST['Image'] ?? 'https://dummyimage.com/300x200/cccccc/ffffff.png&text=No+Image',
            "quantity" => 1, // الكمية الافتراضية
        ];

        $_SESSION['items'][] = $item;
    }

    header('Location: item.php?itemid=' . $_POST['itemsID']);
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['payment'])) {
    include 'payment.php';
    // header("Location: item.php?do=add_cart&itemid=55");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update_cart'])) {
    foreach ($_POST['quantity'] as $itemID => $quantity) {
        if (isset($_SESSION['items'][$itemID])) {
            $_SESSION['items'][$itemID]['quantity'] = intval($quantity);
        }
    }
    header("Location: item.php?do=add_cart&itemid=55");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['remove_item'])) {
    $itemID = $_POST['item_id'];
    $_SESSION['items'] = array_values(array_filter($_SESSION['items'], function ($item) use ($itemID) {
        return $item['itemsID'] != $itemID;
    }));

    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}

if (!isset($_SESSION['items']) || !is_array($_SESSION['items'])) {
    $_SESSION['items'] = [];
}

$subtotal = 0;
if (!empty($_SESSION['items'])) {
    foreach ($_SESSION['items'] as $item) {
        if (isset($item['Price']) && isset($item['quantity'])) {
            $subtotal += $item['Price'] * $item['quantity'];
        }
    }
}
$tax = $subtotal * 0.07;
$total = $subtotal + $tax;
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['process_payment'])) {
    include 'process_payment.php';
    exit();
}
if ( isset($_GET['mass'])) {
    echo '<div style="
        color: #155724; 
        background-color: #d4edda; 
        border: 1px solid #c3e6cb; 
        padding: 10px; 
        margin: 10px 0;
        border-radius: 5px;
        font-weight: bold;
        text-align: center;
    ">' . htmlspecialchars($_GET['mass']) . '</div>';
    exit();
}
?>
<div class="container">
    <h2 class="text-center mb-4">Checkout</h2>
    <form method="POST">
        <div class="row">
            <!-- عرض المنتجات -->
            <div class="col-md-8">
                <?php $count = 0; ?>
                <?php if (!empty($_SESSION['items'])) : ?>
                    <?php foreach ($_SESSION['items'] as $itemID => $item) : ?>
                        <?php $count++; ?>
                        <div class="card mb-3">
                            <div class="m-1">#<?= $count ?></div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-3">
                                        <img src="<?= !empty($item['Image']) ? $item['Image'] : 'https://dummyimage.com/300x200/cccccc/ffffff.png&text=No+Image' ?>" class="img-fluid" alt="<?= $item['ItemName'] ?>">
                                    </div>
                                    <div class="col-md-6">
                                        <h5 class="card-title text-primary"><?= htmlspecialchars($item['ItemName']) ?></h5>
                                        <p class="card-text"><strong>Category:</strong> <?= htmlspecialchars($item['CategoryName']) ?></p>

                                        <!-- ⭐ التقييم بالنجوم -->
                                        <p class="card-text">
                                            <strong>Rating:</strong>
                                            <?php
                                            $rating = intval($item['Rating']);
                                            for ($i = 1; $i <= 5; $i++) {
                                                if ($i <= $rating) {
                                                    echo '<i class="fas fa-star text-warning"></i>';
                                                } else {
                                                    echo '<i class="far fa-star text-muted"></i>';
                                                }
                                            }
                                            ?>
                                        </p>
                                        <p class="card-text"><strong>Date:</strong> <?= htmlspecialchars($item['ItemAddDate']) ?></p>
                                        <p class="card-text"><strong>Description:</strong> <?= nl2br(htmlspecialchars($item['ItemDescription'])) ?></p>
                                        <p class="card-text text-success"><strong>Price:</strong> $<?= number_format(floatval($item['Price']), 2) ?></p>
                                        <p class="card-text text-danger"><strong>Subtotal:</strong> $<?= number_format($subtotal, 2) ?></p>
                                    </div>

                                    <div class="col-md-3">
                                        <label for="quantity_<?= $itemID ?>">Quantity:</label>
                                        <input type="number"
                                            name="quantity[<?= $itemID ?>]"
                                            id="quantity_<?= $itemID ?>"
                                            class="form-control"
                                            value="<?= isset($item['quantity']) ? intval($item['quantity']) : 1 ?>"
                                            min="1">

                                        <input type="hidden" name="item_id" value="<?= $item['itemsID'] ?>">
                                        <input type="hidden" name="remove_item">
                                        <button type="submit" class="btn btn-danger btn-sm mt-2">
                                            <i class="fas fa-trash"></i> Remove
                                        </button>

                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else : ?>
                    <div class="alert alert-info">Your cart is empty.</div>
                <?php endif; ?>
            </div>

            <!-- تفاصيل الطلب -->
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Order Summary</h5>

                        <ul class="list-group list-group-flush">
                            <li class="list-group-item d-flex justify-content-between">
                                <span>Count Items</span>
                                <span id="subtotal"><?= $count ?></span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between">
                                <span>Subtotal</span>
                                <span id="subtotal">$<?= number_format($subtotal, 2) ?></span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between">
                                <span>Tax (7%)</span>
                                <span id="tax">$<?= number_format($tax, 2) ?></span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between fw-bold">
                                <span>Total</span>
                                <span id="total">$<?= number_format($total, 2) ?></span>
                            </li>
                        </ul>

                        <button type="submit" name="update_cart" class="btn btn-primary w-100 mt-3">
                            <i class="fas fa-sync"></i> Update Cart
                        </button>
                        <button type="submit" name="payment" class="btn btn-success w-100 mt-3">
                            <i class="fas fa-credit-card"></i> Proceed to Checkout
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>