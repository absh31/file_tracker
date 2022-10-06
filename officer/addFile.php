<?php
session_start();
include "../header.php";
include "../connection.php";
include './nav.php';
if (!isset($_SESSION['username'])) {
    echo "<script>window.open('../index.php','_self')</script>";
} else {
?>
    <br>
    <div class="container">
        <div class="row">
            <div class="col">
                <h5>Add File</h5>
            </div>
        </div>
        <br>
        <form action="./backend/addFile.php" enctype="multipart/form-data" method="POST">
            <div class="row">
                <table class="table align-middle">
                    <tbody>
                        <tr>
                            <td>File Title</td>
                            <td><input class="form-control" type="text" name="fileTitle" id="file_title" required></td>
                        </tr>
                        <tr>
                            <td>Concerned Person Name</td>
                            <td><input class="form-control" type="text" name="filePerson" id="dept_email"></td>
                        </tr>
                        <tr>
                            <td>File Description</td>
                            <td><textarea class="form-control" name="fileDesc" id="dept_desc" required></textarea></td>
                        </tr>
                        <tr>
                            <td>File Document</td>
                            <td><input class="form-control" type="file" name="fileDoc"></td>
                        </tr>
                        <tr>
                            <td>File Category</td>
                            <td>
                                <select name="fileCat" id="" class="form-control" required>
                                    <option disabled selected>Choose Category</option>
                                    <?php
                                    $fileSql = $conn->prepare("SELECT * FROM tblfilecat WHERE filecat_active = 1");
                                    $fileSql->execute();
                                    $filecats = $fileSql->fetchAll(PDO::FETCH_ASSOC);
                                    foreach ($filecats as $filecat) {
                                    ?>
                                        <option value="<?php echo $filecat['filecat_id'] ?>"><?php echo $filecat['filecat_name'] ?></option>
                                    <?php
                                    }
                                    ?>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td>File Department</td>
                            <td>
                                <select name="fileDept" id="" class="form-control">
                                    <option disabled selected>Choose Department</option>
                                    <?php
                                    $deptSql = $conn->prepare("SELECT * FROM tbldept WHERE dept_active = 1");
                                    $deptSql->execute();
                                    $departments = $deptSql->fetchAll(PDO::FETCH_ASSOC);
                                    foreach ($departments as $department) {
                                    ?>
                                        <option value="<?php echo $department['dept_id'] ?>"><?php echo $department['dept_name'] ?></option>
                                    <?php
                                    }
                                    ?>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td>File Remarks</td>
                            <td><textarea class="form-control" name="fileRemarks" id="dept_remarks"></textarea></td>
                        </tr>
                    </tbody>
                </table>
                <div class="col text-center">
                    <a href="./files.php" class="btn btn-danger px-4 mx-4">Cancel</a>
                    <input class="btn btn-dark px-5" type="submit" name="addFile" value="Add">
                </div>
            </div>
        </form>
    </div>
    <br><br>
    <?php include '../footer.php'; ?>

    <script>
        document.getElementById('file-nav').classList.add('active');
        document.getElementById("my-nav").classList.remove('active');
        document.getElementById("dash-nav").classList.remove('active');
    </script>
<?php
}
?>