<?php
session_start();
include '../../connection.php';
if ((isset($_SESSION['username']) && isset($_SESSION['auth']))) {
    if (isset($_POST['forwardFile']) && $_SESSION['id']) {

        $currHolder = '-1';
        $fileTrack = $_POST['fileTrack'];
        $forwardOfficer = $_POST['forwardOfficer'];
        $forwardRemarks = $_POST['forwardRemarks'];
        $forwardType = "Forwarded";

        if ($forwardOfficer == $_SESSION['id']) {
            echo "<script>window.alert(`You can't forward to your self.`)</script>";
            unset($_POST['forwardFile']);
            echo "<script>window.open('../myFile.php','_self')</script>";
            exit();
        }

        $checkSql = $conn->prepare("SELECT * FROM tblfile WHERE file_track_no = ? AND file_current_holder = ?");
        $checkSql->bindParam(1, $fileTrack);
        $checkSql->bindParam(2, $_SESSION['id']);
        $checkSql->execute();
        if ($checkSql->rowCount() == 0) {
            echo "<script>window.alert(`Bad Request`)</script>";
            echo "<script>window.open('../myFile','_self')</script>";
        }
        $ackSql = $conn->prepare("INSERT INTO tblactivity (activity_file_track_no, activity_from, activity_to, activity_remarks, activity_type, activity_ack) VALUES (?, ?, ?, ?, ?, 0)");
        $ackSql->bindParam(1, $fileTrack);
        $ackSql->bindParam(2, $_SESSION['id']);
        $ackSql->bindParam(3, $forwardOfficer);
        $ackSql->bindParam(4, $forwardRemarks);
        $ackSql->bindParam(5, $forwardType);
        if ($ackSql->execute()) {
            $nullCurrentHolder = -1;
            $currSql = $conn->prepare("UPDATE tblfile SET file_current_holder = ? WHERE file_track_no = ?");
            $currSql->bindParam(1, $nullCurrentHolder);
            $currSql->bindParam(2, $fileTrack);
            if ($currSql->execute()) {
                echo "<script>window.alert(`Forwarded Successfully`)</script>";
                echo "<script>window.open('../myFile.php','_self')</script>";
            }
        }
    }
} else {
    echo "<script>window.alert(`Don't peep!`)</script>";
    echo "<script>window.open('../','_self')</script>";
}
?>