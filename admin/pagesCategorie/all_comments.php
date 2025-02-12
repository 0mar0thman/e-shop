<?php
$sort = isset($_GET['sort']) && $_GET['sort'] == 'ASC' ? 'DESC' : 'ASC';
$stmt = $con->prepare("SELECT * FROM categories ORDER BY ID $sort");
$stmt->execute();
$rows = $stmt->fetchAll();
?>
<style>
    .header-section {
        background-color: #1e1e1e;
        padding: 20px;
        border-radius: 15px;
        margin-bottom: 30px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    }
</style>
<div class="container">

    <div class="header-section">
        <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
            <div>
                <h2 class="custom-h2 fw-bold text-start me-2">Manage Categories</h2>
            </div>
            <div class="d-flex align-items-center flex-wrap gap-3">
                <a id="sortOrdering" class="btn btn-secondary" href="?sort=<?= $sort ?>">
                    <i class="fa-solid fa-sort"></i> Sort Ordering
                </a>
                <button id="toggleAll" class="btn btn-info">
                    <i class="fas fa-eye"></i> Toggle All
                </button>
                <!-- زر ارجع -->
                <a id="sortOrdering" class="btn btn-primary" href="<?= $_SERVER['HTTP_REFERER'] ?>">
                    <i class="fa-solid fa-backward"></i> Back
                </a>
                <a href="categories.php?do=add" class="btn btn-success">
                    <i class="fas fa-plus-circle me-2"></i>Add New Category
                </a>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <?php
        foreach ($rows as $cat) {
            echo '
            <div class="col-md-4 ">
                <div class="custom-card bg-dark">
                    <div class="custom-card-body">
                        <h5 class="custom-card-title text-warning">
                            <i class="fas fa-folder"></i> ' . $cat['ID'] . " " . ($cat['Name'] ? $cat['Name'] : '<span class="text-danger">No Title</span>') . '
                            <button class="btn btn-sm btn-secondary toggle-details float-end">
                                <i class="fas fa-chevron-down"></i>
                            </button>
                        </h5>
                        <div class="details">
                            <hr class="text-white">
                            <p class="custom-card-text">
                                <i class="fas fa-align-left"></i> <strong>Description:</strong> ' . $cat['Description'] . '
                            </p>
                            <p class="custom-card-text">
                                <i class="fas fa-sort-numeric-up"></i> <strong>Price:</strong> ' . $cat['Price'] . '$
                            </p>
                            <p class="custom-card-text">
                                <i class="fas fa-eye' . ($cat['Visibility'] ? '' : '-slash') . '"></i> <strong>Visibility:</strong> ' . ($cat['Visibility'] ? 'Visible' : 'Hidden') . '
                            </p>
                            <p class="custom-card-text">
                                <i class="fa-solid fa-equals"></i> <strong>Quantity:</strong> ' . $cat['Quantity'] . '
                            </p>
                         
                            <div class="text-center">
                                <a class="btn btn-sm btn-danger delete-btn" href="categories.php?do=delete&catid=' . $cat['ID'] . '">
                                    <i class="fas fa-trash"></i> Delete
                                </a>
                                <a class="btn btn-sm btn-primary" href="categories.php?do=edit&catid=' . $cat['ID'] . '">
                                    <i class="fas fa-edit"></i> Edit
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>';
        }
        ?>
    </div>

</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        // زر عرض/إخفاء التفاصيل لكل كارد
        $('.toggle-details').click(function() {
            $(this).closest('.custom-card-body').find('.details').slideToggle(300);
            $(this).find('i').toggleClass('fa-chevron-down fa-chevron-up');
        });

        // زر عرض/إخفاء جميع التفاصيل
        $('#toggleAll').click(function() {
            $('.details').slideToggle(300);
            $('.toggle-details i').toggleClass('fa-chevron-down fa-chevron-up');
        });
    });
</script>

<script>
    $(document).ready(function() {
        $(document).on('click', '.delete-btn', function(event) {
            event.preventDefault();

            var id = $(this).attr('href');

            Swal.fire({
                title: 'Are You Sure?',
                text: "You will not be able to undo this action!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, Delete',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire(
                        'Deleted!',
                        'Item has been successfully deleted.',
                        'success'
                    ).then(() => {
                        window.location.href = 'categories.php?do=delete&id=' + id;
                    });
                }
            });
        });
    });
</script>