<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card shadow-lg needs-validation">
                <!-- زر ارجع -->
                <a id="sortOrdering" class="btn btn-sm btn-secondary w-25" style="margin: 10px; position: absolute ; right: 5px" href="<?= $_SERVER['HTTP_REFERER'] ?>">
                    <i class="fa-solid fa-backward"></i> Back
                </a>
                <!-- Card Body -->
                <div class=" p-4 mt-4">
                    <!-- START: Messages -->
                    <?php if (isset($_SESSION['error']) && !empty($_SESSION['error'])): ?>
                        <div class="alert alert-danger text-center mb-4">
                            <?= $_SESSION['error']; ?>
                        </div>
                        <?php unset($_SESSION['error']); ?>
                    <?php endif; ?>

                    <?php if (!empty($_SESSION['errorValid'])): ?>
                        <div style="position: absolute;" class="alert alert-danger text-center mb-4">
                            <?php foreach ($_SESSION['errorValid'] as $value): ?>
                                <?= htmlspecialchars($value) . '<br>'; ?>
                            <?php endforeach; ?>
                        </div>
                        <?php unset($_SESSION['errorValid']); ?>
                    <?php endif; ?>
                    <!-- END: Messages -->

                    <?php if (!empty($rows)): ?>
                        <!-- Form -->
                        <form method="POST" action="?do=update&update.php" class="text-white" novalidate>
                            <!-- Hidden ID Field -->
                            <input type="hidden" name="userid" value="<?= isset($rows['UserID']) ? htmlspecialchars($rows['UserID']) : '' ?>">

                            <div class="row ">
                                <!-- Username Field -->
                                <div class="col-md-6 mb-4">
                                    <label for="username" class="form-label fw-bold">User Name</label>
                                    <input type="hidden" name="oldUsername" value="<?= isset($rows['Username']) ? htmlspecialchars($rows['Username']) : '' ?>" />
                                    <input type="text" class="form-control form-control-lg" name="newUsername" value="<?= isset($rows['Username']) ? htmlspecialchars($rows['Username']) : '' ?>" autocomplete="off" placeholder="Enter your username" required>
                                    <div class="invalid-feedback">Please enter a valid username.</div>
                                </div>

                                <!-- Old Password Field -->
                                <div class="col-md-6 mb-4">
                                    <label for="oldPassword" class="form-label fw-bold">Old Password</label>
                                    <input type="hidden" name="thePassword" value="<?= isset($rows['Password']) ? htmlspecialchars($rows['Password']) : '' ?>">
                                    <input type="password" class="form-control form-control-lg" name="oldPassword" id="oldPassword" autocomplete="new-password" placeholder="Enter your old password" required>
                                    <div class="invalid-feedback">Please enter your old password.</div>
                                </div>
                            </div>

                            <div class="row">
                                <!-- New Password Field -->
                                <div class="col-md-6 mb-4">
                                    <label for="newPassword" class="form-label fw-bold">New Password <span>(optional)</span></label>
                                    <input type="password" class="form-control form-control-lg" name="newPassword" id="newPassword" autocomplete="new-password" placeholder="Enter a new password">
                                    <div class="invalid-feedback">Please enter a valid new password.</div>
                                </div>

                                <!-- Email Field -->
                                <div class="col-md-6 mb-4">
                                    <label for="email" class="form-label fw-bold">Email</label>
                                    <input type="hidden" name="oldEmail" value="<?= isset($rows['Email']) ? htmlspecialchars($rows['Email']) : '' ?>" />
                                    <input type="email" class="form-control form-control-lg" name="newEmail" value="<?= isset($rows['Email']) ? htmlspecialchars($rows['Email']) : '' ?>" placeholder="Enter your email address" required>
                                    <div class="invalid-feedback">Please enter a valid email address.</div>
                                </div>
                            </div>

                            <div class="row">
                                <!-- Full Name Field -->
                                <div class="col-md-6 mb-4">
                                    <label for="fullname" class="form-label fw-bold">Full Name</label>
                                    <input type="hidden" name="oldFullname" value="<?= isset($rows['FullName']) ? htmlspecialchars($rows['FullName']) : '' ?>">
                                    <input type="text" class="form-control form-control-lg" name="newFullname" value="<?= isset($rows['FullName']) ? htmlspecialchars($rows['FullName']) : '' ?>" placeholder="Enter your full name" required>
                                    <div class="invalid-feedback">Please enter your full name.</div>
                                </div>
                            </div>

                            <!-- Submit Button -->
                            <div class="row">
                                <div class="col-md-6 offset-md-3 mt-4">
                                    <button type="submit" class="btn btn-dark btn-lg fw-bold text-white w-100">Save Changes</button>
                                </div>
                            </div>
                        </form>
                    <?php else: ?>
                        <!-- Display a message if no data is available -->
                        <div class="alert alert-warning text-center">
                            <h4 class="mb-0">No user data found!</h4>
                        </div>
                    <?php endif; ?>
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
</script>