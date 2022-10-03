<?php
session_start();
include '../../connection.php';
if ((isset($_SESSION['username']) && isset($_SESSION['auth']))) {
    include "./checkAdminLogin.php";
    if (checkAdminLogin($_SESSION['auth']) == "Admin") {

        if (isset($_POST['fileCatId'])) {
            $fileCatId = $_POST['fileCatId'];

            $fileCatSql = $conn->prepare("UPDATE tblfilecat SET filecat_active = 0 WHERE filecat_id = ?");
            $fileCatSql->bindParam(1, $fileCatId);
            if ($fileCatSql->execute()) {
                echo "<script>window.alert(`File Category Deleted Successfully`)</script>";
                echo "<script>window.open('../fileCategory.php','_self')</script>";
            }
        }
    }
} else {
    echo "<script>window.alert(`Don't peep!`)</script>";
    echo "<script>window.open('../login.php','_self')</script>";
}
?>
