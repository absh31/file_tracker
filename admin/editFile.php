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
                <h5>Edit File</h5>
            </div>
        </div>
        <br>
        <?php
        if (!isset($_GET['id'])) {
            echo "<script>window.alert(`Bad Request!`)</script>";
            echo "<script>window.open('./files.php','_self')</script>";
        }
        $fileId = $_GET['id'];
        $fileSql = $conn->prepare("SELECT * FROM tblfile WHERE file_id = ?");
        $fileSql->bindParam(1, $fileId);
        $fileSql->execute();
        $file = $fileSql->fetch(PDO::FETCH_ASSOC);
        ?>
        <form action="./backend/editFile.php" method="POST">
            <div class="row">
                <table class="table align-middle">
                    <tbody>
                        <tr>
                            <td><input class="form-control" type="text" name="fileId" id="file_id" value="<?php echo $file['file_id'] ?>" hidden required></td>
                        </tr>
                        <tr>
                            <td>File Tracking No.</td>
                            <td><input class="form-control" type="text" name="fileTrackNo" id="file_title" value="<?php echo $file['file_track_no'] ?>" readonly></td>
                        </tr>
                        <tr>
                            <td>File Title</td>
                            <td><input class="form-control" type="text" name="fileTitle" id="file_title" value="<?php echo $file['file_title'] ?>" required></td>
                        </tr>
                        <tr>
                            <td>File Concerned Person</td>
                            <td><input class="form-control" type="text" name="filePerson" id="file_person" value="<?php echo $file['file_person_name'] ?>" required></td>
                        </tr>
                        <tr>
                            <td>Description</td>
                            <td><textarea class="form-control" type="text" name="fileDesc" id="file_desc"><?php echo $file['file_desc'] ?></textarea></td>
                        </tr>
                        <tr>
                            <td>File Category</td>
                            <td>
                                <select class="form-control" name="fileCat" id="file_cat">
                                    <?php
                                    $filecatSql = $conn->prepare("SELECT * FROM tblfilecat WHERE filecat_active = 1");
                                    $filecatSql->execute();
                                    while ($filecatArray = $filecatSql->fetch(PDO::FETCH_ASSOC)) {
                                    ?>
                                        <option class="form-control" value="<?= $filecatArray['filecat_id'] ?>" <?php echo $filecatArray['filecat_id'] == $file['file_filecat_id'] ? "selected" : "" ?>> <?= $filecatArray['filecat_name'] ?></option>
                                    <?php
                                    }
                                    ?>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td>Remarks</td>
                            <td><textarea class="form-control" type="text" name="fileRemarks" id="file_remarks"><?php echo $file['file_remarks'] ?></textarea></td>
                        </tr>
                    </tbody>
                </table>
                <div class="col text-center">
                    <a href="./files.php" class="btn btn-danger px-4 mx-4">Cancel</a>
                    <input class="btn btn-dark px-4" type="submit" name="editFile" value="Save Changes">
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