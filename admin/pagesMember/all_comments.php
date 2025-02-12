<?php
if (isset($_GET['page']) && $_GET['page'] == 'pending') {
    $query = 'AND RagStatus';
} else {
    $query = null;
}
$sort = isset($_GET['sort']) && $_GET['sort'] == 'ASC' ? 'DESC' : 'ASC';
$stmt = $con->prepare("SELECT * FROM users WHERE GroupID = 1 AND AdminID = 0 $query 
                       ORDER BY UserID $sort");
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
                <div class="container">
                    <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
                        <div>
                            <h2 class="custom-h2 fw-bold text-start me-2">All Members</h2>
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
                            <!-- زر إضافة عضو جديد -->
                            <a href="members.php?do=add" class="btn btn-success">
                                <i class="fas fa-plus-circle me-2"></i>Add New Member
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- الجدول -->
            <div class="table-responsive mt-4">
                <table class="table table-bordered table-striped table-dark table-hover rounded-table">
                    <thead class="rounded">
                        <tr>
                            <th>#ID</th>
                            <th>Username</th>
                            <th>Email</th>
                            <th>Full Name</th>
                            <th>Registered Date</th>
                            <th>Control</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        foreach ($rows as $member) {
                            echo "<tr>";
                            echo "<td>{$member['UserID']}</td>";
                            echo "<td>{$member['Username']}</td>";
                            echo "<td>{$member['Email']}</td>";
                            echo "<td>{$member['FullName']}</td>";
                            echo "<td>{$member['Date']}</td>";
                            echo "<td class='text-center'>
                                    <a class='btn btn-sm btn-danger delete-btn control' href='members.php?do=delete&id=" . $member['UserID'] . "' ><i class='fas fa-trash'></i> Delete</a>
                                    <a class='btn btn-sm btn-primary edit-btn control' href='members.php?do=edit&id=" . $member['UserID'] . "' '><i class='fas fa-edit'></i> Edit</a> ";
                            if ($member['RagStatus'] == 1) {
                                echo "<a class='btn btn-sm btn-info active-btn control' href='members.php?do=active&id=" . $member['UserID'] . "''><i class='fas fa-check'></i> Active</a>";
                            }
                            "</td>";

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

            var deleteLink = $(this).attr('href');

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
                        'Member has been successfully deleted.',
                        'success'
                    ).then(() => {
                        window.location.href = 'members.php?do=delete&id=' + deleteLink;
                    });
                }
            });
        });
    });
</script>


<script>
    $(document).ready(function() {
        $('.delete-btn').click(function(e) {
            e.preventDefault();
            var url = $(this).attr('href');
            var comid = $(this).attr('id').split('-')[1];

            Swal.fire({
                title: 'Are you sure?',
                text: "Do you want to delete this comment?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, delete it!',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: url,
                        type: 'GET',
                        success: function(response) {
                            Swal.fire(
                                'Deleted!',
                                'The comment has been deleted.',
                                'success'
                            );
                            $('#comment-' + comid).remove();
                        },
                        error: function() {
                            Swal.fire(
                                'Error!',
                                'There was a problem deleting the comment.',
                                'error'
                            );
                        }
                    });
                }
            });
        });
    });
</script>