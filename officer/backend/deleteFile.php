<?php
session_start();
include '../../connection.php';
// if ((isset($_SESSION['username']) && isset($_SESSION['auth']))) {
//     include "./checkAdminLogin.php";
    // if (checkAdminLogin($_SESSION['auth']) == "Admin") {

        // if (isset($_POST['fileId'])) {
            $fileId = $_POST['fileId'];
            $reason = $_POST['reason'];
            $type = "Deleted From Officer";
            echo $fileId;
            echo $reason;
            // exit;
            $deleteFileSql = $conn->prepare("UPDATE tblfile SET file_active = '-1' WHERE file_track_no = ?");
            $deleteFileSql->bindParam(1, $fileId);
            if($deleteFileSql->execute()){
                $actSql = $conn->prepare("INSERT INTO tblactivity (activity_file_track_no, activity_remarks, activity_type) VALUES (?, ?, ?)");
                $actSql->bindParam(1, $fileId);
                $actSql->bindParam(2, $reason);
                $actSql->bindParam(3, $type);
                if ($actSql->execute()) {
                    echo "<script>window.alert(`File Deleted Successfully`)</script>";
                    echo "<script>window.open('../trackFile.php','_self')</script>";
                }
            }
        // }
//     }
// } else {
//     echo "<script>window.alert(`Don't peep!`)</script>";
//     echo "<script>window.open('../','_self')</script>";
// }
