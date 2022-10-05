<?php
session_start();
include '../../connection.php';
if ((isset($_SESSION['username']) && isset($_SESSION['auth']))) {
    include "./checkAdminLogin.php";
    if (checkAdminLogin($_SESSION['auth']) == "Admin") {
        if (isset($_POST['ackFile'])) {
            $actId = $_POST['actId'];
            $fileTrack = $_POST['fileTrack'];
            $ackTime = date('Y-m-d H:i:s');
            
            $checkSql = $conn->prepare("SELECT * FROM tblactivity WHERE activity_id = ? AND activity_file_track_no = ?");
            $checkSql->bindParam(1, $actId);
            $checkSql->bindParam(2, $fileTrack);
            $checkSql->execute();
            if($checkSql->rowCount() == 0) {
                echo "<script>window.alert(`Bad Request`)</script>";
                echo "<script>window.open('../myFile','_self')</script>";
            }
            $ackSql = $conn->prepare("UPDATE tblactivity SET activity_ack = 1, activity_ack_time = ? WHERE activity_id = ?");
            $ackSql->bindParam(1, $ackTime);
            $ackSql->bindParam(2, $actId);
            if ($ackSql->execute()) {
                $currSql = $conn->prepare("UPDATE tblfile SET file_current_holder = ? WHERE file_track_no = ?");
                $currSql->bindParam(1, $_SESSION['id']);
                $currSql->bindParam(2, $fileTrack);
                if($currSql->execute()){
                    echo "<script>window.alert(`Acknowledged Successfully`)</script>";
                    echo "<script>window.open('../myFile.php','_self')</script>";
                }    
            }
        }
    }
} else {
    echo "<script>window.alert(`Don't peep!`)</script>";
    echo "<script>window.open('../','_self')</script>";
}
?>
