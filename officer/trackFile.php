<link href="../timeline.css" rel="stylesheet">

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
    $key = $sql->fetch(PDO::FETCH_ASSOC); {

?>
        <br>
        <div class="container-fluid px-5">
            <div class="row">
                <h5 class="text-bold">Pending Files<br></h5>
                <?php
                $file_sql = $conn->prepare("SELECT * FROM tblfile WHERE file_active = 1 AND file_completed = 0");
                $file_sql->execute();
                $files = $file_sql->fetchAll(PDO::FETCH_ASSOC);
                // print_r($files);
                ?>
                <table class="table cell-border" id="myTable">
                    <thead>
                        <tr>
                            <th scope="col">Sr. No.</th>
                            <th scope="col">Tracking No.</th>
                            <th scope="col">Title</th>
                            <th scope="col">Concerned Person</th>
                            <th scope="col">Current Holder</th>
                            <th scope="col">Added By</th>
                            <th scope="col">Added Time</th>
                            <th scope="col">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $sr_no = 1;
                        if (!empty($files)) {

                            foreach ($files as $file) {
                                $fileadd_sql = $conn->prepare("SELECT * FROM tblofficer, tblrole WHERE officer_id = ? AND tblrole.role_id = tblofficer.officer_role_id");
                                $fileadd_sql->bindParam(1, $file['file_added_by']);
                                $fileadd_sql->execute();
                                $fileadd = $fileadd_sql->fetch(PDO::FETCH_ASSOC);

                                if ($file['file_current_holder'] == 0) {
                                    $filecurr['officer_name'] = '<div class="text-danger" >N/A</div>';
                                } else if ($file['file_current_holder'] == -1) {
                                    $filecurr['officer_name'] = '<div class="text-danger" >N/A</div>';
                                } else {

                                    $filecurr_sql = $conn->prepare("SELECT * FROM tblofficer WHERE officer_id = ?");
                                    $filecurr_sql->bindParam(1, $file['file_current_holder']);
                                    $filecurr_sql->execute();
                                    $filecurr = $filecurr_sql->fetch(PDO::FETCH_ASSOC);
                                }
                        ?>
                                <tr>
                                    <form action="./trackFile.php" method="GET">
                                        <th scope="row"><?php echo $sr_no; ?></th>
                                        <td><a href="./trackFile.php?trackNo=<?php echo $file['file_track_no']; ?>&trackFile=Track" target="_blank"><?php echo $file['file_track_no']; ?></a></td>
                                        <td><?php echo $file['file_title'] ?></td>
                                        <td><?php echo $file['file_person_name'] ?></td>
                                        <td><?php echo $filecurr['officer_name'] ?></td>
                                        <td><?php echo $fileadd['officer_name'] ?></td>
                                        <td><?php echo $file['file_time'] ?></td>
                                        <td>
                                            <input class="form-control" type="text" name="trackNo" id="track_no" required hidden value="<?= $file['file_track_no'] ?>">
                                            <input class="btn btn-dark px-2" type="submit" name="trackFile" value="Track">
                                            <br>
                                            <br>
                                            <?php

                                            // echo $key['role_priority'];
                                            // echo $fileadd['role_priority']; 
                                            if ($key['role_priority'] <= $fileadd['role_priority']) {
                                            ?>
                                                <button class="btn btn-danger text-light delete" id="<?php echo $file['file_track_no'] ?>"><i class="fa-solid fa-trash"></i></button>
                                            <?php
                                            }
                                            ?>

                                        </td>
                                    </form>
                                </tr>
                            <?php $sr_no++;
                            }
                        } else {
                            ?>
                            <tr>
                                <td colspan="8" class="text-danger text-center fw-bolder">NO FILES IN THE PORTAL</td>
                            </tr>
                        <?php
                        }
                        ?>
                    </tbody>
                </table>
            </div>
            <!-- <div class="row">
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
            </form> -->

            <?php
            if (isset($_GET['trackFile'])) {

                $trackNo = $_GET['trackNo'];
                $sql = $conn->prepare("SELECT * FROM tblfile f, (SELECT activity_to, activity_file_track_no FROM tblactivity WHERE activity_file_track_no = ? ) as a WHERE a.activity_file_track_no = f.file_track_no GROUP BY f.file_track_no");
                $sql->bindParam(1, $trackNo);
                // $sql->bindParam(2, $_SESSION['id']);
                $sql->execute();
                $key = $sql->fetch(PDO::FETCH_ASSOC);
                if ($sql->rowCount() == 0) {
                    echo "<div class='col-md-12 text text-danger text-center'><br>No file found with Tracking No :  $trackNo</div>";
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
                                    <td class="text-end"><a class="btn btn-dark" href="../uploads<?php echo $doc['document_path']; ?>" target="_blank">View</a></td>
                                </tr>
                            <?php
                            }
                            ?>

                        </tbody>
                    </table>
                    <br>
                    <hr>
                    <br>
                    <br>
                    <br>
                    <br>



                    <div class="row">
                        <h5>Activity Timeline</h5>
                    </div>

                    <div class="row mt-6 mb-6">
                        <ul class="timeline">
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

                                if ($actFrom['officer_name'] == $actTo['officer_name'] && $fileAct['activity_type'] == 'Added') {
                            ?>
                                    <li data-year="<?php echo $fileAct['activity_type'] ?>" data-text="<?php echo "Officer - " . $actFrom['officer_name'] . " added the file!" ?>"></li>

                                <?php
                                } else if ($actFrom['officer_name'] == $actTo['officer_name'] && $fileAct['activity_type'] == 'Uploaded') {
                                ?>
                                    <li data-year="<?php echo $fileAct['activity_type'] ?>" data-text="<?php echo "Officer - " . $actFrom['officer_name'] . " added an attachment!" ?>"></li>

                                <?php
                                } else {
                                ?>
                                    <li data-year="<?php echo $fileAct['activity_type'] ?>" data-text="<?php echo "By " . $actFrom['officer_name'] . " To " . $actTo['officer_name'] . " " . $fileAct['activity_time'] ?>">
                                    </li>

                                <?php
                                }
                                ?>

                                <!-- <li data-year="2018" data-text="Lorem ipsum dolor sit amet, consectetur."></li>
                            <li data-year="2019" data-text="Lorem ipsum dolor sit amet, consectetur."></li>
                            <li data-year="2020" data-text="Lorem ipsum dolor sit amet, consectetur."></li>
                            <li data-year="2021" data-text="Lorem ipsum dolor sit amet, consectetur."></li>
                            <li data-year="2021" data-text="Lorem ipsum dolor sit amet, consectetur."></li>
                            <li data-year="2021" data-text="Lorem ipsum dolor sit amet, consectetur."></li>
                            <li data-year="2021" data-text="Lorem ipsum dolor sit amet, consectetur."></li>
                            <li data-year="2021" data-text="Lorem ipsum dolor sit amet, consectetur."></li> -->
                            <?php
                            }
                            ?>
                        </ul>
                    </div>
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
            document.getElementById('file-nav').classList.add('active');
            document.getElementById("my-nav").classList.remove('active');
            document.getElementById("dash-nav").classList.remove('active');
            $(document).ready(function() {
                // $('#myTable').DataTable();
            });
            $(document).ready(function() {
                $(".delete").on('click', function() {
                    let foo = prompt('Enter the reason for delete');
                    if (confirm("Are you sure you want to delete")) {
                        var id = $(this).attr("id");
                        console.log(id)
                        console.log(foo)
                        $.ajax({
                            type: "POST",
                            url: "backend/deleteFile.php",
                            data: {
                                reason: foo,
                                fileId: id
                            },
                            success: function(response) {
                                window.location.reload();
                                // console.log(response)
                            }
                        });
                    }
                })
            });
        </script>
        </body>

        </html>
<?php
    }
} else {
    echo "<script>window.alert(`Don't peep!`)</script>";
    echo "<script>window.open('../','_self')</script>";
}
?>