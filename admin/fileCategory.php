<?php
session_start();
include('../backend/checkSession.php');
checkSession();
include "../header.php";
include '../connection.php';
include './nav.php';
if ((isset($_SESSION['username']) && isset($_SESSION['auth']))) {
    $sql = $conn->prepare('SELECT * FROM `tblrole` t, `tblofficer` o WHERE t.role_id = ? AND t.role_id = o.officer_role_id');
    $sql->bindParam(1, $_SESSION['auth']);
    $sql->execute();
    $key = $sql->fetch(PDO::FETCH_ASSOC);
?>
    <br>
    <div class="container-fluid px-5">
        <div class="row">
            <div class="col">
                <h5>Manage File Category</h5>
            </div>
            <div class="col text-end">
                <a href="./addFileCat.php" class="btn btn-outline-success"><i class="fa-solid fa-plus"></i>&nbsp;Add File Category</a>
            </div>
        </div>
        <br>
        <div class="row">
            <?php
            $cat_sql = $conn->prepare("SELECT * FROM tblfilecat WHERE filecat_active = 1");
            $cat_sql->execute();
            $cats = $cat_sql->fetchAll(PDO::FETCH_ASSOC);
            ?>
            <table class="table table-bordered text-center">
                <thead>
                    <tr>
                        <th scope="col">Sr. No.</th>
                        <th scope="col">Name</th>
                        <th scope="col">Document</th>
                        <th scope="col">Category Information</th>
                        <th scope="col">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $sr_no = 1;
                    foreach ($cats as $cat) {
                    ?>
                        <tr>
                            <th scope="row"><?php echo $sr_no; ?></th>
                            <td><a href="<?php echo './fileCat.php?id=' . $cat['filecat_id']; ?>" target="_blank"><?php echo $cat['filecat_name'] ?></td>
                            <?php if ($cat['filecat_doc_path'] == '') {
                                echo '<td class="text-danger">No Document</td>';
                            } else {
                            ?>
                                <td><a class="btn btn-dark" href="../uploads<?php echo $cat['filecat_doc_path']; ?>" target="_blank">View</a></td>
                            <?php
                            }  ?>
                            <td><?= $cat['filecat_format'] ?></td>
                            <td>
                                <a href="editFileCat.php?id=<?php echo $cat['filecat_id'] ?>" class="btn btn-primary text-light"><i class="fa-solid fa-pen-to-square"></i></a> &nbsp;
                                <button class="btn btn-danger text-light delete" id="<?php echo $cat['filecat_id'] ?>"><i class="fa-solid fa-trash"></i></button>
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
        document.getElementById('file-nav').classList.remove('active');
        document.getElementById("manage-nav").classList.add('active');
        document.getElementById("dash-nav").classList.remove('active');
        $(document).ready(function() {
            $(".delete").on('click', function() {
                if (confirm("Are you sure you want to delete")) {
                    var id = $(this).attr("id");
                    $.ajax({
                        type: "POST",
                        url: "backend/deleteFileCat.php",
                        data: {
                            fileCatId: id
                        },
                        success: function(response) {
                            window.location.reload();
                        }
                    });
                }
            })
        });
    </script>
<?php
} else {
    echo "<script>window.alert(`Don't peep!`)</script>";
    echo "<script>window.open('../','_self')</script>";
}
?>