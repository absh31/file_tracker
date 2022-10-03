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
                    <h5>Track File</h5>
                </div>
            </div>
            <br>
            <form action="./trackFile.php" method="GET">
                <div class="row">
                    <table class="table align-middle">
                        <tbody>
                            <tr>
                                <td>File Tracking No.</td>
                                <td><input class="form-control" type="text" name="trackNo" id="track_no" required></td>
                            </tr>
                        </tbody>
                    </table>
                    <div class="col text-center">
                        <input class="btn btn-dark px-5" type="submit" name="trackFile" value="Track">
                    </div>
            </form>

            <?php
            if (isset($_GET['trackFile'])) {

                $trackNo = $_GET['trackNo'];
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

                $currsql = $conn->prepare("SELECT * FROM `tblofficer` WHERE officer_id = ?");
                $currsql->bindParam(1, $key['file_current_holder']);
                $currsql->execute();
                $currkey = $currsql->fetch(PDO::FETCH_ASSOC);

                $docsql = $conn->prepare("SELECT * FROM `tbldocument` WHERE document_file_track_no = ?");
                $docsql->bindParam(1, $trackNo);
                $docsql->execute();
                $docs = $docsql->fetchAll(PDO::FETCH_ASSOC);

            ?>
                <br>
                <br>
                <br>
                <hr>
                <h5>File Details</h5>
                <br><br>
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
                                <td class="text-end"><a class="btn btn-dark" href="<?php echo $doc['document_path']; ?>" target="_blank">View</a></td>
                            </tr>
                        <?php
                        }
                        ?>

                    </tbody>
                </table>
            <?php
            }
            ?>
        </div>
        </div>
        <br><br>
        <?php include '../footer.php'; ?>
        <script>
            document.getElementById('file-nav').classList.add('active');
            document.getElementById("manage-nav").classList.remove('active');
            document.getElementById("dash-nav").classList.remove('active');
        </script>
<?php }
} else {
    echo "<script>window.alert(`Don't peep!`)</script>";
    echo "<script>window.open('../login.php','_self')</script>";
}
?>