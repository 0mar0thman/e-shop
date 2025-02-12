<!-- add and insert -->
<div class="container-fluid">
    <div class="row col-lg-12">
        <!-- الجزء الأيسر للرسومات -->
        <div class="col-lg-8 col-md-6 custom-graphics-col">
            <div class="graphics-content text-center" data-aos="fade-right" data-aos-duration="1000">
                <div class="background-image" style="background-image: url('https://source.unsplash.com/random/800x600');"></div>
                <i class="fas fa-box-open fa-5x mb-4 animate__animated animate__bounceIn"></i>
                <h2 class="animate__animated animate__fadeInUp">Add New Item</h2>
                <p class="animate__animated animate__fadeInUp animate__delay-1s">
                    Welcome to our platform! Add new items easily and manage them efficiently.
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
                    <h1 class="h4 fw-bold mb-0">Add New Item</h1>
                </div>
                <div class="card-body p-4 needs-validation">
                    <form method="POST" action="?do=insert" novalidate>
                        <!-- Name Field -->
                        <div class="mb-4">
                            <div class="d-flex justify-content-between">
                                <div class="d-inline-block">
                                    <label class="form-label fw-bold">Item Name</label>
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
                            <input type="text" class="form-control form-control-lg" name="name" autocomplete="off" placeholder="Enter item name" required>
                            <div class="invalid-feedback">Please enter a valid item name.</div>
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
                            <textarea class="form-control form-control-lg" name="description" placeholder="Enter item description" required></textarea>
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
                            <input type="number" class="form-control form-control-lg" name="price" placeholder="Enter item price" required>
                            <div class="invalid-feedback">Please enter a valid price.</div>
                        </div>

                        <!-- Country Made Field -->
                        <div class="mb-4">
                            <div class="d-flex justify-content-between">
                                <div class="d-inline-block">
                                    <label class="form-label fw-bold">Country Made</label>
                                </div>
                                <div class="d-inline-block">
                                    <?php if (!empty($_SESSION['error']) && isset($_SESSION['error']['countryMade'])): ?>
                                        <span class="text-warning mb-4">
                                            <?php echo $_SESSION['error']['countryMade'] ?>
                                        </span>
                                        <?php unset($_SESSION['error']['countryMade']); ?>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <input type="text" class="form-control form-control-lg" name="countryMade" placeholder="Enter country made" required>
                            <div class="invalid-feedback">Please enter a valid country.</div>
                        </div>

                        <!-- Status Field -->
                        <div class="mb-4">
                            <div class="d-flex justify-content-between">
                                <div class="d-inline-block">
                                    <label class="form-label fw-bold">Status</label>
                                </div>
                                <div class="d-inline-block">
                                    <?php if (!empty($_SESSION['error']) && isset($_SESSION['error']['status'])): ?>
                                        <span class="text-warning mb-4">
                                            <?php echo $_SESSION['error']['status'] ?>
                                        </span>
                                        <?php unset($_SESSION['error']['status']); ?>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <select class="form-control form-control-lg" name="status" required>
                                <option value="new">New</option>
                                <option value="used">Used</option>
                                <option value="old">Old</option>
                            </select>
                            <div class="invalid-feedback">Please select a status.</div>
                        </div>

                        <!-- secMember Field -->
                        <div class="mb-4">
                            <div class="d-inline-block">
                                <label class="form-label fw-bold">Member</label>
                            </div>
                            <select class="form-control form-control-lg" name="secMember" required>
                                <?php
                                $stmt = $con->prepare("SELECT * From users");
                                $stmt->execute();
                                $users = $stmt->fetchAll();
                                ?>
                                <?php
                                foreach ($users as $user) {
                                    echo " <option value=' "  .  $user['UserID'] .  " '>  " .  $user["Username"]  . "  </option> ";
                                }
                                ?>
                            </select>
                        </div>

                        <!-- secCategory Field -->
                        <div class="mb-4">
                            <div class="d-inline-block">
                                <label class="form-label fw-bold">Category</label>
                            </div>
                            <select class="form-control form-control-lg" name="secCategory" required>
                                <?php
                                $stmt2 = $con->prepare("SELECT * From categories");
                                $stmt2->execute();
                                $cats = $stmt2->fetchAll();
                                ?>
                                <?php
                                foreach ($cats as $cat) {
                                    echo " <option value=' "  .  $cat['ID'] .  " '>  " .  $cat["Name"]  . "  </option> ";
                                }
                                ?>
                            </select>
                        </div>

                        <!-- Rating Field -->
                        <div class="mb-4">
                            <div class="d-flex justify-content-between">
                                <div class="d-inline-block">
                                    <label class="form-label fw-bold">Rating</label>
                                </div>
                                <div class="d-inline-block">
                                    <?php if (!empty($_SESSION['error']) && isset($_SESSION['error']['rating'])): ?>
                                        <span class="text-warning mb-4">
                                            <?php echo $_SESSION['error']['rating'] ?>
                                        </span>
                                        <?php unset($_SESSION['error']['rating']); ?>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <input type="number" class="form-control form-control-lg" name="rating" min="1" max="5" placeholder="Enter rating (1-5)" required>
                            <div class="invalid-feedback">Please enter a valid rating (1-5).</div>
                        </div>

                        <!-- Submit Button -->
                        <div class="d-grid mt-4">
                            <button type="submit" class="btn btn-dark btn-lg fw-bold text-white">Add Item</button>
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