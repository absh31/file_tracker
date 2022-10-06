<?php
session_start();
include '../../connection.php';
if (isset($_POST['completeFile']) && $_SESSION['id']) {

    $completeRemarks = $_POST['completeRemarks'];
    $fileTrack = $_POST['fileTrack'];

    $checkSql = $conn->prepare("SELECT * FROM tblfile WHERE file_track_no = ? AND file_current_holder = ?");
    $checkSql->bindParam(1, $fileTrack);
    $checkSql->bindParam(2, $_SESSION['id']);
    $checkSql->execute();
    if ($checkSql->rowCount() == 0) {
        echo "<script>window.alert(`Bad Request`)</script>";
        echo "<script>window.open('../myFile','_self')</script>";
    }
    
    $completeActSql = $conn->prepare("INSERT INTO `tblactivity` (`activity_file_track_no`, `activity_from`, `activity_to`, `activity_remarks`, `activity_type`, `activity_ack`) VALUES (?, ?, ?, ?, 'Completed', 1)");
    $completeActSql->bindParam(1, $fileTrack);
    $completeActSql->bindParam(2, $_SESSION['id']);
    $completeActSql->bindParam(3, $_SESSION['id']);
    $completeActSql->bindParam(4, $completeRemarks);
    $completeActSql->execute();
    $currTime = date("Y-m-d H:i:s");
    $completeSql = $conn->prepare("UPDATE `tblfile` SET `file_completed` = 1, `file_current_holder` = 0, `file_complete_time` = ? WHERE `file_track_no` = ?");
    $completeSql->bindParam(1, $currTime);
    $completeSql->bindParam(2, $fileTrack);
    $completeSql->execute(); 
    
    echo "<script>window.alert(`Marked as Done!`)</script>";
    echo "<script>window.open('../myFile.php','_self')</script>";
}
