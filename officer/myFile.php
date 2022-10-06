<?php
session_start();
include "../header.php";
include '../connection.php';
include './nav.php';
if ((isset($_SESSION['username']) && isset($_SESSION['auth']))) {
?>
    <br>
    <div class="container-fluid col-10">
        <div class="row">
            <div class="col">
                <h4>My Files</h4>
            </div>
            <div class="col text-end">
                <a href="./addFile.php" class="btn btn-outline-success"><i class="fa-solid fa-plus"></i>&nbsp;Add File</a>
            </div>
        </div>
        <br>
        <div class="row">
            <h5 class="text-bold text-danger">Recieved Files<br></h5>
            <?php
            $file_sql = $conn->prepare("SELECT * FROM tblfile f, tblactivity a WHERE a.activity_to = ? AND a.activity_ack = 0 AND a.activity_type = 'Forwarded' AND f.file_completed = 0 AND a.activity_file_track_no = f.file_track_no GROUP BY a.activity_file_track_no ORDER BY a.activity_time DESC;");
            $file_sql->bindParam(1, $_SESSION['id']);
            $file_sql->execute();
            $files = $file_sql->fetchAll(PDO::FETCH_ASSOC);
            ?>
            <table class="table cell-border" id="myTable">
                <thead>
                    <tr>
                        <th scope="col">Sr. No.</th>
                        <th scope="col">Tracking No.</th>
                        <th scope="col">Title</th>
                        <th scope="col">Concerned Person</th>
                        <th scope="col">Category</th>
                        <th scope="col">Recieved Time</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $sr_no = 1;
                    foreach ($files as $file) {
                        $fileadd_sql = $conn->prepare("SELECT * FROM tblofficer WHERE officer_id = ?");
                        $fileadd_sql->bindParam(1, $file['file_added_by']);
                        $fileadd_sql->execute();
                        $fileadd = $fileadd_sql->fetch(PDO::FETCH_ASSOC);

                        $filecat_sql = $conn->prepare("SELECT * FROM tblfilecat WHERE filecat_id = ?");
                        $filecat_sql->bindParam(1, $file['file_filecat_id']);
                        $filecat_sql->execute();
                        $filecat = $filecat_sql->fetch(PDO::FETCH_ASSOC);
                    ?>
                        <tr>
                            <th scope="row"><?php echo $sr_no; ?></th>
                            <td><?php echo $file['file_track_no']; ?></td>
                            <td><?php echo $file['file_title']; ?></td>
                            <td><?php echo $file['file_person_name'] ?></td>
                            <td><?php echo $filecat['filecat_name'] ?></td>
                            <td><?php echo $file['activity_time'] ?></td>
                            <td>
                                <a href="ackFile.php?id=<?php echo $file['file_id'] ?>&actId=<?php echo $file['activity_id']; ?>&trackNo=<?php echo $file['file_track_no']; ?>" class="btn btn-primary text-light"><i class="fa-solid fa-pen-to-square"></i></a> &nbsp;
                            </td>
                        </tr>
                    <?php $sr_no++;
                    } ?>
                </tbody>
            </table>
        </div>


        <div class="row">
            <h5 class="text-bold">Pending Files<br></h5>
            <?php
            $file_sql = $conn->prepare("SELECT * FROM tblfile WHERE file_current_holder = ?");
            $file_sql->bindParam(1, $_SESSION['id']);
            $file_sql->execute();
            $files = $file_sql->fetchAll(PDO::FETCH_ASSOC);
            ?>
            <table class="table cell-border" id="myTable1">
                <thead>
                    <tr>
                        <th scope="col">Sr. No.</th>
                        <th scope="col">Tracking No.</th>
                        <th scope="col">Title</th>
                        <th scope="col">Concerned Person</th>
                        <th scope="col">Category</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $sr_no = 1;
                    foreach ($files as $file) {
                        $fileadd_sql = $conn->prepare("SELECT * FROM tblofficer WHERE officer_id = ?");
                        $fileadd_sql->bindParam(1, $file['file_added_by']);
                        $fileadd_sql->execute();
                        $fileadd = $fileadd_sql->fetch(PDO::FETCH_ASSOC);
                        $filecurr_sql = $conn->prepare("SELECT * FROM tblofficer WHERE officer_id = ?");
                        $filecurr_sql->bindParam(1, $file['file_current_holder']);
                        $filecurr_sql->execute();
                        $filecurr = $filecurr_sql->fetch(PDO::FETCH_ASSOC);
                        $filecat_sql = $conn->prepare("SELECT * FROM tblfilecat WHERE filecat_id = ?");
                        $filecat_sql->bindParam(1, $file['file_filecat_id']);
                        $filecat_sql->execute();
                        $filecat = $filecat_sql->fetch(PDO::FETCH_ASSOC);
                    ?>
                        <tr>
                            <th scope="row"><?php echo $sr_no; ?></th>
                            <td><?php echo $file['file_track_no']; ?></td>
                            <td><?php echo $file['file_title']; ?></td>
                            <td><?php echo $file['file_person_name'] ?></td>
                            <td><?php echo $filecat['filecat_name'] ?></td>
                            <td>
                                <a href="workFile.php?trackNo=<?php echo $file['file_track_no']; ?>" class="btn btn-primary text-light"><i class="fa-solid fa-pen-to-square"></i></a> &nbsp;
                            </td>
                        </tr>
                    <?php $sr_no++;
                    } ?>
                </tbody>
            </table>
        </div>


        <div class="row">
            <h5 class="text-bold" style="color : #003975;">Forwarded Files<br></h5>
            <?php
            $file_sql = $conn->prepare("SELECT * 
            FROM tblfile f, tblactivity a 
            WHERE a.activity_from = ? AND f.file_completed = 0 AND a.activity_type = 'Forwarded' AND a.activity_file_track_no = f.file_track_no
            GROUP BY f.file_track_no
            ORDER BY a.activity_time DESC;");
            $file_sql->bindParam(1, $_SESSION['id']);
            $file_sql->execute();
            $files = $file_sql->fetchAll(PDO::FETCH_ASSOC);
            ?>
            <table class="table cell-border" id="myTable2">
                <thead>
                    <tr>
                        <th scope="col">Sr. No.</th>
                        <th scope="col">Tracking No.</th>
                        <th scope="col">Title</th>
                        <th scope="col">Concerned Person</th>
                        <th scope="col">Category</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $sr_no = 1;
                    foreach ($files as $file) {
                        $fileadd_sql = $conn->prepare("SELECT * FROM tblofficer WHERE officer_id = ?");
                        $fileadd_sql->bindParam(1, $file['file_added_by']);
                        $fileadd_sql->execute();
                        $fileadd = $fileadd_sql->fetch(PDO::FETCH_ASSOC);
                        $filecurr_sql = $conn->prepare("SELECT * FROM tblofficer WHERE officer_id = ?");
                        $filecurr_sql->bindParam(1, $file['file_current_holder']);
                        $filecurr_sql->execute();
                        $filecurr = $filecurr_sql->fetch(PDO::FETCH_ASSOC);
                        $filecat_sql = $conn->prepare("SELECT * FROM tblfilecat WHERE filecat_id = ?");
                        $filecat_sql->bindParam(1, $file['file_filecat_id']);
                        $filecat_sql->execute();
                        $filecat = $filecat_sql->fetch(PDO::FETCH_ASSOC);
                    ?>
                        <tr>
                            <th scope="row"><?php echo $sr_no; ?></th>
                            <td><a href="./trackFile.php?trackNo=<?php echo $file['file_track_no']; ?>&trackFile=Track" target="_blank"><?php echo $file['file_track_no']; ?></a></td>
                            <td><?php echo $file['file_title'] ?></td>
                            <td><?php echo $file['file_person_name'] ?></td>
                            <td><?php echo $filecat['filecat_name'] ?></td>
                        </tr>
                    <?php $sr_no++;
                    } ?>
                </tbody>
            </table>
        </div>


        <div class="row">
            <h5 class="text-bold text-success">Completed Files<br></h5>
            <?php
            $file_sql = $conn->prepare("SELECT * FROM tblfile WHERE file_completed = 1");
            $file_sql->execute();
            $files = $file_sql->fetchAll(PDO::FETCH_ASSOC);
            ?>
            <table class="table cell-border" id="myTable3">
                <thead>
                    <tr>
                        <th scope="col">Sr. No.</th>
                        <th scope="col">Tracking No.</th>
                        <th scope="col">Title</th>
                        <th scope="col">Concerned Person</th>
                        <th scope="col">Category</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $sr_no = 1;
                    foreach ($files as $file) {
                        $fileadd_sql = $conn->prepare("SELECT * FROM tblofficer WHERE officer_id = ?");
                        $fileadd_sql->bindParam(1, $file['file_added_by']);
                        $fileadd_sql->execute();
                        $fileadd = $fileadd_sql->fetch(PDO::FETCH_ASSOC);
                        // $filecurr_sql = $conn->prepare("SELECT * FROM tblofficer WHERE officer_id = ?");
                        // $filecurr_sql->bindParam(1, $file['file_current_holder']);
                        // $filecurr_sql->execute();
                        // $filecurr = $filecurr_sql->fetch(PDO::FETCH_ASSOC);
                        $filecat_sql = $conn->prepare("SELECT * FROM tblfilecat WHERE filecat_id = ?");
                        $filecat_sql->bindParam(1, $file['file_filecat_id']);
                        $filecat_sql->execute();
                        $filecat = $filecat_sql->fetch(PDO::FETCH_ASSOC);
                    ?>
                        <tr>
                            <th scope="row"><?php echo $sr_no; ?></th>
                            <td><a href="./trackFile.php?trackNo=<?php echo $file['file_track_no']; ?>&trackFile=Track" target="_blank"><?php echo $file['file_track_no']; ?></a></td>
                            <td><?php echo $file['file_title'] ?></td>
                            <td><?php echo $file['file_person_name'] ?></td>
                            <td><?php echo $filecat['filecat_name'] ?></td>
                        </tr>
                    <?php $sr_no++;
                    } ?>
                </tbody>
            </table>
        </div>
    </div>
    <?php include '../footer.php'; ?>

    <script>
        document.getElementById('my-nav').classList.add('active');
        document.getElementById('file-nav').classList.remove('active');
        document.getElementById("dash-nav").classList.remove('active');
        $(document).ready(function() {
            console.log('my-nav');
            $('#myTable').DataTable();
            $('#myTable1').DataTable();
            $('#myTable2').DataTable();
            $('#myTable3').DataTable();
        });
    </script>
<?php
} else {
    echo "<script>window.alert(`Don't peep!`)</script>";
    echo "<script>window.open('../','_self')</script>";
}
?>