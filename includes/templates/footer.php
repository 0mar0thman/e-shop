<style>
    html,
    body {
        height: 100%;
        margin: 0;
        padding: 0;
        display: flex;
        flex-direction: column;
    }

    footer {
        margin-top: 20px;
        width: 100%;
        background-color: #212529;
        color: white;
        padding: 20px 0;
        position: relative;
    }
</style>
<footer class="bg-dark text-white pt-5">
    <div class="container">
        <div class="row g-4">
            <!-- Store Info -->
            <div class="col-md-4 col-lg-3">
                <h5 class="text-success mb-4">E-Shop</h5>
                <p class="text-muted">Providing the best products with high quality and 24/7 customer support.</p>
                <div class="social-icons mt-4">
                    <a href="#" class="text-white me-3"><i class="fab fa-facebook fa-lg"></i></a>
                    <a href="#" class="text-white me-3"><i class="fab fa-twitter fa-lg"></i></a>
                    <a href="#" class="text-white me-3"><i class="fab fa-instagram fa-lg"></i></a>
                    <a href="#" class="text-white"><i class="fab fa-whatsapp fa-lg"></i></a>
                </div>
            </div>

            <!-- Quick Links -->
            <div class="col-md-4 col-lg-2">
                <h5 class="text-success mb-4">Quick Links</h5>
                <ul class="list-unstyled">
                    <li><a href="#" class="text-white text-decoration-none d-block">Home</a></li>
                    <li><a href="#" class="text-white text-decoration-none d-block">Shop</a></li>
                    <li><a href="#" class="text-white text-decoration-none d-block">Best Sellers</a></li>
                    <li><a href="#" class="text-white text-decoration-none d-block">Offers</a></li>
                </ul>
            </div>

            <!-- Customer Service -->
            <div class="col-md-4 col-lg-2">
                <h5 class="text-success mb-4">Customer Service</h5>
                <ul class="list-unstyled">
                    <li><a href="#" class="text-white text-decoration-none d-block">Return Policy</a></li>
                    <li><a href="#" class="text-white text-decoration-none d-block">Shipping & Delivery</a></li>
                    <li><a href="#" class="text-white text-decoration-none d-block">FAQs</a></li>
                    <li><a href="#" class="text-white text-decoration-none d-block">Track Order</a></li>
                </ul>
            </div>

            <!-- Payment Methods -->
            <div class="col-md-4 col-lg-2">
                <h5 class="text-success mb-4">Payment Methods</h5>
                <img src="payment-methods.png" alt="Payment Methods" class="img-fluid">
            </div>
        </div>

        <hr class="my-4">

        <!-- Bottom Section -->
        <div class="row">
            <div class="col-md-6 text-center text-md-start">
                <p class="text-muted">&copy; 2024 E-Shop. All rights reserved.</p>
            </div>
            <div class="col-md-6 text-center text-md-end">
                <img src="secure-payment.png" alt="Secure Payment" class="img-fluid" style="max-height: 30px;">
            </div>
        </div>
    </div>
</footer>

<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- مكتبات تعتمد على jQuery -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<!-- مكتبات أخرى -->
<script src="<?= $js; ?>bootstrap.bundle.min.js"></script>
<script src="<?= $js; ?>all.min.js"></script>
<script src="<?= $js; ?>jquery-ui.min.js"></script>
<script src="<?= $js; ?>jquery.selectBoxIt.min.js"></script>

<!-- ملفات JavaScript الخاصة بك -->
<script src="<?= $js; ?>backend.js"></script>

<!-- تهيئة AOS -->
<script>
    AOS.init();
</script>


<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    $(document).ready(function() {
        $('.dropdown').on('show.bs.dropdown', function() {
            $(this).find('.dropdown-menu').stop(true, true).slideDown(300);
        });

        $('.dropdown').on('hide.bs.dropdown', function() {
            $(this).find('.dropdown-menu').stop(true, true).slideUp(300);
        });
    });
</script>
<?php ob_end_flush(); ?>
</body>

</html>