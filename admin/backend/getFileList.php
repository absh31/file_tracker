<?php
session_start();
include '../../connection.php';
$sdate = $_POST['sdate'];
$edate = $_POST['edate'];


$officersSql = $conn->prepare("SELECT * FROM tblfile WHERE file_time between ? and ?");
$officersSql->bindParam(1, $sdate);
$officersSql->bindParam(2, $edate);
$officersSql->execute();
$files = $officersSql->fetchAll(PDO::FETCH_ASSOC);
?>

<table class="table cell-border" id="myTable">
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
}
?>
    </tbody>
</table>