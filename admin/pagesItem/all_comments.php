<?php

$sort = isset($_GET['sort']) && $_GET['sort'] == 'ASC' ? 'DESC' : 'ASC';

$stmt = $con->prepare("SELECT items.* , categories.Name AS Cat_Name ,users.Username as User_Name FROM items 
                         INNER JOIN categories ON categories.ID = items.CatID
                         INNER JOIN users ON users.UserID = items.MemberID
                         ORDER BY itemsID $sort ");
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
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="header-section">
                <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
                    <div>
                        <h2 class="custom-h2 fw-bold text-start me-2">All Items</h2>
                    </div>
                    <div class="d-flex align-items-center flex-wrap gap-3">
                        <!-- زر الترتيب -->
                        <a id="sortOrdering" class="btn btn-secondary" href="?sort=<?= $sort ?>">
                            <i class="fa-solid fa-sort"></i> Sort Ordering
                        </a>

                        <!-- زر ارجع -->
                        <a id="sortOrdering" class="btn btn-primary" href="<?= $_SERVER['HTTP_REFERER'] ?>">
                            <i class="fa-solid fa-backward"></i> Back
                        </a>

                        <!-- زر إضافة عنصر جديد -->
                        <a href="items.php?do=add" class="btn btn-success">
                            <i class="fas fa-plus-circle me-2"></i>Add New Item
                        </a>
                    </div>
                </div>
            </div>

            <div class="table-responsive mt-4">
                <table class="table table-bordered table-striped table-dark table-hover rounded-table">
                    <thead class="rounded">
                        <tr>
                            <th>#ID</th>
                            <th>Item Name</th>
                            <th>Description</th>
                            <th>Price</th>
                            <th>Date</th>
                            <th>Country Made</th>
                            <th>Status</th>
                            <th>Rating</th>
                            <th>Category Name</th>
                            <th>Member Name</th>
                            <th>Control</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        foreach ($rows as $item) {
                            echo "<tr>";
                            echo "<td>{$item['itemsID']}</td>";
                            echo "<td>{$item['Name']}</td>";
                            echo "<td>{$item['Description']}</td>";
                            echo "<td>{$item['Price']}</td>";
                            echo "<td>{$item['AddDate']}</td>";
                            echo "<td>{$item['CountryMade']}</td>";
                            echo "<td>{$item['Status']}</td>";
                            echo "<td>{$item['Rating']}</td>";
                            echo "<td>{$item['Cat_Name']}</td>";
                            echo "<td>{$item['User_Name']}</td>";
                            echo "<td class='text-center'>
                                    <a class='btn btn-sm btn-danger delete-btn control' href='items.php?do=delete&itemid=" . $item['itemsID'] . "'><i class='fas fa-trash'></i> Delete</a>
                                    <a class='btn btn-sm btn-primary edit-btn control' href='items.php?do=edit&itemid=" . $item['itemsID'] . "'><i class='fas fa-edit'></i> Edit</a> ";
                            if ($item['Approve'] == 0) {
                                echo "<a class='btn btn-sm btn-info active-btn control mt-1' href='items.php?do=approve&itemid=" . $item['itemsID'] . "'><i class='fas fa-arrow-up'></i> Approve</a>";
                            }
                            echo "</td>";
                            echo "</tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</div>

<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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
                        window.location.href = 'items.php?do=delete&id=' + id;
                    });
                }
            });
        });
    });
</script>