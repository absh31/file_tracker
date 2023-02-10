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
    <div class="container-fluid px-5">
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
            <div class="col text-center text-danger">
                <h5 class="btn btn-outline-danger active" id="rec_files_menu">Recieved Files</h5>
            </div>
            <div class="col text-center text-dark">
                <h5 class="btn btn-outline-dark" id="pen_files_menu">Pending Files</h5>
            </div>
            <div class="col text-center text-primary">
                <h5 class="btn btn-outline-primary" id="for_files_menu">Forwarded Files</h5>
            </div>
            <div class="col text-center text-success">
                <h5 class="btn btn-outline-success" id="com_files_menu">Completed Files</h5>
            </div>
        </div>
        <br>
        <br>
        <div class="row" id="rec_files">
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


        <div class="row" id="pen_files">
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


        <div class="row" id="for_files">
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


        <div class="row" id="com_files">
            <h5 class="text-bold text-success">Completed Files<br></h5>
            <?php
            $file_sql = $conn->prepare("SELECT * FROM tblfile f, tblactivity a WHERE a.activity_from = ? AND f.file_track_no = a.activity_file_track_no AND f.file_completed = 1 GROUP BY f.file_track_no;");
            $file_sql->bindParam(1, $_SESSION['id']);
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
        <br>
        <br>
    </div>
    <?php include '../footer.php'; ?>

    <script>
        
        $('#rec_files').show();
        $('#pen_files').hide();
        $('#for_files').hide();
        $('#com_files').hide();

        $('#rec_files_menu').click(function() {
            $('#rec_files').show(function() {
                $('#rec_files_menu').addClass('active')
            });
            $('#pen_files').hide(function() {
                $('#pen_files_menu').removeClass('active')
            });
            $('#for_files').hide(function() {
                $('#for_files_menu').removeClass('active')
            });
            $('#com_files').hide(function() {
                $('#com_files_menu').removeClass('active')
            });
        })
        $('#pen_files_menu').click(function() {
            $('#pen_files').show(function() {
                $('#pen_files_menu').addClass('active')
            });
            $('#rec_files').hide(function() {
                $('#rec_files_menu').removeClass('active')
            });
            $('#for_files').hide(function() {
                $('#for_files_menu').removeClass('active')
            });
            $('#com_files').hide(function() {
                $('#com_files_menu').removeClass('active')
            });
        })
        $('#for_files_menu').click(function() {
            $('#for_files').show(function() {
                $('#for_files_menu').addClass('active')
            });
            $('#pen_files').hide(function() {
                $('#pen_files_menu').removeClass('active')
            });
            $('#rec_files').hide(function() {
                $('#rec_files_menu').removeClass('active')
            });
            $('#com_files').hide(function() {
                $('#com_files_menu').removeClass('active')
            });
        })
        $('#com_files_menu').click(function() {
            $('#com_files').show(function() {
                $('#com_files_menu').addClass('active')
            });
            $('#pen_files').hide(function() {
                $('#pen_files_menu').removeClass('active')
            });
            $('#for_files').hide(function() {
                $('#for_files_menu').removeClass('active')
            });
            $('#rec_files').hide(function() {
                $('#rec_files_menu').removeClass('active')
            });
        })

        document.getElementById('my-nav').classList.add('active');
        document.getElementById('file-nav').classList.remove('active');
        document.getElementById("manage-nav").classList.remove('active');
        document.getElementById("dash-nav").classList.remove('active');
        $(document).ready(function() {
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