<?php
if (empty($_SESSION['items'])) {
    header('Location: index.php');
    exit();
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
?>

<div class="container">
    <h2 class="text-center text-light mb-4">Payment Information</h2>
    <div class="row">
        <!-- نموذج الدفع -->
        <div class="col-md-6">
            <div class="card p-4 shadow-sm">
                <h4 class="mb-3">Billing Details</h4>
                <form method="POST">
                    <input type="hidden" name="process_payment">
                    <div class="mb-3">
                        <label class="form-label">Full Name</label>
                        <input type="text" class="form-control" name="full_name" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" class="form-control" name="email" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Card Number</label>
                        <input type="text" class="form-control" name="card_number" placeholder="1234 5678 9012 3456" required>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <label class="form-label">Expiration Date</label>
                            <input type="text" class="form-control" name="exp_date" placeholder="MM/YY" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">CVV</label>
                            <input type="text" class="form-control" name="cvv" placeholder="123" required>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-success w-100 mt-3">Confirm Payment</button>
                </form>
            </div>
        </div>

        <!-- تفاصيل الطلب -->
        <div class="col-md-6">
            <div class="card p-4 shadow-sm">
                <h4>Order Summary</h4>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item d-flex justify-content-between">
                        <span>Subtotal</span>
                        <span>$<?= number_format($subtotal, 2) ?></span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between">
                        <span>Tax (7%)</span>
                        <span>$<?= number_format($tax, 2) ?></span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between fw-bold">
                        <span>Total</span>
                        <span>$<?= number_format($total, 2) ?></span>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>