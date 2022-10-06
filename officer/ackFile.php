<?php
session_start();
include "../header.php";
include '../connection.php';
include './nav.php';

if ((isset($_SESSION['username']) && isset($_SESSION['auth']))) {
?>
    <br>
    <div class="container">
        <?php if (isset($_GET['id']) && isset($_GET['actId']) && $_GET['trackNo']) {
            $actId = $_GET['actId'];
            $fileId = $_GET['id'];
            $trackNo = $_GET['trackNo'];

            $checkSql = $conn->prepare("SELECT * FROM `tblactivity` WHERE activity_file_track_no = ? AND activity_id = ? AND activity_to = ? AND activity_ack = 0");
            $checkSql->bindParam(1, $trackNo);
            $checkSql->bindParam(2, $actId);
            $checkSql->bindParam(3, $_SESSION['id']);
            $checkSql->execute();
            if ($checkSql->rowCount() == 0) {
                echo "<script>window.alert(`Bad Request`)</script>";
                echo "<script>window.open('./myFile.php','_self')</script>";
            }
            $checkkey = $checkSql->fetch(PDO::FETCH_ASSOC);

            $fromSql = $conn->prepare("SELECT * FROM `tblofficer` WHERE officer_id = ?");
            $fromSql->bindParam(1, $checkkey['activity_from']);
            $fromSql->execute();
            $fromkey = $fromSql->fetch(PDO::FETCH_ASSOC);

            $sql = $conn->prepare("SELECT * FROM `tblfile` WHERE file_id =?");
            $sql->bindParam(1, $fileId);
            $sql->execute();
            $key = $sql->fetch(PDO::FETCH_ASSOC);

            $filesql = $conn->prepare("SELECT * FROM `tblfilecat` WHERE filecat_id = ?");
            $filesql->bindParam(1, $key['file_filecat_id']);
            $filesql->execute();
            $catkey = $filesql->fetch(PDO::FETCH_ASSOC);

            $addedsql = $conn->prepare("SELECT * FROM `tblofficer` WHERE officer_id = ?");
            $addedsql->bindParam(1, $key['file_added_by']);
            $addedsql->execute();
            $addedkey = $addedsql->fetch(PDO::FETCH_ASSOC);

            if ($key['file_current_holder'] == 0) {
                $currkey['officer_name'] = '<div class="text-danger" >N/A</div>';
            } elseif ($key['file_current_holder'] == -1) {
                $currkey['officer_name'] = '<div class="text-danger" >N/A</div>';
            } else {
                $currsql = $conn->prepare("SELECT * FROM `tblofficer` WHERE officer_id = ?");
                $currsql->bindParam(1, $key['file_current_holder']);
                $currsql->execute();
                $currkey = $currsql->fetch(PDO::FETCH_ASSOC);
            }

            $deptsql = $conn->prepare("SELECT * FROM `tbldept` WHERE dept_id = ?");
            $deptsql->bindParam(1, $key['file_dept_id']);
            $deptsql->execute();
            $deptkey = $deptsql->fetch(PDO::FETCH_ASSOC);

            $docsql = $conn->prepare("SELECT * FROM `tbldocument` WHERE document_file_track_no = ?");
            $docsql->bindParam(1, $fileId);
            $docsql->execute();
            $docs = $docsql->fetchAll(PDO::FETCH_ASSOC);

        ?>
            <h5>File Details</h5>
            <br>
            <table class="table align-middle">
                <tbody>

                    <tr>
                        <td>Remarks From <b><?php echo $fromkey['officer_name']; ?></b></td>
                        <td><?php echo $checkkey['activity_remarks']; ?></td>
                    </tr>
                    <tr>
                        <td>File Tracking No.</td>
                        <td colspan="3"><?php echo $key['file_track_no']; ?></td>
                    </tr>
                    <tr>
                        <td>File Title</td>
                        <td colspan="3"><?php echo $key['file_title']; ?></td>
                    </tr>
                    <tr>
                        <td>File Concerned Person</td>
                        <td colspan="3"><?php echo $key['file_person_name']; ?></td>
                    </tr>
                    <tr>
                        <td>File Description</td>
                        <td colspan="3"><?php echo $key['file_desc']; ?></td>
                    </tr>
                    <tr>
                        <td>File Category</td>
                        <td colspan="3"><a href="<?php echo './fileCat.php?id=' . $catkey['filecat_id']; ?>" target="_blank"><?php echo $catkey['filecat_name']; ?></td>
                    </tr>
                    <tr>
                        <td>File Added By</td>
                        <td colspan="3"><?php echo $addedkey['officer_name']; ?></td>
                    </tr>
                    <tr>
                        <td>File Added Time</td>
                        <td colspan="3"><?php echo $key['file_time']; ?></td>
                    </tr>
                    <tr>
                        <td>File Current Holder</td>
                        <td colspan="3"><?php echo $currkey['officer_name']; ?></td>
                    </tr>
                    <tr>
                        <td>File Department</td>
                        <td colspan="3"><?php echo $deptkey['dept_name']; ?></td>
                    </tr>
                    <tr>
                        <td>File Status</td>
                        <td colspan="3"><?php echo $key['file_status']; ?></td>
                    </tr>
                    <tr>
                        <td>File Completed</td>
                        <td colspan="3"><?php echo $key['file_completed'] ? 'Yes' : 'No'; ?></td>
                    </tr>
                    <tr>
                        <td>File Remarks</td>
                        <td colspan="3"><?php echo $key['file_remarks']; ?></td>
                    </tr>

                    <?php foreach ($docs as $doc) {
                        $docbysql = $conn->prepare("SELECT * FROM tblofficer WHERE officer_id = ?");
                        $docbysql->bindParam(1, $doc['document_by']);
                        $docbysql->execute();
                        $keydocby = $docbysql->fetch(PDO::FETCH_ASSOC);
                    ?>
                        <tr>
                            <td>File Attached Document</td>
                            <td><?php echo $doc['document_title']; ?></td>
                            <td><?php echo "By " . $keydocby['officer_name']; ?></td>
                            <td class="text-end"><a class="btn btn-dark" href="../uploads<?php echo $doc['document_path']; ?>" target="_blank">View</a></td>
                        </tr>
                    <?php
                    }
                    ?>

                </tbody>
            </table>

            <div class="col text-center">
                <form action="./backend/ackFile.php" method="POST">
                    <a href="./myFile.php" class="btn btn-danger px-4 mx-4">Cancel</a>
                    <input type="hidden" type="text" name="actId" value="<?php echo $actId; ?>" hidden />
                    <input class="btn btn-dark px-4" type="text" name="fileTrack" value="<?php echo $key['file_track_no']; ?>" hidden>
                    <input class="btn btn-dark px-4" type="submit" name="ackFile" value="Acknowledge">
                </form>
            </div>

        <?php
        } else {
            echo "<script>window.alert(`Bad Request`)</script>";
            echo "<script>window.open('./myFile.php','_self')</script>";
        }
        ?>
    </div>
    </div>
    <br><br>
    <?php include '../footer.php'; ?>
    <script>
        document.getElementById('my-nav').classList.remove('active');
        document.getElementById('file-nav').classList.remove('active');
        document.getElementById("manage-nav").classList.remove('active');
        document.getElementById("dash-nav").classList.remove('active');
    </script>
<?php
} else {
    echo "<script>window.alert(`Don't peep!`)</script>";
    echo "<script>window.open('../','_self')</script>";
}
?>