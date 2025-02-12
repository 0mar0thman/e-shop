<!-- add and insert -->
<div class="container-fluid">
    <div class="row col-lg-12">
        <!-- الجزء الأيسر للرسومات -->
        <div class="col-lg-8 col-md-6 custom-graphics-col">
            <div class="graphics-content text-center" data-aos="fade-right" data-aos-duration="1000">
                <div class="background-image" style="background-image: url('https://source.unsplash.com/random/800x600');"></div>
                <i class="fas fa-box fa-5x mb-4 animate__animated animate__bounceIn"></i>
                <h2 class="animate__animated animate__fadeInUp">Add New Product</h2>
                <p class="animate__animated animate__fadeInUp animate__delay-1s">
                    Welcome to our platform! Add new products easily and manage them efficiently.
                </p>
                <div class="interactive-icons mt-4">
                    <i class="fas fa-boxes fa-2x mx-3 animate__animated animate__pulse animate__infinite"></i>
                    <i class="fas fa-tags fa-2x mx-3 animate__animated animate__pulse animate__infinite"></i>
                    <i class="fas fa-cogs fa-2x mx-3 animate__animated animate__pulse animate__infinite"></i>
                </div>
            </div>
        </div>

        <!-- الجزء الأيمن للنموذج -->
        <div class="col-lg-4 col-md-6 col-sm-12">
            <div class="card shadow-lg custom-form-card bg-dark text-white">
                <div class="card-header text-white">
                    <h1 class="h4 fw-bold mb-0">Add New Product </h1>
                </div>
                <div class="card-body p-4 needs-validation">
                    <form method="POST" action="?do=insert" novalidate>
                        <!-- Name Field -->
                        <div class="mb-4">
                            <div class="d-flex justify-content-between">
                                <div class="d-inline-block">
                                    <label class="form-label fw-bold">Product Name</label>
                                </div>
                                <div class="d-inline-block">
                                    <?php if (!empty($_SESSION['error']) && isset($_SESSION['error']['name'])): ?>
                                        <span class="text-warning mb-4">
                                            <?php echo $_SESSION['error']['name'] ?>
                                        </span>
                                        <?php unset($_SESSION['error']['name']); ?>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <input type="text" class="form-control form-control-lg" name="name" autocomplete="off" placeholder="Enter product name" required>
                            <div class="invalid-feedback">Please enter a valid product name.</div>
                        </div>

                        <!-- Description Field -->
                        <div class="mb-4">
                            <div class="d-flex justify-content-between">
                                <div class="d-inline-block">
                                    <label class="form-label fw-bold">Description</label>
                                </div>
                                <div class="d-inline-block">
                                    <?php if (!empty($_SESSION['error']) && isset($_SESSION['error']['desc'])): ?>
                                        <span class="text-warning mb-4">
                                            <?php echo $_SESSION['error']['desc'] ?>
                                        </span>
                                        <?php unset($_SESSION['error']['desc']); ?>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <textarea class="form-control form-control-lg" name="description" placeholder="Enter product description" required></textarea>
                            <div class="invalid-feedback">Please enter a valid description.</div>
                        </div>

                        <!-- Price Field -->
                        <div class="mb-4">
                            <div class="d-flex justify-content-between">
                                <div class="d-inline-block">
                                    <label class="form-label fw-bold">Price</label>
                                </div>
                                <div class="d-inline-block">
                                    <?php if (!empty($_SESSION['error']) && isset($_SESSION['error']['price'])): ?>
                                        <span class="text-warning mb-4">
                                            <?php echo $_SESSION['error']['price'] ?>
                                        </span>
                                        <?php unset($_SESSION['error']['price']); ?>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <input type="number" class="form-control form-control-lg" name="price" placeholder="Enter product price" required>
                            <div class="invalid-feedback">Please enter a valid price.</div>
                        </div>

                        <!-- Quantity Field -->
                        <div class="mb-4">
                            <div class="d-flex justify-content-between">
                                <div class="d-inline-block">
                                    <label class="form-label fw-bold">Quantity</label>
                                </div>
                                <div class="d-inline-block">
                                    <?php if (!empty($_SESSION['error']) && isset($_SESSION['error']['quantity'])): ?>
                                        <span class="text-warning mb-4">
                                            <?php echo $_SESSION['error']['quantity'] ?>
                                        </span>
                                        <?php unset($_SESSION['error']['quantity']); ?>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <input type="number" class="form-control form-control-lg" name="quantity" placeholder="Enter product quantity" required>
                            <div class="invalid-feedback">Please enter a valid quantity.</div>
                        </div>

                        <!-- Visiblility Field -->
                        <div class="mb-4">
                            <div class="d-flex justify-content-between">
                                <div class="d-inline-block">
                                    <label class="form-label fw-bold">Visiblility</label>
                                </div>
                                <div class="d-inline-block">
                                    <?php if (!empty($_SESSION['error']) && isset($_SESSION['error']['visibility'])): ?>
                                        <span class="text-warning mb-4">
                                            <?php echo $_SESSION['error']['visibility'] ?>
                                        </span>
                                        <?php unset($_SESSION['error']['visibility']); ?>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <div class="d-flex gap-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="visibility" id="visibleYes" value="1">
                                    <label class="form-check-label" for="visibleYes">Yes</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="visibility" id="visibleNo" value="0">
                                    <label class="form-check-label" for="visibleNo">No</label>
                                </div>
                            </div>
                            <div class="invalid-feedback">Please select a visibility option.</div>
                        </div>

                        <!-- Submit Button -->
                        <div class="d-grid mt-4">
                            <button type="submit" class="btn btn-dark btn-lg fw-bold text-white">Add Product</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    (function() {
        'use strict';
        var forms = document.querySelectorAll('.needs-validation');
        Array.prototype.slice.call(forms).forEach(function(form) {
            form.addEventListener('submit', function(event) {
                if (!form.checkValidity()) {
                    event.preventDefault();
                    event.stopPropagation();
                }
                form.classList.add('was-validated');
            }, false);
        });
    })();

    // تحسين تفاعل الحقول
    document.querySelectorAll('.form-control').forEach(function(input) {
        input.addEventListener('input', function() {
            if (input.checkValidity()) {
                input.classList.remove('is-invalid');
                input.classList.add('is-valid');
            } else {
                input.classList.remove('is-valid');
                input.classList.add('is-invalid');
            }
        });
    });
</script>

<script>
    $(document).ready(function() {
        $('.slick-slider').slick({
            dots: true,
            infinite: true,
            speed: 300,
            slidesToShow: 1,
            adaptiveHeight: true,
            autoplay: true,
            autoplaySpeed: 2000,
        });
    });
</script>