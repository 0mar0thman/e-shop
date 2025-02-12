<?php
// session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // تحقق من توفر البيانات الأساسية
    // if (!isset($_POST['payment_method']) || empty($_SESSION['items'])) {
    //     header("Location: item.php?do=add_cart&itemid=54&mass=Sending_Success");
    //     exit();
    // }

    // الحصول على بيانات الطلب
    $paymentMethod = $_POST['payment_method'];
    $totalAmount = 0;

    foreach ($_SESSION['items'] as $item) {
        if (isset($item['Price']) && isset($item['quantity'])) {
            $totalAmount += $item['Price'] * $item['quantity'];
        }
    }

    $tax = $totalAmount * 0.07; // ضريبة 7%
    $finalTotal = $totalAmount + $tax;

    // هنا يمكن تنفيذ عمليات الدفع الفعلية عبر بوابات الدفع مثل PayPal أو Stripe
    // الآن سنقوم بمحاكاة نجاح عملية الدفع

    $paymentSuccess = true; // محاكاة نجاح الدفع

    if ($paymentSuccess) {
        // حفظ تفاصيل الطلب في قاعدة البيانات (محاكاة العملية)
        $orderID = rand(1000, 9999); // رقم طلب عشوائي

        // حذف السلة بعد إتمام الدفع
        unset($_SESSION['items']);

        // توجيه المستخدم إلى صفحة النجاح
        header("Location: item.php?do=add_cart&itemid=54&mass=Sending_Success");    
        exit();
    } else {
        // توجيه المستخدم إلى صفحة الفشل
        header("Location: item.php?do=add_cart&itemid=54&mass=Sending_failed");
        exit();
    }
} else {
    // منع الوصول المباشر للصفحة
    header("Location: index.php");
    exit();
}
