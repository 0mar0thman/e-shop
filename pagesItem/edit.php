<!-- page validEdit -->
<?php
if (!isset($_SESSION['id'])) {
    echo '<h4 class="text-center mt-5">You must log in first.</h4>';
    exit();
}

$itemid = is_numeric($_GET['itemid']) && intval($_GET['itemid']) ? $_GET['itemid'] : 0;

Admin();

$stmt = $con->prepare("SELECT items.* , categories.Name AS Cat_Name ,users.Username as User_Name FROM items 
                         INNER JOIN categories ON categories.ID = items.CatID
                         INNER JOIN users ON users.UserID = items.MemberID
                         WHERE itemsID = ?");

$stmt->execute(array($itemid));
$rows = $stmt->fetch();
$count = $stmt->rowCount();


if ($count > 0) {
    include 'pagesItem/edit.php';
} else {
    echo '<h4 class="text-center mt-5">This user does not exist.</h4>';
}
?>
<div style="width: 90%; margin: auto;">
    <div class="card shadow-lg needs-validation">
        <!-- زر ارجع -->
        <a id="sortOrdering" class="btn btn-sm btn-secondary w-25" style="margin: 10px; position: absolute ; right: 5px" href="<?= $_SERVER['HTTP_REFERER'] ?>">
            <i class="fa-solid fa-backward"></i> Back
        </a>
        <form action="items.php?do=update" method="POST" class="rounded p-3 mt-5" novalidate>

            <input type="hidden" name="itemid" value="<?= $rows['itemsID'] ?>">

            <div class="grid-container text-white">
                <!-- Name Item Field -->
                <div class="grid-item">
                    <label for="Name" class="form-label fw-bold">Name Item</label>
                    <input type="text" class="form-control form-control-lg" name="name" value="<?= htmlspecialchars($rows['Name']) ?? '' ?>" placeholder="Enter your name item">
                    <span class="text-danger" id="nameError">
                        <?= isset($_SESSION['error']['name']) ? htmlspecialchars($_SESSION['error']['name']) : '' ?>
                    </span>
                    <?php unset($_SESSION['error']['name']) ?>
                </div>

                <!-- Description Field -->
                <div class="grid-item">
                    <label for="description" class="form-label fw-bold">Description</label>
                    <input type="text" class="form-control form-control-lg" name="description" value="<?= htmlspecialchars($rows['Description']) ?? '' ?>" placeholder="Enter your description item" required>
                    <span class="text-danger" id="descriptionError">
                        <?= isset($_SESSION['error']['description']) ? htmlspecialchars($_SESSION['error']['description']) : '' ?>
                    </span>
                    <?php unset($_SESSION['error']['description']) ?>
                </div>

                <!-- Price Field -->
                <div class="grid-item">
                    <label for="price" class="form-label fw-bold">Price</label>
                    <input type="number" class="form-control form-control-lg" name="price" value="<?= htmlspecialchars($rows['Price']) ?? '' ?>" placeholder="Enter your price item" required>
                    <span class="text-danger" id="priceError">
                        <?= isset($_SESSION['error']['price']) ? htmlspecialchars($_SESSION['error']['price']) : '' ?>
                    </span>
                    <?php unset($_SESSION['error']['price']) ?>
                </div>

                <!-- Add Date Field -->
                <?php $date = isset($rows['AddDate']) ? (new DateTime($rows['AddDate']))->format('Y-m-d\TH:i') : '';  ?>
                <div class="grid-item">
                    <label for="AddDate" class="form-label fw-bold">Date</label>
                    <input type="datetime-local" class="form-control form-control-lg" name="AddDate" value="<?= $date ?>" placeholder="Enter your Add Date item" required>
                    <span class="text-danger" id="addDateError">
                        <?= isset($_SESSION['error']['addDate']) ? htmlspecialchars($_SESSION['error']['addDate']) : '' ?>
                    </span>
                    <?php unset($_SESSION['error']['addDate']) ?>
                </div>

                <!-- Country Made Field -->
                <div class="grid-item">
                    <label for="CountryMade" class="form-label fw-bold">Country Made</label>
                    <input type="text" class="form-control form-control-lg" name="CountryMade" value="<?= htmlspecialchars($rows['CountryMade']) ?? '' ?>" placeholder="Enter your Country Made item" required>
                    <span class="text-danger" id="countryMadeError">
                        <?= isset($_SESSION['error']['countryMade']) ? htmlspecialchars($_SESSION['error']['countryMade']) : '' ?>
                    </span>
                    <?php unset($_SESSION['error']['countryMade']) ?>
                </div>

                <!-- Status Field -->
                <div class="grid-item">
                    <label for="Status" class="form-label fw-bold">Status</label>
                    <?php
                    $allStatusOptions = ["New", "Used", "Old"];
                    $currentStatus = htmlspecialchars($rows['Status']) ?? '';
                    ?>

                    <select class="form-control form-control-lg" name="status" required>
                        <option value="<?= $currentStatus ?>" selected>
                            <?= $currentStatus ?: 'Select Status' ?>
                        </option>
                        <?php
                        foreach ($allStatusOptions as $statusOption) {
                            if ($statusOption !== $currentStatus) {
                                echo "<option value='$statusOption'>$statusOption</option>";
                            }
                        }
                        ?>
                    </select>
                    <span class="text-danger" id="statusError">
                        <?= isset($_SESSION['error']['status']) ? htmlspecialchars($_SESSION['error']['status']) : '' ?>
                    </span>
                    <?php unset($_SESSION['error']['status']) ?>
                </div>

                <!-- Rating Field -->
                <div class="grid-item">
                    <label for="Rating" class="form-label fw-bold">Rating</label>
                    <select class="form-control form-control-lg" name="rating" required>
                        <option value="<?= htmlspecialchars($rows['Rating']) ?? '' ?>" selected>
                            <?= isset($rows['Rating']) ? htmlspecialchars($rows['Rating']) : 'Select Rating' ?>
                        </option>
                        <?php for ($i = 1; $i <= 5; $i++) : ?>
                            <?php if (!isset($rows['Rating']) || $rows['Rating'] != $i) : ?>
                                <option value="<?= $i ?>"><?= $i ?></option>
                            <?php endif; ?>
                        <?php endfor; ?>
                    </select>
                    <span class="text-danger" id="ratingError">
                        <?= isset($_SESSION['error']['rating']) ? htmlspecialchars($_SESSION['error']['rating']) : '' ?>
                    </span>
                    <?php unset($_SESSION['error']['rating']) ?>
                </div>

                <!-- Member Field -->
                <div class="grid-item">
                    <label for="Member" class="form-label fw-bold">Member</label>
                    <div>
                        <select class="form-control form-control-lg" name="member" id="memberSelect" required>
                            <?php
                            $stmt = $con->prepare("SELECT * FROM users");
                            $stmt->execute();
                            $users = $stmt->fetchAll();
                            ?>
                            <?php foreach ($users as $user) : ?>
                                <option value="<?= $user['UserID'] ?>" data-name="<?= htmlspecialchars($user['Username']) ?>" <?php if ($rows['User_Name'] == $user['Username']) echo 'selected' ?>>
                                    <?php echo htmlspecialchars($user['Username']) ?>
                                </option>
                            <?php endforeach ?>
                        </select>
                        <!-- حقل مخفي لتخزين اسم المستخدم -->
                        <input type="hidden" name="memberName" id="memberName" value="<?= htmlspecialchars($rows['User_Name']) ?>">
                    </div>
                    <span class="text-danger" id="memberError">
                        <?= isset($_SESSION['error']['member']) ? htmlspecialchars($_SESSION['error']['member']) : '' ?>
                    </span>
                    <?php unset($_SESSION['error']['member']) ?>
                </div>

                <!-- Category Field -->
                <div class="grid-item">
                    <label for="category" class="form-label fw-bold">Category</label>
                    <div>
                        <select class="form-control form-control-lg" name="category" id="categorySelect" required>
                            <?php
                            $stmt = $con->prepare("SELECT * FROM categories");
                            $stmt->execute();
                            $cats = $stmt->fetchAll();
                            ?>
                            <?php foreach ($cats as $cat) : ?>
                                <option value="<?= $cat['ID'] ?>" data-name="<?= htmlspecialchars($cat['Name']) ?>" <?php if ($rows['Cat_Name'] == $cat['Name']) echo 'selected' ?>>
                                    <?php echo htmlspecialchars($cat['Name']) ?>
                                </option>
                            <?php endforeach ?>
                        </select>
                        <!-- حقل مخفي لتخزين اسم الفئة -->
                        <input type="hidden" name="catName" id="catName" value="<?= htmlspecialchars($rows['Cat_Name']) ?>">
                    </div>
                    <span class="text-danger" id="categoryError">
                        <?= isset($_SESSION['error']['category']) ? htmlspecialchars($_SESSION['error']['category']) : '' ?>
                    </span>
                    <?php unset($_SESSION['error']['category']) ?>
                </div>

                <!-- Submit Button -->
                <div class="grid-item full-width">
                    <div class="d-grid mt-4">
                        <button type="submit" class="btn btn-dark btn-lg fw-bold text-white">Save Changes</button>
                    </div>
                </div>
            </div>
        </form>
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
<script>
    document.getElementById('memberSelect').addEventListener('change', function() {
        var selectedOption = this.options[this.selectedIndex];
        document.getElementById('memberName').value = selectedOption.getAttribute('data-name');
    });
</script>
<script>
    document.getElementById('categorySelect').addEventListener('change', function() {
        var selectedOption = this.options[this.selectedIndex];
        document.getElementById('catName').value = selectedOption.getAttribute('data-name');
    });
</script>