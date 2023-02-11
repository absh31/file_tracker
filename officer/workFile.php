<?php
session_start();
include('../backend/checkSession.php');
checkSession();
include "../header.php";
include '../connection.php';
include './nav.php';

if ((isset($_SESSION['username']) && isset($_SESSION['auth']))) {
?>
    <br>
    <div class="container-fluid px-5">
        <?php
        if (isset($_GET['trackNo'])) {

            $trackNo = $_GET['trackNo'];
            $sql = $conn->prepare("SELECT * FROM `tblfile` WHERE file_track_no =? AND file_current_holder = ?");
            $sql->bindParam(1, $trackNo);
            $sql->bindParam(2, $_SESSION['id']);
            $sql->execute();
            $key = $sql->fetch(PDO::FETCH_ASSOC);
            if ($sql->rowCount() == 0) {
                echo "<script>window.alert(`Bad Request`)</script>";
                echo "<script>window.open('./myFile.php','_self')</script>";
            } else {

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
                <br>
                <div class="row text-center">
                    <div class="col">
                        <form class="form form-control" action="./backend/fileUpload.php" class="form form-control" enctype="multipart/form-data" method="POST">
                            File Upload
                            <br><br>
                            <label>File Title</label>
                            <input type="text" class="form-control" name="fileTitle" required />
                            <br><br>
                            <input type="file" name="upFile" class="form-control" required>
                            <div style="font-size: 12px;">Max File Size : 10 MB </div>
                            <br><br>
                            <input type="text" name="fileTrack" value="<?php echo $key['file_track_no']; ?>" hidden />
                            <input type="submit" name="fileUpload" class="btn btn-dark" value="Upload">
                            <br><br>
                        </form>
                    </div>
                    <div class="col">
                        <form class="form form-control" action="./backend/forwardFile.php" method="POST">
                            <label>Select Department</label>
                            <br>
                            <select name="forwardDept" id="" class="form-control" onChange="getOfficers(this.value)">
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
                            <br>
                            <label>Select Officer</label>
                            <br>
                            <select class="form-control" id="officerDrop" name="forwardOfficer" required>
                            </select>
                            <br>
                            <input type="text" name="fileTrack" value="<?php echo $key['file_track_no']; ?>" hidden required />
                            <label>Forward Remarks</label>
                            <br>
                            <input type="text" name="forwardRemarks" class="form-control" required />
                            <br>
                            <input class="btn btn-dark px-4" type="submit" name="forwardFile" value="Forward">
                            <br>
                        </form>
                    </div>
                    <div class="col">
                        <form class="form form-control" action="./backend/completeFile.php" method="POST">
                            <lable>Remarks</lable>
                            <br><br>
                            <br><br>
                            <input class="form-control" type="text" name="completeRemarks" required>
                            <br><br>
                            <br><br>
                            <input type="text" name="fileTrack" value="<?php echo $key['file_track_no']; ?>" hidden />
                            <input class="btn btn-success px-4" type="submit" name="completeFile" value="Mark as Completed">
                            <br><br>
                        </form>
                    </div>
                </div>
                <hr>
                <div class="row text-center">
                    <div class="col">
                        <a href="./myFile.php" class="btn btn-danger px-4 mx-4">Cancel</a>
                    </div>
                </div>
                <hr>
                <h5>Activity Details</h5>
                <br><br>
                <table class="table align-middle" id="myTable">
                    <thead>
                        <tr>
                            <th scope="col">Sr. No.</th>
                            <th scope="col">From</th>
                            <th scope="col">To</th>
                            <th scope="col">Remarks</th>
                            <th scope="col">Type</th>
                            <th scope="col">Acknowledged</th>
                            <th scope="col">Time</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $fileActSql = $conn->prepare("SELECT * FROM tblactivity WHERE activity_file_track_no = ?");
                        $fileActSql->bindParam(1, $trackNo);
                        $fileActSql->execute();
                        $fileActs = $fileActSql->fetchAll(PDO::FETCH_ASSOC);
                        $sr_no = 1;
                        foreach ($fileActs as $fileAct) {
                            $actFromSql = $conn->prepare("SELECT officer_name FROM tblofficer WHERE officer_id = ?");
                            $actFromSql->bindParam(1, $fileAct['activity_from']);
                            $actFromSql->execute();
                            $actFrom = $actFromSql->fetch(PDO::FETCH_ASSOC);

                            $actToSql = $conn->prepare("SELECT officer_name FROM tblofficer WHERE officer_id = ?");
                            $actToSql->bindParam(1, $fileAct['activity_to']);
                            $actToSql->execute();
                            $actTo = $actToSql->fetch(PDO::FETCH_ASSOC);
                        ?>
                            <tr>
                                <th scope="row"><?php echo $sr_no; ?></th>
                                <td><?php echo $actFrom['officer_name']; ?></td>
                                <td><?php echo $actTo['officer_name']; ?></td>
                                <td><?php echo $fileAct['activity_remarks']; ?></td>
                                <td><?php echo $fileAct['activity_type']; ?></td>
                                <td><?php echo $fileAct['activity_ack'] ? 'Yes' : 'No'; ?></td>
                                <td><?php echo $fileAct['activity_time']; ?></td>
                            </tr>
                        <?php
                            $sr_no++;
                        }
                        ?>

                    </tbody>
                </table>

        <?php
            }
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
        $(document).ready(function() {
            $('#myTable').DataTable();
        });

        function getOfficers(deptId) {
            $.ajax({
                    method: "POST",
                    url: "./backend/getOfficers.php",
                    dataType: "html",
                    data: {
                        deptId: deptId
                    }
                })
                .done(function(data) {
                    $("#officerDrop").html(data);
                });
        }
    </script>
<?php } else {
    echo "<script>window.alert(`Don't peep!`)</script>";
    echo "<script>window.open('../','_self')</script>";
}
?>