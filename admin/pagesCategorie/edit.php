<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-12 col-lg-9"> <!-- جعل العرض 90% من الصفحة -->
            <div class="card shadow-lg needs-validation">
                <!-- زر ارجع -->
                <a id="sortOrdering" class="btn btn-sm btn-secondary w-25" style="margin: 10px; position: absolute ; right: 5px" href="<?= $_SERVER['HTTP_REFERER'] ?>">
                    <i class="fa-solid fa-backward"></i> Back
                </a>
                <!-- Card Body -->
                <div class="p-4 mt-5">
                    <!-- START: Messages -->
                    <?php if (isset($_SESSION['error']['name'])): ?>
                        <div class="alert alert-danger text-center mb-4">
                            <?= htmlspecialchars($_SESSION['error']['name']); ?>
                        </div>
                        <?php unset($_SESSION['error']['name']); ?>
                    <?php endif; ?>

                    <?php if (!empty($_SESSION['errorValid'])): ?>
                        <div class="alert alert-danger text-center mb-4">
                            <?php foreach ($_SESSION['errorValid'] as $value): ?>
                                <?= htmlspecialchars($value) . '<br>'; ?>
                            <?php endforeach; ?>
                        </div>
                        <?php unset($_SESSION['errorValid']); ?>
                    <?php endif; ?>
                    <!-- END: Messages -->

                    <!-- START: Check if $cat is available -->
                    <?php if (!empty($cat)): ?>
                        <!-- Form -->
                        <form method="POST" action="categories.php?do=update" class="text-white" novalidate>
                            <!-- Hidden ID Field -->
                            <input type="hidden" name="catid" value="<?= htmlspecialchars($cat['ID']) ?>">

                            <!-- Name and Description Fields -->
                            <div class="row mb-4">
                                <div class="col-md-6">
                                    <label for="name" class="form-label fw-bold">Category Name</label>
                                    <input type="text" class="form-control form-control-lg" name="name" value="<?= htmlspecialchars($cat['Name']) ?>" autocomplete="off" placeholder="Enter category name" required>
                                    <div class="invalid-feedback">Please enter a valid category name.</div>
                                </div>
                                <div class="col-md-6">
                                    <label for="description" class="form-label fw-bold">Description</label>
                                    <textarea class="form-control form-control-lg" name="description" placeholder="Enter category description" required><?= htmlspecialchars($cat['Description']) ?></textarea>
                                    <div class="invalid-feedback">Please enter a valid description.</div>
                                </div>
                            </div>

                            <!-- Price and Quantity Fields -->
                            <div class="row mb-4">
                                <div class="col-md-6">
                                    <label for="ordering" class="form-label fw-bold">Price</label>
                                    <input type="number" class="form-control form-control-lg" name="price" value="<?= htmlspecialchars($cat['Price']) ?>" placeholder="Enter price number" required>
                                    <div class="invalid-feedback">Please enter a valid price number.</div>
                                </div>
                                <div class="col-md-6">
                                    <label for="ordering" class="form-label fw-bold">Quantity</label>
                                    <input type="number" class="form-control form-control-lg" name="quantity" value="<?= htmlspecialchars($cat['Quantity']) ?>" placeholder="Enter quantity number" required>
                                    <div class="invalid-feedback">Please enter a valid quantity number.</div>
                                </div>
                            </div>

                            <!-- Category and Visibility Fields -->
                            <div class="row mb-4">
                                <div class="col-md-6">
                                    <label class="form-label fw-bold">Visible</label>
                                    <div class="d-flex gap-3">
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="visibility" id="visibleYes" value="0" <?= $cat['Visibility'] == 0 ? 'checked' : '' ?>>
                                            <label class="form-check-label" for="visibleYes">Yes</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="visibility" id="visibleNo" value="1" <?= $cat['Visibility'] == 1 ? 'checked' : '' ?>>
                                            <label class="form-check-label" for="visibleNo">No</label>
                                        </div>
                                    </div>
                                    <div class="invalid-feedback">Please select a visibility option.</div>
                                </div>
                            </div>

                            <!-- Submit Button -->
                            <div class="row">
                                <div class="col-md-6 offset-md-3"> <!-- جعل الزر يأخذ 50% من العرض -->
                                    <div class="d-grid mt-4">
                                        <button type="submit" class="btn btn-dark btn-lg fw-bold text-white">Save Changes</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    <?php else: ?>
                        <!-- Display a message if no data is available -->
                        <div class="alert alert-warning text-center">
                            <h4 class="mb-0">No category data found!</h4>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>