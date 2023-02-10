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
                <h5>Edit Category</h5>
            </div>
        </div>
        <br>
        <?php
        if (!isset($_GET['id'])) {
            echo "<script>window.alert(`Bad Request!`)</script>";
            echo "<script>window.open('./files.php','_self')</script>";
        }
        $fileCatId = $_GET['id'];
        $fileCatSql = $conn->prepare("SELECT * FROM tblfilecat WHERE filecat_id = ?");
        $fileCatSql->bindParam(1, $fileCatId);
        $fileCatSql->execute();
        $fileCat = $fileCatSql->fetch(PDO::FETCH_ASSOC);
        ?>
        <form action="./backend/editFileCat.php" enctype="multipart/form-data" method="POST">
            <div class="row">
                <table class="table align-middle">
                    <tbody>
                        <tr>
                            <td><input class="form-control" type="text" name="fileCatId" id="officer_id" value="<?php echo $fileCat['filecat_id'] ?>" hidden required></td>
                        </tr>
                        <tr>
                            <td>Category Name</td>
                            <td><input class="form-control" type="text" name="catName" id="officer_name" value="<?php echo $fileCat['filecat_name'] ?>" required></td>
                        </tr>
                        <tr>
                            <td>Category Format</td>
                            <td><textarea class="form-control" name="catFormat" id="officer_email" ><?php echo $fileCat['filecat_format'] ?></textarea></td>
                        </tr>
                        <tr>
                            <td>Category Document</td>
                            <td><input class="form-control" type="file" name="catDoc" id="officerMobile"></td>
                        </tr>
                        <tr>
                            <td>Category Remarks</td>
                            <td><textarea class="form-control" name="catRemarks" id="officer_email" ><?php echo $fileCat['filecat_remarks'] ?></textarea></td>
                        </tr>
                    </tbody>
                </table>
                <div class="col text-center">
                    <a href="./fileCategory.php" class="btn btn-danger px-4 mx-4">Cancel</a>
                    <input class="btn btn-dark px-4" type="submit" name="editFileCat" value="Save Changes">
                </div>
            </div>
        </form>
    </div>
    <br><br>
    <?php include '../footer.php'; ?>
    </body>

    </html>
<?php
} else {
    echo "<script>window.alert(`Don't peep!`)</script>";
    echo "<script>window.open('../','_self')</script>";
}
?>