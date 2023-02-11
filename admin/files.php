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
            <h4>Files</h4>
        </div>
        <div class="col text-end">
            <a href="./addFile.php" class="btn btn-outline-success"><i class="fa-solid fa-plus"></i>&nbsp;Add File</a>
        </div>
    </div>
    <br>

    <div class="row">
        <div class="col text-center text-dark">
            <h5 class="btn btn-outline-dark active" id="pending_file_menu">Pending Files</h5>
        </div>
        <div class="col text-center text-success">
            <h5 class="btn btn-outline-success" id="completed_file_menu">Completed Files</h5>
        </div>
        <div class="col text-center text-sprimary">
            <h5 class="btn btn-outline-danger" id="deleted_file_menu">Deleted Files</h5>
        </div>
    </div>
    <br>
    <br>

    <div class="row" id="pending_file">
        <h5 class="text-bold">Pending Files<br></h5>
        <?php
            $file_sql = $conn->prepare("SELECT * FROM tblfile WHERE file_active = 1 AND file_completed = 0");
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
                    <th scope="col">Current Holder</th>
                    <th scope="col">Added By</th>
                    <th scope="col">Added Time</th>
                    <th scope="col">Actions</th>
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

                        if ($file['file_current_holder'] == 0) {
                            $filecurr['officer_name'] = '<div class="text-danger" >N/A</div>';
                        } elseif ($file['file_current_holder'] == -1) {
                            $filecurr['officer_name'] = '<div class="text-danger" >N/A</div>';
                        } else {

                            $filecurr_sql = $conn->prepare("SELECT * FROM tblofficer WHERE officer_id = ?");
                            $filecurr_sql->bindParam(1, $file['file_current_holder']);
                            $filecurr_sql->execute();
                            $filecurr = $filecurr_sql->fetch(PDO::FETCH_ASSOC);

                        }

                        $filecat_sql = $conn->prepare("SELECT * FROM tblfilecat WHERE filecat_id = ?");
                        $filecat_sql->bindParam(1, $file['file_filecat_id']);
                        $filecat_sql->execute();
                        $filecat = $filecat_sql->fetch(PDO::FETCH_ASSOC);
                    ?>
                <tr>
                    <th scope="row"><?php echo $sr_no; ?></th>
                    <td><a href="./trackFile.php?trackNo=<?php echo $file['file_track_no']; ?>&trackFile=Track"
                            target="_blank"><?php echo $file['file_track_no']; ?></a></td>
                    <td><?php echo $file['file_title'] ?></td>
                    <td><?php echo $file['file_person_name'] ?></td>
                    <td><?php echo $filecat['filecat_name'] ?></td>
                    <td><?php echo $filecurr['officer_name'] ?></td>
                    <td><?php echo $fileadd['officer_name'] ?></td>
                    <td><?php echo $file['file_time'] ?></td>
                    <td>
                        <a href="editFile.php?id=<?php echo $file['file_id'] ?>" class="btn btn-primary text-light"><i
                                class="fa-solid fa-pen-to-square"></i></a> &nbsp;
                        <button class="btn btn-danger text-light delete" id="<?php echo $file['file_id'] ?>"><i
                                class="fa-solid fa-trash"></i></button>
                    </td>
                </tr>
                <?php $sr_no++;
                    } ?>
            </tbody>
        </table>
    </div>


    <div class="row" id="completed_file">
        <h5 class="text-bold">Completed Files<br></h5>
        <?php
            $file_sql = $conn->prepare("SELECT * FROM tblfile WHERE file_completed = 1 AND file_active = 1");
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
                    <th scope="col">Added By</th>
                    <th scope="col">Added Time</th>
                    <th scope="col">Completed Time</th>
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
                    <td><a href="./trackFile.php?trackNo=<?php echo $file['file_track_no']; ?>&trackFile=Track"
                            target="_blank"><?php echo $file['file_track_no']; ?></a></td>
                    <td><?php echo $file['file_title'] ?></td>
                    <td><?php echo $file['file_person_name'] ?></td>
                    <td><?php echo $filecat['filecat_name'] ?></td>
                    <td><?php echo $fileadd['officer_name'] ?></td>
                    <td><?php echo $file['file_time'] ?></td>
                    <td><?php echo $file['file_complete_time'] ?></td>
                </tr>
                <?php $sr_no++;
                    } ?>
            </tbody>
        </table>
    </div>


    <div class="row" id="deleted_file">
        <h5 class="text-bold">Deleted Files<br></h5>
        <?php
            $file_sql = $conn->prepare("SELECT * FROM tblfile WHERE file_active = -1");
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
                    <th scope="col">Actions</th>
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
                    <td><a href="./trackFile.php?trackNo=<?php echo $file['file_track_no']; ?>&trackFile=Track"
                            target="_blank"><?php echo $file['file_track_no']; ?></a></td>
                    <td><?php echo $file['file_title'] ?></td>
                    <td><?php echo $file['file_person_name'] ?></td>
                    <td><?php echo $filecat['filecat_name'] ?></td>
                    <td>
                        <button class="btn btn-danger text-light delete" id="<?php echo $file['file_id'] ?>"><i class="fa-solid fa-trash"></i></button>
                        <button class="btn btn-success text-light revert" id="<?php echo $file['file_id'] ?>">Restore</button>
                    </td>

                </tr>
                <?php $sr_no++;
                    } ?>
            </tbody>
        </table>
    </div>
</div>
<br><br>
<?php include '../footer.php'; ?>

<script>
document.getElementById('my-nav').classList.remove('active');
document.getElementById('file-nav').classList.add('active');
document.getElementById("manage-nav").classList.remove('active');
document.getElementById("dash-nav").classList.remove('active');
$(document).ready(function() {
    $(".delete").on('click', function() {
        if (confirm("Are you sure you want to delete?")) {
            var id = $(this).attr("id");
            $.ajax({
                type: "POST",
                url: "backend/deleteFile.php",
                data: {
                    fileId: id
                },
                success: function(response) {
                    window.location.reload();
                }
            });
        }
    })
    $(".revert").on('click', function() {
        if (confirm("Are you sure you want to restore the file?")) {
            var id = $(this).attr("id");
            $.ajax({
                type: "POST",
                url: "backend/restoreFile.php",
                data: {
                    fileId: id
                },
                success: function(response) {
                    window.location.reload();
                }
            });
        }
    })
});


$('#pending_file').show();
$('#completed_file').hide();
$('#deleted_file').hide();

$('#pending_file_menu').click(function() {
    $('#pending_file').show(function() {
        $('#pending_file_menu').addClass('active')
    });
    $('#completed_file').hide(function() {
        $('#pen_file_menu').removeClass('active')
    });
    $('#deleted_file').hide(function() {
        $('#deleted_file_menu').removeClass('active')
    });
})
$('#completed_file_menu').click(function() {
    $('#completed_file').show(function() {
        $('#completed_file_menu').addClass('active')
    });
    $('#pending_file').hide(function() {
        $('#pending_file_menu').removeClass('active')
    });
    $('#deleted_file').hide(function() {
        $('#deleted_file_menu').removeClass('active')
    });
})
$('#deleted_file_menu').click(function() {
    $('#deleted_file').show(function() {
        $('#deleted_file_menu').addClass('active')
    });
    $('#completed_file').hide(function() {
        $('#completed_file_menu').removeClass('active')
    });
    $('#pending_file').hide(function() {
        $('#pending_file_menu').removeClass('active')
    });
})

$(document).ready(function() {
    $('#myTable').DataTable();
    $('#myTable1').DataTable();
    $('#myTable2').DataTable();
});
</script>



</script>
<?php
} else {
    echo "<script>window.alert(`Don't peep!`)</script>";
    echo "<script>window.open('../','_self')</script>";
}
?>