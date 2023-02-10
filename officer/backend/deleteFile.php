<?php
// session_start();
// include '../../connection.php';
// if ((isset($_SESSION['username']) && isset($_SESSION['auth']))) {
//     include "./checkAdminLogin.php";
    // if (checkAdminLogin($_SESSION['auth']) == "Admin") {

        // if (isset($_POST['fileId'])) {
            $fileId = $_POST['fileId'];
            echo $fileId;
            $deleteFileSql = $conn->prepare("UPDATE tblfile SET file_active = '-1'WHERE file_id = ?");
            $deleteFileSql->bindParam(1, $fileId);
            if ($deleteFileSql->execute()) {
                echo "<script>window.alert(`File Deleted Successfully`)</script>";
                echo "<script>window.open('../trackFile.php','_self')</script>";
            }
        // }
//     }
// } else {
//     echo "<script>window.alert(`Don't peep!`)</script>";
//     echo "<script>window.open('../','_self')</script>";
// }
?>
