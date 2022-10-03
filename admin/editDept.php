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
?>
    <br>
    <div class="container">
        <div class="row">
            <div class="col">
                <h5>Edit Department</h5>
            </div>
        </div>
        <br>
        <?php
        if (!isset($_GET['id'])) {
            echo "<script>window.alert(`Bad Request!`)</script>";
            echo "<script>window.open('./files.php','_self')</script>";
        }
        $deptId = $_GET['id'];
        $deptSql = $conn->prepare("SELECT * FROM tbldept WHERE dept_id = ?");
        $deptSql->bindParam(1, $deptId);
        $deptSql->execute();
        $department = $deptSql->fetch(PDO::FETCH_ASSOC);
        ?>
        <form action="./backend/editDept.php" method="POST">
            <div class="row">
                <table class="table align-middle">
                    <tbody>
                        <tr>
                            <td><input class="form-control" type="text" name="deptId" id="dept_id" value="<?php echo $department['dept_id'] ?>" hidden required></td>
                        </tr>
                        <tr>
                            <td>Department Name</td>
                            <td><input class="form-control" type="text" name="deptName" id="dept_name" value="<?php echo $department['dept_name'] ?>" required></td>
                        </tr>
                        <tr>
                            <td>Department Email</td>
                            <td><input class="form-control" type="email" name="deptEmail" id="dept_email" value="<?php echo $department['dept_email'] ?>" required></td>
                        </tr>
                        <tr>
                            <td>Description</td>
                            <td><textarea class="form-control" type="text" name="deptDesc" id="dept_desc"><?php echo $department['dept_desc'] ?></textarea></td>
                        </tr>
                        <tr>
                            <td>Remarks</td>
                            <td><textarea class="form-control" type="text" name="deptRemarks" id="dept_remarks"><?php echo $department['dept_remarks'] ?></textarea></td>
                        </tr>
                    </tbody>
                </table>
                <div class="col text-center">
                    <a href="./dept.php" class="btn btn-danger px-4 mx-4">Cancel</a>
                    <input class="btn btn-dark px-4" type="submit" name="editDept" value="Save Changes">
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
    echo "<script>window.open('../login.php','_self')</script>";
}
?>