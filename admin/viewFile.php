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

    if ($key['role_name'] == "Admin") {
?>
        <br>
        <div class="container">
            <?php if (isset($_GET['id'])) {

                $trackNo = $_GET['id'];
                $sql = $conn->prepare("SELECT * FROM `tblfile` WHERE file_track_no =?");
                $sql->bindParam(1, $trackNo);
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
                $docsql->bindParam(1, $trackNo);
                $docsql->execute();
                $docs = $docsql->fetchAll(PDO::FETCH_ASSOC);

            ?>
                <h5>File Details</h5>
                <br>
                <table class="table align-middle">
                    <tbody>
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
                            <td colspan="3"><?php echo $catkey['filecat_name']; ?></td>
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
                        <tr>
                            <td>File Deleted</td>
                            <td colspan="3"><?php echo $key['file_active'] ?  'No' :  'Yes'; ?></td>

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
            <?php
            } else {
                echo "<script>window.alert(`Bad Request`)</script>";
                echo "<script>window.open('./dashboard.php','_self')</script>";
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
<?php }
} else {
    echo "<script>window.alert(`Don't peep!`)</script>";
    echo "<script>window.open('../','_self')</script>";
}
?>