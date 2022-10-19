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
    
    $checkKey = $checkSql->fetch(PDO::FETCH_ASSOC);

    $currTime = date("Y-m-d H:i:s");
    $timeTakenSql = $conn->prepare("UPDATE `tblactivity` SET `activity_time_taken` = ? WHERE `activity_file_track_no` = ? AND `activity_to` = ? AND `activity_type` IN ('Forwarded', 'Added')  AND `activity_time_taken` IS NULL");
    $timeTakenSql->bindParam(1, $currTime);
    $timeTakenSql->bindParam(2, $fileTrack);
    $timeTakenSql->bindParam(3, $_SESSION['id']);
    $timeTakenSql->execute();

    $completeActSql = $conn->prepare("INSERT INTO `tblactivity` (`activity_file_track_no`, `activity_from`, `activity_to`, `activity_remarks`, `activity_type`, `activity_ack`, `activity_ack_time`) VALUES (?, ?, ?, ?, 'Completed', 1, ?)");
    $completeActSql->bindParam(1, $fileTrack);
    $completeActSql->bindParam(2, $_SESSION['id']);
    $completeActSql->bindParam(3, $_SESSION['id']);
    $completeActSql->bindParam(4, $completeRemarks);
    $completeActSql->bindParam(5, $currTime);
    $completeActSql->execute();
    $completeSql = $conn->prepare("UPDATE `tblfile` SET `file_completed` = 1, `file_current_holder` = 0, `file_complete_time` = ? WHERE `file_track_no` = ?");
    $completeSql->bindParam(1, $currTime);
    $completeSql->bindParam(2, $fileTrack);
    $completeSql->execute(); 

    $ownerSql = $conn->prepare("SELECT * FROM tblofficer WHERE officer_id = ?");
    $ownerSql->bindParam(1, $checkKey['file_added_by']);
    $ownerSql->execute();
    $owner = $ownerSql->fetch(PDO::FETCH_ASSOC);
    $to_email = $owner['officer_email'];
    $subject = 'File with Tracking No - '.$fileTrack.' has been completed!';
    $message = 'Hello,<br> File with Tracking No. - '.$fileTrack.' has been completed. You can check at your end.';
    $message .= "<br>Thank You";
    $message .= '<br><br>Regards,<br>File Tracker Team';
    $headers = 'From : File Tracker Team';
    $headers .= "MIME-Version: 1.0\r\n";
    $headers .= "Content-Type: text/html; charset=UTF-8\r\n";
    mail($to_email, $subject, $message, $headers);
    
    echo "<script>window.alert(`Marked as Done!`)</script>";
    echo "<script>window.open('../myFile.php','_self')</script>";
}
