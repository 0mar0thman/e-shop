<div class="container-fluid">
    <div class="row col-lg-12">
        <!-- الجزء الأيسر للرسومات -->
        <div class="col-lg-8 col-md-6 custom-graphics-col">
            <div class="graphics-content text-center" data-aos="fade-right" data-aos-duration="1000">
                <div class="background-image" style="background-image: url('https://source.unsplash.com/random/800x600');"></div>
                <i class="fas fa-user-plus fa-5x mb-4 animate__animated animate__bounceIn"></i>
                <h2 class="animate__animated animate__fadeInUp">Add New Member</h2>
                <p class="animate__animated animate__fadeInUp animate__delay-1s">
                    Welcome to our platform! Add new members easily and manage them efficiently.
                </p>
                <div class="interactive-icons mt-4">
                    <i class="fas fa-users fa-2x mx-3 animate__animated animate__pulse animate__infinite"></i>
                    <i class="fas fa-chart-line fa-2x mx-3 animate__animated animate__pulse animate__infinite"></i>
                    <i class="fas fa-cogs fa-2x mx-3 animate__animated animate__pulse animate__infinite"></i>
                </div>
            </div>
        </div>

        <!-- الجزء الأيمن للنموذج -->
        <div class="col-lg-4 col-md-6 col-sm-12">
            <div class="card shadow-lg custom-form-card bg-dark text-white">
                <div class="card-header text-white">
                    <h1 class="h4 fw-bold mb-0">Add New Member</h1>
                </div>
                <div class="card-body p-4 needs-validation">
                    <form method="POST" action="?do=insert" novalidate>
                        <div class="mb-4">
                            <div class="d-flex justify-content-between">
                                <div class="d-inline-block">
                                    <label class="form-label fw-bold">Username</label>
                                </div>
                                <div class="d-inline-block">
                                    <?php if (!empty($_SESSION['errorValid']) && !empty($_POST['username'])): ?>
                                        <span class="text-warning mb-4">
                                            <?= $_SESSION['errorValid']['nameValid'] ?>
                                        </span>
                                        <?php unset($_SESSION['errorValid']['nameValid']); ?>
                                    <?php endif; ?>
                                    <?php if (!empty($_SESSION['error']) && isset($_SESSION['error']['name'])): ?>
                                        <span class="text-warning mb-4">
                                            <?php echo $_SESSION['error']['name'] ?>
                                        </span>
                                        <?php unset($_SESSION['error']['name']); ?>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <input type="text" class="form-control form-control-lg" name="username" autocomplete="off" placeholder="Enter your username" required>
                            <div class="invalid-feedback">Please enter a valid username.</div>
                        </div>

                        <div class="mb-4">
                            <div class="d-flex justify-content-between">
                                <div class="d-inline-block">
                                    <label class="form-label fw-bold">Password</label>
                                </div>
                                <div class="d-inline-block">
                                    <?php if (!empty($_SESSION['error']) && isset($_SESSION['error']['password'])): ?>
                                        <span class="text-warning mb-4">
                                            <?php echo $_SESSION['error']['password'] ?>
                                        </span>
                                        <?php unset($_SESSION['error']['password']); ?>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <input type="password" class="form-control form-control-lg" name="password" id="oldPassword" autocomplete="new-password" placeholder="Enter your password" required>
                            <div class="invalid-feedback">Please enter your password.</div>
                        </div>

                        <div class="mb-4">
                            <div class="d-flex justify-content-between">
                                <div class="d-inline-block">
                                    <label class="form-label fw-bold">Email</label>
                                </div>
                                <div class="d-inline-block">
                                    <?php if (!empty($_SESSION['error']) && isset($_SESSION['error']['email'])): ?>
                                        <span class="text-warning mb-4">
                                            <?php echo $_SESSION['error']['email'] ?>
                                        </span>
                                        <?php unset($_SESSION['error']['email']); ?>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <input type="email" class="form-control form-control-lg" name="email" placeholder="Enter your email address" required>
                            <div class="invalid-feedback">Please enter a valid email address.</div>
                        </div>

                        <div class="mb-4">
                            <div class="d-flex justify-content-between">
                                <div class="d-inline-block">
                                    <label class="form-label fw-bold">Full Name</label>
                                </div>
                                <div class="d-inline-block">
                                    <?php if (!empty($_SESSION['error']) && isset($_SESSION['error']['fullname'])): ?>
                                        <span class="text-warning mb-4">
                                            <?php echo $_SESSION['error']['fullname'] ?>
                                        </span>
                                        <?php unset($_SESSION['error']['fullname']); ?>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <input type="text" class="form-control form-control-lg" name="fullname" placeholder="Enter your full name" required>
                            <div class="invalid-feedback">Please enter your full name.</div>
                        </div>

                        <div class="d-grid mt-4">
                            <button type="submit" class="btn btn-dark btn-lg fw-bold text-white">Add Member</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

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
    })();
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