<?php
session_start();
include '../../connection.php';
if ((isset($_SESSION['username']) && isset($_SESSION['auth']))) {
    include "./checkAdminLogin.php";
    if (checkAdminLogin($_SESSION['auth']) == "Admin") {

        if (isset($_POST['fileId'])) {
            $fileId = $_POST['fileId'];

            $deleteFileSql = $conn->prepare("UPDATE tblfile SET file_active = 1 WHERE file_id = ?");
            $deleteFileSql->bindParam(1, $fileId);
            if ($deleteFileSql->execute()) {
                echo "<script>window.alert(`File Restored Successfully`)</script>";
                echo "<script>window.open('../dept.php','_self')</script>";
            }
        }
    }
} else {
    echo "<script>window.alert(`Don't peep!`)</script>";
    echo "<script>window.open('../','_self')</script>";
}
?>
