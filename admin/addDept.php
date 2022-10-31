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
    <div class="container">
        <div class="row">
            <div class="col">
                <h5>Add Department</h5>
            </div>
        </div>
        <br>
        <form action="./backend/addDept.php" method="POST">
            <div class="row">
                <table class="table align-middle">
                    <tbody>
                        <tr>
                            <td>Department Name</td>
                            <td><input class="form-control" type="text" name="deptName" id="dept_name" required></td>
                        </tr>
                        <tr>
                            <td>Department Email</td>
                            <td><input class="form-control" type="email" name="deptEmail" id="dept_email" required></td>
                        </tr>
                        <tr>
                            <td>Department Description</td>
                            <td><textarea class="form-control" name="deptDesc" id="dept_desc"></textarea></td>
                        </tr>
                        <tr>
                            <td>Remarks</td>
                            <td><textarea class="form-control" name="deptRemarks" id="dept_remarks"></textarea></td>
                        </tr>
                    </tbody>
                </table>
                <div class="col text-center">
                    <a href="./dept.php" class="btn btn-danger px-4 mx-4">Cancel</a>
                    <input class="btn btn-dark px-5" type="submit" name="addDept" value="Add">
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