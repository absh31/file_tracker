<?php
session_start();
include "../header.php";
include '../connection.php';
include './nav.php';

if ((isset($_SESSION['username']) && isset($_SESSION['auth']))) {
    $sql = $conn->prepare('SELECT * FROM `tblrole` t, `tblofficer` o WHERE t.role_id = ? AND t.role_id = o.officer_role_id');
    $sql->bindParam(1, $_SESSION['auth']);
    $sql->execute();
    $key = $sql->fetch(PDO::FETCH_ASSOC);

    if ($key['role_name'] == "Admin") {
?>
        <br>
        <div class="container">
            <div class="row">
                <div class="col">
                    <h5>Manage Roles</h5>
                </div>
                <div class="col text-end">
                    <a href="./addRole.php" class="btn btn-outline-success"><i class="fa-solid fa-plus"></i>&nbsp;Add Role</a>
                </div>
            </div>
            <br>
            <div class="row">
                <?php
                $role_sql = $conn->prepare("SELECT * FROM tblrole WHERE role_active = 1 ORDER BY role_priority");
                $role_sql->execute();
                $roles = $role_sql->fetchAll(PDO::FETCH_ASSOC);
                ?>
                <table class="table" id="myTable">
                    <thead>
                        <tr>
                            <th scope="col">Sr. No.</th>
                            <th scope="col">Role Name</th>
                            <th scope="col">Role Priority</th>
                            <th scope="col">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $sr_no = 1;
                        foreach ($roles as $role) {
                        ?>
                            <tr>
                                <th scope="row"><?php echo $sr_no; ?></th>
                                <td><?php echo $role['role_name'] ?></td>
                                <td><?php echo $role['role_priority'] ?></td>
                                <td>
                                    &nbsp;
                                    <button class="btn btn-danger text-light delete" id="<?php echo $role['role_priority'] ?>"><i class="fa-solid fa-trash"></i></button>
                                </td>
                            </tr>
                        <?php $sr_no++;
                        } ?>
                    </tbody>
                </table>
            </div>
        </div>
        <br><br>
        <?php include '../footer.php'; ?>

        <script>
            document.getElementById('my-nav').classList.remove('active');
            document.getElementById("file-nav").classList.remove('active');
            document.getElementById("manage-nav").classList.add('active');
            document.getElementById("dash-nav").classList.remove('active');
            $(document).ready(function() {
                $(".delete").on('click', function() {
                    if (confirm("Are you sure you want to delete")) {
                        var id = $(this).attr("id");
                        $.ajax({
                            type: "POST",
                            url: "backend/deleteRoles.php",
                            data: {
                                userRoleId: id
                            },
                            success: function(response) {
                                window.location.reload();
                            }
                        });
                    }
                })
            });
            $(document).ready(function() {
            $('#myTable').DataTable();
        });
        </script>
<?php }
} else {
    echo "<script>window.alert(`Don't peep!`)</script>";
    echo "<script>window.open('../','_self')</script>";
}
?>